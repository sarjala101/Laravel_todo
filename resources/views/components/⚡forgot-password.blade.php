<?php

use Illuminate\Support\Facades\Password;
use Livewire\Component;

new class extends Component
{
    public $email = '';

    public function sendResetLink()
    {
        $this->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink([
            'email' => $this->email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Password reset link sent. Check your email.',
            ]);

            return redirect()->route('livewire.login');
        }

        $this->addError('email', __($status));
    }
};
?>

<div class="flex min-h-screen items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-lg">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Forgot Password</h1>

            <p class="mt-2 text-sm text-gray-500">Enter your email and we'll send you a password reset link.</p>
        </div>

        <form wire:submit="sendResetLink" class="space-y-5">
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Email
                </label>

                <input
                    type="email"
                    wire:model="email"
                    autocomplete="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />

                @error ('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="sendResetLink"
                class="w-full rounded-lg bg-blue-600 px-4 py-2.5 font-medium text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="sendResetLink">
                    Send Reset Link
                </span>

                <span wire:loading wire:target="sendResetLink">
                    Sending...
                </span>
            </button>
        </form>

        <div class="mt-6 text-center">
            <a
                href="{{ route('livewire.login') }}"
                class="text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Back to Login
            </a>
        </div>
    </div>
</div>
