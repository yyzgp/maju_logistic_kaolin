@extends('layouts.administrator')
@section('title', 'Workshops')
@section('head')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">


                        <a href="{{ route('administrator.merchants.create') }}" class="btn btn-sm btn-dark float-end"><i
                                class="mdi mdi-plus"></i> Add Workshop</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger float-end me-1" style="display: none"
                            id="delete-all">
                            <i class="mdi mdi-delete"></i> {{ __('Delete') }}</a>
                    </div>
                    <h4 class="page-title">Workshops</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        @include('administrator.merchants.filter')
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
                                            <th class="bg-green">Workshop</th>
                                            <th class="bg-green">Contact Person</th>
                                            <th class="bg-green">Email</th>
                                            <th class="bg-green">Address</th>
                                            <th class="bg-green">Status</th>
                                            <th class="bg-green"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($merchants as $merchant)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input checkbox-row"
                                                            name="rows" id="customCheck{{ $merchant->id }}"
                                                            value="{{ $merchant->id }}">
                                                        <label class="form-check-label"
                                                            for="customCheck{{ $merchant->id }}">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td class="table-user">

                                                    <img @isset($merchant->avatar) src="{{ asset('storage/uploads/administrators/' . $merchant->slug . '/' . $merchant->avatar) }}" @else src="https://placehold.co/150x150/D82D36/FFF?text={{ $merchant->name[0] }}{{ $merchant->name[1] }}" @endisset
                                                        alt="table-user" class="me-1 rounded-circle" width="30px">
                                                    <a href="javascript:void(0);"
                                                        class="text-body fw-semibold">{{ $merchant->name }}</a>
                                                </td>
                                                <td>{{ $merchant->storeDetail->name }}</td>
                                                <td>{{ $merchant->email }}</td>
                                                <td>{{ $merchant->storeDetail?->address ?? 'NA' }}</td>
                                                <td>
                                                    <select class="form-select form-select-sm"
                                                        onchange="changeStatus({{ $merchant->id }}, this.value)">
                                                        <option value="pending"
                                                            {{ $merchant->status == 'pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                        <option value="active"
                                                            {{ $merchant->status == 'active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="blocked"
                                                            {{ $merchant->status == 'blocked' ? 'selected' : '' }}>Blocked
                                                        </option>
                                                        <option value="suspended"
                                                            {{ $merchant->status == 'suspended' ? 'selected' : '' }}>
                                                            Suspended
                                                        </option>
                                                    </select>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="{{ route('customer-request-form', $merchant->slug) }}"
                                                            class="dropdown-item"><i class="mdi mdi-form-select me-1"></i>
                                                            Customer
                                                            Request Form</a>
                                                        <a href="{{ route('administrator.merchants.delivery-orders', $merchant->slug) }}"
                                                            class="dropdown-item"><i class="mdi mdi-eye me-1"></i>
                                                            View
                                                            Delivery Orders</a>
                                                        <a href="{{ route('administrator.invoices.index', ['merchant' => $merchant->id]) }}"
                                                            class="dropdown-item"><i class="mdi mdi-eye me-1"></i>
                                                            Invoices</a>
                                                        <a href="javascript:void(0);" class="dropdown-item change-password"
                                                            data-bs-toggle="modal" data-bs-target="#modal-password"
                                                            data-id="{{ $merchant->id }}"
                                                            data-name="{{ $merchant->name }}"><i
                                                                class="mdi mdi-lock-outline me-1"></i> Change Password</a>

                                                        <a href="{{ route('administrator.merchants.show', $merchant->id) }}"
                                                            class="dropdown-item"><i class="mdi mdi-eye me-1"></i>
                                                            View
                                                            Workshop</a>
                                                        <a href="{{ route('administrator.merchants.edit', $merchant->id) }}"
                                                            class="dropdown-item"><i
                                                                class="mdi mdi-circle-edit-outline me-1"></i>
                                                            Edit
                                                            Workshop</a>
                                                        <a href="javascript:void(0);"
                                                            onclick="confirmDelete({{ $merchant->id }})"
                                                            class="dropdown-item"><i
                                                                class="mdi mdi-trash-can-outline me-1"></i>
                                                            Delete
                                                            Workshop</a>
                                                        <form id='delete-form{{ $merchant->id }}'
                                                            action='{{ route('administrator.merchants.destroy', $merchant->id) }}'
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
                                {{ $merchants->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                        action="{{ route('administrator.merchants.reset-password') }}">
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
                    orderable: !1
                }, {
                    orderable: !1
                }, ]
            })
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
                    url: "{{ route('administrator.merchants.bulk-delete') }}",
                    data: {
                        merchants: rows,
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

        $(".change-password").click(function() {
            var a = $(this).data("id"),
                t = $(this).data("name");
            $("#id").val(a), $("#volunteer_name").text(t), $("#volunteer_name_input").val(t)
        });
    </script>

    <script>
        function changeStatus(id, value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                }
            });
            var formData = {
                merchant_id: id,
                status: value
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('administrator.merchants.change-status') }}',
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    console.log(formData);
                },
                success: function(res, status) {
                    console.log(res);
                },
                error: function(res, status) {
                    console.log(res);
                }
            });
        }
    </script>


    @error('password')
        <script>
            $(document).ready(function() {
                $('#modal-password').modal('show');
            });
        </script>
    @enderror
@endpush
