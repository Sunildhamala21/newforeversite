@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="max-w-md px-4 py-20 mx-auto">
        <h1 class="text-xl font-semibold text-center">Login</h1>

        @foreach ($errors->all() as $m)
            {{ $m }}
        @endforeach

        <form action="{{ route('auth.login') }}" class="mt-10 space-y-4" method="post">
            @csrf

            <x-forms.field field="email" type="email" autocomplete="username" />
            <x-forms.field field="password" type="password" autocomplete="current-password" />
            <div class="mt-10">
                <button type="submit" class="justify-center w-full font-semibold btn btn-accent">Login</button>
                <a href="/register" class="block mt-4 text-sm">Don't have an account? <span
                        class="underline">Register</span></a>
            </div>

            {{-- <div class="flex gap-2">
                <a href="{{ route('auth.google.redirect') }}"
                    class="flex-grow p-2 text-center bg-gray-100 border border-gray-400 rounded hover:bg-gray-200">Sign in
                    with Google</a>
                <a href="{{ route('auth.facebook.redirect') }}"
                    class="flex-grow p-2 text-center bg-gray-100 border border-gray-400 rounded hover:bg-gray-200">Sign in
                    with Facebook</a>
            </div> --}}
        </form>
    </div>
@endsection
