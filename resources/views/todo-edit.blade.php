<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Todo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-gray-100">

    <div class="max-w-xl mx-auto px-4 py-10">

        <div class="bg-white rounded-xl shadow-sm p-6">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Edit Todo
            </h1>

            <form
                action="/todo/{{ $todo->id }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Task
                </label>

                <input
                    type="text"
                    name="task"
                    value="{{ $todo->task }}"
                    required
                    class="w-full border border-gray-300 rounded-lg
                           px-4 py-3
                           focus:outline-none
                           focus:ring-2
                           focus:ring-blue-500"
                >


                <div class="flex gap-3 mt-5">

                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-5 py-3 rounded-lg
                               hover:bg-blue-700 transition"
                    >
                        Update
                    </button>


                    <a
                        href="/todo"
                        class="px-5 py-3 rounded-lg
                               border border-gray-300
                               text-gray-600
                               hover:bg-gray-50 transition"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>