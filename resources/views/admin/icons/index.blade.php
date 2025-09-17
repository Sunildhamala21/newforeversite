@extends('layouts.admin')
@section('content')
    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon-earth-globe"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Icons
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="dropdown dropdown-inline">
                        </div>
                    </div>
                </div>
            </div>

            <div class="kt-portlet__body" x-data="{ keyword: '' }">
                <div class="form-group"><input type="text" class="form-control" x-model="keyword" placeholder="Search">
                </div>
                <div style="display:grid;grid-template-columns: repeat( auto-fit, minmax(250px, 1fr) );gap:10px;">
                    @foreach ($icons as $icon)
                        <div x-on:click="copyContent('{{ str($icon)->chopStart('icon-') }}')"
                            x-show="'{{ str($icon)->chopStart('icon-') }}'.includes(keyword)">
                            <div style="display:flex;align-items:center;gap:4px;">
                                <x-dynamic-component :component="$icon" style="width:30;height:30;pointer-events: none" />
                                <div>{{ str($icon)->chopStart('icon-') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const copyContent = async (text) => {
                try {
                    await navigator.clipboard.writeText(text);
                } catch (err) {}
            }
        </script>
    @endpush
    <!-- end:: Content -->
@endsection
