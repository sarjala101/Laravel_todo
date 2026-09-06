<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reset Password - Todo App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen
 bg-gray-100 flex items-center justify-center px-4">

    <!-- TOAST MESSAGES -->

    @include('components.toast')


    <div class="w-full max-w-md">

        <div class="bg-white rounded-xl
         shadow-sm border border-gray-200 p-8">


            <!-- TITLE -->

            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-gray-800">
                    Reset Password
                </h1>

                <p class="text-gray-500 mt-2">
                    Enter your new password below
                </p>

            </div>


            <!-- RESET PASSWORD FORM -->

            <form
                action="{{ route('password.update') }}"
                method="POST"
            >

                @csrf

                <input
                    type="hidden"
                    name="token"
                    value="{{ $token }}"
                >


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
                        value="{{ $email }}"
                        required
                        readonly
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3 bg-gray-100
                               focus:outline-none"
                    >

                </div>


                <!-- NEW PASSWORD -->

                <div class="mb-5">

                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        New Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter new password"
                        required
                        minlength="6"
                        autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                </div>


                <!-- CONFIRM PASSWORD -->

                <div class="mb-6">

                    <label
                        for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm new password"
                        required
                        minlength="6"
                        autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                </div>


                <!-- RESET BUTTON -->

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white
                           py-3 rounded-lg
                           hover:bg-blue-700
                           transition font-medium"
                >
                    Reset Password
                </button>

            </form>


            <!-- BACK TO LOGIN -->

            <div class="text-center mt-6 text-sm">

                <a
                    href="{{ route('login') }}"
                    class="text-blue-600 hover:text-blue-700 font-medium"
                >
                    ← Back to Login
                </a>

            </div>


        </div>

    </div>


</body>

</html>