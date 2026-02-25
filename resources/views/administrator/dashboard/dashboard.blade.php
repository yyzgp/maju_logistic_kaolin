@extends('layouts.administrator')
@section('title', 'Dashboard')
@section('head')
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/js/app.js'])
    @endif
@endsection
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
            <div class="col-xl-3 col-lg-6">
                <div class="card cta-box bg-danger text-white">
                    <div class="card-body">
                        <a href="{{ route('administrator.tasks.index', ['month' => \Carbon\Carbon::now()->format('m')]) }}" class="text-decoration-none text-white">
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
                        <a href="{{ route('administrator.tasks.index', ['status' => 'in-transist', 'month' => \Carbon\Carbon::now()->format('m')]) }}"
                            class="text-decoration-none text-white">
                            <div class="d-flex align-items-start align-items-center">
                                <div class="w-100 overflow-hidden">
                                    <h4 class="mt-0">In Transit</h4>
                                    <h3 class="m-0 fw-bold cta-box-title">{{ $total_new_tasks }}</h3>
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
                        <a href="{{ route('administrator.tasks.index', ['status' => 'unassigned', 'month' => \Carbon\Carbon::now()->format('m')]) }}"
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
                        <a href="{{ route('administrator.tasks.index', ['status' => 'completed', 'month' => \Carbon\Carbon::now()->format('m')]) }}"
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
            {{-- <div class="col-xl-2 col-lg-6">
                <div class="card cta-box bg-danger text-white">
                    <div class="card-body">
                        <a href="{{ route('administrator.tasks.index',['month' => \Carbon\Carbon::now()->format('m')]) }}" class="text-decoration-none text-white">
                            <div class="d-flex align-items-start align-items-center">
                                <div class="w-100 overflow-hidden">
                                    <h4 class="mt-0">Due Today</h4>
                                    <h3 class="m-0 fw-bold cta-box-title">{{ $today_due_tasks }}</h3>
                                </div>
                                <i class="ms-3 uil-angle-right-b"></i>
                            </div>
                        </a>
                    </div>

                </div>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-xl-5">
                <div class="card"  style="max-height: 498px;">
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="container-one"></div>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card" style="max-height: 498px;" data-simplebar>
                    <div class="card-body">
                        <div class="inbox-widget">
                            @foreach ($drivers as $key => $driver)
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="{{ $driver['avatar'] }}"
                                            class="rounded-circle avatar-image" alt=""><span
                                            id="online-driver-{{ $driver['id'] }}" class="text-success online-status-icon"
                                            style="display: none;">●</span><span id="offline-driver-{{ $driver['id'] }}"
                                            class="text-muted offline-status-icon">●</span></div>
                                    <p class="inbox-item-author">{{ $driver['firstname'] }} {{ $driver['lastname'] }}</p>
                                    <p class="inbox-item-text">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"
                                            style="width: {{ $driver['total_assigned_jobs'] }}%"
                                            aria-valuenow="{{ $driver['total_assigned_jobs'] }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    </p>
                                    <p class="inbox-item-date">
                                        <a href="#" class="btn btn-sm btn-link text-info font-13">
                                            {{ $driver['total_assigned_jobs'] }}/100 </a>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="container-two"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script>
            window.addEventListener('DOMContentLoaded', function() {

                window.Echo.channel('online-status')
                    .listen('SendOnlineStatus', (data) => {
                        if (data.is_online == true) {
                            $("#online-driver-" + data.driver_id).show();
                            $("#offline-driver-" + data.driver_id).hide();
                        } else {
                            $("#online-driver-" + data.driver_id).hide();
                            $("#offline-driver-" + data.driver_id).show();
                        }
                    })
            });
        </script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script>
            Highcharts.chart('container-one', {
                chart: {
                    type: 'pie',
                    custom: {},
                    events: {
                        render() {
                            const chart = this,
                                series = chart.series[0];
                            let customLabel = chart.options.chart.custom.label;

                            if (!customLabel) {
                                customLabel = chart.options.chart.custom.label =
                                    chart.renderer.label(
                                        'Total<br/>' +
                                        '<strong>' + "{{ $total_tasks }}" + '</strong>'
                                    )
                                    .css({
                                        color: '#000',
                                        textAnchor: 'middle'
                                    })
                                    .add();
                            }


                            const x = series.center[0] + chart.plotLeft,
                                y = series.center[1] + chart.plotTop -
                                (customLabel.attr('height') / 2);

                            customLabel.attr({
                                x,
                                y
                            });
                            // Set font size based on chart diameter
                            customLabel.css({
                                fontSize: `${series.center[2] / 12}px`
                            });
                        }
                    }
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                title: {
                    text: 'Active Tasks'
                },
                subtitle: {
                    text: 'Data Source: <a href="{{ route('administrator.dashboard') }}">Logisticss</a> {{ \Carbon\Carbon::now()->format("M") }} {{ \Carbon\Carbon::now()->format("Y") }}'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.1f}</b>'
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        borderRadius: 8,
                        dataLabels: [{
                            enabled: true,
                            distance: 20,
                            format: '{point.name}'
                        }, {
                            enabled: true,
                            distance: -15,
                            format: '{point.y:.1f}',
                            style: {
                                fontSize: '0.9em'
                            }
                        }],
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Tasks',
                    colorByPoint: true,
                    innerSize: '65%',
                    data: [{
                        name: 'Assigned Tasks',
                        y: parseInt('{{ $total_assigned_tasks }}')
                    }, {
                        name: 'Unassigned Tasks',
                        y: parseInt('{{ $total_unassigned_tasks }}')
                    }]
                }]
            });
        </script>
        <script>
            Highcharts.chart('container-two', {
                chart: {
                    type: 'pie',
                    custom: {},
                    events: {
                        render() {
                            const chart = this,
                                series = chart.series[0];
                            let customLabel = chart.options.chart.custom.label;

                            if (!customLabel) {
                                customLabel = chart.options.chart.custom.label =
                                    chart.renderer.label(
                                        'Total<br/>' +
                                        '<strong>' + "{{ $total_tasks }}" + '</strong>'
                                    )
                                    .css({
                                        color: '#000',
                                        textAnchor: 'middle'
                                    })
                                    .add();
                            }


                            const x = series.center[0] + chart.plotLeft,
                                y = series.center[1] + chart.plotTop -
                                (customLabel.attr('height') / 2);

                            customLabel.attr({
                                x,
                                y
                            });
                            // Set font size based on chart diameter
                            customLabel.css({
                                fontSize: `${series.center[2] / 12}px`
                            });
                        }
                    }
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                title: {
                    text: 'Task History'
                },
                subtitle: {
                    text: 'Data Source: <a href="{{ route('administrator.dashboard') }}">Logisticss</a> {{ \Carbon\Carbon::now()->format("M") }} {{ \Carbon\Carbon::now()->format("Y") }}'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.1f}</b>'
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        borderRadius: 8,
                        dataLabels: [{
                            enabled: true,
                            distance: 20,
                            format: '{point.name}'
                        }, {
                            enabled: true,
                            distance: -15,
                            format: '{point.y:.1f}',
                            style: {
                                fontSize: '0.9em'
                            }
                        }],
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Tasks',
                    colorByPoint: true,
                    innerSize: '65%',
                    data: [{
                        name: 'Active Tasks',
                        y: parseInt('{{ $total_active_tasks }}')
                    }, {
                        name: 'Completed Tasks',
                        y: parseInt('{{ $total_completed_tasks }}')
                    }, {
                        name: 'In Transit Tasks',
                        y: parseInt('{{ $total_intransit_tasks }}')
                    }, {
                        name: 'Failed Tasks',
                        y: parseInt('{{ $total_failed_tasks }}')
                    }, {
                        name: 'Arrived Tasks',
                        y: parseInt('{{ $total_arrived_tasks }}')
                    }, {
                        name: 'Cancelled Tasks',
                        y: parseInt('{{ $total_cancelled_tasks }}')
                    }]
                }]
            });
        </script>
    @endpush
