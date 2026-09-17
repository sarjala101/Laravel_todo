<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public $token = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    public function resetPassword()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],

            function (User $user, string $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Password reset successfully. Please login.',
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
            <h1 class="text-3xl font-bold text-gray-800">Reset Password</h1>

            <p class="mt-2 text-sm text-gray-500">Enter your new password below.</p>
        </div>

        <form wire:submit="resetPassword" class="space-y-5">
            {{-- Email --}}
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

            {{-- Password --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    New Password
                </label>

                <input
                    type="password"
                    wire:model="password"
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />

                @error ('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Confirm New Password
                </label>

                <input
                    type="password"
                    wire:model="password_confirmation"
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />

                @error ('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="resetPassword"
                class="w-full rounded-lg bg-blue-600 px-4 py-2.5 font-medium text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="resetPassword">
                    Reset Password
                </span>

                <span wire:loading wire:target="resetPassword">
                    Resetting...
                </span>
            </button>
        </form>
    </div>
</div>
