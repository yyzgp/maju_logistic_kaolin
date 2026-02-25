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
                                    <div class="fw-bold">Task Source</div>
                                </div>
                                <span>{{ ucfirst($task->source) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Task Type</div>
                                </div>
                                <span>{{ ucfirst($task->type) }}</span>
                            </li>
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
                                    <span class="btn btn-sm btn-danger">{{ $task->service->name }}</span>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Workshop</div>
                                </div>
                                <span><a href="{{ route('administrator.merchants.show', $task->merchant_id) }}"
                                        class="text-danger">{{ \App\Models\Merchant::find($task->merchant_id)->name }}</a></span>
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
                                    <div class="fw-bold">Service Time</div>
                                </div>
                                <span>{{ $task->service_time }} Minutes</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Requirements</div>
                                </div>
                                <span>
                                    @foreach ($task->requirements as $requirement)
                                        {{ ucfirst($requirement) }} @if ($loop->last)
                                        @else
                                            ,
                                        @endif
                                    @endforeach
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Task Status</div>
                                </div>
                                <span>{{ ucfirst($task->status) }}</span>
                            </li>
                        </ul>
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
                                    <div class="fw-bold">Vehicle Type</div>
                                </div>
                                <span>{{ $task->vehicle_type ?? 'Not Found' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Vehicle Plate Number</div>
                                </div>
                                <span>{{ $task->registration_number ?? 'Not Found' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Due Time</div>
                                </div>
                                <span>{{ \Carbon\Carbon::parse($task->due_time)->format('M d Y, h:i A') }}</span>
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
            </div>
        </div>
    </div> <!-- container -->
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
@endpush
