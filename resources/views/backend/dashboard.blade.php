@extends('backend.master')

@section('content')
    <main class="content-body">

        <!-- Start - Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">eCommerce</li>
                </ol>
            </nav>
        </div>
        <!-- End - Page Title & Breadcrumb -->

        <div class="container-fluid">

            <div class="row">

                <!-- Start - Revenue  -->
                <div class="col-xxl-4 col-xl-12">
                    <div class="row">
                        <div class="col-xxl-12 col-md-6">
                            <div class="card text-bg-primary overflow-hidden z-1">
                                <img src="{{ asset('backend/app-assets/images/card-bg1.png') }}" alt=""
                                    class="position-absolute top-0 start-0 z-n1">
                                <div class="card-header pb-0 border-0 align-items-start pt-4">
                                    <h4 class="card-title">Revenue</h4>
                                    <div class="clearfix">
                                        <select class="selectpicker form-select form-select-sm">
                                            <option value="Monthly">Monthly</option>
                                            <option value="Weekly">Weekly</option>
                                            <option value="Yearly">Yearly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body pt-1">
                                    <h3 class="display-4 text-white fw-semibold mb-2">$34,129.03</h3>
                                    <div class="d-flex justify-content-between align-items-end">
                                        <div class="clearfix">
                                            <span class="text-success fw-medium fs-lg">+8.50%</span>
                                            <span class="text-white fs-lg">prev month</span>
                                        </div>
                                        <div id="chartRevenue"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12 col-md-6">
                            <div class="card overflow-hidden z-1">
                                <img src="{{ asset('backend/app-assets/images/card-bg1.png') }}" alt=""
                                    class="position-absolute top-0 start-0 z-n1">
                                <div class="card-header pb-0 border-0 align-items-start pt-4">
                                    <h4 class="card-title">Total Sales</h4>
                                    <div class="clearfix">
                                        <select class="selectpicker form-select form-select-sm">
                                            <option value="Monthly">Monthly</option>
                                            <option value="Weekly">Weekly</option>
                                            <option value="Yearly">Yearly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body pt-1">
                                    <h3 class="display-4 fw-semibold mb-2">$201,843.52</h3>
                                    <div class="d-flex justify-content-between align-items-end">
                                        <div class="clearfix">
                                            <span class="text-success fw-medium fs-lg">+8.50%</span>
                                            <span class="text-gray-400 fs-lg">prev month</span>
                                        </div>
                                        <div id="chartTotalSales"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End - Revenue  -->

                <!-- Start - Sales Analytics  -->

                <!-- End - Sales Analytics  -->

                <!-- Start - Greeting Card -->
               
                <!-- End - Greeting Card -->
                <div class="col-xxl-5 col-xl-8">
                    <div class="card">
                        <div class="card-header pb-0 border-0 align-items-start">
                            <h4 class="card-title">User Information</h4>
                            <div class="clearfix">
                                <a href="{{ route('users.pdf') }}" class="btn btn-outline-primary"><i
                                        class="fi fi-rr-download"></i> Download</a>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <span class="fs-lg">Total User</span>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-users me-2 fs-4 text-primary"></i>
                                <h4 id="totalUsers" class="mb-0">0</h4>
                            </div>

                            <small id="totalPercent">0%</small>
                        </div>
                        <div id="chartSpendingStatistic"></div>
                        <div class="card-footer p-2 pt-0 border-0">
                            <div class="row g-2">
                                <div class="col-sm-4 col-6 col-xl-4">
                                    <div class="border rounded px-3 py-2">
                                        <span class="fs-sm text-gray-500">Total User This Month</span>
                                        <h3>
                                            <i class="fa-solid fa-users me-2"></i>
                                            <span id="currentUsers">0</span>
                                        </h3>
                                        <span id="growthPercent" class="fw-bold"></span>

                                    </div>
                                </div>
                                <div class="col-sm-4 col-6 col-xl-4">
                                    <div class="border rounded px-3 py-2">
                                        <span class="fs-sm text-gray-500">Active User This Month</span>
                                        <h3>
                                            <i class="fa-solid fa-users me-2"></i>
                                            <span id="activeCount">0</span>
                                        </h3>
                                        <span id="activePercent"></span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12 col-xl-4">
                                    <div class="border rounded px-3 py-2">
                                        <span class="fs-sm text-gray-500">Inactive User This Month</span>
                                        <h3>
                                            <i class="fa-solid fa-users me-2"></i>
                                            <span id="inactiveCount">0</span>
                                        </h3>
                                        <span id="inactivePercent"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card text-center custom-card-1">
                        <div class="card-body">
                            <h4 class="fw-semibold fs-xl mb-0">Congratulation James</h4>
                            <img class="w-100 mix-blend-darken px-xxl-2"
                                src="{{ asset('backend/app-assets/images/achieved.png') }}" alt="">
                            <h5 class="display-4 fw-semibold mb-1 lh-1">$1200K</h5>
                            <p class="text-dark text-opacity-50 mb-2">0.95% since last year</p>
                            <p class="fs-lg fw-medium px-xxl-4 lh-sm">You have reached 99.9% of your sales target today.</p>
                            <p class="fs-xs text-primary fw-medium mb-0">Updated 20 minutes ago.</p>
                        </div>
                    </div>
                </div>


                {{-- <div class="col-xxl-5 col-xl-8">
                    <div class="card">
                        <div class="card-header pb-0 border-0 align-items-start">
                            <h4 class="card-title">Spending Statistic</h4>
                            <div class="clearfix">
                                <a href="javascript:void(0);" class="btn btn-primary light"><i
                                        class="fi fi-rr-download"></i> Download</a>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <span class="fs-lg">Income</span>
                            <h3 class="display-5 fw-semibold mb-0">$20,687.69 <span
                                    class="text-success fw-medium fs-lg">+8.50%</span></h3>
                        </div>
                        <div id="chartSpendingStatistic"></div>
                        <div class="card-footer p-2 pt-0 border-0">
                            <div class="row g-2">
                                <div class="col-sm-4 col-6 col-xl-4">
                                    <div class="border rounded px-3 py-2">
                                        <span class="fs-sm text-gray-500">Total Revenue</span>
                                        <h4 class="mb-2 fw-semibold">$201,843.52</h4>
                                        <span class="fs-sm text-success">+6.32%</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6 col-xl-4">
                                    <div class="border rounded px-3 py-2">
                                        <span class="fs-sm text-gray-500">Total Sales</span>
                                        <h4 class="mb-2 fw-semibold">$280,547.36</h4>
                                        <span class="fs-sm text-danger">-2.05%</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12 col-xl-4">
                                    <div class="border rounded px-3 py-2">
                                        <span class="fs-sm text-gray-500">Total Profit</span>
                                        <h4 class="mb-2 fw-semibold">$500,468.15</h4>
                                        <span class="fs-sm text-success">+2.01%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>

    </main>
@endsection
