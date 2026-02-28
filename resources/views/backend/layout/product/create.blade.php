@extends('backend.master')

@section('title', 'Product Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Product</li>
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
                                    <h4 class="card-title">Add Category</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">


                                    <form action="{{ route('product.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" name="name" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Seclect Category</label>
                                                <select name="category_id" id="category" class="form-control">
                                                    <option value="">Select Category</option>
                                                    @foreach ($Categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Select Sub Category</label>
                                                <select name="sub_category_id" id="sub_category" class="form-control">
                                                    <option value="">Select Sub Category</option>
                                                </select>

                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Product Price</label>
                                                <input type="number" name="price" class="form-control">
                                            </div>

                                            
                                            <div class="mb-4">
                                                <label class="form-label font-weight-bold">Product Images</label>
                                                <div class="product-image-upload-wrapper">
                                                    <div id="image-preview-grid" class="image-preview-grid">
                                                        
                                                    </div>
                                                    <div class="add-image-box-wrapper">
                                                        <input type="file" id="product_images" multiple class="dropify"
                                                            data-height="100" data-width="100" accept="image/*"
                                                            data-allowed-file-extensions="jpg png jpeg webp" />
                                                    </div>
                                                </div>
                                                <input type="file" name="images[]" id="hidden_images" multiple
                                                    class="d-none">
                                                <small class="text-muted">You can select multiple images. Click the '+' box
                                                    to add more.</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="active"
                                                        {{ old('status') == 'active' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="inactive"
                                                        {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                                @error('status')
                                                    <small style="color:red">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="clearfix">
                                                <button type="submit" class="btn btn-outline-primary">Save Product</button>
                                            </div>
                                        </div>
                                    </form>
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
    <!-- Dropify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>

    <style>
        .product-image-upload-wrapper {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            background-color: #f9fafb;
            min-height: 140px;
            transition: all 0.3s ease;
        }

        .product-image-upload-wrapper:hover {
            border-color: #633dfe;
            background-color: #f3f4f6;
        }

        .image-preview-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .preview-item {
            width: 100px;
            height: 100px;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            background: #fff;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-item .remove-image {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            color: #ef4444;
            font-size: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            opacity: 0.8;
            transition: all 0.2s ease;
            z-index: 10;
        }

        .preview-item .remove-image:hover {
            opacity: 1;
            background: #fff;
            transform: translate(-50%, -50%) scale(1.1);
        }

        .add-image-box-wrapper {
            width: 100px;
            height: 100px;
        }

        /* Customizing Dropify to fit the square grid */
        .add-image-box-wrapper .dropify-wrapper {
            height: 100px !important;
            width: 100px !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
        }

        .add-image-box-wrapper .dropify-wrapper .dropify-message p {
            font-size: 12px !important;
            margin: 0 !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Internal file list to keep track of multiple images
            let fileList = new DataTransfer();
            const hiddenInput = document.getElementById('hidden_images');
            const previewGrid = $('#image-preview-grid');

            // Initialize Dropify
            let drEvent = $('.dropify').dropify({
                messages: {
                    'default': '<i class="fa fa-plus fa-2x"></i>',
                    'replace': 'Change',
                    'remove': 'Remove',
                    'error': 'Error'
                }
            });

            // Handle file selection
            $('.dropify').on('change', function() {
                const files = this.files;

                if (files.length > 0) {
                    Array.from(files).forEach(file => {
                        // Add to our hidden file list
                        fileList.items.add(file);

                        // Create Preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const previewHtml = `
                                <div class="preview-item shadow-sm">
                                    <img src="${e.target.result}" alt="preview">
                                    <button type="button" class="remove-image" data-name="${file.name}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            `;
                            previewGrid.append(previewHtml);
                        }
                        reader.readAsDataURL(file);
                    });

                    // Sync hidden input
                    hiddenInput.files = fileList.files;

                    // Clear dropify for next upload
                    let drInstance = drEvent.data('dropify');
                    drInstance.resetPreview();
                    drInstance.clearElement();
                }
            });

            // Handle image removal
            $(document).on('click', '.remove-image', function() {
                const fileName = $(this).data('name');
                const parent = $(this).closest('.preview-item');

                // Remove from preview UI
                parent.fadeOut(300, function() {
                    $(this).remove();
                });

                // Remove from DataTransfer object
                const newFileList = new DataTransfer();
                Array.from(fileList.files).forEach(file => {
                    if (file.name !== fileName) {
                        newFileList.items.add(file);
                    }
                });
                fileList = newFileList;
                hiddenInput.files = fileList.files;
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#category').on('change', function() {
                let category_id = $(this).val();

                if (category_id) {
                    $.ajax({
                        url: '/admin/product/get-subcategories/' + category_id,
                        type: 'GET',
                        success: function(data) {
                            let html = '<option value="">Select Sub Category</option>';
                            data.forEach(function(row) {
                                html +=
                                `<option value="${row.id}">${row.name}</option>`;
                            });
                            $('#sub_category').html(html);
                        }
                    });
                } else {
                    $('#sub_category').html('<option value="">Select Sub Category</option>');
                }
            });
        });
    </script>
@endpush
