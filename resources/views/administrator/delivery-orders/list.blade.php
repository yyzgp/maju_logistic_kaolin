@extends('layouts.administrator')
@section('title', 'Delivery Orders')
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
                    <h4 class="page-title">Delivery Orders <span class="text-danger">[{{ $merchant->name }}]</span></h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        @include('administrator.delivery-orders.filter')
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100"
                                    style="font-size: 13px;">
                                    <thead>
                                        <tr>

                                            <th class="bg-green">DO No.</th>
                                            <th class="bg-green">Recipient</th>
                                            <th class="bg-green">Type</th>
                                            <th class="bg-green text-center" width="14%">Status</th>
                                            <th class="bg-green">Completed At</th>
                                            <th class="bg-green"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tasks as $task)
                                            <tr>

                                                <td>
                                                    {{ 'F0000'.$task->id }}
                                                </td>

                                                <td class="table-user">
                                                    <a href="{{ route('administrator.tasks.show', $task->id) }}"
                                                        class="text-body fw-semibold">
                                                        <span class="text-danger">{{ $task->name }}</span>
                                                        <br>
                                                        <i class="uil uil-location-point"></i> {{ $task->address }}
                                                        <br>
                                                        <i class="uil uil-envelope"></i> {{ $task->email }}
                                                        <br>
                                                        <i class="uil uil-phone"></i> {{ $task->phone }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <h5>
                                                        <a href="javascript:void(0)"
                                                            class="badge badge-primary-gradient">{{ $task->type }}</a>
                                                    </h5>

                                                    @isset($task->parent_task_id)
                                                        <h5>
                                                            <a href="javascript:void(0)"
                                                                class="badge bg-warning text-dark">Sub Task</a>
                                                                <h5>
                                                                    <a href="{{ route("administrator.tasks.show", $task->parent_task_id) }}"
                                                                        class="badge bg-dark">Linked Parent Task</a>
                                                                </h5>
                                                        </h5>
                                                    @endisset
                                                        @php
                                                            $child_exists = \App\Models\Task::where('parent_task_id', $task->id)->exists();
                                                        @endphp
                                                    @if($child_exists)
                                                    <h5><a href="javascript:void(0)"
                                                        class="badge bg-warning text-dark">Parent Task</a></h5>
                                                    <h5>
                                                        <a href="{{ route("administrator.tasks.show", \App\Models\Task::where('parent_task_id', $task->id)->first()->id) }}"
                                                            class="badge bg-dark">Linked Child Task</a>
                                                    </h5>
                                                    @endif

                                                </td>

                                                <td class="text-center">
                                                    <span class="text-success">Completed</span>
                                                 </td>
                                                <td>
                                                    <i class="uil-calender me-1"></i>
                                                    {{ \Carbon\Carbon::parse($task->completion_time)->format('M d Y') }}<br>
                                                    <i class="uil-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($task->completion_time)->format('h:i A') }}<br>
                                                    @isset($task->driver_id)<i class="uil uil-user me-1"></i>
                                                    <a href="{{ route('administrator.drivers.show', $task->driver_id) }}"
                                                        class="text-success">{{ \App\Models\User::find($task->driver_id)->firstname }}
                                                        {{ \App\Models\User::find($task->driver_id)->lastname }}</a>@endisset
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route("administrator.merchants.download-order", $task->id) }}" class="btn btn-danger text-decoration-none">
                                                        <i class="mdi mdi-download"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $tasks->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                    url: "{{ route('administrator.tasks.bulk-delete') }}",
                    data: {
                        tasks: rows,
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
                task_id: id,
                status: value
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('administrator.tasks.change-status') }}',
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


<script>
    function assignDriver(id) {

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
               $("#task_id").val(id);
               $('#danger-header-modal').modal('show');

            },
            error: function(res, status) {
                console.log(res);
            }
        });
    }
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
@endpush
