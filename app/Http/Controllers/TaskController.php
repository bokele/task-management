<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::orderBy('name')->get();
        return view('tasks.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $task = new Task();
        $priority = Task::where('created_by', NULL)->max('priority') + 1;


        $task->created_by = auth()->id();
        $task->project_id = $request->project_name;
        $task->name = $request->task_name;
        $task->priority = $priority;
        $task->save();

        return redirect()->route('tasks.index')->with(['message' => 'Task has been saved', 'status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $projects = Project::orderBy('name')->get();

        return view('tasks.edit', compact('projects', 'task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->created_by = auth()->id();
        $task->project_id = $request->project_name;
        $task->name = $request->task_name;
        $task->update();

        return redirect()->route('tasks.index')->with(['message' => 'Task has been updated', 'status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        Task::where('created_by', NULL)->where('priority', '>', $task->priority)->decrement('priority', 1);
        $task->delete();
        return redirect()->route('tasks.index')->with(['message' => 'Task has been deleted', 'status' => true]);
    }
}
