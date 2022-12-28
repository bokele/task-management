<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="container">
                <div class="card border-primary">
                    <div class="card-header  text-primary text-uppercase">
                        List Of Teams
                        <a href="{{ route('teams.create') }}" type="button" class="btn btn-outline-primary btn-sm float-right"><i class='cil-plus icon-2x'></i> Add A New Team</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <livewire:team.team-table />
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
