@extends('backend.master')

@section('title', 'System Setting Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">System Setting</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start -Update System Setting -->
                        <div class="col-xl-8">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Update System Setting</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Setting upgrate Form --}}
                                    <div id="addCategoryContainer">
                                        <form action="{{ route('admin.setting.mailstore') }}" method="POST">
                                            @csrf
                                            <div class="card-body">
                                                <div class="d-flex gap-3">
                                                    <div class="col-xl-12">
                                                        <div>
                                                            <div class="mb-3">
                                                                <label class="form-label">MAIL MAILER</label>
                                                                <input type="text" name="mail_mailer"
                                                                    value="{{ env('MAIL_MAILER') }}"
                                                                    class="form-control" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">MAIL HOST</label>
                                                                <input type="text" name="mail_host"
                                                                    value="{{ env('MAIL_HOST') }}"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">MAIL PORT</label>
                                                            <input type="text" name="mail_port"
                                                                value="{{ env('MAIL_PORT') }}" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">MAIL USERNAME</label>
                                                            <input type="text" name="mail_username"
                                                                value="{{ env('MAIL_USERNAME') }}" class="form-control" required>
                            
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">MAIL PASSWORD</label>
                                                            <input type="text" name="mail_password"
                                                                value="{{ env('MAIL_PASSWORD') }}" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">MAIL ENCRYPTION</label>
                                                            <input type="text" name="mail_encryption"
                                                                value="{{ env('MAIL_ENCRYPTION') }}"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">MAIL FROM ADDRESS</label>
                                                            <input type="text" name="mail_from_address"
                                                                value="{{ env('MAIL_FROM_ADDRESS') }}"
                                                                class="form-control" required>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End - Blog Category Add -->



                    </div>
                </div>
            </div>
        </div>

    </main>



@endsection

@push('scripts')
@endpush
