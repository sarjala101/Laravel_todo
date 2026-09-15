<?php

use App\Models\Todo;
use Livewire\Component;

new class extends Component
{
    public $task = '';

    public $description = '';

    public $priority = 'medium';

    public function saveTodo()
    {
        auth()->user()->todos()->create([
            'task' => $this->task,
            'description' => $this->description,
            'priority' => $this->priority,
        ]);

        $this->task = '';
        $this->description = '';
        $this->priority = 'medium';
    }

    public function render()
    {
        $todos = auth()->user()->todos()
            ->orderByRaw("
                CASE priority
                    WHEN 'high' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'low' THEN 3
                END
            ")
            ->latest()
            ->get();

        return $this->view([
            'todos' => $todos,
        ]);
    }
};
?>

<div class="min-h-screen bg-gray-100 py-10">
    <div class="mx-auto max-w-3xl px-4">
        <!-- Page Heading -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Livewire Todo App</h1>

            <p class="mt-2 text-gray-500">Manage your tasks easily</p>
        </div>

        <!-- Add Todo Card -->
        <div class="mb-8 rounded-xl bg-white p-6 shadow-md">
            <h2 class="mb-5 text-xl font-semibold text-gray-800">
                Add New Todo
            </h2>

            <form wire:submit="saveTodo">
                <!-- Task -->
                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Task
                    </label>

                    <input
                        type="text"
                        wire:model="task"
                        placeholder="Enter your task"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    />
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Description
                    </label>

                    <textarea
                        wire:model="description"
                        rows="3"
                        placeholder="Enter task description"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    ></textarea>
                </div>

                <!-- Priority -->
                <div class="mb-5">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Priority
                    </label>

                    <select
                        wire:model="priority"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    >
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full rounded-lg bg-blue-600 px-4 py-2.5 font-medium text-white transition hover:bg-blue-700"
                >
                    Add Todo
                </button>
            </form>
        </div>

        <!-- Todo List -->
        <div>
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">My Todos</h2>

                <span
                    class="rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-700"
                >
                    {{ $todos->count() }} Tasks
                </span>
            </div>

            @forelse ($todos as $todo)
                <div class="mb-4 rounded-xl bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <!-- Todo Information -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ $todo->task }}
                            </h3>

                            @if ($todo->description)
                                <p class="mt-2 text-sm text-gray-600">
                                    {{ $todo->description }}
                                </p>
                            @endif
                        </div>

                        <!-- Priority Badge -->
                        <div>
                            @if ($todo->priority === 'high')
                                <span
                                    class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700"
                                >
                                    High
                                </span>

                            @elseif ($todo->priority === 'medium')
                                <span
                                    class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700"
                                >
                                    Medium
                                </span>

                            @else
                                <span
                                    class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700"
                                >
                                    Low
                                </span>

                            @endif
                        </div>
                    </div>
                </div>

            @empty
                <div class="rounded-xl bg-white p-8 text-center shadow-sm">
                    <p class="text-gray-500">No todos yet.</p>

                    <p class="mt-1 text-sm text-gray-400">Add your first todo using the form above.</p>
                </div>

            @endforelse
        </div>
    </div>
</div>
