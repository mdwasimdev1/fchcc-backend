@extends('backend.master')

@section('title', 'Sponsor Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Sponsor</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start - Blog Category Add -->
                        <div class="col-xl-4">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Add Sponsor</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Add Sponsor Form --}}
                                    <div id="addSponsorContainer">
                                        <form action="{{ route('sponsor.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">

                                                <div class="mb-3">
                                                    <label class="form-label">Name (English)</label>
                                                    <input type="text" name="name[en]" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Name (Spanish)</label>
                                                    <input type="text" name="name[es]" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description (English)</label>
                                                    <textarea id="description_en" name="description[en]" cols="30" rows="2" class="form-control"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description (Spanish)</label>
                                                    <textarea id="description_es" name="description[es]" cols="30" rows="2" class="form-control"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Website URL</label>
                                                    <input type="text" name="website_url" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Sponsor Logo</label>
                                                    <input type="file" name="logo" class="dropify" accept="image/*"
                                                        data-allowed-file-extensions="jpg png jpeg webp"
                                                        data-max-file-size="12M">
                                                </div>

                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-success">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Edit Category Form --}}
                                    <div id="editSponsorContainer" style="display: none;">
                                        <form id="updateSponsorForm" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" id="edit_sponsor_id">
                                            <div class="card-body">
                                                <h5 class="mb-3">Edit Sponsor</h5>

                                                <div class="mb-3">
                                                    <label class="form-label">Name (English)</label>
                                                    <input type="text" name="name[en]" id="edit_name_en"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Name (Spanish)</label>
                                                    <input type="text" name="name[es]" id="edit_name_es"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description (English)</label>
                                                    <input type="text" name="description[en]" id="edit_description_en"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description (Spanish)</label>
                                                    <input type="text" name="description[es]" id="edit_description_es"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Website URL</label>
                                                    <input type="text" name="website_url" id="edit_website_url"
                                                        class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Sponsor Logo</label>
                                                    <input type="file" name="logo" id="edit_logo"
                                                        class="dropify-edit" accept="image/*">
                                                </div>
                                                {{-- <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" id="edit_status" class="form-control">
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div> --}}
                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">Update</button>
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        id="cancelCategoryEdit">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End - Blog Category Add -->

                        <!-- Start - Blog Category Table -->
                        <div class="col-xl-8">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="fa-solid fa-file-lines me-1 text-primary"></i>Sponsor
                                        List</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseContactList"
                                        role="button" aria-expanded="false" aria-controls="collapseContactList">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseContactList">
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table id="sponsorTable"
                                                class="DataTable table  verticle-middle table-bordered  table-responsive-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="">S.No</th>
                                                        <th scope="">Name</th>
                                                        <th scope="col">Logo</th>
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
        let table = $('#sponsorTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('sponsor.data') }}",

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'logo',
                    name: 'logo',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data ?
                            `<img src="${data}" width="50" height="50" class="rounded">` :
                            `<span class="text-muted">No Logo</span>`;
                    }
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


        // Dropify Edit initialization
        let dropifyEdit;

        function initDropifyEdit(url = '') {

            if (dropifyEdit) {
                dropifyEdit.destroy();
            }

            let input = $('#edit_logo');

            if (url) {
                input.attr('data-default-file', url);
            } else {
                input.removeAttr('data-default-file');
            }

            dropifyEdit = input.dropify().data('dropify');
        }


        // Edit Sponsor
        $(document).on('click', '.editSponsor', function() {

            let id = $(this).data('id');

            $.ajax({
                url: `/admin/sponsor/${id}/edit`,
                type: 'GET',

                success: function(response) {

                    $('#edit_sponsor_id').val(response.id);
                    $('#edit_website_url').val(response.website_url);
                    $('#edit_status').val(response.status);

                    // translations
                    $('#edit_name_en').val(response.name_en);
                    $('#edit_name_es').val(response.name_es);

                    $('#edit_description_en').val(response.description_en);
                    $('#edit_description_es').val(response.description_es);

                    let logoUrl = response.logo ?
                        `{{ asset('uploads/sponsors') }}/${response.logo}` :
                        '';

                    initDropifyEdit(logoUrl);

                    $('#addSponsorContainer').hide();
                    $('#editSponsorContainer').show();

                    $('html, body').animate({
                        scrollTop: $("#collapseFilter").offset().top - 100
                    }, 500);
                }
            });

        });


        // Cancel Edit
        $('#cancelSponsorEdit').on('click', function() {

            $('#editSponsorContainer').hide();
            $('#addSponsorContainer').show();

        });


        // Update Sponsor
        $('#updateSponsorForm').on('submit', function(e) {

            e.preventDefault();

            let id = $('#edit_sponsor_id').val();
            let formData = new FormData(this);

            $.ajax({

                url: `/admin/sponsor/${id}/update`,
                type: 'POST',
                data: formData,

                contentType: false,
                processData: false,

                success: function(response) {

                    if (response.success) {

                        $('#editSponsorContainer').hide();
                        $('#addSponsorContainer').show();

                        table.ajax.reload(null, false);

                        toastr.success(response.message, 'Success');
                    }
                },

                error: function(xhr) {

                    let errors = xhr.responseJSON?.errors;

                    if (errors) {
                        let errorMsg = Object.values(errors)[0][0];
                        toastr.error(errorMsg, 'Error');
                    } else if (xhr.responseJSON?.message) {
                        toastr.error(xhr.responseJSON.message, 'Error');
                    }
                }

            });

        });
    </script>
@endpush
