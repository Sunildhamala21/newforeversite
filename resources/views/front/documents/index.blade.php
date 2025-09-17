@extends('layouts.front_inner')
@section('title', 'Company Legal Documents')
@section('content')
    <x-hero title="Legal Documents" />

    <section>
        <div class="container py-20">
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 md:gap-8">
                @forelse($documents as $document)
                    <a href="{{ $document->fileUrl }}"
                       class="stretched-link"
                       data-fancybox="gallery"
                       data-caption="{{ $document->name }}">
                        <img src="{{ $document->fileUrl }}"
                             alt="{{ $document->name }}"
                             class="w-full">
                    </a>
                @empty
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <p>No Documents to show.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>
        $(function() {
            $('[data-fancybox="gallery"]').fancybox({
                buttons: ['close']
            });
        });
    </script>
@endpush
