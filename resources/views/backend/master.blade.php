<!DOCTYPE html>
<html lang="en" data-bs-theme="{{ session('theme', 'light') }}">


<!-- Mirrored from hexabox.dexignlab.com/xhtml/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Jan 2026 20:50:38 GMT -->

<head>

    <!-- Title -->
    <title>Admin Dashboard Template</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="dexignlabs">
    <meta name="robots" content="index, follow">
    <meta name="format-detection" content="telephone=no">

    <meta name="keywords"
        content="HexaBox, Bootstrap admin template, multipurpose admin dashboard, responsive dashboard UI, web app admin panel, analytics dashboard, Bootstrap 5 template, HTML admin UI, admin panel design, modern dashboard template, SaaS dashboard, CRM admin UI">
    <meta name="description"
        content="HexaBox is a powerful Multipurpose Bootstrap Admin Dashboard Template designed for web applications, analytics, CRM, and SaaS platforms. Fully responsive, customizable, and packed with modern UI components.">

    <!-- OPENGRAPH META -->
    <meta property="og:title" content="HexaBox – Multipurpose Bootstrap Admin Dashboard Template">
    <meta property="og:description"
        content="HexaBox is a versatile and responsive Bootstrap admin dashboard template, perfect for analytics, CRM systems, and backend web interfaces.">
    <meta property="og:image" content="social-image.png">
    <meta property="og:url" content="https://hexabox.dexignlab.com/">
    <meta property="og:type" content="website">

    <!-- TWITTER META -->
    <meta name="twitter:title" content="HexaBox – Multipurpose Bootstrap Admin Dashboard Template">
    <meta name="twitter:description"
        content="Create high-performing dashboards with HexaBox – a responsive and feature-rich Bootstrap admin template for all kinds of web apps.">
    <meta name="twitter:image" content="social-image.png">
    <meta name="twitter:card" content="summary_large_image">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title')</title>
    @include('backend.partials.style')
    <!-- End - Style CSS -->
     @stack('script')
     
</head>

<body>

    <!-- Start - Preloader -->
    <div class="ic_preloader" id="ic_preloader">
        <div class="spinner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- End - Preloader -->

    <!-- Start - Main Wrapper -->
    <div id="main-wrapper" data-bs-theme="{{ session('theme', 'light') }}">

        <!-- BEGIN: Header-->
        @include('backend.partials.header')
        <!-- END: Header-->


        <!-- BEGIN: Main Menu-->
        @include('backend.partials.sidebar')
        <!-- END: Main Menu-->

        <!-- BEGIN: Content-->
        @yield('content')
        <!-- END: Content-->

        <!-- BEGIN: Footer-->
        @include('backend.partials.footer')
        <!--END: Footer-->
        @include('backend.partials.script')
        @stack('scripts')
    </div>
    <!-- End - Main Wrapper -->

</body>

</html>
