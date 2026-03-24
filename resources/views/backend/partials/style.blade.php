<!-- FAVICONS ICON -->
@php
    $adminFavicon = optional($setting)->admin_favicon;
    $adminFaviconPath = $adminFavicon ? 'uploads/setting/admin/' . $adminFavicon : 'backend/app-assets/images/default-favicon.png';
@endphp
<link rel="shortcut icon" type="image/png" href="{{ asset($adminFaviconPath) }}">

<link href="{{ asset('backend/app-assets/vendor/@yaireo/tagify/dist/tagify.css') }}" rel="stylesheet">
<link href="{{ asset('backend/app-assets/vendor/metismenu/dist/metisMenu.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/app-assets/vendor/@flaticon/flaticon-uicons/css/all/all.css') }}" rel="stylesheet">
<link href="{{ asset('backend/app-assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap/dist/css/jsvectormap.min.css">
<link rel="stylesheet" href="{{ asset('backend/app-assets/vendor/swiper/swiper-bundle.min.css') }}">

<link href="{{ asset('backend/app-assets/css/plugins.css') }}" rel="stylesheet">
<link href="{{ asset('backend/app-assets/css/style.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<!-- dataTables -->
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<!-- Dropify CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- End - Style CSS -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">

<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">


