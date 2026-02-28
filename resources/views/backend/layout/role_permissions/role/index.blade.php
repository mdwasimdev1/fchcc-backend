@extends('backend.master')

@section('title', 'Role Page')

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
                    <li class="breadcrumb-item active" aria-current="page">Add Roles</li>
                </ol>
            </nav>
        </div>
        <!-- End - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <h4 class="mb-3">Role Permission</h4>


                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title">Role Permission</h4>
                            </div>
                            <a href="{{ route('role.create') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-plus me-1"></i> Create Role
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover custom-table">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th class="text-start" style="width: 250px;">Module / Permission</th>
                                            @foreach ($roles as $role)
                                                <th>
                                                    {{ $role->name }}<br>
                                                    <div class="form-check d-inline-block mt-1">
                                                        <input type="checkbox"
                                                            class="form-check-input select-all-role shadow-none"
                                                            data-role-id="{{ $role->id }}"
                                                            data-role-name="{{ $role->name }}"
                                                            title="Select/Deselect all for {{ $role->name }}">
                                                        <label class="form-check-label small"
                                                            style="font-size: 10px;">ALL</label>
                                                    </div>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissionGroups as $groupName => $permissions)
                                            <tr class="">
                                                <td class="fw-bold text-uppercase">
                                                    {{ ucfirst($groupName) }} Management
                                                </td>
                                                {{-- @foreach ($roles as $role)
                                                    <td class="text-center">
                                                        <div class="form-check d-inline-block">
                                                            <input type="checkbox"
                                                                class="form-check-input select-all-module shadow-none"
                                                                data-role-id="{{ $role->id }}"
                                                                data-role-name="{{ $role->name }}"
                                                                data-module="{{ $groupName }}"
                                                                title="Select all in {{ $groupName }}">
                                                            <label class="form-check-label small"
                                                                style="font-size: 10px;">Group</label>
                                                        </div>
                                                    </td>
                                                @endforeach --}}
                                            </tr>
                                            @foreach ($permissions as $permission)
                                                <tr>
                                                    <td class="ps-4 text-start">
                                                        <span class="text-dark">{{ ucfirst($permission->name) }}</span>
                                                    </td>
                                                    @foreach ($roles as $role)
                                                        <td class="text-center">
                                                            <div class="form-check d-inline-block">
                                                                <input type="checkbox"
                                                                    class="form-check-input permission-checkbox shadow-none"
                                                                    data-role="{{ $role->id }}"
                                                                    data-group="{{ $groupName }}"
                                                                    data-permission="{{ $permission->id }}"
                                                                    data-role-name="{{ $role->name }}"
                                                                    data-permission-name="{{ $permission->name }}"
                                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>


@endsection


@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll('.permission-checkbox').forEach(checkbox => {

                checkbox.addEventListener('change', function() {

                    let currentCheckbox = this; // checkbox store করলাম

                    fetch("{{ route('role.permission.update') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                role_id: currentCheckbox.dataset.role,
                                permission_id: currentCheckbox.dataset.permission,
                                checked: currentCheckbox.checked
                            })
                        })
                        .then(res => res.json())
                        .then(data => {

                            if (data.success) {
                                toastr.success(data.message); // ✅ success message
                            } else {
                                toastr.error(data.message || "Something went wrong!");
                                currentCheckbox.checked = !currentCheckbox
                                    .checked; // ❗ revert checkbox
                            }

                        })
                        .catch(error => {
                            toastr.error("Update failed!");
                            currentCheckbox.checked = !currentCheckbox
                                .checked; // ❗ revert checkbox
                        });

                });

            });

        });
    </script>
    {{-- <script>
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {

                fetch("{{ route('role.permission.update') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            role_id: this.dataset.role,
                            permission_id: this.dataset.permission,
                            checked: this.checked
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                           toastr.success(data.message); 
                        } else {
                           toastr.error("Something went wrong!");
                        }
                    })
                    .catch(err => {
                        toastr.error('Update failed!');
                    });
            });
        });
    </script> --}}
@endpush
