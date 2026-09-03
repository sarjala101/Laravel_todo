<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Forgot Password - Todo App</title>

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
                    Forgot Password?
                </h1>

                <p class="text-gray-500 mt-2">
                    Enter your email and we'll send you a password reset link.
                </p>

            </div>


            <!-- FORM -->

            <form
                action="{{ route('password.email') }}"
                method="POST"
                id="forgot-password-form"
                novalidate
            >

                @csrf


                <!-- EMAIL -->

                <div class="mb-6">

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
                        placeholder="Enter your registered email"
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


                <!-- BUTTON -->

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white
                           py-3 rounded-lg
                           hover:bg-blue-700
                           transition font-medium"
                >
                    Send Password Reset Link
                </button>

            </form>


            <!-- BACK TO LOGIN -->

            <div class="text-center mt-6 text-sm text-gray-600">

                <span>Remember your password?</span>

                <a
                    href="{{ route('login') }}"
                    class="text-blue-600 hover:text-blue-700
                           font-medium ml-1"
                >
                    Back to Login
                </a>

            </div>


        </div>

    </div>



    <!-- EMAIL VALIDATION -->

    <script>

        const emailInput =
            document.getElementById('email');

        const emailError =
            document.getElementById('email-error');

        const forgotPasswordForm =
            document.getElementById('forgot-password-form');


        /*
        |--------------------------------------------------------------------------
        | Helper functions
        |--------------------------------------------------------------------------
        */

        function showError() {

            emailInput.classList.remove(
                'border-gray-300',
                'border-green-500'
            );

            emailInput.classList.add('border-red-500');

            emailError.classList.remove('hidden');

        }


        function showValid() {

            emailInput.classList.remove(
                'border-gray-300',
                'border-red-500'
            );

            emailInput.classList.add('border-green-500');

            emailError.classList.add('hidden');

        }


        function resetInput() {

            emailInput.classList.remove(
                'border-red-500',
                'border-green-500'
            );

            emailInput.classList.add('border-gray-300');

            emailError.classList.add('hidden');

        }


        /*
        |--------------------------------------------------------------------------
        | Email validation
        |--------------------------------------------------------------------------
        */

        function validateEmail(showEmptyError = false) {

            const value =
                emailInput.value.trim();


            if (value.length === 0) {

                if (showEmptyError) {

                    showError();

                } else {

                    resetInput();

                }

                return false;

            }


            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            if (!emailPattern.test(value)) {

                showError();

                return false;

            }


            showValid();

            return true;

        }


        /*
        |--------------------------------------------------------------------------
        | Validate while typing
        |--------------------------------------------------------------------------
        */

        emailInput.addEventListener(
            'input',
            function () {

                validateEmail();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Final validation
        |--------------------------------------------------------------------------
        */

        forgotPasswordForm.addEventListener(
            'submit',
            function (event) {

                const emailValid =
                    validateEmail(true);


                if (!emailValid) {

                    event.preventDefault();

                }

            }
        );

    </script>


</body>

</html>