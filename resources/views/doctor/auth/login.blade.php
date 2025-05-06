@extends('layouts.public.doctorPortal')

@section('styles')
<style>
    .btn-primary {
        background-color: #e12454;
        color: white;
    }
    .btn-primary:hover {
        background-color: #c01e48;
    }
    .link-accent {
        color: #e12454;
    }
    .link-accent:hover {
        color: #c01e48;
        text-decoration: underline;
    }
    .border-accent {
        border-color: #e12454;
    }
    .focus-accent:focus {
        border-color: #e12454;
        ring-color: #e12454;
    }
    .checkbox-accent:checked {
        background-color: #e12454;
        border-color: #e12454;
    }
</style>
@endsection

@section('content')
<div class=" mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Left Side - Welcome Message -->
            <div class="md:w-2/5 bg-[#223a66] p-8 text-white">
                <h2 class="text-2xl font-bold mb-6">Welcome Back</h2>
                <p class="mb-4">Sign in to access your doctor dashboard and manage your appointments.</p>
                <div class="flex items-center mt-8">
                    <svg class="h-5 w-5 text-[#e12454] mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Manage your schedule</span>
                </div>
                <div class="flex items-center mt-3">
                    <svg class="h-5 w-5 text-[#e12454] mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>View patient records</span>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="md:w-3/5 p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Doctor Login</h1>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('doctor.login.submit') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full focus-accent"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required
                                    autofocus
                                    autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full focus-accent"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                  class="rounded border-gray-300 checkbox-accent focus:ring-[#e12454]"
                                  name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                            <a class="text-sm link-accent" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <button type="submit" class="btn-primary px-4 py-2 rounded-md font-medium">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
