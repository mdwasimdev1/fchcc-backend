@extends('backend.master')

@section('title', 'Product Page')

@section('content')


    <!-- Start - Content Body -->
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">App Profile</li>
                </ol>
            </nav>
        </div>
        <!-- End - Page Title & Breadcrumb -->

        <div class="container-fluid">

            <div class="row">

                <!-- Start - Profile Header -->
                <div class="col-lg-12">
                    <div class="card-profile card card-body p-2 pb-0">
                        <div class="photo-content">
                            <div class="cover-photo rounded"></div>
                        </div>
                        <div class="p-sm-3 p-2 d-sm-flex w-100">
                            <div class="profile-photo me-sm-3">
                                <img src="{{ Auth::user()->image ? asset('uploads/profile/' . Auth::user()->image) : asset('backend/app-assets/images/default-user.png') }}"
                                    id="profileImage" class="img-fluid rounded-circle border border-4 border-white"
                                    alt="Profile Image" style="width: 100px; height: 100px; object-fit: cover;">
                                <div>
                                    <a href="javascript:void(0);"
                                        class="btn btn-primary btn-sm mt-2 d-flex align-items-center" id="updateProfileBtn">
                                        Update Profile</a>
                                    <input type="file" id="profileInput" accept="image/*" style="display:none;">
                                </div>
                            </div>
                            <div class="d-flex w-100 py-2 py-sm-0">
                                <div class="d-flex flex-wrap w-100 gap-3">
                                    <div class="clearfix">
                                        <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                        <span>{{ Auth::user()->username }}</span>
                                    </div>
                                    <div class="clearfix">
                                        <h5 class="mb-0">{{ Auth::user()->email }}</h5>
                                        <span>Email</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End - Profile Header -->

            </div>

            <div class="row">
                <!-- Start - Profile Feed -->
                <div class="col-xl-12 col-xxl-12">
                    <div class="card h-auto">
                        <div class="card-header">
                            <ul class="nav nav-underline card-header-tabs" id="nav-tab" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="underline-about-tab" data-bs-toggle="tab"
                                        data-bs-target="#underline-about" type="button" role="tab"
                                        aria-controls="underline-about" aria-selected="false">Profile Edit</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="underline-setting-tab" data-bs-toggle="tab"
                                        data-bs-target="#underline-setting" type="button" role="tab"
                                        aria-controls="underline-setting" aria-selected="false">Password Update</button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="tab-content" id="underline-tabContent">

                                <div class="tab-pane fade show active" id="underline-about" role="tabpanel"
                                    aria-labelledby="underline-about-tab" tabindex="0">
                                    <div class="pt-4 border-bottom-1 pb-3">

                                        <form method="post" action="{{ route('profile.update') }}">
                                            @csrf

                                            <div class="row">
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label">User Name </label>
                                                    <input type="text" name="username"
                                                        value="{{ Auth::user()->username }}" class="form-control @error('username') is-invalid @enderror">
                                                    @error('username')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                                                        class="form-control @error('name') is-invalid @enderror">
                                                    @error('name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                                                        class="form-control @error('email') is-invalid @enderror">
                                                    @error('email')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12">
                                                    <button class="btn btn-primary" type="submit">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>



                                </div>
                                <div class="tab-pane fade" id="underline-setting" role="tabpanel"
                                    aria-labelledby="underline-setting-tab" tabindex="0">

                                    <form method="post" action="{{ route('profile.update.password') }}">
                                        @csrf

                                        <div class="row">

                                            <div class="mb-3 col-md-12">
                                                <label class="form-label">Current Password</label>
                                                <input type="password" name='current_password'
                                                    placeholder="Current Password" class="form-control @error('current_password') is-invalid @enderror">
                                                @error('current_password')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-12">
                                                <label class="form-label">New Password</label>
                                                <input type="password" name="new_password" placeholder="New Password"
                                                    class="form-control @error('new_password') is-invalid @enderror">
                                                @error('new_password')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-12">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" name="new_password_confirmation"
                                                    placeholder="Confirm Password" class="form-control">
                                            </div>

                                            <div class="col-md-12">
                                                <button class="btn btn-outline-primary" type="submit">Update Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End - Profile Feed -->

            </div>

        </div>
    </main>
    <!-- End - Content Body -->


    <!-- End - Main Wrapper -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#updateProfileBtn').on('click', function() {
                $('#profileInput').click();
            });

            $('#profileInput').on('change', function() {

                let file = this.files[0];
                if (!file) return;

                let formData = new FormData();
                formData.append('profile_image', file);

                $.ajax({
                    url: "{{ route('profile.update.profile.picture') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        alert('Profile updated successfully ✅');
                        $('#profileImage').attr('src', res.image);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Upload failed ❌');
                    }
                });
            });

        });
    </script>
@endpush
