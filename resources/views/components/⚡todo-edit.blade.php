<?php

//use App\Livewire\Concerns\HasTaskRules;
use App\Models\Todo;
use Livewire\Component;

new class extends Component
{
   // use HasTaskRules;

    public Todo $todo;

    public $task = '';

    public $description = '';

    public $priority = 'medium';

    public function mount(Todo $todo)
    {
        $this->authorize('update', $todo);

        $this->todo = $todo;

        $this->task = $todo->task;
        $this->description = $todo->description;
        $this->priority = $todo->priority;
    }

    public function updateTodo()
    {
        $this->validate([
    'task' => ['required', 'string', 'max:255'],
    'description' => ['nullable', 'string'],
    'priority' => ['required', 'in:high,medium,low'],
]);

        $this->todo->update([
            'task' => $this->task,
            'description' => $this->description,
            'priority' => $this->priority,
        ]);

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Task updated successfully!',
        ]);

        return redirect()->route('livewire.todo');
    }
};
?>

<div class="min-h-screen bg-gray-100 py-8">
    <div class="mx-auto max-w-2xl px-4">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Task</h1>

                <p class="mt-1 text-sm text-gray-500">Update your task details.</p>
            </div>

            <a
                href="{{ route('livewire.todo') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Back
            </a>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <form wire:submit="updateTodo" class="space-y-5">
                {{-- Task --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Task
                    </label>

                    <input
                        type="text"
                        wire:model="task"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    />

                    @error ('task')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Description
                    </label>

                    <textarea
                        wire:model="description"
                        rows="5"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    ></textarea>

                    @error ('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Priority --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Priority
                    </label>

                    <select
                        wire:model="priority"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500"
                    >
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>

                    @error ('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a
                        href="{{ route('livewire.todo') }}"
                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="updateTodo"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span wire:loading.remove wire:target="updateTodo">
                            Update Task
                        </span>

                        <span wire:loading wire:target="updateTodo">
                            Updating...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
