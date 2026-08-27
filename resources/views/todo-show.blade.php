<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Task Details</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-gray-100">


<div class="max-w-2xl mx-auto px-4 py-10">


    <!-- BACK -->

    <a
        href="/todo"
        class="text-blue-600 hover:underline"
    >
        ← Back to Todo List
    </a>



    <!-- DETAILS CARD -->

    <div class="bg-white rounded-xl shadow-sm p-6 mt-5">


        <!-- TITLE -->

        <div class="flex justify-between items-start gap-4">

            <h1 class="text-2xl font-bold text-gray-800">
                {{ $todo->task }}
            </h1>


            <!-- PRIORITY -->

            <span
                class="px-3 py-1 rounded-full text-sm font-medium
                {{ $todo->priority === 'high'
                    ? 'bg-red-100 text-red-700'
                    : ($todo->priority === 'medium'
                        ? 'bg-yellow-100 text-yellow-700'
                        : 'bg-green-100 text-green-700') }}"
            >
                {{ ucfirst($todo->priority) }}
            </span>

        </div>



        <!-- DESCRIPTION -->

        <div class="mt-6">

            <h2 class="text-sm font-semibold text-gray-500">
                Description
            </h2>

            <p class="mt-2 text-gray-700 whitespace-pre-line">
                {{ $todo->description ?: 'No description added.' }}
            </p>

        </div>



        <!-- STATUS -->

        <div class="mt-6">

            <h2 class="text-sm font-semibold text-gray-500">
                Status
            </h2>

            @if($todo->is_completed)

                <p class="mt-2 text-green-600 font-medium">
                    ✓ Completed
                </p>

            @else

                <p class="mt-2 text-orange-500 font-medium">
                    ⏳ Pending
                </p>

            @endif

        </div>



        <!-- CREATED DATE -->

        <div class="mt-6">

            <h2 class="text-sm font-semibold text-gray-500">
                Created Date
            </h2>

            <p class="mt-2 text-gray-700">
                {{ $todo->created_at->format('M d, Y h:i A') }}
            </p>

        </div>



        <!-- UPDATED DATE -->

        <div class="mt-6">

            <h2 class="text-sm font-semibold text-gray-500">
                Last Updated
            </h2>

            <p class="mt-2 text-gray-700">
                {{ $todo->updated_at->format('M d, Y h:i A') }}
            </p>

        </div>



        <!-- COMPLETED DATE -->

        @if($todo->is_completed && $todo->completed_at)

            <div class="mt-6">

                <h2 class="text-sm font-semibold text-gray-500">
                    Completed Date
                </h2>

                <p class="mt-2 text-green-600">
                    {{ $todo->completed_at->format('M d, Y h:i A') }}
                </p>

            </div>

        @endif



        <!-- ACTIONS -->

        <div class="mt-8 flex gap-3">


            @if(!$todo->is_completed)

                <a
                    href="/todo/{{ $todo->id }}/edit"
                    class="px-4 py-2 bg-blue-600
                           text-white rounded-lg
                           hover:bg-blue-700"
                >
                    Edit Task
                </a>

            @endif


            <a
                href="/todo"
                class="px-4 py-2 border border-gray-300
                       rounded-lg hover:bg-gray-50"
            >
                Back
            </a>

        </div>

    </div>

</div>


</body>

</html>