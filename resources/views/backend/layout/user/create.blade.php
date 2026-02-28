@extends('backend.master')

@section('title', 'User Add Page')

@section('content')

    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add User</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start - Dynamic Page Add -->
                        <div class="col-xl-8">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Add User</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Add FAQ Form --}}
                                    <div id="addFaqFormContainer">
                                        <form id="createUser" action="{{ route('user.store') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Select Role</label>
                                                    <select name="is_admin" id="" class="form-control">
                                                        <option value="">Select Role</option>
                                                        <option value="1">Admin</option>
                                                        <option value="0">User</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="Enter name">
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Username</label>
                                                    <input type="text" name="username" class="form-control"
                                                        placeholder="Enter name">
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        placeholder="example@gmail.com">
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Enter name">
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Confirm Password</label>
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        placeholder="Enter name">
                                                </div>
                                                
                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">Create</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End -  Dynamic Add -->
                    </div>
                </div>
            </div>
        </div>

    </main>




@endsection
