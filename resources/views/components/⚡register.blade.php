<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

new class extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function register()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Registration successful! Please login.',
        ]);

        return redirect()->route('livewire.login');
    }
};
?>

<div
    class="flex min-h-screen items-center justify-center bg-gray-100 px-4 py-8"
>
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-lg">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Create Account</h1>

            <p class="mt-2 text-sm text-gray-500">Register to start managing your tasks</p>
        </div>

        <form wire:submit="register" class="space-y-5">
            {{-- Name --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Name <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    wire:model="name"
                    autocomplete="name"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 transition outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />

                @error ('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Email <span class="text-red-500">*</span>
                </label>

                <input
                    type="email"
                    wire:model="email"
                    autocomplete="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 transition outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />

                @error ('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Password <span class="text-red-500">*</span>
                </label>

                <input
                    type="password"
                    wire:model="password"
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 transition outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />

                @error ('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm password --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Confirm Password <span class="text-red-500">*</span>
                </label>

                <input
                    type="password"
                    wire:model="password_confirmation"
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 transition outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />

                @error ('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="register"
                class="w-full rounded-lg bg-blue-600 px-4 py-2.5 font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="register">
                    Register
                </span>

                <span wire:loading wire:target="register">
                    Creating account...
                </span>
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            Already have an account?

            <a
                href="{{ route('livewire.login') }}"
                class="font-medium text-blue-600 hover:text-blue-700"
            >
                Login
            </a>
        </div>
    </div>
</div>
