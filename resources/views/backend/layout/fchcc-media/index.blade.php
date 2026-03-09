@extends('backend.master')

@section('title', 'FCHCC Media Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">FCHCC {{ __('messages.media') }}</li>
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
                                    <h4 class="card-title">{{ __('messages.add') }} {{ __('messages.media') }}</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Add Media Form --}}
                                    <div id="addMediaContainer">
                                        <form action="{{ route('media.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <ul class="nav nav-tabs">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-bs-toggle="tab"
                                                                href="#en">{{ __('messages.english') }}</a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab"
                                                                href="#es">{{ __('messages.spanish') }}</a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="en">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.title') }}
                                                                ({{ __('messages.english') }})</label>
                                                            <input type="text" name="title[en]" class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.description') }}
                                                                ({{ __('messages.english') }})</label>
                                                            <textarea id="description_en" name="description[en]" cols="30" rows="2" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="es">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.title') }}
                                                                ({{ __('messages.spanish') }})</label>
                                                            <input type="text" name="title[es]" class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.description') }}
                                                                ({{ __('messages.spanish') }})</label>
                                                            <textarea id="description_es" name="description[es]" cols="30" rows="2" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

        
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.media') }}
                                                        {{ __('messages.image') }}</label>
                                                    <input type="file" name="image" class="dropify" accept="image/*"
                                                        data-allowed-file-extensions="jpg png jpeg webp"
                                                        data-max-file-size="12M">
                                                </div>

                                                <div class="clearfix">
                                                    <button type="submit"
                                                        class="btn btn-outline-success">{{ __('messages.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Edit Media Form --}}
                                    <div id="editMediaContainer" style="display: none;">
                                        <form id="updateMediaForm" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" id="edit_media_id">
                                            <div class="card-body">
                                                <h5 class="mb-3">{{ __('messages.edit') }} {{ __('messages.media') }}
                                                </h5>

                                                <div class="mb-3">
                                                    <ul class="nav nav-tabs">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-bs-toggle="tab"
                                                                href="#edit_en">{{ __('messages.english') }}</a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab"
                                                                href="#edit_es">{{ __('messages.spanish') }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="edit_en">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.title') }}
                                                                ({{ __('messages.english') }})</label>
                                                            <input type="text" name="title[en]" id="edit_title_en"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.description') }}
                                                                ({{ __('messages.english') }})</label>
                                                            <input type="text" name="description[en]"
                                                                id="edit_description_en" class="form-control">
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane fade" id="edit_es" >
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.title') }}
                                                                ({{ __('messages.spanish') }})</label>
                                                            <input type="text" name="title[es]" id="edit_title_es"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.description') }}
                                                                ({{ __('messages.spanish') }})</label>
                                                            <input type="text" name="description[es]"
                                                                id="edit_description_es" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.image') }}</label>
                                                    <input type="file" name="image" id="edit_image"
                                                        class="dropify-edit" accept="image/*">
                                                </div>

                                                <div class="clearfix">
                                                    <button type="submit"
                                                        class="btn btn-outline-primary">{{ __('messages.update') }}</button>
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        id="cancelCategoryEdit">{{ __('messages.cancel') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End - Blog Category Add -->

                        <!-- Start - Media Table -->
                        <div class="col-xl-8">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title"><i
                                            class="fa-solid fa-file-lines me-1 text-primary"></i>{{ __('messages.media') }}
                                        {{ __('messages.list') }}</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseContactList"
                                        role="button" aria-expanded="false" aria-controls="collapseContactList">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseContactList">
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table id="mediaTable"
                                                class="DataTable table  verticle-middle table-bordered  table-responsive-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="">{{ __('messages.s.no') }}</th>
                                                        <th scope="">{{ __('messages.title') }}</th>
                                                        <th scope="col">{{ __('messages.image') }}</th>
                                                        <th scope="col">{{ __('messages.status') }}</th>
                                                        <th scope="col" class="text-end">{{ __('messages.actions') }}
                                                        </th>
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
        let table = $('#mediaTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('media.data') }}",

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data ?
                            `<img src="${data}" width="50" height="50" class="rounded">` :
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


        // Edit Media
        $(document).on('click', '.editMedia', function() {

            let id = $(this).data('id');

            $.ajax({
                url: `/admin/media/${id}/edit`,
                type: 'GET',

                success: function(response) {

                    $('#edit_media_id').val(response.id);
                    $('#edit_status').val(response.status);

                    // translations
                    $('#edit_title_en').val(response.title_en);
                    $('#edit_title_es').val(response.title_es);

                    $('#edit_description_en').val(response.description_en);
                    $('#edit_description_es').val(response.description_es);

                    let image = response.image ?
                        `{{ asset('uploads/fchcc_media') }}/${response.image}` :
                        '';

                    initDropifyEdit(image);

                    $('#addMediaContainer').hide();
                    $('#editMediaContainer').show();

                    $('html, body').animate({
                        scrollTop: $("#collapseFilter").offset().top - 100
                    }, 500);
                }
            });

        });


        // Cancel Edit
        $('#cancelMediaEdit').on('click', function() {

            $('#editMediaContainer').hide();
            $('#addMediaContainer').show();

        });


        // Update Media
        $('#updateMediaForm').on('submit', function(e) {

            e.preventDefault();

            let id = $('#edit_media_id').val();
            let formData = new FormData(this);

            $.ajax({

                url: `/admin/media/${id}/update`,
                type: 'POST',
                data: formData,

                contentType: false,
                processData: false,

                success: function(response) {

                    if (response.success) {

                        $('#editMediaContainer').hide();
                        $('#addMediaContainer').show();

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



        $(document).ready(function() {

            $('.nav-tabs a').click(function() {
                $(this).tab('show');
            });

        });
    </script>
@endpush
