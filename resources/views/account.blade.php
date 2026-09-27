<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 py-8">

    <div class="mx-auto max-w-3xl px-4">

        <!-- HEADER -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
                <p class="mt-1 text-sm text-gray-500">View your account information.</p>
            </div>

            <a
                href="{{ route('todo.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition"
            >
                Back to Tasks
            </a>
        </div>

        <!-- PROFILE CARD -->
        <div class="rounded-2xl bg-white p-6 shadow-sm">

            <div class="flex items-center gap-4 border-b border-gray-200 pb-6">
                <div
                    class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 text-2xl font-bold text-blue-600"
                >
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ Auth::user()->name }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div class="rounded-lg bg-gray-50 p-4">
                    <p class="text-xs font-medium text-gray-400 uppercase">Name</p>
                    <p class="mt-1 font-medium text-gray-800">
                        {{ Auth::user()->name }}
                    </p>
                </div>

                <div class="rounded-lg bg-gray-50 p-4">
                    <p class="text-xs font-medium text-gray-400 uppercase">Email</p>
                    <p class="mt-1 font-medium text-gray-800">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>

            <div class="mt-6 border-t border-gray-200 pt-6">
                <form action="/logout" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700 transition"
                    >
                        Logout
                    </button>
                </form>
            </div>

        </div>

    </div>

</body>

</html>
