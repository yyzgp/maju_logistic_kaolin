@extends('layouts.administrator')
@section('title', 'Invoices')
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


                        {{-- <a href="{{ route('administrator.invoices.settings') }}" class="btn btn-sm btn-dark float-end"><i
                                class="dripicons-gear me-1"></i> Invoice Settings</a> --}}
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger float-end me-1" style="display: none"
                            id="delete-all">
                            <i class="mdi mdi-delete"></i> {{ __('Delete') }}</a>
                    </div>
                    <h4 class="page-title">Invoices</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        @include('administrator.invoices.filter')
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100"
                                    style="font-size: 14px;">
                                    <thead>
                                        <tr>
                                            <th class="all bg-green" width="3%">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="all-rows">
                                                    <label class="form-check-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th class="bg-green" width="20%">Invoice No.</th>
                                            <th class="bg-green" width="10%">Workshop</th>
                                            <th class="bg-green" width="10%">Invoice From</th>
                                            <th class="bg-green" width="14%">Invoice Upto</th>
                                            <th class="bg-green" width="14%">Amount</th>
                                            <th class="bg-green" width="10%">Created Time</th>
                                            <th class="bg-green" width="3%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input checkbox-row"
                                                            name="rows" id="customCheck{{ $invoice->id }}"
                                                            value="{{ $invoice->id }}">
                                                        <label class="form-check-label"
                                                            for="customCheck{{ $invoice->id }}">&nbsp;</label>
                                                    </div>
                                                </td>

                                                <td class="table-user">
                                                    <a href="{{ route('administrator.invoices.edit', $invoice->id) }}"
                                                        class="text-body fw-semibold">
                                                        <span class="text-danger">{{ $invoice->invoice_no }}</span>
                                                    </a>
                                                </td>

                                                <td><a href="{{ route('administrator.merchants.show', $invoice->merchant_id) }}"
                                                        class="text-danger">{{ optional(\App\Models\Merchant::find($invoice->merchant_id))->name }}</a>
                                                </td>

                                                <td>
                                                    <i class="uil-calender me-1"></i>
                                                    {{ \Carbon\Carbon::parse($invoice->invoice_from)->format('M d Y') }}<br>
                                                </td>
                                                <td>
                                                    <i class="uil-calender me-1"></i>
                                                    {{ \Carbon\Carbon::parse($invoice->invoice_upto)->format('M d Y') }}<br>
                                                </td>
                                                <td>
                                                    $ {{ $invoice->amount }} SGD
                                                </td>
                                                <td>
                                                    <i class="uil-calender me-1"></i>
                                                    {{ \Carbon\Carbon::parse($invoice->created_at)->format('M d Y') }}<br>
                                                    <i class="uil-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($invoice->created_at)->format('h:i A') }}<br>
                                                    <i class="uil uil-user me-1"></i>
                                                    System Generated
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <a href="{{ route('administrator.invoices.edit', $invoice->id) }}"
                                                            class="dropdown-item"><i class="mdi mdi-download me-1"></i>
                                                            Download
                                                            Invoice</a>

                                                        <a href="javascript:void(0);"
                                                            onclick="confirmDelete({{ $invoice->id }})"
                                                            class="dropdown-item"><i
                                                                class="mdi mdi-trash-can-outline me-1"></i>
                                                            Delete
                                                            Invoice</a>
                                                        <form id='delete-form{{ $invoice->id }}'
                                                            action='{{ route('administrator.invoices.destroy', $invoice->id) }}'
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
                                {{ $invoices->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                autoWidth: false,
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
                    url: "{{ route('administrator.invoices.bulk-delete') }}",
                    data: {
                        invoices: rows,
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
    </script>
@endpush
