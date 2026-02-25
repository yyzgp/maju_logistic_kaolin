@extends('layouts.administrator')
@section('title', 'Show Workshop')

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
                    <h4 class="page-title">Show Workshop</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $merchant->avatar }}" class="rounded-circle avatar-lg img-thumbnail"
                            alt="profile-image">

                        <h4 class="mb-0 mt-2">{{ $merchant->name }}</h4>
                        <p class="text-muted font-14">Workshop</p>

                        <a href="{{ route('administrator.merchants.edit', $merchant->id) }}"
                            class="btn btn-success btn-sm mb-2"><i class="mdi mdi-circle-edit-outline me-1"></i> Edit</a>
                        <a href="javascript:void(0);" onclick="confirmDelete({{ $merchant->id }})"
                            class="btn btn-danger btn-sm mb-2"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>
                        <form id='delete-form{{ $merchant->id }}'
                            action='{{ route('administrator.merchants.destroy', $merchant->id) }}' method='POST'>
                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                            <input type='hidden' name='_method' value='DELETE'>
                        </form>
                        <p class="text-muted font-14">Date Joined :
                            {{ \Carbon\Carbon::parse($merchant->created_at)->format('l, M d h:i A') }}</p>

                    </div>
                </div>
                <div class="card">
                    <h4 class="py-2 px-3">Workshop Store Details</h4>
                    <div class="card-body pt-0">
                        <ul class="list-group list-unstyled">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Contact Person</div>
                                </div>
                                <span>{{ isset($merchant->storeDetail) ? $merchant->storeDetail->name : 'Not Found' }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Contact Number</div>
                                </div>
                                <span>{{ isset($merchant->storeDetail) ? $merchant->storeDetail->dialcode . ' ' . $merchant->storeDetail->phone : 'Not Found' }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Contact Email</div>
                                </div>
                                <span>{{ isset($merchant->storeDetail) ? $merchant->storeDetail->email : 'Not Found' }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Address</div>
                                </div>
                                <span>{{ isset($merchant->storeDetail) ? $merchant->storeDetail->address : 'Not Found' }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Building / Floor / Room</div>
                                </div>
                                <span>{{ isset($merchant->storeDetail) ? $merchant->storeDetail->building_floor_room : 'Not Found' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <h4 class="py-2 px-3">Instruction / Notes</h4>
                    <div class="card-body pt-0">
                        {{ isset($merchant->storeDetail) ? $merchant->storeDetail->notes : 'Not Found' }}
                    </div>
                </div>
                <div class="card">
                    <h4 class="py-2 px-3">Workshop Billing Details</h4>
                    <div class="card-body pt-0">
                        <ul class="list-group list-unstyled">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Billing Name</div>
                                </div>
                                <span>{{ isset($merchant->billingDetail) ? $merchant->billingDetail->name : 'Not Found' }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Billing Contact Number</div>
                                </div>
                                <span>{{ isset($merchant->billingDetail) ? $merchant->billingDetail->dialcode . ' ' . $merchant->billingDetail->phone : 'Not Found' }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Billing Email</div>
                                </div>
                                <span>{{ isset($merchant->billingDetail) ? $merchant->billingDetail->email : 'Not Found' }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Billing Address</div>
                                </div>
                                <span>{{ isset($merchant->billingDetail) ? $merchant->billingDetail->address : 'Not Found' }}</span>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="card">
                    <h4 class="py-2 px-3">Workshop Services</h4>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>

                                            <th class="bg-green">Service</th>
                                            <th class="bg-green">Pricing</th>
                                            <th class="bg-green">Task Type</th>
                                            <th class="bg-green">Enabled</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                            <tr>

                                                <td class="table-user">


                                                    <a href="{{ route('administrator.services.show', $service->id) }}"
                                                        class="text-body fw-semibold">{{ $service->name }}</a>
                                                </td>
                                                <td>$ {{ $service->price }}</td>


                                                <td>
                                                    @foreach ($service->type as $type)
                                                        @if ($type == 'Battery/Tyre')
                                                            <h5><a href="#"
                                                                    class="badge badge-dark-lighten">{{ $type }}</a>
                                                            </h5>
                                                        @else
                                                            <h5><a href="#"
                                                                    class="badge badge-danger-lighten">{{ $type }}</a>
                                                            </h5>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $service->status ? "Enabled" : "Disabled" }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
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
