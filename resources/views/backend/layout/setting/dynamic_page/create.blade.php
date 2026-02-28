@extends('backend.master')

@section('title', 'Dynamic Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Dynamic Page</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start - Dynamic Page Add -->
                        <div class="col-xl-12">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Add Dynamic Page</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Add FAQ Form --}}
                                    <div id="addFaqFormContainer">
                                        <form id="createDynamicPage" action="{{ route('dynamicpages.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Page Title</label>
                                                    <input type="text" name="page_title" class="form-control"
                                                        placeholder="Enter Page Title">
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Page Content</label>
                                                    <textarea name="page_content" id="page_content" cols="30" rows="5"
                                                        class="ck-editor form-control @error('page_content') is-invalid @enderror"></textarea>
                                                </div>
                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">Save</button>
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

@push('scripts')
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

    <script>
        let addEditor;
        let editEditor;

        // Initialize Add Form Editor
        ClassicEditor
            .create(document.querySelector('#page_content'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder'],
                height: '500px'
            })
            .then(editor => {
                addEditor = editor;
            })
            .catch(error => { console.error(error); });

        // Initialize Edit Form Editor
        ClassicEditor
            .create(document.querySelector('#edit_page_content'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder'],
                height: '500px'
            })
            .then(editor => {
                editEditor = editor;
            })
            .catch(error => { console.error(error); });
    </script>
@endpush
