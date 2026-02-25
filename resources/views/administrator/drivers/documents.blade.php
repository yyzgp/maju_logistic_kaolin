@extends('layouts.administrator')
@section('title', 'Driver Docs')
@section('head')
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
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
                        <button data-bs-toggle="modal" data-bs-target="#modal-add" type="submit"
                            class="btn btn-sm btn-danger" form="driverForm"><i
                                class="mdi mdi-database me-1"></i>Add</button>
                    </div>
                    <h4 class="page-title">Driver Documents</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="card">
                <div class="card-body">

                    <div class="col-md-12 table-responsive">
                        @if (count($docs) > 0)
                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>

                                        <th class="bg-green">Document</th>
                                        <th class="bg-green">Status</th>
                                        <th class="bg-green">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($docs as $doc)
                                        @php
                                            $docname = match ($doc->document) {
                                                'dl_front' => 'Driving Licence Front',
                                                'dl_back' => 'Driving Licence Back',
                                            };
                                        @endphp
                                        <tr>

                                            <td>{{ $docname }}</td>
                                            <td>{{ $doc->status }}</td>

                                            <td class="text-start">
                                                <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-center">


                                                    <a href="{{ asset('storage/uploads/driver-docs') . '/' . $driver_id . '/' . $doc->file }}"
                                                        class="dropdown-item view-file"><i class="mdi mdi-eye me-1"></i>
                                                        View</a>

                                                    <a href="javascript:void(0);" class="dropdown-item change-status"
                                                        docid="{{ $doc->id }}"><i
                                                            class="mdi mdi-file-outline me-1"></i> Change Status</a>
                                                    <button onclick="confirmDelete('{{ $doc->id }}')"
                                                        class="dropdown-item"><i class="mdi mdi-delete me-1"></i>
                                                        Delete</button>

                                                </div>
                                            </td>
                                            <form id='delete-form{{ $doc->id }}'
                                                action='{{ route('administrator.driver.doc-remove', $doc->id) }}'
                                                method='POST'>
                                                <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center">No Document Found.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container -->

    <div id="modal-add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-addLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-danger">
                    <p class="modal-title text-center" id="primary-header-modalLabel">
                        <strong>{{ __('Add New Document') }}</strong></p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="changePasswordForm" enctype="multipart/form-data"
                        action="{{ route('administrator.driver.document-add') }}">
                        @csrf
                        <input type="hidden" value="{{ $driver_id }}" name="driver_id" id="">

                        <div class="form-group mb-2">
                            <label for="password">Select Document</label>
                            <select name="document" required class="form-select">
                                <option value="">--select--</option>
                                <option value="dl_front">Driving Licence Front</option>
                                <option value="dl_back">Driving Licence Back</option>
                            </select>

                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Upload document file</label>
                            <input type="file" name="file" class="form-control" />

                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Status</label>
                            <select name="status" required class="form-select">
                                <option value="">--select--</option>
                                <option value="Approved">Approved</option>
                                <option value="Pending">Pending</option>
                                <option value="Expired">Expired</option>
                                <option value="Rejected">Rejected</option>
                            </select>

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

    <div id="modal-status" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-statusLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-danger">
                    <p class="modal-title text-center" id="primary-header-modalLabel">
                        <strong>{{ __('Change Document Status') }}</strong></p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="changeStatusForm"
                        action="{{ route('administrator.driver.document-status') }}">
                        @csrf
                        <input type="hidden" value="" name="id" id="doc_id">

                        <div class="form-group mb-2">
                            <label for="password">Status</label>
                            <select name="status" required class="form-select">
                                <option value="">--select--</option>
                                <option value="Approved">Approved</option>
                                <option value="Pending">Pending</option>
                                <option value="Expired">Expired</option>
                                <option value="Rejected">Rejected</option>
                            </select>

                        </div>
                    </form>
                </div>
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="changeStatusForm" class="btn btn-sm btn-danger">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">

                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        jQuery(document).ready(function($) {
            $('.change-status').on('click', function(e) {
                var doc_id = $(this).attr('docid');
                $('#doc_id').val(doc_id);
                $('#modal-status').modal('show');
            });

            $('.view-file').on('click', function(event) {
                event.preventDefault();

                var href = $(this).attr('href');
                var fileExtension = href.split('.').pop().toLowerCase();
                var modalBodyContent;

                if (fileExtension === 'pdf') {
                    modalBodyContent = '<iframe src="' + href +
                        '" frameborder="0" style="width:100%; height:700px;"></iframe>';
                } else if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                    modalBodyContent = '<img src="' + href + '" class="img-fluid" alt="Image">';
                } else {
                    modalBodyContent = '<p>File type not supported for preview.</p>';
                }

                $('#fileModal .modal-body').addClass('modal-lg').html(modalBodyContent);
                $('#fileModal').modal('show');
            });

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
