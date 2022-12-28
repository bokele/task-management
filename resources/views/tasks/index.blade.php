<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="container">
                <div class="card">
                    <div class="card-header border-blue text-primary">
                        List Of Tasks
                        <a href="{{ route('tasks.create') }}" type="button" class="btn btn-outline-primary btn-sm float-right">Add A New Task</a>
                    </div>
                    <div class="card-body">
                        <livewire:task.task-table />

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
