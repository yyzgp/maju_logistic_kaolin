@extends('layouts.administrator')
@section('title', 'Show Service')

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
                    <h4 class="page-title">Show Service</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $service->avatar }}" class="rounded-circle avatar-lg img-thumbnail"
                            alt="profile-image">

                        <h4 class="mb-0 mt-2">{{ $service->name }} </h4>
                        <p class="text-muted font-14">Service</p>

                        <a href="{{ route('administrator.services.edit', $service->id) }}"
                            class="btn btn-success btn-sm mb-2"><i class="mdi mdi-circle-edit-outline me-1"></i> Edit</a>
                        <a href="javascript:void(0);" onclick="confirmDelete({{ $service->id }})"
                            class="btn btn-danger btn-sm mb-2"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>
                        <form id='delete-form{{ $service->id }}'
                            action='{{ route('administrator.services.destroy', $service->id) }}' method='POST'>
                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                            <input type='hidden' name='_method' value='DELETE'>
                        </form>
                        <p class="text-muted font-14">Date Created :
                            {{ \Carbon\Carbon::parse($service->created_at)->format('l, M d h:i A') }}</p>
                        <div class="text-start mt-3">
                            <ul class="list-group list-unstyled">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Service</div>
                                    </div>
                                    <span>{{ $service->name }} </span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Base Price</div>
                                    </div>
                                    <span>$ {{ $service->price }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Extra Night Charges</div>
                                    </div>
                                    <span>$ {{ $service->extra_night_price }}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Status</div>
                                    </div>
                                    <span>{{ $service->status ? 'Enabled' : 'Disabled' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Type</div>
                                    </div>
                                    <span class="text-end">
                                        @foreach ($service->type as $type)
                                            @if ($type == 'Battery/Tyre')
                                                <h4><a href="#"
                                                        class="badge badge-dark-lighten">{{ $type }}</a>
                                                </h4>
                                            @else
                                                <h4><a href="#"
                                                        class="badge badge-danger-lighten">{{ $type }}</a>
                                                </h4>
                                            @endif
                                        @endforeach
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Workshops</div>
                                    </div>
                                    <span class="text-end">
                                        @php
                                            $merchants = \App\Models\Merchant::whereIn('id', $service->merchants)->get([
                                                'id',
                                                'name',
                                            ]);
                                        @endphp
                                        @foreach ($merchants as $merchant)
                                            <h4><a href="{{ route('administrator.merchants.show', $merchant->id) }}"
                                                    class="badge badge-primary-lighten">{{ $merchant->name }}</a>
                                            </h4>
                                        @endforeach
                                    </span>
                                </li>
                            </ul>
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
