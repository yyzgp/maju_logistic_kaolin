@extends('layouts.administrator')
@section('title', 'Drivers')
@section('head')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
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


                        <a href="{{ route('administrator.drivers.create') }}" class="btn btn-sm btn-dark float-end"><i
                                class="mdi mdi-plus"></i> Add Driver</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger float-end me-1" style="display: none"
                            id="delete-all">
                            <i class="mdi mdi-delete"></i> {{ __('Delete') }}</a>
                    </div>
                    <h4 class="page-title">Drivers</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        @include('administrator.drivers.filter')
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th class="all bg-green" width="3%">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="all-rows">
                                                    <label class="form-check-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th class="bg-green">Driver</th>
                                            <th class="bg-green">Email</th>
                                            <th class="bg-green">Phone</th>
                                            <th class="bg-green text-center">Vehicle Details</th>
                                            <th class="bg-green text-center">Online</th>
                                            <th class="bg-green text-center">Enabled</th>
                                            <th class="bg-green"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($drivers as $driver)
                                            @php
                                                $icon = match ($driver->vehicle_type) {
                                                    'Car' => 'car.png',
                                                    'Van' => 'van.png',
                                                    'Truck' => 'tow-truck.png',
                                                    'Bike' => 'bike.png',
                                                    'Bicycle' => 'bicycle.png',
                                                    'Walking' => 'walk.png',
                                                    default => null,
                                                };
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input checkbox-row"
                                                            name="rows" id="customCheck{{ $driver->id }}"
                                                            value="{{ $driver->id }}">
                                                        <label class="form-check-label"
                                                            for="customCheck{{ $driver->id }}">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td class="table-user">

                                                    <img @isset($driver->avatar) src="{{ asset('storage/uploads/drivers/' . $driver->slug . '/' . $driver->avatar) }}" @else src="https://placehold.co/150x150/D82D36/FFF?text={{ $driver->firstname[0] }}{{ $driver->lastname ? $driver->lastname[0] : $driver->firstname[1] }}" @endisset
                                                        alt="table-user" class="me-1 rounded-circle" width="30px">
                                                    <a href="javascript:void(0);"
                                                        class="text-body fw-semibold">{{ $driver->firstname }}
                                                        {{ $driver->lastname }}</a>
                                                </td>
                                                <td>{{ $driver->email }}</td>
                                                <td>{{ $driver->dialcode }} {{ $driver->phone }}</td>
                                                <td class="text-center"><a href="#" data-toggle="tooltip"
                                                        title="{{ $driver->vehicle_type }}"><img
                                                            src="{{ asset('assets/images/icons') . '/' . $icon }}"
                                                            alt=""></a>
                                                    @if ($driver->vehicle != 'Walking')
                                                        <span class="badge badge-warning small"
                                                            style="background:#FFBF34">{{ $driver->vehicle_registration_no }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if (!is_null($driver->app_push_token))
                                                        <input nid="{{ $driver->id }}" type="checkbox"
                                                            id="is_online_{{ $driver->id }}"
                                                            @if ($driver->is_online == true) checked @endif
                                                            data-switch="danger" value="{{ $driver->id }}"
                                                            class="is_online" />
                                                        <label for="is_online_{{ $driver->id }}" data-on-label="On"
                                                            data-off-label="Off"></label>
                                                    @endif

                                                </td>
                                                <td class="text-center"><input type="checkbox"
                                                        id="switch{{ $driver->id }}"
                                                        @if ($driver->status == true) checked @endif
                                                        data-switch="danger" value="{{ $driver->id }}" class="status" />
                                                    <label for="switch{{ $driver->id }}" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="javascript:void(0);" class="dropdown-item change-password"
                                                            data-bs-toggle="modal" data-bs-target="#modal-password"
                                                            data-id="{{ $driver->id }}"
                                                            data-name="{{ $driver->firstname }} {{ $driver->lastname }}"><i
                                                                class="mdi mdi-lock-outline me-1"></i> Change Password</a>

                                                        <a href="{{ route('administrator.drivers.show', $driver->id) }}"
                                                            class="dropdown-item"><i class="mdi mdi-eye me-1"></i>
                                                            View
                                                            Driver</a>
                                                        <a href="{{ route('administrator.driver.documents', $driver->id) }}"
                                                            class="dropdown-item"><i class="mdi mdi-file me-1"></i>
                                                            Documents
                                                        </a>
                                                        <a href="{{ route('administrator.drivers.edit', $driver->id) }}"
                                                            class="dropdown-item"><i
                                                                class="mdi mdi-circle-edit-outline me-1"></i>
                                                            Edit
                                                            Driver</a>
                                                        <a href="javascript:void(0);"
                                                            onclick="confirmDelete({{ $driver->id }})"
                                                            class="dropdown-item"><i
                                                                class="mdi mdi-trash-can-outline me-1"></i>
                                                            Delete
                                                            Driver</a>
                                                        <form id='delete-form{{ $driver->id }}'
                                                            action='{{ route('administrator.drivers.destroy', $driver->id) }}'
                                                            method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $drivers->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-passwordLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-danger">
                    <p class="modal-title text-center" id="primary-header-modalLabel"><strong>Want to Change Password of
                        </strong><span id="volunteer_name">{{ old('volunteer_name') }}</span></p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="changePasswordForm"
                        action="{{ route('administrator.drivers.reset-password') }}">
                        @csrf
                        <input type="hidden" value="{{ old('volunteer_name') }}" name="volunteer_name"
                            id="volunteer_name_input">
                        <input type="hidden" value="{{ old('id') }}" name="id" id="id">
                        <div class="form-group mb-2 {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label for="password">New password *</label>
                            <input type="password" id="password" name="password" placeholder="Enter new password"
                                class="form-control">
                            @error('password')
                                <code id="name-error" class="text-danger">{{ $message }}</code>
                            @enderror
                        </div>
                        <div class="form-group mb-2 {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            <label for="password_confirmation">Confirm password *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" placeholder="Re-enter new password">
                        </div>
                    </form>
                </div>
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="changePasswordForm" class="btn btn-sm btn-danger">Confirm</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>


    <!-- Datatable Init js -->
    <script>
        $(function() {
            $("#basic-datatable").DataTable({
                paging: !1,
                pageLength: 20,
                lengthChange: !1,
                searching: !1,
                ordering: !0,
                info: !1,
                autoWidth: !1,
                responsive: !0,
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                    targets: [0],
                    visible: !0,
                    searchable: !0
                }],
                columns: [{
                    orderable: !1
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !1
                }, {
                    orderable: !1
                }, {
                    orderable: !1
                }, ]
            })
        });

        $(document).ready(function($) {
            $('[data-toggle="tooltip"]').tooltip();

            $('.is_online').change(function(e) {
                e.preventDefault();
                let nid = $(this).attr('nid');
                let prop = $(this).prop('checked');

                $.ajax({
                    url: "{{ route('administrator.drivers.notify-app') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: nid,
                        prop: prop ? 1 : 0
                    },
                    success: function(res) {
                        Toastify({

                            text: res.success,
                            duration: 6000,
                            style: {
                                background: "#D82D36",
                            },
                        }).showToast();

                    }
                });

                if (prop) {
                    $(this).prop('checked', false);
                } else {
                    $(this).prop('checked', true);
                }
            });
        });
    </script>

    <script type="text/javascript">
        $("#all-rows").change(function() {
            var c = [];
            this.checked ? ($(".checkbox-row").prop("checked", !0), $("input:checkbox[name=rows]:checked").each(
                function() {
                    c.push($(this).val())
                }), $("#delete-all").css("display", "block")) : ($(".checkbox-row").prop("checked", !1),
                c = [], $("#delete-all").css("display", "none"))
        });

        $(".checkbox-row").change(function() {
            rows = [], $("input:checkbox[name=rows]:checked").each(function() {
                rows.push($(this).val())
            }), 0 == rows.length ? $("#delete-all").css("display", "none") : $("#delete-all").css("display",
                "block")
        });

        $("#delete-all").click(function(e) {
            rows = [], $("input:checkbox[name=rows]:checked").each(function() {
                rows.push($(this).val())
            }), Swal.fire({
                title: "Are you sure?",
                text: "You want to delete selected rows!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete selected!"
            }).then(t => {
                t.isConfirmed && ($("#delete-all").text("Deleting..."), e.preventDefault(), $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('administrator.drivers.bulk-delete') }}",
                    data: {
                        drivers: rows,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(e) {
                        location.reload()
                    }
                }))
            })
        });

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

        $(".status").change(function() {
            var url = "{{ route('administrator.drivers.change-status', ':id') }}";
            url = url.replace(':id', this.value);
            window.location.href = url;
        });

        $(".change-password").click(function() {
            var a = $(this).data("id"),
                t = $(this).data("name");
            $("#id").val(a), $("#volunteer_name").text(t), $("#volunteer_name_input").val(t)
        });
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {

            window.Echo.channel('online-status')
                .listen('SendOnlineStatus', (data) => {
                    if (data.is_online == 1) {
                        $('#is_online_' + data.driver_id).prop('checked', true);
                    } else {
                        $('#is_online_' + data.driver_id).prop('checked', false);
                    }
                })
        });
    </script>

    @error('password')
        <script>
            $(document).ready(function() {
                $('#modal-password').modal('show');
            });
        </script>
    @enderror
@endpush
