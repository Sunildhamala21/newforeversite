@extends('layouts.admin')

@section('content')
    <div class="container"><a href="{{ url('generate-sitemap') }}" class="btn btn-primary">Build Sitemap</a></div>
    <div class="container mt-4"><a href="{{ url('generate-sitemap-image') }}" class="btn btn-primary">Build Image Sitemap</a></div>
@endsection
