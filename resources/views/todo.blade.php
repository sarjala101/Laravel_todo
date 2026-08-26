<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Todo List</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-gray-100">

    <div class="max-w-2xl mx-auto px-4 py-10">

        <!-- Header -->

        <div class="text-center mb-8">

            <h1 class="text-4xl font-bold text-gray-800">
                My Todo List
            </h1>

            <p class="text-gray-500 mt-2">
                Stay organized, one task at a time.
            </p>

        </div>


        <!-- Add Todo -->

        <div class="bg-white rounded-xl shadow-sm p-5 mb-6">

            <form action="/todo" method="POST" class="flex gap-3">

                @csrf

                <input
                    type="text"
                    name="task"
                    placeholder="What do you need to do?"
                    required
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg
                           hover:bg-blue-700 transition"
                >
                    Add
                </button>

            </form>

        </div>


        <!-- Todo List -->

        <div class="bg-white rounded-xl shadow-sm p-5">

            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                My Tasks
            </h2>


            @if ($todos->count() > 0)

                <div class="space-y-3">

                    @foreach ($todos as $todo)

                        <div
                            class="flex items-center justify-between
                                   border border-gray-200 rounded-lg
                                   p-4 hover:bg-gray-50 transition"
                        >

                            <span class="text-gray-700">
                                {{ $todo->task }}
                            </span>


                            <div class="flex gap-2">

                                <!-- Edit -->

                                <a
                                    href="/todo/{{ $todo->id }}/edit"
                                    class="px-3 py-2 text-sm text-blue-600
                                           border border-blue-200 rounded-lg
                                           hover:bg-blue-50 transition"
                                >
                                    Edit
                                </a>


                                <!-- Delete -->

                                <form
                                    action="/todo/{{ $todo->id }}"
                                    method="POST"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-3 py-2 text-sm text-red-600
                                               border border-red-200 rounded-lg
                                               hover:bg-red-50 transition"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="text-center py-10">

                    <p class="text-gray-400">
                        No tasks yet.
                    </p>

                    <p class="text-gray-400 text-sm mt-1">
                        Add your first task above.
                    </p>

                </div>

            @endif

        </div>

    </div>

</body>

</html>