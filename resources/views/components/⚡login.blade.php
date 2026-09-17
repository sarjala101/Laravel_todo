<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $email = '';

    public $password = '';

    public $remember = false;


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Check Credentials
        |--------------------------------------------------------------------------
        */

        if (! Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {

            $this->addError(
                'email',
                'The provided credentials are incorrect.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        request()->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Login Toast
        |--------------------------------------------------------------------------
        */

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Login successful!',
        ]);


        return redirect()->route('livewire.todo');
    }
};
?>

<div class="flex min-h-screen items-center justify-center bg-gray-100 px-4">
    {{-- ================================================================
         Toast
    ================================================================= --}}

    @if (session()->has('toast'))
        <div
            data-toast
            data-toast-type="{{ session('toast.type') }}"
            data-toast-message="{{ session('toast.message') }}"
            class="hidden"
        ></div>

    @endif

    <div class="w-full max-w-md">
        <div class="rounded-xl bg-white p-6 shadow-sm">
            {{-- ============================================================
                 Header
            ============================================================= --}}

            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-800">Livewire Login</h1>

                <p class="mt-1 text-sm text-gray-500">Login using a Livewire component</p>
            </div>

            {{-- ============================================================
                 Login Form
            ============================================================= --}}

            <form wire:submit="login">
                {{-- Email --}}

                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Email
                    </label>

                    <input
                        type="email"
                        wire:model="email"
                        autocomplete="email"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    />

                    @error ('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                    @enderror
                </div>

                {{-- Password --}}

                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Password
                    </label>

                    <input
                        type="password"
                        wire:model="password"
                        autocomplete="current-password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    />

                    @error ('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                    @enderror
                </div>

                {{-- Remember Me --}}

                <div class="mb-6 flex items-center gap-2">
                    <input
                        type="checkbox"
                        wire:model="remember"
                        class="rounded border-gray-300"
                    />

                    <label class="text-sm text-gray-600"> Remember me </label>
                </div>

                {{-- Login Button --}}

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="login"
                    class="w-full rounded-lg bg-blue-600 py-3 font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="login"> Login </span>

                    <span wire:loading wire:target="login">
                        Logging in...
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>
