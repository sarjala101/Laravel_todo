<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - Todo App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

    <!-- TOAST MESSAGES -->

    @include('components.toast')


    <div class="w-full max-w-md">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">

            <!-- TITLE -->

            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-gray-800">
                    Welcome Back
                </h1>

                <p class="text-gray-500 mt-2">
                    Login to manage your todos
                </p>

            </div>


            <!-- LOGIN FORM -->

            <form
                action="/login"
                method="POST"
                autocomplete="off"
            >

                @csrf


                <!-- EMAIL -->

                <div class="mb-5">

                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 mb-2"
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
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                </div>


                <!-- PASSWORD -->

                <div class="mb-6">

                    <div class="flex items-center justify-between mb-2">

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
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                </div>

                <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-blue-600 hover:text-blue-700 font-medium"
                        >
                            Forgot Password?
                        </a>


                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white
                           py-3 rounded-lg
                           hover:bg-blue-700
                           transition font-medium mt-[15px]"
                >
                    Login
                </button>

            </form>


            <!-- REGISTER -->

            <div class="text-center mt-6 text-sm text-gray-600">

                <span>Don't have an account?</span>

                <a
                    href="{{ route('register') }}"
                    class="text-blue-600 hover:text-blue-700
                           font-medium ml-1"
                >
                    Register now
                </a>

            </div>


        </div>

    </div>


</body>

</html>