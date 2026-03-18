@extends('backend.master')

@section('title', 'Admin Setting Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Admin Setting</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start -Update System Setting -->
                        <div class="col-xl-12">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Update Admin Setting</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Setting upgrate Form --}}
                                    <div id="addCategoryContainer">
                                        <form action="{{ route('admin.settingupdate') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="">
                                                    <div class="col-xl-12 d-flex gap-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Logo</label>
                                                            <input type="file" id="admin_logo" name="admin_logo"
                                                                class="dropify form-control" accept="image/*"
                                                                data-allowed-file-extensions="jpg png jpeg webp"
                                                                data-max-file-size="12M"
                                                                @isset($setting->admin_logo)
                                                                  data-default-file="{{ asset('uploads/setting/admin/' . $setting->admin_logo) }}"
                                                               @endisset>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Mini Logo</label>
                                                            <input type="file" id="admin_mini_logo"
                                                                name="admin_mini_logo" class="dropify form-control"
                                                                accept="image/*"
                                                                data-allowed-file-extensions="jpg png jpeg webp"
                                                                data-max-file-size="12M"
                                                                @isset($setting->admin_mini_logo)
                                                                  data-default-file="{{ asset('uploads/setting/admin/' . $setting->admin_mini_logo) }}"
                                                               @endisset>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Favicon</label>
                                                            <input type="file" id="admin_favicon" name="admin_favicon"
                                                                class="dropify form-control" accept="image/*"
                                                                data-allowed-file-extensions="jpg png jpeg webp"
                                                                data-max-file-size="12M"
                                                                @isset($setting->admin_favicon)
                                                                  data-default-file="{{ asset('uploads/setting/admin/' . $setting->admin_favicon) }}"
                                                               @endisset>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">

                                                        <div class="d-flex gap-3 flex-wrap">
                                                            <div class="mb-3 flex-fill">
                                                                <label class="form-label">Title (English)</label>
                                                                <input type="text" name="admin_title[en]"
                                                                    value="{{ $setting->admin_title_en ?? '' }}"
                                                                    class="form-control w-100">
                                                            </div>
                                                            <div class="mb-3 flex-fill">
                                                                <label class="form-label">Title (Spanish)</label>
                                                                <input type="text" name="admin_title[es]"
                                                                    value="{{ $setting->admin_title_es ?? '' }}"
                                                                    class="form-control w-100">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex gap-3 flex-wrap">
                                                            <div class="mb-3 flex-fill">
                                                                <label class="form-label">Short Title (English)</label>
                                                                <input type="text" name="admin_short_title[en]"
                                                                    value="{{ $setting->admin_short_title_en ?? '' }}"
                                                                    class="form-control w-100">
                                                            </div>
                                                            <div class="mb-3 flex-fill">
                                                                <label class="form-label">Short Title (Spanish)</label>
                                                                <input type="text" name="admin_short_title[es]"
                                                                    value="{{ $setting->admin_short_title_es ?? '' }}"
                                                                    class="form-control w-100">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex gap-3 flex-wrap">
                                                            <div class="mb-3 flex-fill">
                                                                <label class="form-label">Copy Right (English)</label>
                                                                <input type="text" name="admin_copyright[en]"
                                                                    value="{{ $setting->admin_copyright_en ?? '' }}"
                                                                    class="form-control w-100">
                                                            </div>
                                                            <div class="mb-3 flex-fill">
                                                                <label class="form-label">Copy Right (Spanish)</label>
                                                                <input type="text" name="admin_copyright[es]"
                                                                    value="{{ $setting->admin_copyright_es ?? '' }}"
                                                                    class="form-control w-100">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">Update</button>
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
    {{-- <script>
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
    </script> --}}
    <script>
        $(document).ready(function() {


            if (logoUrl) {
                $('#admin_logo').attr('data-default-file', logoUrl);
            }

            if (faviconUrl) {
                $('#admin_favicon').attr('data-default-file', faviconUrl);
            }

            $('.dropify').dropify();
        });
    </script>
@endpush
