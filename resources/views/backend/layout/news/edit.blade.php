@extends('backend.master')

@section('title', 'Edit FCHCC News Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('news.index') }}">FCHCC {{ __('messages.news') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.edit') }}</li>
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
                                    <h4 class="card-title">{{ __('messages.edit') }} {{ __('messages.news') }}</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    
                                    {{-- Edit News Form --}}
                                    <div id="editNewsContainer">

                                        <!-- The form points to the update route -->
                                        <!-- Note: It's important to use the same method (POST) your controller is expecting,
                                             and since we are updating we might need PUT or we use POST based on NewsController.php -->
                                        <!-- Because your controller expects a POST request (Route::post('/news/{id}/update')), we keep it POST -->
                                        <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" id="editNewsForm">
                                            @csrf

                                            <!-- Because the request update comes as Json in the previous design, let's keep it as an AJAX request for smooth update 
                                                 Or rely on standard form submit if controller returns json -->
                                            
                                            <input type="hidden" name="id" id="edit_news_id" value="{{ $news->id }}">
                                            
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
                                                            <input type="text" name="title[en]" id="edit_title_en" value="{{ $news->translations->where('locale', 'en')->first()->title ?? '' }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.description') }}
                                                                ({{ __('messages.english') }})</label>
                                                            <textarea id="description_en" name="description[en]" cols="30" rows="2" class="ck-editor form-control">{{ $news->translations->where('locale', 'en')->first()->description ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="es">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.title') }}
                                                                ({{ __('messages.spanish') }})</label>
                                                            <input type="text" name="title[es]" id="edit_title_es" value="{{ $news->translations->where('locale', 'es')->first()->title ?? '' }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('messages.description') }}
                                                                ({{ __('messages.spanish') }})</label>
                                                            <textarea id="description_es" name="description[es]" cols="30" rows="2" class="ck-editor form-control">{{ $news->translations->where('locale', 'es')->first()->description ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.news') }}
                                                        {{ __('messages.image') }}</label>
                                                    <input type="file" name="image" id="edit_image" class="dropify-edit" accept="image/*"
                                                         @if($news->image) data-default-file="{{ asset('uploads/fchcc_news/' . $news->image) }}" @endif
                                                         data-allowed-file-extensions="jpg png jpeg webp"
                                                         data-max-file-size="12M">
                                                </div>

                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">{{ __('messages.update') }}</button>
                                                    <a href="{{ route('news.index') }}" class="btn btn-outline-secondary">{{ __('messages.cancel') }}</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- End Edit News Form --}}

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
        $(document).ready(function() {
            // Initialize Dropify
            $('.dropify-edit').dropify();

            // Tab switching
            $('.nav-tabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            // Handle Form Submit via AJAX (Since Controller expects JSON response and no redirect)
            $('#editNewsForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let url = $(this).attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Success');
                            setTimeout(function() {
                                window.location.href = "{{ route('news.index') }}";
                            }, 1500);
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
        });
    </script>
@endpush
