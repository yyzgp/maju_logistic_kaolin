@extends('layouts.administrator')
@section('title', 'Map')
@section('head')
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/js/app.js'])
    @endif
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title">
                        Map Tracking
                    </h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div id="map" style="height: 460px; width:100%; border-radius:10px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        @include('administrator.maps.navigation-tabs')
                        <div class="tab-content">
                            <div class="tab-pane show active" id="task-tab" style="max-height: 475px;" data-simplebar>
                                @include('administrator.maps.tasks')
                            </div>
                            <div class="tab-pane" id="driver-tab">
                                @include('administrator.maps.drivers')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="assign-driver-modal">

    </div>
@endsection
@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_api_key') }}&loading=async&callback=initGMap&libraries=places,marker,drawing,geometry">
    </script>
    <script>
        var map;
        var markers = [];
        var assigned_tasks = [];
        var unassigned_tasks = [];
        var completed_tasks = [];
        var drivers = [];

        function initGMap(tab = "", id = "") {

            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 1.3327368,
                    lng: 103.8082656
                },
                zoom: 12,
                mapId: "{{ config('app.google_map_id') }}",
                mapTypeControl: !1,
                MapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_RIGHT
                },
                fullscreenControl: !0,
            });


            var assigned_tasks = [
                @foreach ($assigned_tasks as $task)
                    {
                        id: {{ $task->id }},
                        url: "{{ route('administrator.tasks.show', $task->id) }}",
                        lat: {{ $task->latitude ?? '0' }},
                        lng: {{ $task->longitude ?? '0' }},
                        title: 'Task Id: {{ $task->id }}',
                        customer: '{{ $task->name }}',
                        phone: '{{ $task->dialcode }} {{ $task->phone }}',
                        email: '{{ $task->email }}',
                        address: '{{ $task->address }}',
                        type: '{{ $task->type }}',
                        merchant: '{{ $task->merchant->name }}',
                        due_by: '{{ \Carbon\Carbon::parse($task->due_time)->format('M d, Y h:i A') }}',
                        status: '{{ ucfirst($task->status) }}',
                    },
                @endforeach
            ];

            if (tab == "Assigned" && id !== "") {
                var filtered_assigned_tasks = assigned_tasks.filter(x => x.id === id);
            }

            var unassigned_tasks = [
                @foreach ($unassigned_tasks as $task)
                    {
                        id: {{ $task->id }},
                        url: "{{ route('administrator.tasks.show', $task->id) }}",
                        lat: {{ $task->latitude ?? '0' }},
                        lng: {{ $task->longitude ?? '0' }},
                        title: 'Task Id: {{ $task->id }}',
                        customer: '{{ $task->name }}',
                        phone: '{{ $task->dialcode }} {{ $task->phone }}',
                        email: '{{ $task->email }}',
                        address: '{{ $task->address }}',
                        type: '{{ $task->type }}',
                        merchant: '{{ $task->merchant->name }}',
                        due_by: '{{ \Carbon\Carbon::parse($task->due_time)->format('M d, Y h:i A') }}',
                        status: '{{ ucfirst($task->status) }}',
                    },
                @endforeach
            ];

            if (tab == "Unassigned" && id !== "") {
                var filtered_unassigned_tasks = unassigned_tasks.filter(x => x.id === id);
            }

            var completed_tasks = [
                @foreach ($completed_tasks as $task)
                    {
                        id: {{ $task->id }},
                        url: "{{ route('administrator.tasks.show', $task->id) }}",
                        lat: {{ $task->latitude ?? '0' }},
                        lng: {{ $task->longitude ?? '0' }},
                        title: 'Task Id: {{ $task->id }}',
                        customer: '{{ $task->name }}',
                        phone: '{{ $task->dialcode }} {{ $task->phone }}',
                        email: '{{ $task->email }}',
                        address: '{{ $task->address }}',
                        type: '{{ $task->type }}',
                        merchant: '{{ $task->merchant->name }}',
                        due_by: '{{ \Carbon\Carbon::parse($task->due_time)->format('M d, Y h:i A') }}',
                        status: '{{ ucfirst($task->status) }}',
                    },
                @endforeach
            ];

            if (tab == "Completed" && id !== "") {
                var filtered_completed_tasks = completed_tasks.filter(x => x.id === id);
            }

            var drivers = [
                @foreach ($drivers as $driver)
                    {
                        id: {{ $driver['id'] }},
                        url: "{{ route('administrator.drivers.show', $driver['id']) }}",
                        lat: {{ $driver['latitude'] ?? '0' }},
                        lng: {{ $driver['longitude'] ?? '0' }},
                        driver: '{{ $driver['firstname'] }} {{ $driver['lastname'] }}',
                        vehicle_type: '{{ $driver['vehicle_type'] }}',
                        vehicle_reg: '{{ $driver['vehicle_registration_no'] }}',
                        phone: '{{ $driver['dialcode'] }} {{ $driver['phone'] }}',
                        email: '{{ $driver['email'] }}',
                        address: '{{ $driver['address'] }}',
                        status: '{{ ucfirst($driver['status']) }}',
                    },
                @endforeach
            ];

            if (tab == "Driver" && id !== "") {
                var filtered_drivers = drivers.filter(x => x.id === id);
            }


            var tab = (tab !== "") ? tab : "Assigned";

            switch (tab) {
                case "Assigned":
                    var final_assigned_tasks = (tab == "Assigned" && id !== "") ? filtered_assigned_tasks : assigned_tasks;

                    final_assigned_tasks.forEach((task) => {

                        const marker = new google.maps.marker.AdvancedMarkerElement({
                            position: new google.maps.LatLng({
                                "lat": (task.lat),
                                "lng": task.lng
                            }),
                            map,

                            collisionBehavior: "REQUIRED",

                        });

                        if (tab == "Assigned" && id !== "") {
                            map.setCenter(new google.maps.LatLng({
                                "lat": (task.lat),
                                "lng": task.lng
                            }));
                        }

                        const infowindow = new google.maps.InfoWindow({
                            content: contentString(task),
                            ariaLabel: task.title,
                            maxWidth: '450px'
                        });

                        marker.addListener("click", () => {
                            infowindow.open({
                                anchor: marker,
                                map,
                            });
                        });

                        markers.push(marker);
                    });
                    break;
                case "Unassigned":
                    var final_unassigned_tasks = (tab == "Unassigned" && id !== "") ? filtered_unassigned_tasks :
                        unassigned_tasks;

                    final_unassigned_tasks.forEach((task) => {
                        const marker = new google.maps.marker.AdvancedMarkerElement({
                            position: new google.maps.LatLng({
                                "lat": (task.lat),
                                "lng": task.lng
                            }),
                            map,

                            collisionBehavior: "REQUIRED",
                        });

                        if (tab == "Unassigned" && id !== "") {
                            map.setCenter(new google.maps.LatLng({
                                "lat": (task.lat),
                                "lng": task.lng
                            }));
                        }

                        const infowindow = new google.maps.InfoWindow({
                            content: contentString(task),
                            ariaLabel: task.title,
                            maxWidth: '450px'
                        });

                        marker.addListener("click", () => {
                            infowindow.open({
                                anchor: marker,
                                map,
                            });
                        });

                        markers.push(marker);
                    });
                    break;
                case "Completed":
                    var final_completed_tasks = (tab == "Completed" && id !== "") ? filtered_completed_tasks :
                        completed_tasks;
                    final_completed_tasks.forEach((task) => {
                        const marker = new google.maps.marker.AdvancedMarkerElement({
                            position: new google.maps.LatLng({
                                "lat": (task.lat),
                                "lng": task.lng
                            }),
                            map,

                            collisionBehavior: "REQUIRED",
                        });

                        if (tab == "Completed" && id !== "") {
                            map.setCenter(new google.maps.LatLng({
                                "lat": (task.lat),
                                "lng": task.lng
                            }));
                        }

                        const infowindow = new google.maps.InfoWindow({
                            content: contentString(task),
                            ariaLabel: task.title,
                            maxWidth: '450px'
                        });

                        marker.addListener("click", () => {
                            infowindow.open({
                                anchor: marker,
                                map,
                            });
                        });

                        markers.push(marker);
                    });
                    break;
                case "Driver":
                    var final_drivers = (tab == "Driver" && id !== "") ? filtered_drivers : drivers;
                    final_drivers.forEach((driver) => {
                        const driverMarker = document.createElement("img");
                        driverMarker.src ="{{ asset('assets/images/tow-truck.png') }}";
                        const marker = new google.maps.marker.AdvancedMarkerElement({
                            position: new google.maps.LatLng({
                                "lat": (driver.lat),
                                "lng": driver.lng
                            }),
                            content: driverMarker,
                            map,

                            collisionBehavior: "REQUIRED",
                        });

                        if (tab == "Driver" && id !== "") {
                            map.setCenter(new google.maps.LatLng({
                                "lat": (driver.lat),
                                "lng": driver.lng
                            }));
                        }

                        const infowindow = new google.maps.InfoWindow({
                            content: contentDriverString(driver),
                            ariaLabel: driver.driver,
                            maxWidth: '450px'
                        });

                        marker.addListener("click", () => {
                            infowindow.close();//hide the infowindow

                            infowindow.open({
                                anchor: marker,
                                map,
                            });
                        });

                        markers.push(marker);
                    });
                    break;
                default:
                    break;
            }

        }
    </script>
    <script>
        function contentString(task) {
            var contentString = "<div class='row'>";
            contentString += "<div class='col-sm-12 text-center'>";
            contentString += "<h5 class='text-dark mb-0'>" + task.title + "</h5>";
            contentString += "</div>";
            contentString += "<div class='col-sm-12 text-center'>";
            contentString += "<h6 class='text-danger mt-1'><a href='https://maps.google.com/?q=" + task.lat + ", " + task
                .lng + "' class='text-danger' target='_blank'>" + task.address + "</a></h6>";
            contentString += "</div>";
            contentString += "</div>";

            contentString += "<div class='row'>";
            contentString += "<div class='col-sm-6 text-start'>";
            contentString += "<h5><span class='badge bg-success rounded-pill'>" + task.status + "</span></h5>";
            contentString += "</div>";
            contentString += "<div class='col-sm-6 text-end'>";
            contentString += "<h5><span class='badge bg-danger rounded-pill'>" + task.type + "</span></h5>";
            contentString += "</div>";
            contentString += "</div>";

            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-6 text-start'>";
            contentString += "<h6>Customer</h6>";
            contentString += "</div>";
            contentString += "<div class='col-sm-6 text-end'>";
            contentString += "<h6>" + task.customer + "</h6>";
            contentString += "</div>";
            contentString += "</div>";

            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-6 text-start'>";
            contentString += "<h6>Phone</h6>";
            contentString += "</div>";
            contentString += "<div class='col-sm-6 text-end'>";
            contentString += "<h6>" + task.phone + "</h6>";
            contentString += "</div>";
            contentString += "</div>";

            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-6 text-start'>";
            contentString += "<h6>Email</h6>";
            contentString += "</div>";
            contentString += "<div class='col-sm-6 text-end'>";
            contentString += "<h6>" + task.email + "</h6>";
            contentString += "</div>";
            contentString += "</div>";

            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-6 text-start'>";
            contentString += "<h6>Due Time</h6>";
            contentString += "</div>";
            contentString += "<div class='col-sm-6 text-end'>";
            contentString += "<h6>" + task.due_by + "</h6>";
            contentString += "</div>";
            contentString += "</div>";

            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-6 text-start'>";
            contentString += "<h6>Merchanr</h6>";
            contentString += "</div>";
            contentString += "<div class='col-sm-6 text-end'>";
            contentString += "<h6>" + task.merchant + "</h6>";
            contentString += "</div>";
            contentString += "</div>";

            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-12 d-grid'>";
            contentString += "<a href=" + task.url + " class='btn btn-sm btn-danger'>View Task</h6>";
            contentString += "</div>";
            contentString += "</div>";

            return contentString;
        }
    </script>
    <script>
        function contentDriverString(driver) {
            var contentString = "<div class='row'>";
            contentString += "<div class='col-sm-12 text-center'>";
            contentString += "<h5 class='text-dark mb-0'>" + driver.driver + "</h5>";
            contentString += "</div>";
            contentString += "<div class='col-sm-12 text-center'>";
            contentString += "<h6 class='text-danger mt-1'><a href='https://maps.google.com/?q=" + driver.lat + ", " +
                driver.lng + "' class='text-danger' target='_blank'>" + driver.address + "</a></h6>";
            contentString += "</div>";
            contentString += "</div>";



            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-6 text-start'>";
            contentString += "<h6>Vehicle Type</h6>";
            contentString += "</div>";
            contentString += "<div class='col-sm-6 text-end'>";
            contentString += "<h6>" + driver.vehicle_type + "</h6>";
            contentString += "</div>";
            contentString += "</div>";

            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-6 text-start'>";
            contentString += "<h6>Vehicle Type</h6>";
            contentString += "</div>";
            contentString += "<div class='col-sm-6 text-end'>";
            contentString += "<h6>" + driver.vehicle_reg + "</h6>";
            contentString += "</div>";
            contentString += "</div>";

            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-6 text-start'>";
            contentString += "<h6>Phone</h6>";
            contentString += "</div>";
            contentString += "<div class='col-sm-6 text-end'>";
            contentString += "<h6>" + driver.phone + "</h6>";
            contentString += "</div>";
            contentString += "</div>";

            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-6 text-start'>";
            contentString += "<h6>Email</h6>";
            contentString += "</div>";
            contentString += "<div class='col-sm-6 text-end'>";
            contentString += "<h6>" + driver.email + "</h6>";
            contentString += "</div>";
            contentString += "</div>";


            contentString += "<div class='row' style='width:600px;'>";
            contentString += "<div class='col-sm-12 d-grid'>";
            contentString += "<a href=" + driver.url + " class='btn btn-sm btn-danger'>View Driver</h6>";
            contentString += "</div>";
            contentString += "</div>";

            return contentString;
        }
    </script>
    <script>
        function getTaskDetails(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            });
            var formData = {
                task_id: id,
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('administrator.tasks.get-details') }}',
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    console.log('Before Sending Request');
                },
                success: function(res, status) {
                    return res.task;
                },
                error: function(res, status) {
                    console.log(res);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#driver-filter").keyup(function() {

                // Retrieve the input field text and reset the count to zero
                var filter = $.trim($(this).val()),
                    count = 0;
                var children = $('#inbox-widget div').children();
                // Loop through the comment list
                children.find('.inbox-item-author').each(function() {

                    // If the list item does not contain the text phrase fade it out
                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).parent().parent().parent().parent().hide(); // MY CHANGE

                        // Show the list item if the phrase matches and increase the count by 1
                    } else {
                        $(this).parent().parent().parent().parent().show(); // MY CHANGE
                        count++;
                    }

                });

            });
        });
    </script>
    <script>
        function assignDriver(id) {
            $("#task_id").val(id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            });
            var formData = {
                task_id: id,
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('administrator.tracking.drivers-nearby') }}',
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    console.log('Before Sending Request');
                },
                success: function(res, status) {
                    $("#assign-driver-modal").html(res);
                    $('#danger-header-modal').modal('show');

                },
                error: function(res, status) {
                    console.log(res);
                }
            });
        }
    </script>
    {{--<script>
        window.addEventListener('DOMContentLoaded', function() {


            window.Echo.channel('location')
                .listen('SendLocation', (data) => {
                    console.log({
                        driver: data.driver.firstname + " " + data.driver.lastname,
                        latitude: data.location.lat,
                        longitude: data.location.long
                    });
                  //  if (data.driver.is_online == 1) {
                    if (data.location.lat) {
                        $("#online-driver-" + data.driver.id).show();
                        $("#offline-driver-" + data.driver.id).hide();
                    } else {
                        $("#online-driver-" + data.driver.id).hide();
                        $("#offline-driver-" + data.driver.id).show();
                    }
                });
        });
    </script>--}}

    <script>
        window.addEventListener('DOMContentLoaded', function () {
          
            let driverTimers = {};

            window.Echo.channel('location')
                .listen('SendLocation', (data) => {
                    const driverId = data.driver.id;

                    console.log({
                        driver: data.driver.firstname + " " + data.driver.lastname,
                        latitude: data.location.lat,
                        longitude: data.location.long
                    });

                    if (data.location.lat) {
                        $("#online-driver-" + driverId).show();
                        $("#offline-driver-" + driverId).hide();
                    } else {
                        $("#online-driver-" + driverId).hide();
                        $("#offline-driver-" + driverId).show();
                    }

                    if (driverTimers[driverId]) {
                        clearTimeout(driverTimers[driverId]);
                    }

                    driverTimers[driverId] = setTimeout(() => {
                        $("#online-driver-" + driverId).hide();
                        $("#offline-driver-" + driverId).show();
                        console.log("Driver " + driverId + " set to offline (no updates in 5s)");
                    }, 5000);
                });
        });
    </script>

    <script>
        window.addEventListener('DOMContentLoaded', function() {

            window.Echo.channel('online-status')
                .listen('SendOnlineStatus', (data) => {
                    if (data.is_online == 1) {
                        $("#online-driver-" + data.driver_id).show();
                        $("#offline-driver-" + data.driver_id).hide();
                    } else {
                        $("#online-driver-" + data.driver_id).hide();
                        $("#offline-driver-" + data.driver_id).show();
                    }
                })
        });
    </script>

<script>
    $(document).ready(function() {
        $('#modal_service_id').select2({
            placeholder: 'Select',
            allowClear: true
        });
    });
</script>
@endpush
