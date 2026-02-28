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
                    <li class="breadcrumb-item active" aria-current="page">Sub Category</li>
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
                                    <h4 class="card-title">Add Sub Category</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Add Category Form --}}
                                    <div id="addSubCategoryContainer">
                                        <form action="{{ route('SubCategory.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Seclect Category</label>
                                                    <select name="category_id" class="form-control">
                                                        <option value="">Select Category</option>
                                                        @foreach ($Categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Sub Category Image</label>
                                                    <input type="file" name="image" class="dropify" accept="image/*"
                                                        data-allowed-file-extensions="jpg png jpeg webp"
                                                        data-max-file-size="12M">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Edit Category Form --}}
                                    <div id="editSubCategoryContainer" style="display: none;">
                                        <form id="updateSubCategoryForm" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" id="edit_sub_category_id">
                                            <div class="card-body">
                                                <h5 class="mb-3">Edit Sub Category</h5>
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" id="edit_name"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Seclect Category</label>
                                                    <select name="category_id" class="form-control">
                                                        <option value="">Select Category</option>
                                                        @foreach ($Categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Sub Category Image</label>
                                                    <input type="file" name="image" id="edit_image"
                                                        class="dropify-edit" accept="image/*">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" id="edit_status" class="form-control">
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
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
                                    <h4 class="card-title"><i
                                            class="fa-solid fa-file-lines me-1 text-primary"></i>Category List</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseContactList"
                                        role="button" aria-expanded="false" aria-controls="collapseContactList">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseContactList">
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table id="subCategoryTable"
                                                class="DataTable table table-bordered  verticle-middle table-responsive-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">S.No</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Image</th>
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
        let table = $('#subCategoryTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('subCategory.data') }}",
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
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data ? `<img src="${data}" width="50" height="50" class="rounded">` :
                            `<span class="text-muted">No Image</span>`;
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
            let input = $('#edit_image');
            if (url) {
                input.attr('data-default-file', url);
            } else {
                input.removeAttr('data-default-file');
            }
            dropifyEdit = input.dropify().data('dropify');
        }

        // Edit Category
        $(document).on('click', '.editSubCategory', function() {
            let id = $(this).data('id');
            $.ajax({
                url: `/admin/sub-category/${id}/edit`,
                type: 'GET',
                success: function(response) {
                    $('#edit_sub_category_id').val(response.id);
                    $('#edit_category_id').val(response.category_id);
                    $('#edit_name').val(response.name);
                    $('#edit_status').val(response.status);

                    let imageUrl = response.image ?
                        `{{ asset('uploads/subCategories') }}/${response.image}` : '';
                    initDropifyEdit(imageUrl);

                    $('#addSubCategoryContainer').hide();
                    $('#editSubCategoryContainer').show();

                    $('html, body').animate({
                        scrollTop: $("#collapseFilter").offset().top - 100
                    }, 500);
                }
            });
        });

        $('#cancelSubCategoryEdit').on('click', function() {
            $('#editSubCategoryContainer').hide();
            $('#addSubCategoryContainer').show();
        });

        $('#updateSubCategoryForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#edit_sub_category_id').val();
            let formData = new FormData(this);

            $.ajax({
                url: `/admin/sub-category/update/${id}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#editSubCategoryContainer').hide();
                        $('#addSubCategoryContainer').show();
                        table.ajax.reload(null, false);
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        alert(Object.values(errors)[0][0]);
                    }
                }
            });
        });

       
    </script>
@endpush
