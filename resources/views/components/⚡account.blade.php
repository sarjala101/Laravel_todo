<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | Store Logout Toast After Session Invalidation
        |--------------------------------------------------------------------------
        */

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Logout successful!',
        ]);


        return redirect()->route('livewire.login');
    }
};
?>

<div class="min-h-screen bg-gray-100 py-8">
    <div class="mx-auto max-w-2xl px-4">
        {{-- ============================================================
             Toast
        ============================================================= --}}

        @if (session()->has('toast'))
            <div
                data-toast
                data-toast-type="{{ session('toast.type') }}"
                data-toast-message="{{ session('toast.message') }}"
                class="hidden"
            ></div>

        @endif

        <div class="rounded-xl bg-white p-6 shadow-sm">
            {{-- ============================================================
                 Header
            ============================================================= --}}

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">My Account</h1>

                <p class="mt-1 text-sm text-gray-500">Your authenticated user information</p>
            </div>

            {{-- ============================================================
                 User Information
            ============================================================= --}}

            <div class="mb-6 rounded-lg bg-gray-50 p-4">
                <p class="text-xs font-medium text-gray-500">Name</p>

                <p class="mt-1 text-lg font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </p>

                <p class="mt-4 text-xs font-medium text-gray-500">Email</p>

                <p class="mt-1 text-sm text-gray-700">
                    {{ auth()->user()->email }}
                </p>
            </div>

            {{-- ============================================================
                 Buttons
            ============================================================= --}}

            <div class="flex gap-3">
                <a
                    href="{{ route('livewire.todo') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Back to Tasks
                </a>

                <button
                    type="button"
                    wire:click="logout"
                    wire:loading.attr="disabled"
                    wire:target="logout"
                    class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="logout">
                        Logout
                    </span>

                    <span wire:loading wire:target="logout">
                        Logging out...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
