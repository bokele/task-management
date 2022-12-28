<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="container">
                <div class="card border-warning">
                    <div class="card-header border-blue text-primary text-uppercase">
                        <i class='cil-pencil icon-4x'></i> Edit Project N<sup>o</sup> <span class="text-danger">{{$project->code}}</span>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('projects.update', $project->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="project_name" class="form-label">Project Name</label>
                                <input type="text" name="project_name" class="form-control {{ $errors->has('project_name') ? 'is-invalid' : '' }}" id="project_name" placeholder="Project Name" value="{{ $project->name }}" />
                                @if($errors->has('project_name'))
                                <div class="invalid-feedback">{{$errors->first('project_name')}}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="project_status" class="form-label">Project Status</label>
                                <select name="project_status" class="form-control {{ $errors->has('project_status') ? 'is-invalid' : '' }}" id="project_status">
                                    <option value="">Select The Project Status</option>
                                    <option value="pending" @if ($project->status == 'pending') selected @endif>Pending</option>
                                    <option value="completed" @if ($project->status == 'completed') selected @endif>Completed</option>
                                    <option value="in progress" @if ($project->status == 'in progress') selected @endif>In Progress</option>
                                    <option value="incomplete" @if ($project->status == 'incomplete') selected @endif>Incomplete</option>
                                    <option value="review" @if ($project->status == 'review') selected @endif>Review</option>
                                    <option value="repossessed" @if ($project->status == 'repossessed') selected @endif>Repossessed</option>
                                </select>
                                @if($errors->has('project_status'))
                                <div class="invalid-feedback">{{$errors->first('project_status')}}</div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-sm float-right"><i class='cil-save icon-4x'></i> Save Change</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
