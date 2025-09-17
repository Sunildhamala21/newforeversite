@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="max-w-md px-4 py-20 mx-auto">
        <h1 class="text-xl font-semibold text-center">Create an Account</h1>
        <form action="{{ route('auth.register') }}" method="post" class="mt-10 space-y-4">
            @csrf

            {{-- @foreach ($errors->all() as $m)
                {{ $m }}
            @endforeach --}}
            <x-forms.field field="name" />
            <x-forms.field field="email" type="email" autocomplete="username" />
            <x-forms.field field="password" type="password" autocomplete="new-password" />
            <x-forms.field field="password_confirmation" type="password" autocomplete="new-password" />

            <div class="mt-10">
                <button type="submit" class="justify-center w-full font-semibold btn btn-accent">Register</button>
                <a href="/login" class="block mt-4 text-sm">Already have an account? <span
                        class="underline">Login</span></a>
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
