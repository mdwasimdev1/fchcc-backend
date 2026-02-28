@extends('backend.master')

@section('title', 'Create Role')

@section('content')
    <main class="content-body">
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('role.permission.index') }}">Role Permission</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Role</li>
                </ol>
            </nav>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add New Role</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('role.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter role name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">The name must be unique and descriptive.</small>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('role.permission.index') }}" class="btn btn-outline-danger">Cancel</a>
                                    <button type="submit" class="btn btn-outline-primary">Save Role</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
