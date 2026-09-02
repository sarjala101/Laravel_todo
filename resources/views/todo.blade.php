<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Todo List</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-gray-100">


    <!-- TOAST MESSAGES -->

    @include('components.toast')


    <div class="max-w-3xl mx-auto px-4 py-10">


        <!-- HEADER -->

        <div class="flex items-center justify-between mb-8">


            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    My Todo List
                </h1>


                @auth

                    <p class="text-gray-500 mt-1">
                        Welcome, {{ auth()->user()->name }}
                    </p>

                @endauth

            </div>



            <!-- LOGOUT BUTTON -->

            <form
                action="/logout"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="px-4 py-2
                           bg-blue-600 text-white
                           rounded-lg
                           hover:bg-blue-700
                           transition"
                >
                    Logout
                </button>

            </form>


        </div>



        <!-- ADD TASK FORM -->

        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">


            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Add New Task
            </h2>


            <form
                action="/todo"
                method="POST"
            >

                @csrf


                <!-- TASK -->

                <input
                    type="text"
                    name="task"
                    placeholder="Enter task name"
                    value="{{ old('task') }}"
                    class="w-full border border-gray-300 rounded-lg
                           px-4 py-3 mb-3
                           focus:outline-none focus:ring-2
                           focus:ring-blue-500"
                    required
                >


                <!-- DESCRIPTION -->

                <textarea
                    name="description"
                    rows="3"
                    placeholder="Enter task description"
                    class="w-full border border-gray-300 rounded-lg
                           px-4 py-3 mb-3
                           focus:outline-none focus:ring-2
                           focus:ring-blue-500"
                >{{ old('description') }}</textarea>


                <!-- PRIORITY -->

                <select
                    name="priority"
                    class="w-full border border-gray-300 rounded-lg
                           px-4 py-3 mb-4
                           focus:outline-none focus:ring-2
                           focus:ring-blue-500"
                >

                    <option value="medium" selected>
                        Medium Priority
                    </option>

                    <option value="high">
                        High Priority
                    </option>

                    <option value="low">
                        Low Priority
                    </option>

                </select>


                <!-- ADD BUTTON -->

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white
                           py-3 rounded-lg
                           hover:bg-blue-700 transition"
                >
                    Add Task
                </button>

            </form>


        </div>



        <!-- VALIDATION ERRORS ARE NOW TOASTS -->



        <!-- TASK LIST -->

        <div class="space-y-4">


            @forelse($todos as $todo)


                <!-- TASK CARD -->

                <div
                    class="bg-white border border-gray-200
                           rounded-xl p-5 shadow-sm
                           hover:shadow-md transition"
                >


                    <div class="flex items-start justify-between gap-4">


                        <!-- LEFT SIDE -->

                        <div class="flex items-start gap-3 flex-1">


                            <!-- CHECKBOX -->

                            <form
                                action="/todo/{{ $todo->id }}/complete"
                                method="POST"
                            >

                                @csrf

                                @method('PATCH')

                                <input
                                    type="checkbox"
                                    onchange="this.form.submit()"
                                    {{ $todo->is_completed ? 'checked' : '' }}
                                    class="w-5 h-5 mt-1 cursor-pointer"
                                >

                            </form>



                            <!-- TASK INFORMATION -->

                            <a
                                href="/todo/{{ $todo->id }}"
                                class="flex-1"
                            >

                                <div>


                                    <!-- TASK NAME -->

                                    <h3
                                        class="text-lg font-semibold
                                        {{ $todo->is_completed
                                            ? 'line-through text-gray-400'
                                            : 'text-gray-800' }}"
                                    >
                                        {{ $todo->task }}
                                    </h3>



                                    <!-- PRIORITY -->

                                    <span
                                        class="inline-block mt-2
                                               px-2.5 py-1 rounded-full
                                               text-xs font-medium
                                        {{ $todo->priority === 'high'
                                            ? 'bg-red-100 text-red-700'
                                            : ($todo->priority === 'medium'
                                                ? 'bg-yellow-100 text-yellow-700'
                                                : 'bg-green-100 text-green-700') }}"
                                    >
                                        {{ ucfirst($todo->priority) }}
                                    </span>



                                    <!-- COMPLETED DATE -->

                                    @if($todo->is_completed && $todo->completed_at)

                                        <p class="text-xs text-green-600 mt-2">

                                            Done:
                                            {{ $todo->completed_at->format('M d, Y h:i A') }}

                                        </p>

                                    @endif


                                </div>

                            </a>


                        </div>



                        <!-- BUTTONS -->

                        <div class="flex gap-2">


                            <!-- EDIT -->

                            @if(!$todo->is_completed)

                                <a
                                    href="/todo/{{ $todo->id }}/edit"
                                    class="px-3 py-2 text-sm
                                           text-blue-600
                                           border border-blue-200
                                           rounded-lg
                                           hover:bg-blue-50"
                                >
                                    Edit
                                </a>

                            @endif



                            <!-- DELETE -->

                            <form
                                action="/todo/{{ $todo->id }}"
                                method="POST"
                                class="delete-form"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="px-3 py-2 text-sm
                                           text-red-600
                                           border border-red-200
                                           rounded-lg
                                           hover:bg-red-50"
                                >
                                    Delete
                                </button>

                            </form>


                        </div>


                    </div>


                </div>


            @empty


                <!-- NO TASK -->

                <div
                    class="bg-white rounded-xl
                           p-8 text-center text-gray-500"
                >
                    No tasks yet. Add your first task!
                </div>


            @endforelse


        </div>


    </div>


</body>

</html>