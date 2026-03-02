@extends('backend.master')

@section('title', 'User Add Page')

@section('content')

    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Event</li>
                </ol>
            </nav>
        </div>
        <!-- end - Page Title & Breadcrumb -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <!-- Start - Dynamic Page Add -->
                        <div class="col-xl-8">
                            <div class="card card-collapse">
                                <div class="card-header">
                                    <h4 class="card-title">Add Event</h4>
                                    <a class="collapse-indicator" data-bs-toggle="collapse" href="#collapseFilter"
                                        role="button" aria-expanded="false" aria-controls="collapseFilter">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                                <div class="collapsed collapse show" id="collapseFilter">
                                    {{-- Add FAQ Form --}}
                                    <div id="addFaqFormContainer">
                                        <form id="createEvent" action="{{ route('event.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Event Date</label>
                                                    <input type="date" name="event_date" class="form-control">
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Title (EN)</label>
                                                    <input type="text" name="title[en]" class="form-control"
                                                        placeholder="Enter Title">
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Title (ES)</label>
                                                    <input type="text" name="title[es]" class="form-control"
                                                        placeholder="Enter Title">
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Description (EN)</label>
                                                    <input type="text" name="description[en]" class="form-control"
                                                        placeholder="Enter description">
                                                </div>
                                                <div class="mb-3 d-flex flex-column">
                                                    <label class="form-label">Description (ES)</label>
                                                    <input type="text" name="description[es]" class="form-control"
                                                        placeholder="Enter description">
                                                </div>

                                                <div class="clearfix">
                                                    <button type="submit" class="btn btn-outline-primary">Create</button>
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
