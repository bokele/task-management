<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="container">
                <div class="card border-primary">
                    <div class="card-header  text-primary text-uppercase">
                        <i class='cil-plus icon-4x'></i> Add A New Team

                    </div>
                    <div class="card-body">
                        <form action="{{ route('tasks.store') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="project_name" class="form-label">Project Name</label>
                                <select name="project_name" id="project_name" class="form-control {{ $errors->has('project_name') ? 'is-invalid' : '' }}">
                                    <option value="">Select a project</option>
                                    @foreach ($projects as $project)
                                    <option value="{{$project->id}}" {{ old('project_name')==$project->id ? 'selected' : '' }}>{{$project->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('project_name'))
                                <div class="invalid-feedback">{{$errors->first('project_name')}}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="task_name" class="form-label">Task Name</label>
                                <input type="text" name="task_name" class="form-control {{ $errors->has('task_name') ? 'is-invalid' : '' }}" id="task_name" placeholder="Task name" value="{{ old('task_name') }}" />
                                @if($errors->has('task_name'))
                                <div class="invalid-feedback">{{$errors->first('task_name')}}</div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-outline-primary btn-sm float-right"><i class='cil-save icon-4x'></i> Save</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
