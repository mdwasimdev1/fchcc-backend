@extends('backend.master')

@section('title', 'Edit Dynamic Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('dynamicpages.index') }}">Dynamic Pages</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Dynamic Page</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start - Dynamic Page Edit -->
                        <div class="col-xl-12">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Edit Dynamic Page</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseEditForm"
                                        role="button" aria-expanded="false" aria-controls="collapseEditForm">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseEditForm">
                                    <div class="card-body">
                                        <form id="updateDynamicPage" action="{{ route('dynamicpages.update', $page->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3 d-flex flex-column">
                                                <label class="form-label">Page Title</label>
                                                <input type="text" name="page_title" class="form-control"
                                                    value="{{ old('page_title', $page->page_title) }}"
                                                    placeholder="Enter Page Title">
                                                @error('page_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 d-flex flex-column">
                                                <label class="form-label">Page Content</label>
                                                <textarea name="page_content" id="page_content" cols="30" rows="10"
                                                    class="ck-editor form-control @error('page_content') is-invalid @enderror">{{ old('page_content', $page->page_content) }}</textarea>
                                                @error('page_content')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="clearfix">
                                                <button type="submit" class="btn btn-outline-primary">Update</button>
                                                <a href="{{ route('dynamicpages.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End -  Dynamic Edit -->
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#page_content'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder'],
            })
            .catch(error => { console.error(error); });
    </script>
@endpush
