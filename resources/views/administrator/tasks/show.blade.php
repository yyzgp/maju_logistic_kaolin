@extends('layouts.administrator')
@section('title', 'Show Task')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                    </div>
                    <h4 class="page-title">Show Task</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $task->avatar }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                        <h4 class="mb-0 mt-2">{{ $task->name }}</h4>
                        <p class="text-muted font-14">Customer</p>

                        <a href="{{ route('administrator.tasks.edit', $task->id) }}" class="btn btn-success btn-sm mb-2"><i
                                class="mdi mdi-circle-edit-outline me-1"></i> Edit</a>
                        <a href="javascript:void(0);" onclick="confirmDelete({{ $task->id }})"
                            class="btn btn-danger btn-sm mb-2"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>
                        <form id='delete-form{{ $task->id }}'
                            action='{{ route('administrator.tasks.destroy', $task->id) }}' method='POST'>
                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                            <input type='hidden' name='_method' value='DELETE'>
                        </form>
                        <p class="text-muted font-14">Date Created :
                            {{ \Carbon\Carbon::parse($task->created_at)->format('l, M d h:i A') }}</p>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h4 class="py-2 px-3">Task Details</h4>
                    <div class="card-body pt-0">
                        <ul class="list-group list-unstyled">

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Task Type</div>
                                </div>
                                <span>{{ ucfirst($task->type) }}</span>
                            </li>
                            @if (!is_null($task->battery_tyre_size))
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Battery/Tyre Size</div>
                                    </div>
                                    <span>{{ $task->battery_tyre_size }}</span>
                                </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Task Priority</div>
                                </div>
                                <span>{{ ucfirst($task->priority) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Task Services</div>
                                </div>

                                <span>
                                    <span class="btn btn-sm btn-danger">{{ $task->service?->name ?? 'N/A' }}</span>
                                </span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Workshop </div>
                                </div>
                                <span><a href="{{ route('administrator.merchants.show', $task->merchant_id) }}"
                                        class="text-danger">{{ \App\Models\Merchant::find($task->merchant_id)->name }}</a></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    @if (\App\Models\Merchant::find($task->merchant_id)->slug == 'paynow')
                                        <div class="fw-bold">Destination Address</div>
                                    @else   
                                    <div class="fw-bold">Workshop Address</div>
                                    @endif
                                </div>
                                <span><a href="{{ route('administrator.merchants.show', $task->merchant_id) }}"
                                        class="text-danger">{{ $task->destination_building_floor_room }}
                                        {{ $task->destination_address }} </a></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Driver</div>
                                </div>
                                @isset($task->driver_id)
                                    <span><a href="{{ route('administrator.drivers.show', $task->driver_id) }}"
                                            class="text-danger">{{ \App\Models\User::find($task->driver_id)->firstname }}
                                            {{ \App\Models\User::find($task->driver_id)->lastname }}</a></span>
                                @else
                                    <span>Not Assigned</span>
                                @endisset
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Towing Fee</div>
                                </div>
                                <span>$ {{ $task->towing_fee }} SGD</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Due Amount</div>
                                </div>
                                <span>$ {{ $task->due_amount }} SGD</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Requirements</div>
                                </div>
                                <span>
                                    @isset($task->requirements)
                                        @foreach ($task->requirements as $requirement)
                                            {{ ucfirst($requirement) }} @if ($loop->last)
                                            @else
                                                ,
                                            @endif
                                        @endforeach
                                        @endif
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Task Status</div>
                                    </div>
                                    <span>{{ is_null($task->driver_id) ? 'Unassigned' : ucfirst($task->status) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if (count($epods) > 0)
                                @foreach ($epods as $title => $epod)

                                    <h4 class="py-2 px-3">{{ $title }}</h4>
                                    <div class="row">

                                        @if (count($epod) > 0)
                                            @foreach ($epod as $e)
                                                <div class="col-3 mx-3 card  mb-2 m-1 cursor-pointer"
                                                    style="border-radius: 0px;border: none !important;"
                                                    onclick="openModal(`{{ $e['uri'] }}`)">
                                                    <div class="bg-image hover-overlay" data-mdb-ripple-init
                                                        data-mdb-ripple-color="light">
                                                        <img src="{{ $e['uri'] }}" class="img-fluid" />
                                                        <a href="#!">
                                                            <div class="mask"
                                                                style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach


                                        @endif

                                    </div>
                                @endforeach
                                @else
                                <div class="col-12 text-center">
                                    <div class="alert alert-danger" role="alert">
                                        No EPOD Found
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h4 class="py-2 px-3">Breakdown Details</h4>
                        <div class="card-body pt-0">
                            <ul class="list-group list-unstyled">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Recipient's Name</div>
                                    </div>
                                    <span>{{ ucfirst($task->name) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Recipient's Phone</div>
                                    </div>
                                    <span>{{ $task->dialcode . $task->phone }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Recipient's Email Address</div>
                                    </div>
                                    <span>{{ $task->email }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Recipient's Address</div>
                                    </div>
                                    <span class="text-end">
                                        <a href="https://maps.google.com/?q={{ $task->latitude }},{{ $task->longitude }}"
                                            class="text-danger" target="_blank">{{ $task->address }}</a>
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Recipient's Location</div>
                                    </div>
                                    <span>{{ $task->location ?? 'Not Found' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Vehicle Model</div>
                                    </div>
                                    <span>{{ $task->vehicle_type ?? 'Not Found' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Vehicle Plate Number</div>
                                    </div>
                                    <span>{{ $task->registration_number ?? 'Not Found' }}</span>
                                </li>


                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <h4 class="py-2 px-3">Instruction / Notes</h4>
                        <div class="card-body pt-0">
                            {{ isset($task->notes) ? $task->notes : 'Not Found' }}
                        </div>
                    </div>
                    <div class="card">
                        <h4 class="py-2 px-3">Remarks</h4>
                        <div class="card-body pt-0">
                            {{ isset($task->remarks) ? $task->remarks : 'Not Found' }}
                        </div>
                    </div>
                    @isset($task->parent_task_id)
                        <div class="card">
                            <h4 class="py-2 px-3">Linked Tasks</h4>
                            <div class="card-body pt-0">
                                <a href="{{ route('administrator.tasks.show', $task->parentTask->id) }}"
                                    class="text-body fw-semibold">
                                    <span class="text-danger">{{ $task->parentTask->name }}</span>
                                    <br>
                                    <i class="uil uil-trophy"></i> Task Id {{ $task->id }}
                                    <br>
                                    <i class="uil uil-location-point"></i> {{ $task->parentTask->address }}
                                    <br>
                                    <i class="uil uil-envelope"></i> {{ $task->parentTask->email }}
                                    <br>
                                    <i class="uil uil-phone"></i> {{ $task->parentTask->phone }}
                                </a>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        </div> <!-- container -->
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
    @endsection
    @push('scripts')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(e) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Delete it!"
                }).then(t => {
                    t.isConfirmed && document.getElementById("delete-form" + e).submit()
                })
            }
        </script>
        <script>
            function openModal(imageUrl) {
                document.getElementById("modalImage").src = imageUrl;
                var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
                myModal.show();
            }
        </script>
    @endpush
