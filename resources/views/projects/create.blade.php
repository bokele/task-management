<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="container">
                <div class="card">
                    <div class="card-header border-blue text-primary">
                        Add A New Project

                    </div>
                    <div class="card-body">
                        <form action="{{ route('projects.store') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="project_name" class="form-label">Project Name</label>
                                <input type="text" name="project_name" class="form-control {{ $errors->has('project_name') ? 'is-invalid' : '' }}" id="project_name" placeholder="Project Name" value="{{ old('project_name') }}" />
                                @if($errors->has('project_name'))
                                <div class="invalid-feedback">{{$errors->first('project_name')}}</div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-sm float-right">Save</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
