<?php

//use App\Livewire\Concerns\HasTaskRules;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
   // use HasTaskRules;
    use WithPagination;

    #[Url(as: 'q')]
    public $search = '';

    #[Url]
    public $status = 'all';

    #[Url]
    public $priority = 'all';

    #[Url]
    public $sort = 'newest';

    public $task = '';

    public $description = '';

    public $taskPriority = 'medium';

    public $showCreateForm = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedPriority()
    {
        $this->resetPage();
    }

    public function updatedSort()
    {
        $this->resetPage();
    }

    public function toggleCreateForm()
    {
        $this->showCreateForm = ! $this->showCreateForm;

        if (! $this->showCreateForm) {
            $this->resetCreateForm();
        }
    }

    private function resetCreateForm()
    {
        $this->reset([
            'task',
            'description',
        ]);

        $this->taskPriority = 'medium';
        $this->resetValidation();
    }

    public function saveTodo()
    {
        $this->validate([
    'task' => ['required', 'string', 'max:255'],
    'description' => ['nullable', 'string'],
    'taskPriority' => ['required', 'in:high,medium,low'],
]);

        Auth::user()->todos()->create([
            'task' => $this->task,
            'description' => $this->description,
            'priority' => $this->taskPriority,
            'is_completed' => false,
            'completed_at' => null,
        ]);

        $this->resetCreateForm();
        $this->showCreateForm = false;

        $this->dispatch(
            'show-toast',
            type: 'success',
            message: 'Task added successfully!'
        );
    }

    public function toggleComplete($todoId)
    {
        $todo = Auth::user()
            ->todos()
            ->findOrFail($todoId);

        $todo->update([
            'is_completed' => ! $todo->is_completed,
            'completed_at' => ! $todo->is_completed
                ? now()
                : null,
        ]);

        $message = $todo->is_completed
            ? 'Task completed successfully!'
            : 'Task marked as pending!';

        $this->dispatch(
            'show-toast',
            type: 'success',
            message: $message
        );
    }

    public function confirmDelete($todoId)
    {
        $this->dispatch(
            'confirm-delete',
            todoId: $todoId
        );
    }

    public function deleteTodo($todoId)
    {
        $todo = Auth::user()
            ->todos()
            ->findOrFail($todoId);

        $todo->delete();

        $this->dispatch(
            'show-toast',
            type: 'success',
            message: 'Task deleted successfully!'
        );
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Logout successful!',
        ]);

        return redirect()->route('livewire.login');
    }

    #[Computed]
    public function todos()
    {
        return Auth::user()
            ->todos()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('task', 'like', '%' . $this->search . '%')
                        ->orWhere(
                            'description',
                            'like',
                            '%' . $this->search . '%'
                        );
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where(
                    'is_completed',
                    $this->status === 'completed'
                );
            })
            ->when($this->priority !== 'all', function ($query) {
                $query->where(
                    'priority',
                    $this->priority
                );
            })
            ->when($this->sort === 'newest', function ($query) {
                $query->latest();
            })
            ->when($this->sort === 'oldest', function ($query) {
                $query->oldest();
            })
            ->when($this->sort === 'high', function ($query) {
                $query->orderByRaw("
                    CASE priority
                        WHEN 'high' THEN 1
                        WHEN 'medium' THEN 2
                        WHEN 'low' THEN 3
                    END
                ");
            })
            ->when($this->sort === 'low', function ($query) {
                $query->orderByRaw("
                    CASE priority
                        WHEN 'low' THEN 1
                        WHEN 'medium' THEN 2
                        WHEN 'high' THEN 3
                    END
                ");
            })
            ->paginate(5);
    }
};
?>

