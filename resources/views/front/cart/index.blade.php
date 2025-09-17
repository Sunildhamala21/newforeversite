@extends('layouts.front_inner')

@section('title', 'Cart')
@section('content')
    @livewire('cart-table')
    @push('scripts')
        <script type="text/javascript">
            $(function() {
                var session_success_message = '{{ session()->has('success_message') ? session()->get('success_message') : '' }}';
                var session_error_message = '{{ session()->has('success_message') ? session()->get('success_message') : '' }}';
                if (session_success_message) {
                    toastr.success(session_success_message);
                }
                if (session_error_message) {
                    toastr.danger(session_error_message);
                }
            });
        </script>
    @endpush
@endsection
