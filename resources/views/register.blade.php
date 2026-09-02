<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register - Todo App</title>

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
                    Create Account
                </h1>

                <p class="text-gray-500 mt-2">
                    Register to start managing your todos
                </p>

            </div>


            <!-- REGISTER FORM -->

            <form
                action="/register"
                method="POST"
                id="register-form"
                novalidate
            >

                @csrf


                <!-- NAME -->

                <div class="mb-5">

                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Name <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter your name"
                        autocomplete="name"
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                    <p
                        id="name-error"
                        class="text-red-500 text-sm mt-1 hidden"
                    >
                        Name is required.
                    </p>

                </div>


                <!-- EMAIL -->

                <div class="mb-5">

                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Email <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        autocomplete="email"
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                    <p
                        id="email-error"
                        class="text-red-500 text-sm mt-1 hidden"
                    >
                        Please enter a valid email address.
                    </p>

                </div>


                <!-- PASSWORD -->

                <div class="mb-5">

                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Password <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                    <p
                        id="password-error"
                        class="text-red-500 text-sm mt-1 hidden"
                    >
                        Password must be at least 6 characters.
                    </p>

                </div>


                <!-- CONFIRM PASSWORD -->

                <div class="mb-6">

                    <label
                        for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Confirm Password <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                        autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500"
                    >

                    <p
                        id="confirm-password-error"
                        class="text-red-500 text-sm mt-1 hidden"
                    >
                        Passwords do not match.
                    </p>

                </div>


                <!-- REGISTER BUTTON -->

                <button
                    type="submit"
                    id="register-button"
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



    <!-- LIVE VALIDATION -->

    <script>

        const nameInput =
            document.getElementById('name');

        const emailInput =
            document.getElementById('email');

        const passwordInput =
            document.getElementById('password');

        const confirmPasswordInput =
            document.getElementById('password_confirmation');


        const nameError =
            document.getElementById('name-error');

        const emailError =
            document.getElementById('email-error');

        const passwordError =
            document.getElementById('password-error');

        const confirmPasswordError =
            document.getElementById('confirm-password-error');



        /*
        |--------------------------------------------------------------------------
        | Helper functions
        |--------------------------------------------------------------------------
        */

        function showError(input, errorElement) {

            input.classList.remove(
                'border-gray-300',
                'border-green-500'
            );

            input.classList.add('border-red-500');

            errorElement.classList.remove('hidden');

        }


        function showValid(input, errorElement) {

            input.classList.remove(
                'border-gray-300',
                'border-red-500'
            );

            input.classList.add('border-green-500');

            errorElement.classList.add('hidden');

        }


        function resetInput(input, errorElement) {

            input.classList.remove(
                'border-red-500',
                'border-green-500'
            );

            input.classList.add('border-gray-300');

            errorElement.classList.add('hidden');

        }



        /*
        |--------------------------------------------------------------------------
        | Name validation
        |--------------------------------------------------------------------------
        */

        function validateName(showEmptyError = false) {

            const value = nameInput.value.trim();

            if (value.length === 0) {

                if (showEmptyError) {

                    showError(
                        nameInput,
                        nameError
                    );

                } else {

                    resetInput(
                        nameInput,
                        nameError
                    );

                }

                return false;

            }

            showValid(
                nameInput,
                nameError
            );

            return true;

        }



        /*
        |--------------------------------------------------------------------------
        | Email validation
        |--------------------------------------------------------------------------
        */

        function validateEmail(showEmptyError = false) {

            const value = emailInput.value.trim();

            if (value.length === 0) {

                if (showEmptyError) {

                    showError(
                        emailInput,
                        emailError
                    );

                } else {

                    resetInput(
                        emailInput,
                        emailError
                    );

                }

                return false;

            }


            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            if (!emailPattern.test(value)) {

                showError(
                    emailInput,
                    emailError
                );

                return false;

            }


            showValid(
                emailInput,
                emailError
            );

            return true;

        }



        /*
        |--------------------------------------------------------------------------
        | Password validation
        |--------------------------------------------------------------------------
        */

        function validatePassword(showEmptyError = false) {

            const value = passwordInput.value;

            if (value.length === 0) {

                if (showEmptyError) {

                    showError(
                        passwordInput,
                        passwordError
                    );

                } else {

                    resetInput(
                        passwordInput,
                        passwordError
                    );

                }

                return false;

            }


            if (value.length < 6) {

                showError(
                    passwordInput,
                    passwordError
                );

                return false;

            }


            showValid(
                passwordInput,
                passwordError
            );


            if (confirmPasswordInput.value.length > 0) {

                validateConfirmPassword();

            }


            return true;

        }



        /*
        |--------------------------------------------------------------------------
        | Confirm password validation
        |--------------------------------------------------------------------------
        */

        function validateConfirmPassword(showEmptyError = false) {

            const password =
                passwordInput.value;

            const confirmation =
                confirmPasswordInput.value;


            if (confirmation.length === 0) {

                if (showEmptyError) {

                    showError(
                        confirmPasswordInput,
                        confirmPasswordError
                    );

                } else {

                    resetInput(
                        confirmPasswordInput,
                        confirmPasswordError
                    );

                }

                return false;

            }


            if (password !== confirmation) {

                showError(
                    confirmPasswordInput,
                    confirmPasswordError
                );

                return false;

            }


            showValid(
                confirmPasswordInput,
                confirmPasswordError
            );

            return true;

        }



        /*
        |--------------------------------------------------------------------------
        | Validate while typing
        |--------------------------------------------------------------------------
        */

        nameInput.addEventListener(
            'input',
            function () {
                validateName();
            }
        );


        emailInput.addEventListener(
            'input',
            function () {
                validateEmail();
            }
        );


        passwordInput.addEventListener(
            'input',
            function () {
                validatePassword();
            }
        );


        confirmPasswordInput.addEventListener(
            'input',
            function () {
                validateConfirmPassword();
            }
        );



        /*
        |--------------------------------------------------------------------------
        | Final browser-side validation
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('register-form')
            .addEventListener(
                'submit',
                function (event) {

                    const nameValid =
                        validateName(true);

                    const emailValid =
                        validateEmail(true);

                    const passwordValid =
                        validatePassword(true);

                    const confirmPasswordValid =
                        validateConfirmPassword(true);


                    if (
                        !nameValid ||
                        !emailValid ||
                        !passwordValid ||
                        !confirmPasswordValid
                    ) {

                        event.preventDefault();

                    }

                }
            );

    </script>


</body>

</html>