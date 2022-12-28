<?php

namespace App\Http\Livewire\Team;

use App\Models\Team;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class TeamTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Team>
     */
    public function datasource(): Builder
    {
        return Team::query()->with(['createdBy', 'project', 'teamLeader', 'teamLeaderAssistance']);
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return ['createdBy', 'project', 'teamLeader', 'teamLeaderAssistance'];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()

            ->addColumn('project_id', function (Team $model) {
                return Str::title($model->project->name);
            })
            ->addColumn('team_leader_id', function (Team $model) {
                return Str::title($model->teamLeader->name);
            })
            ->addColumn('team_leader_assistance_id', function (Team $model) {
                return Str::title($model->teamLeaderAssistance->name);
            })
            ->addColumn('code')


            ->addColumn('name', function (Team $model) {
                return Str::title($model->name);
            })
            ->addColumn('updated_at_formatted', fn (Team $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [

            Column::make('CODE', 'code')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('NAME', 'name')
                ->sortable()
                ->searchable()
                ->makeInputText(),
            Column::make('PROJECT', 'project_id')
                ->makeInputRange(),

            Column::make('TEAM LEADER', 'team_leader_id'),

            Column::make('TEAM LEADER ASSISTANCE ', 'team_leader_assistance_id'),





            Column::make('UPDATED AT', 'updated_at_formatted', 'updated_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker(),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Team Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            Button::make('edit', "<i class='cil-pencil icon-2x' title='Edit Team'></i>")
                ->class('btn btn-outline-warning btn-sm float-right m-1')
                ->route('teams.edit', ['team' => 'id'])
                ->target('_self'),
            Button::make('show', "<i class='cil-folder-open icon-2x' title='Team Details'></i>")
                ->class('btn btn-outline-primary btn-sm float-right m-1')
                ->route('teams.show', ['team' => 'id'])
                ->target('_self'),

            Button::make('destroy', "<i class='cil-trash icon-2x' title='Delete Team'></i>")
                ->class('btn btn-outline-danger btn-sm float-right m-1')
                ->route('teams.destroy', ['team' => 'id'])
                ->method('delete')
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Team Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($team) => $team->id === 1)
                ->hide(),
        ];
    }
    */
}
