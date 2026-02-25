@extends('layouts.administrator')
@section('title', 'Dashboard')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-4 input-group input-group-merge">
                            <div class="btn-group">
                                <a href="{{ route('administrator.dashboard') }}" id="date-text" class="btn btn-dark">
                                    @if ($filter['start_date'])
                                        Custom Date
                                    @elseif($filter['date_range'] == 'today')
                                        Today
                                    @elseif($filter['date_range'] == 'yesterday')
                                        Yesterday
                                    @elseif($filter['date_range'] == 'week')
                                        This Week
                                    @elseif($filter['date_range'] == 'month')
                                        This Month
                                    @elseif($filter['date_range'] == 'year')
                                        This Year
                                    @else
                                        All Dates
                                    @endif
                                </a>
                                <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                </button>
                                <div class="dropdown-menu dashboard-filter-dropdown"
                                    style="transform: translate(0px, 40px) !important;">
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="showDateInput();">Custom</a>
                                    <a class="dropdown-item"
                                        href="{{ route('administrator.dashboard', ['filter' => 'today']) }}">Today</a>
                                    <a class="dropdown-item"
                                        href="{{ route('administrator.dashboard', ['filter' => 'yesterday']) }}">Yesterday</a>
                                    <a class="dropdown-item"
                                        href="{{ route('administrator.dashboard', ['filter' => 'week']) }}">This
                                        Week</a>
                                    <a class="dropdown-item"
                                        href="{{ route('administrator.dashboard', ['filter' => 'month']) }}">This
                                        Month</a>
                                    <a class="dropdown-item"
                                        href="{{ route('administrator.dashboard', ['filter' => 'year']) }}">This
                                        Year</a>
                                </div>
                            </div>

                            <div class="date-width me-2">
                                <input type="date" class="form-control date-width" name="start_date"
                                    id="filter_start_date" placeholder="Start Date" onfocus="(this.type='date')"
                                    onblur="(this.type='text')"
                                    @isset($filter['start_date']) value="{{ $filter['start_date'] }}" @else style="display: none;" @endif>
                            </div>
                            <div class="date-width me-2">
                                <input type="date" class="form-control date-width" name="end_date" id="filter_end_date" placeholder="End Date" onfocus="(this.type='date')"
                                onblur="(this.type='text')"  @isset($filter['end_date']) value="{{ $filter['end_date'] }}" @else style="display: none;" @endif>
                            </div>
                                <button type="button" id="filter-button" form="filter-form" class="btn btn-sm btn-danger" onclick="handler()"  @isset($filter['start_date'])  @else style="display: none;" @endif>Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-6">
                            <div class="card cta-box bg-danger text-white">
                                <div class="card-body">
                                    <a href="{{ route('administrator.tasks.index') }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex align-items-start align-items-center">
                                            <div class="w-100 overflow-hidden">
                                                <h4 class="mt-0">Total Tasks</h4>
                                                <h3 class="m-0 fw-bold cta-box-title">{{ $total_tasks }}</h3>
                                            </div>
                                            <i class="ms-3 uil-angle-right-b"></i>
                                        </div>
                                    </a>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->

                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card cta-box bg-danger text-white">
                                <div class="card-body">
                                    <a href="{{ route('administrator.merchants.index') }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex align-items-start align-items-center">
                                            <div class="w-100 overflow-hidden">
                                                <h4 class="mt-0">Total Workshops</h4>
                                                <h3 class="m-0 fw-bold cta-box-title">{{ $total_merchants }}</h3>
                                            </div>
                                            <i class="ms-3 uil-angle-right-b"></i>
                                        </div>
                                    </a>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->

                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card cta-box bg-danger text-white">
                                <div class="card-body">
                                    <a href="{{ route('administrator.drivers.index') }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex align-items-start align-items-center">
                                            <div class="w-100 overflow-hidden">
                                                <h4 class="mt-0">Total Drivers</h4>
                                                <h3 class="m-0 fw-bold cta-box-title">{{ $total_drivers }}</h3>
                                            </div>
                                            <i class="ms-3 uil-angle-right-b"></i>
                                        </div>
                                    </a>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->

                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card cta-box bg-danger text-white">
                                <div class="card-body">
                                    <a href="{{ route('administrator.dispatchers.index') }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex align-items-start align-items-center">
                                            <div class="w-100 overflow-hidden">
                                                <h4 class="mt-0">Total Dispatchers</h4>
                                                <h3 class="m-0 fw-bold cta-box-title">{{ $total_dispatchers }}</h3>
                                            </div>
                                            <i class="ms-3 uil-angle-right-b"></i>
                                        </div>
                                    </a>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->

                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card cta-box bg-danger text-white">
                                <div class="card-body">
                                    <a href="{{ route('administrator.tasks.index', ['status' => 'active']) }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex align-items-start align-items-center">
                                            <div class="w-100 overflow-hidden">
                                                <h4 class="mt-0">Active Tasks</h4>
                                                <h3 class="m-0 fw-bold cta-box-title">{{ $total_active_tasks }}</h3>
                                            </div>
                                            <i class="ms-3 uil-angle-right-b"></i>
                                        </div>
                                    </a>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card cta-box bg-danger text-white">
                                <div class="card-body">
                                    <a href="{{ route('administrator.tasks.index', ['status' => 'completed']) }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex align-items-start align-items-center">
                                            <div class="w-100 overflow-hidden">
                                                <h4 class="mt-0">Completed Tasks</h4>
                                                <h3 class="m-0 fw-bold cta-box-title">{{ $total_completed_tasks }}</h3>
                                            </div>
                                            <i class="ms-3 uil-angle-right-b"></i>
                                        </div>
                                    </a>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card cta-box bg-danger text-white">
                                <div class="card-body">
                                    <a href="{{ route('administrator.tasks.index', ['status' => 'failed']) }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex align-items-start align-items-center">
                                            <div class="w-100 overflow-hidden">
                                                <h4 class="mt-0">Failed Tasks</h4>
                                                <h3 class="m-0 fw-bold cta-box-title">{{ $total_failed_tasks }}</h3>
                                            </div>
                                            <i class="ms-3 uil-angle-right-b"></i>
                                        </div>
                                    </a>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card cta-box bg-danger text-white">
                                <div class="card-body">
                                    <a href="{{ route('administrator.tasks.index', ['status' => 'cancelled']) }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex align-items-start align-items-center">
                                            <div class="w-100 overflow-hidden">
                                                <h4 class="mt-0">Cancelled Tasks</h4>
                                                <h3 class="m-0 fw-bold cta-box-title">{{ $total_cancelled_tasks }}</h3>
                                            </div>
                                            <i class="ms-3 uil-angle-right-b"></i>
                                        </div>
                                    </a>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card cta-box bg-danger text-white">
                                <div class="card-body">
                                    <a href="{{ route('administrator.tasks.index', ['driver' => 'unassigned']) }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex align-items-start align-items-center">
                                            <div class="w-100 overflow-hidden">
                                                <h4 class="mt-0">Unassigned Tasks</h4>
                                                <h3 class="m-0 fw-bold cta-box-title">{{ $total_unassigned_tasks }}</h3>
                                            </div>
                                            <i class="ms-3 uil-angle-right-b"></i>
                                        </div>
                                    </a>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card cta-box bg-danger text-white">
                                <div class="card-body">
                                    <a href="{{ route('administrator.tasks.index', ['driver' => 'assigned']) }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex align-items-start align-items-center">
                                            <div class="w-100 overflow-hidden">
                                                <h4 class="mt-0">Assigned Tasks</h4>
                                                <h3 class="m-0 fw-bold cta-box-title">{{ $total_assigned_tasks }}</h3>
                                            </div>
                                            <i class="ms-3 uil-angle-right-b"></i>
                                        </div>
                                    </a>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script>
            function showDateInput() {
                $("#date-text").text("Custom Date");
                $('#filter_start_date').toggle();
                $('#filter_end_date').toggle();
                $('#filter-button').toggle();
            }

            function handler() {
                var base = "{!! route('administrator.dashboard') !!}";
                var start_date = $("#filter_start_date").val();
                var end_date = $("#filter_end_date").val();
                var url = base + '?start_date=' + start_date + '&end_date=' + end_date;
                location.href = url;
            }
        </script>
    @endpush
