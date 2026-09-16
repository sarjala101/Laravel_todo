<?php

use App\Models\Todo;
use Livewire\Component;

new class extends Component
{
    public Todo $todo;

    public $task = '';

    public $description = '';

    public $priority = 'medium';

    public function mount(Todo $todo)
    {
        // Make sure this todo belongs to the logged-in user
        abort_unless($todo->user_id === auth()->id(), 403);

        // Completed todos cannot be edited
        if ($todo->is_completed) {
            abort(403, 'Completed tasks cannot be edited.');
        }

        $this->todo = $todo;

        // Put existing todo data into the form
        $this->task = $todo->task;
        $this->description = $todo->description;
        $this->priority = $todo->priority;
    }

    public function updateTodo()
    {
        $this->validate([
            'task' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:high,medium,low',
        ]);

        $this->todo->update([
            'task' => $this->task,
            'description' => $this->description,
            'priority' => $this->priority,
        ]);

        $this->dispatch(
        'show-toast',
        type: 'success',
        message: 'Task updated successfully!'
        );
        return redirect()->route('livewire.todo');
    }
};
?>

<div class="min-h-screen bg-gray-100 py-8">
    <div class="mx-auto max-w-2xl px-4">
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Task</h1>

                <p class="mt-1 text-sm text-gray-500">Update your task details</p>
            </div>

            <form wire:submit="updateTodo">
                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Task
                    </label>

                    <input
                        type="text"
                        wire:model="task"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    />

                    @error ('task')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Description
                    </label>

                    <textarea
                        wire:model="description"
                        rows="4"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    ></textarea>

                    @error ('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Priority
                    </label>

                    <select
                        wire:model="priority"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    >
                        <option value="high">High Priority</option>

                        <option value="medium">Medium Priority</option>

                        <option value="low">Low Priority</option>
                    </select>

                    @error ('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="updateTodo"
                        class="flex-1 rounded-lg bg-blue-600 py-3 font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="updateTodo">
                            Update Task
                        </span>

                        <span wire:loading wire:target="updateTodo">
                            Updating...
                        </span>
                    </button>

                    <a
                        href="{{ route('livewire.todo') }}"
                        class="rounded-lg border border-gray-300 px-6 py-3 font-medium text-gray-700 transition hover:bg-gray-50"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
