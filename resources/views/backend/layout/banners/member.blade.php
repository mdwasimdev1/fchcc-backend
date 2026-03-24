@extends('backend.master')

@section('title', 'Member Banner')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Member Banner</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Member Banner</h4>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Errors:</strong>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('banner.member.update', ['id' => $banner->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- Banner Image -->
                                <div class="mb-3">
                                    <label class="form-label">Banner Image</label>
                                    <input type="file" name="image" class="dropify" accept="image/*"
                                        data-allowed-file-extensions="jpg png jpeg webp"
                                        data-max-file-size="12M"
                                        @isset($banner->image)
                                          data-default-file="{{ asset('uploads/banners/' . $banner->image) }}"
                                       @endisset>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Title Section -->
                                <div class="d-flex gap-3 flex-wrap">
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Title (English)</label>
                                        <input type="text" name="title_en"
                                            value="{{ $banner->translations->where('locale', 'en')->first()->title ?? '' }}"
                                            class="form-control" placeholder="Enter banner title in English">
                                        @error('title_en')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Title (Spanish)</label>
                                        <input type="text" name="title_es"
                                            value="{{ $banner->translations->where('locale', 'es')->first()->title ?? '' }}"
                                            class="form-control" placeholder="Enter banner title in Spanish">
                                        @error('title_es')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description Section -->
                                <div class="d-flex gap-3 flex-wrap">
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Description (English)</label>
                                        <textarea name="description_en" rows="3" class="form-control"
                                            placeholder="Enter banner description in English">{{ $banner->translations->where('locale', 'en')->first()->description ?? '' }}</textarea>
                                        @error('description_en')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Description (Spanish)</label>
                                        <textarea name="description_es" rows="3" class="form-control"
                                            placeholder="Enter banner description in Spanish">{{ $banner->translations->where('locale', 'es')->first()->description ?? '' }}</textarea>
                                        @error('description_es')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Button Text Section -->
                                <div class="d-flex gap-3 flex-wrap">
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Button Text (English)</label>
                                        <input type="text" name="button_text_en"
                                            value="{{ $banner->translations->where('locale', 'en')->first()->button_text ?? '' }}" class="form-control"
                                            placeholder="Enter button text in English">
                                        @error('button_text_en')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Button Text (Spanish)</label>
                                        <input type="text" name="button_text_es"
                                            value="{{ $banner->translations->where('locale', 'es')->first()->button_text ?? '' }}" class="form-control"
                                            placeholder="Enter button text in Spanish">
                                        @error('button_text_es')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Button URL -->
                                <div class="mb-3">
                                    <label class="form-label">Button URL</label>
                                    <input type="url" name="button_url" value="{{ $banner->button_url ?? '' }}"
                                        class="form-control" placeholder="https://example.com">
                                    @error('button_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                            id="bannerStatus" {{ $banner->status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bannerStatus">
                                            Active
                                        </label>
                                    </div>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update Banner</button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
