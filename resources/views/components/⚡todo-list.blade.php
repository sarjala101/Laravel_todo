<?php

use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $search = '';

    public $status = 'all';

    public $priority = 'all';

    public $sort = 'newest';

    public $task = '';

    public $description = '';

    public $taskPriority = 'medium';

    public $showCreateForm = false;


    /*
    |--------------------------------------------------------------------------
    | Reset pagination when filters change
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Show / Hide Create Form
    |--------------------------------------------------------------------------
    */

    public function toggleCreateForm()
    {
        $this->showCreateForm = ! $this->showCreateForm;

        if (! $this->showCreateForm) {
            $this->resetValidation();

            $this->reset([
                'task',
                'description',
            ]);

            $this->taskPriority = 'medium';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Save Todo
    |--------------------------------------------------------------------------
    */

    public function saveTodo()
    {
        $this->validate([
            'task' => 'required|string|max:255',
            'description' => 'nullable|string',
            'taskPriority' => 'required|in:high,medium,low',
        ]);

        auth()->user()->todos()->create([
            'task' => $this->task,
            'description' => $this->description,
            'priority' => $this->taskPriority,
        ]);

        $this->reset([
            'task',
            'description',
        ]);

        $this->taskPriority = 'medium';

        $this->showCreateForm = false;

        $this->dispatch(
            'show-toast',
            type: 'success',
            message: 'Task added successfully!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Complete / Pending
    |--------------------------------------------------------------------------
    */

    public function toggleComplete($todoId)
    {
        $todo = auth()->user()->todos()->findOrFail($todoId);

        if ($todo->is_completed) {

            $todo->update([
                'is_completed' => false,
                'completed_at' => null,
            ]);

            $this->dispatch(
                'show-toast',
                type: 'info',
                message: 'Task marked as pending!'
            );

        } else {

            $todo->update([
                'is_completed' => true,
                'completed_at' => now(),
            ]);

            $this->dispatch(
                'show-toast',
                type: 'success',
                message: 'Task completed successfully!'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Todo
    |--------------------------------------------------------------------------
    */

    public function deleteTodo($todoId)
    {
        $todo = auth()->user()->todos()->findOrFail($todoId);

        $todo->delete();

        $this->dispatch(
            'show-toast',
            type: 'success',
            message: 'Task deleted successfully!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Confirmation
    |--------------------------------------------------------------------------
    */

    public function confirmDelete($todoId)
    {
        $this->dispatch(
            'confirm-delete',
            todoId: $todoId
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Todo List
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $query = auth()->user()->todos();


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($this->search) {
            $query->where(function ($q) {

                $q->where(
                    'task',
                    'like',
                    '%' . $this->search . '%'
                )->orWhere(
                    'description',
                    'like',
                    '%' . $this->search . '%'
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($this->status === 'completed') {

            $query->where('is_completed', true);

        } elseif ($this->status === 'pending') {

            $query->where('is_completed', false);
        }


        /*
        |--------------------------------------------------------------------------
        | Priority Filter
        |--------------------------------------------------------------------------
        */

        if ($this->priority !== 'all') {

            $query->where(
                'priority',
                $this->priority
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        if ($this->sort === 'newest') {

            $query->latest();

        } elseif ($this->sort === 'oldest') {

            $query->oldest();

        } elseif ($this->sort === 'high') {

            $query->orderByRaw("
                CASE priority
                    WHEN 'high' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'low' THEN 3
                END
            ");

        } elseif ($this->sort === 'low') {

            $query->orderByRaw("
                CASE priority
                    WHEN 'low' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'high' THEN 3
                END
            ");
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $todos = $query->paginate(5);

        return $this->view([
            'todos' => $todos,
        ]);
    }
};
?>

<div class="min-h-screen bg-gray-100 py-8">
    <div class="mx-auto max-w-4xl px-4">
        {{-- ================================================================
             Toast From Session
             This MUST stay INSIDE the single root element.
        ================================================================= --}}

        @if (session()->has('toast'))
            <div
                data-toast
                data-toast-type="{{ session('toast.type') }}"
                data-toast-message="{{ session('toast.message') }}"
                class="hidden"
            ></div>
        @endif

        {{-- ================================================================
             Page Header
        ================================================================= --}}

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Livewire Todo App
                </h1>

                <p class="mt-1 text-sm text-gray-500">Manage your tasks with Livewire</p>
            </div>

            {{-- Profile + Logout --}}

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
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
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

        {{-- ================================================================
             Filters
        ================================================================= --}}

        <div class="mb-5 rounded-xl bg-white p-4 shadow-sm">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-4">
                {{-- Search --}}

                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-600">
                        Search
                    </label>

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search tasks..."
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200 focus:outline-none"
                    />
                </div>

                {{-- Status --}}

                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-600">
                        Status
                    </label>

                    <select
                        wire:model.live="status"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200 focus:outline-none"
                    >
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                {{-- Priority --}}

                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-600">
                        Priority
                    </label>

                    <select
                        wire:model.live="priority"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200 focus:outline-none"
                    >
                        <option value="all">All</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>

                {{-- Sort --}}

                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-600">
                        Sort By
                    </label>

                    <select
                        wire:model.live="sort"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200 focus:outline-none"
                    >
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="high">High Priority First</option>
                        <option value="low">Low Priority First</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- ================================================================
             Todo Heading + Add Button
        ================================================================= --}}

        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-semibold text-gray-800">My Todos</h2>

                <span
                    class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700"
                >
                    {{ $todos->total() }}
                </span>
            </div>

            <button
                type="button"
                wire:click="toggleCreateForm"
                class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
            >
                @if ($showCreateForm)
                    − Close
                @else
                    + Add New Task
                @endif
            </button>
        </div>

        {{-- ================================================================
             Add Task Popup
        ================================================================= --}}

        @if ($showCreateForm)
            <div
                class="fixed inset-0 z-40 flex items-start justify-center bg-black/30 px-4 pt-20"
                wire:click.self="toggleCreateForm"
            >
                <div class="w-full max-w-md rounded-xl bg-white p-5 shadow-xl">
                    {{-- Popup Header --}}

                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Add New Task
                        </h2>

                        <button
                            type="button"
                            wire:click="toggleCreateForm"
                            class="rounded-md px-2 py-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600"
                        >
                            ✕
                        </button>
                    </div>

                    <form wire:submit="saveTodo">
                        {{-- Task --}}

                        <div class="mb-3">
                            <label
                                class="mb-1 block text-xs font-medium text-gray-700"
                            >
                                Task
                            </label>

                            <input
                                type="text"
                                wire:model.live="task"
                                placeholder="Enter task name"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200 focus:outline-none"
                            />

                            @error ('task')
                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Description --}}

                        <div class="mb-3">
                            <label
                                class="mb-1 block text-xs font-medium text-gray-700"
                            >
                                Description
                            </label>

                            <textarea
                                wire:model="description"
                                rows="3"
                                placeholder="Enter task description"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200 focus:outline-none"
                            ></textarea>

                            @error ('description')
                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Priority --}}

                        <div class="mb-4">
                            <label
                                class="mb-1 block text-xs font-medium text-gray-700"
                            >
                                Priority
                            </label>

                            <select
                                wire:model="taskPriority"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200 focus:outline-none"
                            >
                                <option value="high">High Priority</option>
                                <option value="medium">Medium Priority</option>
                                <option value="low">Low Priority</option>
                            </select>

                            @error ('taskPriority')
                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Submit --}}

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="saveTodo"
                            class="w-full rounded-lg bg-blue-600 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="saveTodo">
                                Add Task
                            </span>

                            <span wire:loading wire:target="saveTodo">
                                Adding...
                            </span>
                        </button>
                    </form>
                </div>
            </div>

        @endif

        {{-- ================================================================
             Todo List
        ================================================================= --}}

        <div class="space-y-3">
            @forelse ($todos as $todo)
                <div
                    wire:key="todo-{{ $todo->id }}"
                    class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-md"
                >
                    <div class="flex items-start justify-between gap-4">
                        {{-- Todo Information --}}

                        <div class="flex flex-1 items-start gap-3">
                            <input
                                type="checkbox"
                                wire:click="toggleComplete({{ $todo->id }})"
                                {{ $todo->is_completed ? 'checked' : '' }}
                                class="mt-1 h-4 w-4 cursor-pointer"
                            />

                            <div class="flex-1">
                                <h3
                                    class="text-base font-semibold
                                    {{ $todo->is_completed
                                        ? 'text-gray-400 line-through'
                                        : 'text-gray-800' }}"
                                >
                                    {{ $todo->task }}
                                </h3>

                                @if ($todo->description)
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ $todo->description }}
                                    </p>

                                @endif

                                {{-- Priority Badge --}}

                                <span
                                    class="mt-2 inline-block rounded-full px-2 py-1 text-xs font-medium
                                    {{ $todo->priority === 'high'
                                        ? 'bg-red-100 text-red-700'
                                        : ($todo->priority === 'medium'
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : 'bg-green-100 text-green-700') }}"
                                >
                                    {{ ucfirst($todo->priority) }}
                                </span>

                                {{-- Completed Time --}}

                                @if ($todo->is_completed && $todo->completed_at)
                                    <p class="mt-1 text-xs text-green-600">
                                        Done: {{ $todo->completed_at->format('M d, Y h:i A') }}
                                    </p>

                                @endif
                            </div>
                        </div>

                        {{-- Edit + Delete Buttons --}}

                        <div class="flex items-center gap-2">
                            {{-- Edit --}}

                            @if (!$todo->is_completed)
                                <a
                                    href="{{ route('livewire.todo.edit', $todo) }}"
                                    class="rounded-lg border border-blue-200 px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-50"
                                >
                                    Edit
                                </a>

                            @endif

                            {{-- Delete --}}

                            <button
                                type="button"
                                wire:click="confirmDelete({{ $todo->id }})"
                                wire:loading.attr="disabled"
                                wire:target="deleteTodo"
                                class="rounded-lg border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span
                                    wire:loading.remove
                                    wire:target="deleteTodo"
                                >
                                    Delete
                                </span>

                                <span wire:loading wire:target="deleteTodo">
                                    Deleting...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

            @empty
                <div class="rounded-xl bg-white p-8 text-center shadow-sm">
                    <p class="text-sm text-gray-500">No todos found.</p>
                </div>

            @endforelse
        </div>

        {{-- ================================================================
             Pagination
        ================================================================= --}}

        <div class="mt-5">{{ $todos->links() }}</div>
    </div>

    {{-- ================================================================
         SweetAlert / Toast JavaScript
         This is INSIDE the single root element.
    ================================================================= --}}

    @script
        <script>
            /*
            |--------------------------------------------------------------------------
            | Toast Messages
            |--------------------------------------------------------------------------
            */

            $wire.on("show-toast", (event) => {
                Swal.fire({
                    toast: true,

                    position: "top-end",

                    icon: event.type,

                    title: event.message,

                    showConfirmButton: false,

                    showClass: {
                        popup: "",
                    },

                    hideClass: {
                        popup: "",
                    },

                    timer: 3000,

                    timerProgressBar: true,

                    background: "#ffffff",

                    color: "#111111",
                });
            });

            /*
            |--------------------------------------------------------------------------
            | Delete Confirmation
            |--------------------------------------------------------------------------
            */

            $wire.on("confirm-delete", (event) => {
                Swal.fire({
                    title: "Delete this task?",

                    icon: "warning",

                    iconColor: "#dc2626",

                    draggable: true,

                    width: "400px",

                    showCancelButton: true,

                    confirmButtonText: "Yes, delete it",

                    cancelButtonText: "Cancel",

                    showClass: {
                        popup: "",
                    },

                    hideClass: {
                        popup: "",
                    },

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