<div class="min-h-screen bg-gray-100 py-8">
    <div class="mx-auto max-w-6xl px-4">
        {{-- Header --}}
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Livewire Todo App
                </h1>

                <p class="mt-1 text-sm text-gray-500">Manage your tasks with Livewire</p>
            </div>

            <div class="flex items-center gap-2">
                <a
                    href="{{ route('livewire.account') }}"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50"
                >
                    Profile
                </a>

                <button
                    type="button"
                    wire:click="logout"
                    wire:loading.attr="disabled"
                    wire:target="logout"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span wire:loading.remove wire:target="logout">
                        Logout
                    </span>

                    <span wire:loading wire:target="logout">
                        Logging out...
                    </span>
                </button>
            </div>
        </div>

        {{-- Search / Filters --}}
        <div class="mb-6 rounded-xl bg-white p-4 shadow-sm">
            <div class="grid gap-4 md:grid-cols-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Search
                    </label>

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search tasks..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    />
                </div>

                {{-- Status --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Status
                    </label>

                    <select
                        wire:model.live="status"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500"
                    >
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                {{-- Priority --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Priority
                    </label>

                    <select
                        wire:model.live="priority"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500"
                    >
                        <option value="all">All</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-700">
                        Sort:
                    </label>

                    <select
                        wire:model.live="sort"
                        class="rounded-lg border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-500"
                    >
                        <option value="newest">Newest</option>
                        <option value="oldest">Oldest</option>
                        <option value="high">High Priority</option>
                        <option value="low">Low Priority</option>
                    </select>
                </div>

                <button
                    type="button"
                    wire:click="toggleCreateForm"
                    class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700"
                >
                    + Add Task
                </button>
            </div>
        </div>

        {{-- Loading indicator --}}
        <div
            wire:loading
            wire:target="search,status,priority,sort"
            class="mb-4 text-sm text-gray-500"
        >
            Loading tasks...
        </div>

        {{-- Create Task Popup --}}
        @if ($showCreateForm)
            <div
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 px-4"
            >
                <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">
                    <div class="mb-5 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-800">
                            Add New Task
                        </h2>

                        <button
                            type="button"
                            wire:click="toggleCreateForm"
                            class="text-2xl text-gray-400 hover:text-gray-600"
                        >
                            &times;
                        </button>
                    </div>

                    <form wire:submit="saveTodo" class="space-y-4">
                        {{-- Task --}}
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                            >
                                Task
                            </label>

                            <input
                                type="text"
                                wire:model="task"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            />

                            @error ('task')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                            >
                                Description
                            </label>

                            <textarea
                                wire:model="description"
                                rows="4"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            ></textarea>

                            @error ('description')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Priority --}}
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                            >
                                Priority
                            </label>

                            <select
                                wire:model="taskPriority"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500"
                            >
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>

                            @error ('taskPriority')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button
                                type="button"
                                wire:click="toggleCreateForm"
                                class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:target="saveTodo"
                                class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                            >
                                <span
                                    wire:loading.remove
                                    wire:target="saveTodo"
                                >
                                    Save Task
                                </span>

                                <span wire:loading wire:target="saveTodo">
                                    Saving...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        @endif

        {{-- Todo List --}}
        <div class="space-y-4">
            @forelse ($this->todos as $todo)
                <div
                    wire:key="todo-{{ $todo->id }}"
                    class="rounded-xl bg-white p-5 shadow-sm"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex min-w-0 items-start gap-3">
                            <input
                                type="checkbox"
                                wire:click="toggleComplete({{ $todo->id }})"
                                class="mt-1 h-5 w-5 rounded border-gray-300"
                                @checked ($todo->is_completed)
                            />

                            <div class="min-w-0">
                                <h3
                                    class="font-semibold {{ $todo->is_completed ? 'text-gray-400 line-through' : 'text-gray-800' }}"
                                >
                                    {{ $todo->task }}
                                </h3>

                                @if ($todo->description)
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $todo->description }}
                                    </p>
                                @endif

                                <div
                                    class="mt-3 flex flex-wrap items-center gap-2"
                                >
                                    <span
                                        class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600"
                                    >
                                        {{ ucfirst($todo->priority) }}
                                    </span>

                                    <span
                                        class="rounded-full px-2.5 py-1 text-xs font-medium
                                        {{ $todo->is_completed
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-yellow-100 text-yellow-700' }}"
                                    >
                                        {{ $todo->is_completed ? 'Completed' : 'Pending' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex shrink-0 items-center gap-2">
                            <a
                                href="{{ route('livewire.todo.show', $todo) }}"
                                class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50"
                            >
                                View
                            </a>

                            @if (! $todo->is_completed)
                                <a
                                    href="{{ route('livewire.todo.edit', $todo) }}"
                                    class="rounded-lg border border-blue-300 px-3 py-2 text-sm text-blue-600 hover:bg-blue-50"
                                >
                                    Edit
                                </a>

                            @endif

                            <button
                                type="button"
                                wire:click="confirmDelete({{ $todo->id }})"
                                class="rounded-lg border border-red-300 px-3 py-2 text-sm text-red-600 hover:bg-red-50"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

            @empty
                <div class="rounded-xl bg-white p-10 text-center shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-700">
                        No tasks found
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">Try changing your search or filters.</p>
                </div>

            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">{{ $this->todos->links() }}</div>
    </div>

    @script
        <script>
            $wire.on("show-toast", (event) => {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: event.type,
                    title: event.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: "#ffffff",
                    color: "#111111",
                });
            });

            $wire.on("confirm-delete", (event) => {
                Swal.fire({
                    title: "Delete this task?",
                    text: "This task will be moved to the trash.",
                    icon: "warning",
                    iconColor: "#dc2626",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it",
                    cancelButtonText: "Cancel",
                    background: "#ffffff",
                    color: "#1f2937",
                    confirmButtonColor: "#aa0000",
                    cancelButtonColor: "#6b7280",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.deleteTodo(event.todoId);
                    }
                });
            });
        </script>
    @endscript
</div>
