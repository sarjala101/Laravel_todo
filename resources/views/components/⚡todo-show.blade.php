<?php

use App\Models\Todo;
use Livewire\Component;

new class extends Component
{
    public Todo $todo;

    public function mount(Todo $todo)
    {
        // Make sure this task belongs to the logged-in user.
        abort_unless(
            $todo->user_id === auth()->id(),
            403
        );

        $this->todo = $todo;
    }
};
?>

<div class="min-h-screen bg-gray-100 py-8">
    <div class="mx-auto max-w-2xl px-4">
        {{-- Header --}}
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Task Details</h1>

                <p class="mt-1 text-sm text-gray-500">View the details of your task.</p>
            </div>

            <a
                href="{{ route('livewire.todo') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Back
            </a>
        </div>

        {{-- Task details --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $todo->task }}
                </h2>

                <div class="mt-3 flex flex-wrap gap-2">
                    <span
                        class="rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-600"
                    >
                        Priority: {{ ucfirst($todo->priority) }}
                    </span>

                    <span
                        class="rounded-full px-3 py-1 text-sm font-medium
                        {{ $todo->is_completed
                            ? 'bg-green-100 text-green-700'
                            : 'bg-yellow-100 text-yellow-700' }}"
                    >
                        {{ $todo->is_completed ? 'Completed' : 'Pending' }}
                    </span>
                </div>
            </div>

            {{-- Description --}}
            <div class="border-t border-gray-200 pt-5">
                <h3 class="text-sm font-semibold text-gray-700">Description</h3>

                @if ($todo->description)
                    <p class="mt-2 whitespace-pre-line text-gray-600">
                        {{ $todo->description }}
                    </p>

                @else
                    <p class="mt-2 text-gray-400">No description provided.</p>

                @endif
            </div>

            {{-- Dates --}}
            <div class="mt-6 border-t border-gray-200 pt-5">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase">Created</p>

                        <p class="mt-1 text-sm text-gray-700">
                            {{ $todo->created_at?->format('M d, Y h:i A') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase">Completed</p>

                        <p class="mt-1 text-sm text-gray-700">
                            {{ $todo->completed_at?->format('M d, Y h:i A') ?? 'Not completed yet' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Edit --}}
            @if (! $todo->is_completed)
                <div class="mt-6">
                    <a
                        href="{{ route('livewire.todo.edit', $todo) }}"
                        class="inline-block rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
                    >
                        Edit Task
                    </a>
                </div>

            @endif
        </div>
    </div>
</div>
