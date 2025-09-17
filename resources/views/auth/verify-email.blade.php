@extends('layouts.auth')

@section('content')
    <div class="max-w-md px-4 py-20 mx-auto">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we
            just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif
        <div class="flex items-center justify-between mt-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div>
                    <button class="btn btn-primary">
                        Resend Verification Email
                    </button>
                </div>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
@endsection
