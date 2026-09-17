<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

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

        request()->session()->regenerate();

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Login successful!',
        ]);

        return redirect()->route('livewire.todo');
    }
};
?>

<div class="flex min-h-screen items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-lg">
        {{-- Header --}}
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Login</h1>

            <p class="mt-2 text-sm text-gray-500">Login to manage your tasks</p>
        </div>

        {{-- Login Form --}}
        <form wire:submit="login" class="space-y-5">
            {{-- Email --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Email
                </label>

                <input
                    type="email"
                    wire:model="email"
                    autocomplete="email"
                    placeholder="Enter your email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 transition outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />

                @error ('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <div class="mb-1 flex items-center justify-between">
                    <label class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                </div>

                <input
                    type="password"
                    wire:model="password"
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 transition outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />

                @error ('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me --}}
            <div class="flex items-center">
                <input
                    type="checkbox"
                    wire:model="remember"
                    id="remember"
                    class="h-4 w-4 rounded border-gray-300"
                />

                <label for="remember" class="ml-2 text-sm text-gray-600">
                    Remember me
                </label>
            </div>
            <a
                href="{{ route('password.request') }}"
                class="text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Forgot password?
            </a>

            {{-- Login button --}}
            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="login"
                class="w-full rounded-lg bg-blue-600 px-4 py-2.5 font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="login"> Login </span>

                <span wire:loading wire:target="login"> Logging in... </span>
            </button>
        </form>

        {{-- Register --}}
        <div class="mt-6 text-center text-sm text-gray-600">
            Don't have an account?

            <a
                href="{{ route('livewire.register') }}"
                class="font-medium text-blue-600 hover:text-blue-700"
            >
                Register
            </a>
        </div>
    </div>
</div>
