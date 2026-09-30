<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    //welcome message
    <title>Welcome Back: Todo App</title>

    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen items-center justify-center bg-gray-100 px-4">
    <!-- TOAST MESSAGES -->

    @include ('components.toast')

    <div class="w-full max-w-md">
        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            <!-- TITLE -->

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Welcome Back</h1>

                <p class="mt-2 text-gray-500">Login to manage your todos</p>
            </div>

            <!-- LOGIN FORM -->

            <form action="/login" method="POST" autocomplete="off">
                @csrf

                <!-- EMAIL -->

                <div class="mb-5">
                    <label
                        for="email"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        required
                        autocomplete="email"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <!-- PASSWORD -->

                <div class="mb-6">
                    <div class="mb-2 flex items-center justify-between">
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Password
                        </label>
                    </div>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <a
                    href="{{ route('password.request') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-700"
                >
                    Forgot Password?
                </a>

                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    class="mt-[15px] w-full rounded-lg bg-blue-600 py-3 font-medium text-white transition hover:bg-blue-700"
                >
                    Login
                </button>
            </form>

            <!-- REGISTER -->

            <div class="mt-6 text-center text-sm text-gray-600">
                <span>Don't have an account?</span>

                <a
                    href="{{ route('register') }}"
                    class="ml-1 font-medium text-blue-600 hover:text-blue-700"
                >
                    Register Now
                </a>
            </div>
        </div>
    </div>
</body>
</html>
