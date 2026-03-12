@extends('backend.master')

@section('title', 'FCHCC News Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">FCHCC {{ __('messages.news') }}</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start - Blog Category Add -->
                        <div class="col-xl-12">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('messages.add') }} {{ __('messages.news') }}</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Add News Form --}}
                                    <div id="addNewsContainer">
                                        <form action="{{ route('news.store') }}" method="POST"
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
                                                            <textarea id="description_en" name="description[en]" cols="30" rows="2" class="ck-editor form-control"></textarea>
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
                                                            <textarea id="description_es" name="description[es]" cols="30" rows="2" class="ck-editor form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.news') }}
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

                                    {{-- Edit News Form --}}
                                    <div id="editNewsContainer" style="display: none;">
                                        <form id="updateNewsForm" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" id="edit_news_id">
                                            <div class="card-body">
                                                <h5 class="mb-3">{{ __('messages.edit') }} {{ __('messages.news') }}
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
                                                    <div class="tab-pane fade" id="edit_es">
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
                                                    <label class="form-label">{{ __('messages.news') }}
                                                        {{ __('messages.image') }}</label>
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

                    </div>
                </div>
            </div>
        </div>

    </main>



@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        document.querySelectorAll('.ck-editor').forEach((el) => {
            ClassicEditor
                .create(el)
                .catch(error => {
                    console.error(error);
                });
        });
    </script>




    <script>


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


        // Edit News
        $(document).on('click', '.editNews', function() {

            let id = $(this).data('id');

            $.ajax({
                url: `/admin/news/${id}/edit`,
                type: 'GET',

                success: function(response) {

                    $('#edit_news_id').val(response.id);
                    $('#edit_status').val(response.status);

                    // translations
                    $('#edit_title_en').val(response.title_en);
                    $('#edit_title_es').val(response.title_es);

                    $('#edit_description_en').val(response.description_en);
                    $('#edit_description_es').val(response.description_es);

                    let image = response.image ?
                        `{{ asset('uploads/fchcc_news') }}/${response.image}` :
                        '';

                    initDropifyEdit(image);

                    $('#addNewsContainer').hide();
                    $('#editNewsContainer').show();

                    $('html, body').animate({
                        scrollTop: $("#collapseFilter").offset().top - 100
                    }, 500);
                }
            });

        });


        // Cancel Edit
        $('#cancelNewsEdit').on('click', function() {

            $('#editNewsContainer').hide();
            $('#addNewsContainer').show();

        });


        // Update News
        $('#updateNewsForm').on('submit', function(e) {

            e.preventDefault();

            let id = $('#edit_news_id').val();
            let formData = new FormData(this);

            $.ajax({

                url: `/admin/news/${id}/update`,
                type: 'POST',
                data: formData,

                contentType: false,
                processData: false,

                success: function(response) {

                    if (response.success) {

                        $('#editNewsContainer').hide();
                        $('#addNewsContainer').show();

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
