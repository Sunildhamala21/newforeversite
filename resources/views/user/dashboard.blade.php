@extends('layouts.auth')

@section('content')
    <div class="max-w-md px-4 py-20 mx-auto">
        Welcome, {{ auth()->user()->name }}
    </div>
@endsection
