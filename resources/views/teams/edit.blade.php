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
                        <form action="{{ route('teams.update', $team->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="project_name" class="form-label">Project Name</label>
                                    <select name="project_name" id="project_name" class="form-control {{ $errors->has('project_name') ? 'is-invalid' : '' }} rounded-0">
                                        <option value="">Select a project</option>
                                        @foreach ($projects as $project)
                                        <option value="{{$project->id}}" {{ $team->project_id==$project->id ? 'selected' : '' }}>{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('project_name'))
                                    <div class="invalid-feedback">{{$errors->first('project_name')}}</div>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="team_name" class="form-label">Team Name</label>
                                    <input type="text" name="team_name" class="form-control {{ $errors->has('team_name') ? 'is-invalid' : '' }} rounded-0" id="team_name" placeholder="Team name" value="{{ $team->name }}" />
                                    @if($errors->has('team_name'))
                                    <div class="invalid-feedback">{{$errors->first('team_name')}}</div>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="team_leader" class="form-label">Team Leader</label>
                                    <select name="team_leader" id="team_leader" class="form-control {{ $errors->has('team_leader') ? 'is-invalid' : '' }} rounded-0">
                                        <option value="">Select a Team leader</option>
                                        @foreach ($users as $user)
                                        <option value="{{$user->id}}" {{ $team->team_leader_id==$user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('team_leader'))
                                    <div class="invalid-feedback">{{$errors->first('team_leader')}}</div>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="team_leader_assistance" class="form-label">Team Leader Assistance</label>
                                    <select name="team_leader_assistance" id="team_leader_assistance" class="form-control {{ $errors->has('team_leader_assistance') ? 'is-invalid' : '' }} rounded-0">
                                        <option value="">Select a Team leader assistance</option>
                                        @foreach ($users as $user)
                                        <option value="{{$user->id}}" {{ $team->team_leader_assistance_id==$user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('team_leader_assistance'))
                                    <div class="invalid-feedback">{{$errors->first('team_leader_assistance')}}</div>
                                    @endif
                                </div>
                            </div>





                            <button type="submit" class="btn btn-outline-primary btn-sm float-right text-uppercase"><i class='cil-save icon-4x'></i> Save Change</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
