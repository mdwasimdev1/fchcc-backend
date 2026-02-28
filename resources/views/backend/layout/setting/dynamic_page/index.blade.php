@extends('backend.master')

@section('title', 'Category Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dynamic Pages</li>
                </ol>
            </nav>
            <div>
                <a href="{{ route('dynamicpages.create') }}" class="btn btn-outline-primary">Add Dayamic Page</a>
            </div>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <!-- Start - Daynamic page Table -->
                        <div class="col-xl-12">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Dynamic Pages List</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseContactList"
                                        role="button" aria-expanded="false" aria-controls="collapseContactList">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseContactList">
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table id="dynamicPageTable"
                                                class="DataTable table  table-bordered verticle-middle table-responsive-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">S.No</th>
                                                        <th scope="col text-red-500 ">Page Title</th>
                                                        <th scope="col">Page Content</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col" class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End - Blog Category Table -->

                    </div>
                </div>
            </div>
        </div>

    </main>



@endsection

@push('scripts')
    <script>
        let table = $('#dynamicPageTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('dynamicpages.data') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'page_title',
                    name: 'page_title'
                },
                {
                    data: 'page_content',
                    name: 'page_content'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    class: 'text-end'
                }
            ],
            order: [
                [1, 'asc']
            ],
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100]
        });
    </script>

@endpush
