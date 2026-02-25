@extends('layouts.administrator')
@section('title', 'Services')
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


                        <a href="{{ route('administrator.services.create') }}" class="btn btn-sm btn-dark float-end"><i
                                class="mdi mdi-plus"></i> Add Service</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger float-end me-1" style="display: none"
                            id="delete-all">
                            <i class="mdi mdi-delete"></i> {{ __('Delete') }}</a>
                    </div>
                    <h4 class="page-title">Services</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        @include('administrator.services.filter')
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
                                            <th class="bg-green">Service</th>
                                            <th class="bg-green">Pricing</th>
                                            <th class="bg-green">Workshops</th>
                                            <th class="bg-green">Task Type</th>
                                            <th class="bg-green">Enabled</th>
                                            <th class="bg-green"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input checkbox-row"
                                                            name="rows" id="customCheck{{ $service->id }}"
                                                            value="{{ $service->id }}">
                                                        <label class="form-check-label"
                                                            for="customCheck{{ $service->id }}">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td class="table-user">


                                                    <a href="{{ route('administrator.services.show', $service->id) }}"
                                                        class="text-body fw-semibold">{{ $service->name }}</a>
                                                </td>
                                                <td>$ {{ $service->price }}</td>

                                                <td>
                                                    @php
                                                        $merchants = \App\Models\Merchant::whereIn(
                                                            'id',
                                                            $service->merchants,
                                                        )->get(['id', 'name']);
                                                    @endphp
                                                    <div class="accordion custom-accordion"
                                                        id="custom-accordion-{{ $loop->iteration }}">
                                                        <div class="card mb-0">
                                                            <div class="card-header bg-danger text-white"
                                                                id="heading{{ $loop->iteration }}">
                                                                <h5 class="m-0">
                                                                    <a class="custom-accordion-title collapsed d-block text-white text-center"
                                                                        data-bs-toggle="collapse"
                                                                        href="#collapse{{ $loop->iteration }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapse{{ $loop->iteration }}">
                                                                        View Merchants<i
                                                                            class="mdi mdi-chevron-down accordion-arrow"></i>
                                                                    </a>
                                                                </h5>
                                                            </div>
                                                            <div id="collapse{{ $loop->iteration }}" class="collapse"
                                                                aria-labelledby="heading{{ $loop->iteration }}"
                                                                data-bs-parent="#custom-accordion-{{ $loop->iteration }}">
                                                                <div class="card-body">
                                                                    @foreach ($merchants as $merchant)
                                                                        <h5><a href="{{ route('administrator.merchants.show', $merchant->id) }}"
                                                                                class="badge badge-primary-lighten">{{ $merchant->name }}</a>
                                                                        </h5>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>

                                                </td>
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
                                                <td><input type="checkbox" id="switch{{ $service->id }}"
                                                        @if ($service->status == true) checked @endif
                                                        data-switch="danger" value="{{ $service->id }}" class="status" />
                                                    <label for="switch{{ $service->id }}" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">


                                                        <a href="{{ route('administrator.services.show', $service->id) }}"
                                                            class="dropdown-item"><i class="mdi mdi-eye me-1"></i>
                                                            View
                                                            Service</a>
                                                        <a href="{{ route('administrator.services.edit', $service->id) }}"
                                                            class="dropdown-item"><i
                                                                class="mdi mdi-circle-edit-outline me-1"></i>
                                                            Edit
                                                            Service</a>
                                                        <a href="javascript:void(0);"
                                                            onclick="confirmDelete({{ $service->id }})"
                                                            class="dropdown-item"><i
                                                                class="mdi mdi-trash-can-outline me-1"></i>
                                                            Delete
                                                            Service</a>
                                                        <form id='delete-form{{ $service->id }}'
                                                            action='{{ route('administrator.services.destroy', $service->id) }}'
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
                                {{ $services->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
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
                    url: "{{ route('administrator.services.bulk-delete') }}",
                    data: {
                        services: rows,
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
            var url = "{{ route('administrator.services.change-status', ':id') }}";
            url = url.replace(':id', this.value);
            window.location.href = url;
        });

        $(".change-password").click(function() {
            var a = $(this).data("id"),
                t = $(this).data("name");
            $("#id").val(a), $("#volunteer_name").text(t), $("#volunteer_name_input").val(t)
        });
    </script>
@endpush
