<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Task</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-gray-100">


<div class="max-w-xl mx-auto px-4 py-10">


    <!-- BACK -->

    <a
        href="/todo"
        class="text-blue-600 hover:underline"
    >
        ← Back to Todo List
    </a>



    <!-- EDIT CARD -->

    <div class="bg-white rounded-xl shadow-sm p-6 mt-5">


        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Edit Task
        </h1>



        <!-- VALIDATION ERRORS -->

        @if($errors->any())

            <div
                class="bg-red-50 border border-red-200
                       text-red-700 rounded-lg p-4 mb-5"
            >

                <ul class="list-disc ml-5">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif



        <!-- FORM -->

        <form
            action="/todo/{{ $todo->id }}"
            method="POST"
            onsubmit="return confirm('Are you sure you want to update this task?');"
        >

            @csrf

            @method('PUT')



            <!-- TASK -->

            <label
                class="block text-sm font-medium
                       text-gray-700 mb-2"
            >
                Task Name
            </label>

            <input
                type="text"
                name="task"
                value="{{ $todo->task }}"
                class="w-full border border-gray-300
                       rounded-lg px-4 py-3 mb-5
                       focus:outline-none
                       focus:ring-2 focus:ring-blue-500"
                required
            >



            <!-- DESCRIPTION -->

            <label
                class="block text-sm font-medium
                       text-gray-700 mb-2"
            >
                Description
            </label>

            <textarea
                name="description"
                rows="5"
                class="w-full border border-gray-300
                       rounded-lg px-4 py-3 mb-5
                       focus:outline-none
                       focus:ring-2 focus:ring-blue-500"
            >{{ $todo->description }}</textarea>



            <!-- PRIORITY -->

            <label
                class="block text-sm font-medium
                       text-gray-700 mb-2"
            >
                Priority
            </label>

            <select
                name="priority"
                class="w-full border border-gray-300
                       rounded-lg px-4 py-3 mb-6
                       focus:outline-none
                       focus:ring-2 focus:ring-blue-500"
            >

                <option
                    value="high"
                    {{ $todo->priority === 'high' ? 'selected' : '' }}
                >
                    High Priority
                </option>

                <option
                    value="medium"
                    {{ $todo->priority === 'medium' ? 'selected' : '' }}
                >
                    Medium Priority
                </option>

                <option
                    value="low"
                    {{ $todo->priority === 'low' ? 'selected' : '' }}
                >
                    Low Priority
                </option>

            </select>



            <!-- BUTTONS -->

            <div class="flex gap-3">


                <button
                    type="submit"
                    class="flex-1 bg-blue-600
                           text-white py-3 rounded-lg
                           hover:bg-blue-700"
                >
                    Update Task
                </button>


                <a
                    href="/todo"
                    class="flex-1 text-center
                           border border-gray-300
                           py-3 rounded-lg
                           hover:bg-gray-50"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>


</body>

</html>