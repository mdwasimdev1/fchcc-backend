@extends('backend.master')

@section('title', 'Featured Video')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.featured-videos') }}</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('messages.edit') }} {{ __('messages.featured-videos') }}</h4>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ __('messages.errors') }}:</strong>
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

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('featured-video.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Video Title -->
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.title') }}</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ $video->title ?? '' }}"
                                        placeholder="Enter featured video title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Video File Upload -->
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.video') }}</label>
                                    <input type="file" name="video_file" class="dropify"
                                        accept="video/mp4,video/webm,video/ogg,video/quicktime"
                                        data-allowed-file-extensions="mp4 webm ogg mov"
                                        data-max-file-size="50M">
                                    @error('video_file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted d-block mt-2">
                                        {{ __('messages.supported') }}: MP4, WebM, OGG, MOV ({{ __('messages.max_file_size') }}: 50MB)
                                    </small>
                                </div>

                                <!-- Video Preview -->
                                @if ($video->video_file)
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('messages.preview') }}</label>
                                        <div class="ratio ratio-16x9 border rounded">
                                            <video controls class="w-100">
                                                <source src="{{ asset('storage/' . $video->video_file) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </div>
                                @endif

                                <!-- Status Toggle -->
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                            id="videoStatus" {{ $video->status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="videoStatus">
                                            {{ $video->status ? __('messages.active') : __('messages.inactive') }}
                                        </label>
                                    </div>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
