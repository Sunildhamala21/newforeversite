<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!-- begin::Head -->

<head>
    <!--begin::Base Path (base relative path for assets of this page) -->
    <base href="../../../../">
    <!--end::Base Path -->
    <meta charset="utf-8" />
    <title>Admin | Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Base form control examples">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
    <!--end::Fonts -->
    <!--begin:: Global Mandatory Vendors -->
    <link href="./assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet"
        type="text/css" />
    <!--end:: Global Mandatory Vendors -->
    <!--begin:: Global Optional Vendors -->

    <!--end:: Global Optional Vendors -->
    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="./assets/css/demo1/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->
    <!--begin::Layout Skins(used by all pages) -->
    <link href="./assets/css/demo1/skins/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/demo1/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/demo1/skins/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/demo1/skins/aside/dark.css" rel="stylesheet" type="text/css" />
    <link href="./assets/vendors/custom/vendors/line-awesome/css/line-awesome.css" rel="stylesheet" type="text/css" />
    <link href="./assets/vendors/general/toastr/build/toastr.css" rel="stylesheet" type="text/css" />
    <!--end::Layout Skins -->
    <link href="./assets/vendors/custom/vendors/flaticon/flaticon.css" rel="stylesheet" type="text/css" />
    <link href="./assets/vendors/custom/vendors/flaticon2/flaticon.css" rel="stylesheet" type="text/css" />
    <link href="./assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet"
        type="text/css" />
    <link href="./assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet"
        type="text/css" />
    <link href="./assets/vendors/general/sweetalert2/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/admin-style.css" rel="stylesheet" type="text/css" />

    @stack('styles')
</head>
<!-- end::Head -->
<!-- begin::Body -->

<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    <!-- begin:: Page -->
    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="demo1/index.html">
                <img alt="Logo" src="./assets/media/logos/logo-light.png" />
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left"
                id="kt_aside_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                    class="flaticon-more"></i></button>
        </div>
    </div>
    <!-- end:: Header Mobile -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <!-- begin:: Aside -->
            @include('admin.elements.aside-menu')
            <!-- end:: Aside -->
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                <!-- begin:: Header -->
                @include('admin.elements.header')

                <!-- end:: Header -->
                <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                    <!-- begin:: Subheader -->
                    <!-- end:: Subheader -->
                    <!-- begin:: Content -->
                    <div class="" id="kt_content">
                        <!-- begin:: Subheader -->

                        <!-- end:: Subheader -->
                        @yield('content')
                    </div>

                    <!-- end:: Content -->
                </div>
                <!-- begin:: Footer -->
                @include('admin.elements.footer')
                <!-- end:: Footer -->
            </div>
        </div>
    </div>
    <!-- end:: Page -->
    <!-- begin::Quick Panel -->

    <!-- end::Quick Panel -->
    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>
    <!-- end::Scrolltop -->
    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
        var KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#5d78ff",
                    "dark": "#282a3c",
                    "light": "#ffffff",
                    "primary": "#5867dd",
                    "success": "#34bfa3",
                    "info": "#36a3f7",
                    "warning": "#ffb822",
                    "danger": "#fd3995"
                },
                "base": {
                    "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                    "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
                }
            }
        };
    </script>
    <!-- end::Global Config -->
    <!--begin:: Global Mandatory Vendors -->
    <script src="./assets/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/popper.js/dist/umd/popper.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/js-cookie/src/js.cookie.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/moment/min/moment.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/sticky-js/dist/sticky.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/wnumb/wNumb.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/toastr/build/toastr.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/block-ui/jquery.blockUI.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/custom/js/vendors/sweetalert2.init.js" type="text/javascript"></script>
    <!--end:: Global Mandatory Vendors -->
    <!--begin:: Global Optional Vendors -->

    @vite('resources/js/admin/editor.js')

    <!-- custom js -->
    <script src="./assets/js/toastr-option.js" type="text/javascript"></script>
    <!-- end of custom js -->

    <!--end:: Global Optional Vendors -->
    <!--begin::Global Theme Bundle(used by all pages) -->
    <script src="./assets/js/demo1/scripts.bundle.js" type="text/javascript"></script>
    <!--end::Global Theme Bundle -->
    <script type="text/javascript">
        $(function() {
            var flashMessage = '<?php echo session()->get('message'); ?>';
            if (flashMessage != '') {
                toastr.success(flashMessage);
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var status = jqXHR.status;
                    if (status == 404) {
                        toastr.warning("Element not found.");
                    } else if (status == 422) {
                        toastr.info(jqXHR.responseJSON.message);
                    }
                }
            });
        });
    </script>
    @vite('resources/js/admin/admin.js')
    @stack('scripts')
</body>
<!-- end::Body -->

</html>
