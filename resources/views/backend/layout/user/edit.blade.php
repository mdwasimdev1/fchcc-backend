@extends('backend.master')

@section('title', 'Edit User')

@section('content')

    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('users.index') }}">User List</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start - User Edit Form -->
                        <div class="col-xl-8">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Edit User</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    <div class="card-body">
                                        <form id="updateUser" action="{{ route('user.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            
                                            <div class="mb-3 d-flex flex-column">
                                                <label class="form-label">Select Role</label>
                                                <select name="is_admin" class="form-control @error('is_admin') is-invalid @enderror">
                                                    <option value="">Select Role</option>
                                                    <option value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'selected' : '' }}>Admin</option>
                                                    <option value="0" {{ old('is_admin', $user->is_admin) == 0 ? 'selected' : '' }}>User</option>
                                                </select>
                                                @error('is_admin')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="mb-3 d-flex flex-column">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Enter name" value="{{ old('name', $user->name) }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="mb-3 d-flex flex-column">
                                                <label class="form-label">Username</label>
                                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                                    placeholder="Enter username" value="{{ old('username', $user->username) }}">
                                                @error('username')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="mb-3 d-flex flex-column">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="example@gmail.com" value="{{ old('email', $user->email) }}">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="mb-3 d-flex flex-column">
                                                <label class="form-label">Password (Leave blank to keep current)</label>
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Enter new password">
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="mb-3 d-flex flex-column">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" name="password_confirmation" class="form-control">
                                            </div>
                                            
                                            <div class="clearfix">
                                                <button type="submit" class="btn btn-outline-primary">Update</button>
                                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End - User Edit Form -->
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
