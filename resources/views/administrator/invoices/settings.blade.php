@extends('layouts.administrator')
@section('title', 'Invoice Settings')
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
                        <a href="{{ route('administrator.invoices.index') }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-danger" form="driverForm"><i
                                class="mdi mdi-database me-1"></i>Save</button>
                    </div>
                    <h4 class="page-title">Invoice Settings</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <form id="driverForm" method="POST" action="{{ route('administrator.invoices.settings') }}"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">



                                <div class="col-sm-12 mb-2">
                                    <label class="col-form-label"
                                        for="invoice_frequency">{{ __('Invoice Frequency') }}</label>

                                    <select id="invoice_frequency" class="form-select" name="invoice_frequency">
                                        <option value="">Select Frequency</option>
                                        <option value="weekly"
                                            {{ old('invoice_frequency', $frequency) == 'weekly' ? 'selected' : '' }}>
                                            Weekly</option>
                                        <option value="monthly"
                                            {{ old('invoice_frequency', $frequency) == 'monthly' ? 'selected' : '' }}>
                                            Monthly
                                        </option>
                                        <option value="quarterly"
                                            {{ old('invoice_frequency', $frequency) == 'quarterly' ? 'selected' : '' }}>
                                            Quarterly
                                        </option>
                                        <option value="annually"
                                            {{ old('invoice_frequency', $frequency) == 'annually' ? 'selected' : '' }}>
                                            Annually
                                        </option>
                                    </select>

                                    @error('invoice_frequency')
                                        <span id="invoice_frequency-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12 text-end">
                                    <a href="{{ route('administrator.invoices.index') }}"
                                        class="btn btn-sm btn-dark me-1"><i
                                            class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                                    <button type="submit" class="btn btn-sm btn-danger" form="driverForm"><i
                                            class="mdi mdi-database me-1"></i>Save</button>
                                </div>
                            </div>
                        </div>

                    </div>


                </form>
            </div>
        </div>
    </div> <!-- container -->
@endsection
@push('scripts')
@endpush
