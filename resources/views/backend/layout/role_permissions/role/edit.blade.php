@extends('backend.master')

@section('title', 'Edit Role')

@section('content')
    <main class="content-body">
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
                </ol>
            </nav>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Role: {{ $role->name }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('role.update', $role->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter role name" value="{{ old('name', $role->name) }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">The name must be unique.</small>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('role.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-outline-primary">Update Role</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
