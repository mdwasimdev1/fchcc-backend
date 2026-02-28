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
                    <li class="breadcrumb-item active" aria-current="page">Stripe</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start -Update System Setting -->
                        <div class="col-xl-8">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Stripe key Update</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Setting upgrate Form --}}
                                    <div id="addCategoryContainer">
                                        <form action="{{ route('stripe.post') }}" method="POST">
                                            @csrf
                                            <div class="card-body">
                                                <div class="d-flex gap-3">
                                                    <div class="col-xl-12">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Stripe Key</label>
                                                            <input type="text" name="stripe_key"
                                                                value="{{ env('STRIPE_KEY') }}" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Stripe Secret</label>
                                                            <input type="text" name="stripe_secret"
                                                                value="{{ env('STRIPE_SECRET') }}" class="form-control" required>
                        
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">Submit</button>
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
@endpush
