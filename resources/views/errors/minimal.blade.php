@extends('layouts.front_inner')
@section('content')
    <style type="text/css">
        .error-template {
            padding: 40px 15px;
            text-align: center;
        }

        .error-actions {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .error-actions .btn {
            margin-right: 10px;
        }
    </style>

    <div class="container">
        <div class="py-10 row" style="text-align: center;">
            <div class="col-md-12">
                <div class="error-template">
                    <h1> Oops!</h1>
                    <h2> @yield('code')</h2>
                    <div class="error-details">
                        @yield('message')
                    </div>
                    <div class="error-actions">
                        <a href="{{ url('/') }}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-home"></span>
                            Take Me Home </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
