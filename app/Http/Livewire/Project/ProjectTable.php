<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class ProjectTable extends PowerGridComponent
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
     * @return Builder<\App\Models\Project>
     */
    public function datasource(): Builder
    {
        return Project::query()->with(['createdBy'])->orderBy('id', 'desc');
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
        return [
            'createdBy'
        ];
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

            ->addColumn('status', function (Project $model) {

                if ($model->status == 'pending') {
                    $status = '<span class="badge bg-warning">' . strtoupper(e($model->status)) . '</span>';
                } elseif ($model->status == 'completed') {
                    $status = '<span class="badge bg-success">' . strtoupper(e($model->status)) . '</span>';
                } elseif ($model->status == 'in progress') {
                    $status = '<span class="badge bg-primary">' . strtoupper(e($model->status)) . '</span>'; //IN PROGRESS
                } elseif ($model->status == 'incomplete') {
                    $status = '<span class="badge bg-danger">' . strtoupper(e($model->status)) . '</span>'; //INCOMPLETE
                } elseif ($model->status == 'review') {
                    $status = '<span class="badge bg-dark"><i class="cib-blind "></i>' . strtoupper(e($model->status)) . '</span>'; //REVIEW
                } elseif ($model->status == 'repossessed') {
                    $status = '<span class="badge bg-secondary">' . strtoupper(e($model->status)) . '</span>'; //REPOSSESSED
                }
                return $status;
            })
            ->addColumn('code')

            /** Example of custom column using a closure **/
            ->addColumn('code_lower', function (Project $model) {
                return strtolower(e($model->code));
            })

            ->addColumn('name', function (Project $model) {
                return Str::title($model->name);
            })
            ->addColumn('updated_at_formatted', fn (Project $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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


            Column::make('STATUS', 'status')
                ->sortable()
                ->makeInputText(),

            Column::make('CODE', 'code')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('NAME', 'name')
                ->sortable()
                ->searchable()
                ->makeInputText(),


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
     * PowerGrid Project Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            Button::make('edit', "<i class='cil-pencil icon-2x' title='Edit Project'></i>")
                ->class('btn btn-outline-warning btn-sm float-right m-1')
                ->route('projects.edit', ['project' => 'id'])
                ->target('_self'),
            Button::make('show', "<i class='cil-folder-open icon-2x'></i>")
                ->class('btn btn-outline-primary btn-sm float-right m-1')
                ->route('projects.show', ['project' => 'id'])
                ->target('_self'),

            Button::make('destroy', "<i class='cil-trash icon-2x'></i>")
                ->class('btn btn-outline-danger btn-sm float-right m-1')
                ->route('projects.destroy', ['project' => 'id'])
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
     * PowerGrid Project Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($project) => $project->id === 1)
                ->hide(),
        ];
    }
    */
}
