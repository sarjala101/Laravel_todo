<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - Todo App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">


    <div class="w-full max-w-md">


        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">


            <!-- TITLE -->

            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-gray-800">
                    Create Account
                </h1>

                <p class="text-gray-500 mt-2">
                    Register to start managing your todos
                </p>

            </div>


            <!-- VALIDATION ERRORS -->

            @if($errors->any())

                <div class="bg-red-50 border border-red-200
                            text-red-700 rounded-lg p-3 mb-5">

                    <ul class="list-disc ml-5">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- REGISTER FORM -->

            <form action="/register" method="POST">

                @csrf


                <!-- NAME -->

                <div class="mb-5">

                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter your name"
                        required
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                </div>


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
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                </div>


                <!-- PASSWORD -->

                <div class="mb-5">

                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
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
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                        required
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                </div>


                <!-- REGISTER BUTTON -->

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white
                           py-3 rounded-lg
                           hover:bg-blue-700
                           transition font-medium"
                >
                    Register
                </button>

            </form>


            <!-- LOGIN -->

            <div class="text-center mt-6 text-sm text-gray-600">

                <span>Already have an account?</span>

                <a
                    href="/login"
                    class="text-blue-600 hover:text-blue-700
                           font-medium ml-1"
                >
                    Login
                </a>

            </div>


        </div>


    </div>


</body>

</html>

