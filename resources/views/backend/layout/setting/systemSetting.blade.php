@extends('backend.master')

@section('title', 'System Setting Page')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">System Setting</li>
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
                                    <h4 class="card-title">Update System Setting</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Setting upgrate Form --}}
                                    <div id="addCategoryContainer">
                                        <form action="{{ route('system.settingupdate') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="d-flex gap-3">
                                                    <div class="col-xl-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Logo</label>
                                                            <input type="file" name="logo" class="dropify"
                                                                accept="image/*"
                                                                data-allowed-file-extensions="jpg png jpeg webp"
                                                                data-max-file-size="12M"
                                                                 @isset($setting->logo)
                                                                  data-default-file="{{ asset('uploads/setting/system/' . $setting->logo) }}"
                                                               @endisset>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Favicon</label>
                                                            <input type="file" name="favicon" class="dropify"
                                                                accept="image/*"
                                                                data-allowed-file-extensions="jpg png jpeg webp"
                                                                data-max-file-size="12M"
                                                                @isset($setting->favicon)
                                                                  data-default-file="{{ asset('uploads/setting/system/' . $setting->favicon) }}"
                                                               @endisset
                                                               >
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-8">
                                                        <div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Title</label>
                                                                <input type="text" name="system_title" value="{{ $setting->system_title ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Short Title</label>
                                                                <input type="text" name="system_short_title" value="{{ $setting->system_short_title ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Tag Line</label>
                                                            <input type="text" name="tag_line" value="{{ $setting->tag_line ?? '' }}" class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Company Name</label>
                                                            <input type="text" name="company_name" value="{{ $setting->company_name ?? '' }}" class="form-control">
                                                        </div>

                                                        <div class="mb-3">
                                                            <div class="form-group">
                                                                <label for="phone-floating">Phone Number</label>
                                                                <div class="input-group">
                                                                    <select class="custom-select select2-size-lg"
                                                                        id="country-code" name="phone_code">
                                                                        <option value="+1"
                                                                            {{ $setting?->phone_code === '+1' ? 'selected' : '' }}>
                                                                            +1
                                                                            (USA)
                                                                        </option>
                                                                        <option value="+1"
                                                                            {{ $setting?->phone_code === '+1' ? 'selected' : '' }}>
                                                                            +1
                                                                            (Canada)</option>
                                                                        <option value="+44"
                                                                            {{ $setting?->phone_code === '+44' ? 'selected' : '' }}>
                                                                            +44
                                                                            (United Kingdom)</option>
                                                                        <option value="+91"
                                                                            {{ $setting?->phone_code === '+91' ? 'selected' : '' }}>
                                                                            +91
                                                                            (India)</option>
                                                                        <option value="+61"
                                                                            {{ $setting?->phone_code === '+61' ? 'selected' : '' }}>
                                                                            +61
                                                                            (Australia)</option>
                                                                        <option value="+81"
                                                                            {{ $setting?->phone_code === '+81' ? 'selected' : '' }}>
                                                                            +81
                                                                            (Japan)</option>
                                                                        <option value="+49"
                                                                            {{ $setting?->phone_code === '+49' ? 'selected' : '' }}>
                                                                            +49
                                                                            (Germany)</option>
                                                                        <option value="+33"
                                                                            {{ $setting?->phone_code === '+33' ? 'selected' : '' }}>
                                                                            +33
                                                                            (France)</option>
                                                                        <option value="+34"
                                                                            {{ $setting?->phone_code === '+34' ? 'selected' : '' }}>
                                                                            +34
                                                                            (Spain)</option>
                                                                        <option value="+39"
                                                                            {{ $setting?->phone_code === '+39' ? 'selected' : '' }}>
                                                                            +39
                                                                            (Italy)</option>
                                                                        <option value="+55"
                                                                            {{ $setting?->phone_code === '+55' ? 'selected' : '' }}>
                                                                            +55
                                                                            (Brazil)</option>
                                                                        <option value="+7"
                                                                            {{ $setting?->phone_code === '+7' ? 'selected' : '' }}>
                                                                            +7
                                                                            (Russia)</option>
                                                                        <option value="+86"
                                                                            {{ $setting?->phone_code === '+86' ? 'selected' : '' }}>
                                                                            +86
                                                                            (China)</option>
                                                                        <option value="+91"
                                                                            {{ $setting?->phone_code === '+91' ? 'selected' : '' }}>
                                                                            +91
                                                                            (India)</option>
                                                                        <option value="+62"
                                                                            {{ $setting?->phone_code === '+62' ? 'selected' : '' }}>
                                                                            +62
                                                                            (Indonesia)</option>
                                                                        <option value="+971"
                                                                            {{ $setting?->phone_code === '+971' ? 'selected' : '' }}>
                                                                            +971
                                                                            (United Arab Emirates)</option>
                                                                        <option value="+52"
                                                                            {{ $setting?->phone_code === '+52' ? 'selected' : '' }}>
                                                                            +52
                                                                            (Mexico)</option>
                                                                        <option value="+20"
                                                                            {{ $setting?->phone_code === '+20' ? 'selected' : '' }}>
                                                                            +20
                                                                            (Egypt)</option>
                                                                        <option value="+27"
                                                                            {{ $setting?->phone_code === '+27' ? 'selected' : '' }}>
                                                                            +27
                                                                            (South Africa)</option>
                                                                        <option value="+66"
                                                                            {{ $setting?->phone_code === '+66' ? 'selected' : '' }}>
                                                                            +66
                                                                            (Thailand)</option>
                                                                        <option value="+63"
                                                                            {{ $setting?->phone_code === '+63' ? 'selected' : '' }}>
                                                                            +63
                                                                            (Philippines)</option>
                                                                        <option value="+55"
                                                                            {{ $setting?->phone_code === '+55' ? 'selected' : '' }}>
                                                                            +55
                                                                            (Brazil)</option>
                                                                        <option value="+98"
                                                                            {{ $setting?->phone_code === '+98' ? 'selected' : '' }}>
                                                                            +98
                                                                            (Iran)</option>
                                                                        <option value="+90"
                                                                            {{ $setting?->phone_code === '+90' ? 'selected' : '' }}>
                                                                            +90
                                                                            (Turkey)</option>
                                                                        <option value="+82"
                                                                            {{ $setting?->phone_code === '+82' ? 'selected' : '' }}>
                                                                            +82
                                                                            (South Korea)</option>
                                                                        <option value="+34"
                                                                            {{ $setting?->phone_code === '+34' ? 'selected' : '' }}>
                                                                            +34
                                                                            (Spain)</option>
                                                                        <option value="+32"
                                                                            {{ $setting?->phone_code === '+32' ? 'selected' : '' }}>
                                                                            +32
                                                                            (Belgium)</option>
                                                                        <option value="+31"
                                                                            {{ $setting?->phone_code === '+31' ? 'selected' : '' }}>
                                                                            +31
                                                                            (Netherlands)</option>
                                                                        <option value="+47"
                                                                            {{ $setting?->phone_code === '+47' ? 'selected' : '' }}>
                                                                            +47
                                                                            (Norway)</option>
                                                                        <option value="+48"
                                                                            {{ $setting?->phone_code === '+48' ? 'selected' : '' }}>
                                                                            +48
                                                                            (Poland)</option>
                                                                        <option value="+41"
                                                                            {{ $setting?->phone_code === '+41' ? 'selected' : '' }}>
                                                                            +41
                                                                            (Switzerland)</option>
                                                                        <option value="+46"
                                                                            {{ $setting?->phone_code === '+46' ? 'selected' : '' }}>
                                                                            +46
                                                                            (Sweden)</option>
                                                                        <option value="+45"
                                                                            {{ $setting?->phone_code === '+45' ? 'selected' : '' }}>
                                                                            +45
                                                                            (Denmark)</option>
                                                                        <option value="+354"
                                                                            {{ $setting?->phone_code === '+354' ? 'selected' : '' }}>
                                                                            +354
                                                                            (Iceland)</option>
                                                                        <option value="+351"
                                                                            {{ $setting?->phone_code === '+351' ? 'selected' : '' }}>
                                                                            +351
                                                                            (Portugal)</option>
                                                                        <option value="+353"
                                                                            {{ $setting?->phone_code === '+353' ? 'selected' : '' }}>
                                                                            +353
                                                                            (Ireland)</option>
                                                                        <option value="+93"
                                                                            {{ $setting?->phone_code === '+93' ? 'selected' : '' }}>
                                                                            +93
                                                                            (Afghanistan)</option>
                                                                        <option value="+994"
                                                                            {{ $setting?->phone_code === '+994' ? 'selected' : '' }}>
                                                                            +994
                                                                            (Azerbaijan)</option>
                                                                        <option value="+1"
                                                                            {{ $setting?->phone_code === '+1' ? 'selected' : '' }}>
                                                                            +1
                                                                            (Bahrain)</option>
                                                                        <option value="+880"
                                                                            {{ $setting?->phone_code === '+880' ? 'selected' : '' }}>
                                                                            +880
                                                                            (Bangladesh)</option>
                                                                        <option value="+975"
                                                                            {{ $setting?->phone_code === '+975' ? 'selected' : '' }}>
                                                                            +975
                                                                            (Bhutan)</option>
                                                                        <option value="+855"
                                                                            {{ $setting?->phone_code === '+855' ? 'selected' : '' }}>
                                                                            +855
                                                                            (Cambodia)</option>
                                                                        <option value="+86"
                                                                            {{ $setting?->phone_code === '+86' ? 'selected' : '' }}>
                                                                            +86
                                                                            (China)</option>
                                                                        <option value="+357"
                                                                            {{ $setting?->phone_code === '+357' ? 'selected' : '' }}>
                                                                            +357
                                                                            (Cyprus)</option>
                                                                        <option value="+61"
                                                                            {{ $setting?->phone_code === '+61' ? 'selected' : '' }}>
                                                                            +61
                                                                            (Georgia)</option>
                                                                        <option value="+91"
                                                                            {{ $setting?->phone_code === '+91' ? 'selected' : '' }}>
                                                                            +91
                                                                            (India)</option>
                                                                        <option value="+62"
                                                                            {{ $setting?->phone_code === '+62' ? 'selected' : '' }}>
                                                                            +62
                                                                            (Indonesia)</option>
                                                                        <option value="+98"
                                                                            {{ $setting?->phone_code === '+98' ? 'selected' : '' }}>
                                                                            +98
                                                                            (Iran)</option>
                                                                        <option value="+81"
                                                                            {{ $setting?->phone_code === '+81' ? 'selected' : '' }}>
                                                                            +81
                                                                            (Japan)</option>
                                                                        <option value="+962"
                                                                            {{ $setting?->phone_code === '+962' ? 'selected' : '' }}>
                                                                            +962
                                                                            (Jordan)</option>
                                                                        <option value="+961"
                                                                            {{ $setting?->phone_code === '+961' ? 'selected' : '' }}>
                                                                            +961
                                                                            (Lebanon)</option>
                                                                        <option value="+960"
                                                                            {{ $setting?->phone_code === '+960' ? 'selected' : '' }}>
                                                                            +960
                                                                            (Maldives)</option>
                                                                        <option value="+60"
                                                                            {{ $setting?->phone_code === '+60' ? 'selected' : '' }}>
                                                                            +60
                                                                            (Malaysia)</option>
                                                                        <option value="+965"
                                                                            {{ $setting?->phone_code === '+965' ? 'selected' : '' }}>
                                                                            +965
                                                                            (Kuwait)</option>
                                                                    </select>

                                                                    <input type="text" class="form-control"
                                                                        id="phone_number" name="phone_number"
                                                                        value="{{ $setting->phone_number ?? '' }}"
                                                                        placeholder="Enter your phone number">
                                                                </div>
                                                                @error('phone_number')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email" value="{{ $setting->email ?? '' }}" class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Copyright text</label>
                                                            <input type="text" name="copyright_text" value="{{ $setting->copyright_text ?? '' }}" class="form-control">
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
    </script>
@endpush
