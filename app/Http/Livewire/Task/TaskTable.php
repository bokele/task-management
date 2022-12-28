<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class TaskTable extends PowerGridComponent
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
     * @return Builder<\App\Models\Task>
     */
    public function datasource(): Builder
    {
        return Task::query()->with(['project', 'createdBy'])->orderBy('priority', 'desc')->orderBy('updated_at', 'desc');
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
            'project',
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

            ->addColumn('project_id', function (Task $model) {
                return Str::title($model->project->name);
            })
            ->addColumn('priority', function (Task $model) {
                $possition = '';
                if ($model->priority >= 1) {
                    $possition =  '<a wire:click="task_up(' . $model->id . ')" href="#">
                    &uarr;
                </a>';
                }


                if ($model->priority < $model->max('priority')) {
                    $possition =  '<a wire:click="task_down(' . $model->id . ')" href="#">
                    &darr;
                </a>';
                }
                return  $model->priority . " " . $possition;
            })




            ->addColumn('name', function (Task $model) {
                return Str::title($model->name);
            })
            // ->addColumn('created_at_formatted', fn (Task $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->addColumn('updated_at_formatted', fn (Task $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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




            Column::make('PROJECT', 'project_id'),


            Column::make('PRIORITY', 'priority')
                ->makeInputRange(),



            Column::make('NAME', 'name')
                ->sortable()
                ->searchable()
                ->makeInputText(),



            // Column::make('CREATED AT', 'created_at_formatted', 'created_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

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
     * PowerGrid Task Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            Button::make('edit', "<i class='cil-pencil icon-2x' title='Edit Task'></i>")
                ->class('btn btn-outline-warning btn-sm float-right m-1')
                ->route('tasks.edit', ['task' => 'id'])
                ->target('_self'),
            Button::make('show', "<i class='cil-folder-open icon-2x' title='Task Details'></i>")
                ->class('btn btn-outline-primary btn-sm float-right m-1')
                ->route('tasks.show', ['task' => 'id'])
                ->target('_self'),

            Button::make('destroy', "<i class='cil-trash icon-2x' title='Delete Task'></i>")
                ->class('btn btn-outline-danger btn-sm float-right m-1')
                ->route('tasks.destroy', ['task' => 'id'])
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
     * PowerGrid Task Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($task) => $task->id === 1)
                ->hide(),
        ];
    }
    */

    public function task_up($task_id)
    {
        $task = Task::find($task_id);
        if ($task) {
            Task::where('created_by', auth()->id())->where('priority', $task->priority - 1)->update([
                'priority' => $task->priority
            ]);
            $task->update(['priority' => $task->priority - 1]);
        }
    }

    public function task_down($task_id)
    {
        $task = Task::find($task_id);
        if ($task) {
            Task::where('created_by', auth()->id())->where('priority', $task->priority + 1)->update([
                'priority' => $task->priority
            ]);
            $task->update(['priority' => $task->priority + 1]);
        }
    }
}
