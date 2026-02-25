<!doctype html>
<html lang="en">

<head>
    <title>Customer Request Form</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet"
        type="text/css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

    <div class="container">
        <div class="row my-4">
            <div class="col-6 text-start">
                <img src="{{ asset('assets/images/logo/logo.png') }}" title="logo" alt="logo" width="30%">
            </div>
            <div class="col-6 text-end">
                <h3 class="text-danger pt-2">Track Order</h3>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-2">
                    <div class="card-body pt-2 pb-1">
                        <div class="card-widgets">
                            @if ($task->status != 'completed')
                                <a href="javascript:void(0)">
                                    <h2 class="text-danger text-center">{{ $eta }}</h2>
                                </a>
                                <br>
                            @else
                                <a href="javascript:void(0)">
                                    <h2 class="text-danger text-center">This Order has been completed</h2>
                                </a>
                                <br>
                            @endif
                        </div>
                        <h2 class="card-title mt-1">ETA</h2>
                        @if ($task->status != 'completed')
                            <h6 class="text-end">Pickup driver is <span class="text-danger">{{ $distance_away }}
                                    km</span> away
                            </h6>
                        @else
                            <h6 class="text-end">
                            </h6>
                        @endif
                    </div>



                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div id="map" style="height: 500px; width:100%; border-radius:10px;"></div>
                    </div>
                </div>

           
                @if(count($epods) > 0)
                @foreach($epods as $title => $epod)

                <h4 class="pt-2 px-3 pb-0 mb-0 text-start text-danger">{{ $title }}</h4>
                <div class="row">
                    
                @if( count($epod) > 0)
                @foreach($epod as $e)

                    <div class="col-2 card mb-2 m-1 cursor-pointer"  onclick="openModal(`{{ $e['uri'] }}`)">
                        <div class="card-body pt-1 d-grcid">
                        <img src="{{ $e['uri'] }}" width="50">
                        </div>
                    </div>

                @endforeach
                @endif

                </div>
                @endforeach
                @endif

            </div>


            <div class="col-xl-4">
                <div class="card mb-2">
                    <div class="card-header d-grid">
                        <button type="button"
                            class="btn btn-sm btn-success">{{ $task->status == 'in-transist' ? 'In Transit' : ucfirst($task->status) }}</button>
                    </div>
                </div>
                <div class="card mb-2">
                    <h4 class="pt-2 px-3 pb-0 mb-0 text-start text-danger">Pickup Location</h4>
                    <div class="card-body pt-1 d-grid">
                        <h5 class="card-title"><i
                                class="mdi mdi-map-marker text-danger me-1"></i>{{ $task->address }}</button>
                    </div>
                </div>
                <div class="card mb-2">
                    <h4 class="pt-2 px-3 pb-0 mb-0 text-start text-danger">Workshop Location</h4>
                    <div class="card-body pt-1 d-grid">
                        <h5 class="card-title"><i
                                class="mdi mdi-map-marker text-danger me-1"></i>{{ $task->merchant->storeDetail->address }}
                        </h5>
                    </div>
                </div>



                <div class="card mb-2">
                    <h4 class="pt-2 px-3 text-danger">Task Details</h4>

                    <div class="card-body pt-0">
                        <ul class="list-group list-unstyled" style="font-size: 13px;">

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="me-auto">
                                    <div class="fw-bold">Task Type</div>
                                </div>
                                <span>{{ ucfirst($task->type) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="me-auto">
                                    <div class="fw-bold">Task Priority</div>
                                </div>
                                <span>{{ ucfirst($task->priority) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="me-auto">
                                    <div class="fw-bold">Task Services</div>
                                </div>

                                <span>
                                    <span>{{ $task->service?->name }}</span>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="me-auto">
                                    <div class="fw-bold">Workshop</div>
                                </div>
                                <span
                                    class="text-danger">{{ \App\Models\Merchant::find($task->merchant_id)->name }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="me-auto">
                                    <div class="fw-bold">Total Fee</div>
                                </div>
                                <span>$ {{ $task->towing_fee }} SGD</span>
                            </li>

                        </ul>
                    </div>
                </div>
                @isset($task->driver_id)
                    <div class="card">
                        <h4 class="pt-2 px-3 text-danger">Driver Details</h4>
                        <div class="card-body pt-0">
                            <ul class="list-group list-unstyled" style="font-size: 13px;">

                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div class="fw-bold">Driver</div>
                                    </div>
                                    <span>{{ ucfirst($task->driver->firstname) }}
                                        {{ ucfirst($task->driver->lastname) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div class="fw-bold">Phone</div>
                                    </div>
                                    <span>{{ $task->driver->dialcode }} {{ $task->driver->phone }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div class="fw-bold">PickUp Vehicle Type</div>
                                    </div>
                                    <span>{{ $task->driver->vehicle_type }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div class="fw-bold">PickUp Vehicle No.</div>
                                    </div>
                                    <span>{{ $task->driver->vehicle_registration_no }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
        var task_position = {
            lat: {{ $task->latitude }},
            lng: {{ $task->longitude }}
        };

        var driver_position = {
            lat: {{ $task->driver->latitude }},
            lng: {{ $task->driver->longitude }}
        }

        function initGMap() {
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({
                suppressMarkers: true
            });
            var icons = {
                start: new google.maps.MarkerImage(
                    // URL
                    '{{ asset('assets/images/tow-truck.png') }}',
                    // (width,height)
                    new google.maps.Size(44, 32),
                    // The origin point (x,y)
                    new google.maps.Point(0, 0),
                    // The anchor point (x,y)
                    new google.maps.Point(22, 32)
                ),
                end: new google.maps.MarkerImage(
                    // URL
                    '{{ asset('assets/images/red-pin.png') }}',
                    // (width,height)
                    new google.maps.Size(44, 32),
                    // The origin point (x,y)
                    new google.maps.Point(0, 0),
                    // The anchor point (x,y)
                    new google.maps.Point(22, 32)
                )
            };
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

            directionsRenderer.setMap(map);



            map.setCenter(task_position);
            @if ($task->status != 'completed')
                directionsService
                    .route({
                        origin: driver_position,
                        destination: task_position,
                        travelMode: google.maps.TravelMode.DRIVING,
                        drivingOptions: {
                            departureTime: new Date(Date.now() + 2000), // for the time N milliseconds from now.
                            trafficModel: 'optimistic'
                        }
                    })
                    .then((response) => {
                        var leg = response.routes[0].legs[0];
                        makeMarker(leg.start_location, icons.start, "Driver");
                        makeMarker(leg.end_location, icons.end, "Your Location");
                        directionsRenderer.setDirections(response);
                    })
                    .catch((e) => console.log(e));
            @else
                const marker = new google.maps.marker.AdvancedMarkerElement({
                    position: new google.maps.LatLng({
                        lat: parseFloat("{{ $task->latitude }}"),
                        lng: parseFloat("{{ $task->longitude }}")
                    }),
                    map,

                    collisionBehavior: "REQUIRED",

                });
                markers.push(marker);
            @endif


        }
    </script>
    <script>
        function makeMarker(position, icon, title) {
            new google.maps.Marker({
                position: position,
                map: map,
                icon: icon,
                title: title
            });
        }

    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function openModal(imageUrl) {
        document.getElementById("modalImage").src = imageUrl;
        var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
        myModal.show();
    }
</script>

 <!-- Bootstrap Modal -->
 <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Epod Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Preview">
                </div>
            </div>
        </div>
    </div>

</body>

</html>
