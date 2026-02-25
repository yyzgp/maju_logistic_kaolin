@extends('layouts.administrator')
@section('title', 'Company Details')
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
                        <button type="submit" class="btn btn-sm btn-danger" form="companyDetailForm"><i
                                class="mdi mdi-database me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Company Details</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <form id="companyDetailForm" method="POST" action="{{ route('administrator.company-details') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 mb-2 {{ $errors->has('company') ? 'has-error' : '' }}">
                                    <label for="company">Company</label>
                                    <input type="text" class="form-control" id="company" name="company"
                                        placeholder="Enter Company Name" value="{{ old('company', $company->company) }}"
                                        autofocus>
                                    @error('company')
                                        <span id="company-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter Email Address" value="{{ old('email', $company->email) }}">
                                    @error('email')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-2 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Enter Phone Number" value="{{ old('phone', $company->phone) }}">
                                    @error('phone')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <input id="dial-code" name="dialcode" type="hidden"
                                        value="{{ isset($company) ? $company->dialcode : '' }}">
                                </div>

                                <div class="col-sm-6 mb-2 {{ $errors->has('website') ? 'has-error' : '' }}">
                                    <label for="website">Website URL</label>
                                    <input type="text" class="form-control" id="website" name="website"
                                        placeholder="Enter Website URL" value="{{ old('website', $company->website) }}">
                                    @error('website')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-2 {{ $errors->has('address_line_1') ? 'has-error' : '' }}">
                                    <label for="address_line_1">Address Line 1</label>
                                    <input type="text" class="form-control" id="address_line_1" name="address_line_1"
                                        placeholder="Enter Address Line 1"
                                        value="{{ old('address_line_1', $company->address_line_1) }}">
                                    @error('address_line_1')
                                        <span id="address_line_1-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('address') ? 'has-error' : '' }}">
                                    <label for="address_line_2">Address Line 2</label>
                                    <input type="text" class="form-control" id="address_line_2" name="address_line_2"
                                        placeholder="Enter Address Line 2"
                                        value="{{ old('address_line_2', $company->address_line_2) }}">
                                    @error('address_line_2')
                                        <span id="address_line_2-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('city') ? 'has-error' : '' }}">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        placeholder="Enter City" value="{{ old('city', $company->city) }}">
                                    @error('city')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('state') ? 'has-error' : '' }}">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        placeholder="Enter State" value="{{ old('state', $company->state) }}">
                                    @error('state')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label for="country">{{ __('Country') }}</label>

                                    <select id="country" class="form-select" name="country">
                                        <option value="">Select Country</option>
                                    </select>

                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('zipcode') ? 'has-error' : '' }}">
                                    <label for="zipcode">Zipcode</label>
                                    <input type="text" class="form-control" id="zipcode" name="zipcode"
                                        placeholder="Enter Zipcode" value="{{ old('zipcode', $company->zipcode) }}">
                                    @error('zipcode')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('invoice_frequency') ? 'has-error' : '' }}">
                                    <label for="invoice_frequency">Invoice Frequency</label>
                                    <select class="form-select" id="invoice_frequency" name="invoice_frequency">
                                        <option value="">Choose Frequency</option>
                                        <option value="1"
                                            {{ old('invoice_frequency', $company->invoice_frequency) == '1' ? 'selected' : '' }}>
                                            1 Week</option>
                                        <option value="2"
                                            {{ old('invoice_frequency', $company->invoice_frequency) == '2' ? 'selected' : '' }}>
                                            2 Weeks</option>
                                        <option value="3"
                                            {{ old('invoice_frequency', $company->invoice_frequency) == '3' ? 'selected' : '' }}>
                                            3 Weeks</option>
                                        <option value="4"
                                            {{ old('invoice_frequency', $company->invoice_frequency) == '4' ? 'selected' : '' }}>
                                            4 Weeks</option>
                                    </select>
                                    @error('invoice_frequency')
                                        <span id="invoice_frequency-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label for="logo">Logo</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="logo" name="logo"
                                            onchange="loadPreview(this);">
                                    </div>
                                    @if ($errors->has('logo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('logo') }}</strong>
                                        </span>
                                    @endif
                                    <img id="preview_img" src="{{ $company->logo }}" class="mt-2" width="260"
                                        height="71" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 mb-2 {{ $errors->has('uen_no') ? 'has-error' : '' }}">
                                    <label for="uen_no">UEN No.</label>
                                    <input type="text" class="form-control" id="uen_no" name="uen_no"
                                        placeholder="Enter UEN No." value="{{ old('uen_no', $company->uen_no) }}">
                                    @error('uen_no')
                                        <span id="uen_no-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('gst_no') ? 'has-error' : '' }}">
                                    <label for="gst_no">GST No.</label>
                                    <input type="text" class="form-control" id="gst_no" name="gst_no"
                                        placeholder="Enter GST No." value="{{ old('gst_no', $company->gst_no) }}">
                                    @error('gst_no')
                                        <span id="gst_no-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('bank_name') ? 'has-error' : '' }}">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name"
                                        placeholder="Enter Bank Name"
                                        value="{{ old('bank_name', $company->bank_name) }}">
                                    @error('bank_name')
                                        <span id="bank_name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('bank_account_no') ? 'has-error' : '' }}">
                                    <label for="bank_account_no">Bank Account No.</label>
                                    <input type="text" class="form-control" id="bank_account_no"
                                        name="bank_account_no" placeholder="Enter Bank Account No."
                                        value="{{ old('bank_account_no', $company->bank_account_no) }}">
                                    @error('bank_account_no')
                                        <span id="bank_account_no-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('cheque_payable_to') ? 'has-error' : '' }}">
                                    <label for="cheque_payable_to">Cheque payable to</label>
                                    <input type="text" class="form-control" id="cheque_payable_to"
                                        name="cheque_payable_to" placeholder="Enter Cheque payable to"
                                        value="{{ old('cheque_payable_to', $company->cheque_payable_to) }}">
                                    @error('cheque_payable_to')
                                        <span id="cheque_payable_to-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-sm btn-danger" form="companyDetailForm"><i
                                    class="mdi mdi-database me-1"></i>Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- container -->
@endsection
@push('scripts')
    <script>
        function loadPreview(input, id) {
            id = id || '#preview_img';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width(260)
                        .height(71);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script src="{{ asset('assets/js/plugins/intl-tel-input/js/intlTelInput.min.js') }}"></script>
    <script>
        // get the country data from the plugin
        var countryData = window.intlTelInputGlobals.getCountryData(),

            input = document.querySelector("#phone"),
            dialCode = document.querySelector("#dial-code");
        countryDropdown = document.querySelector("#country");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            var optionNode = document.createElement("option");
            optionNode.value = country.iso2;
            var textNode = document.createTextNode(country.name);
            optionNode.appendChild(textNode);
            countryDropdown.appendChild(optionNode);
        }

        // init plugin
        var iti = window.intlTelInput(input, {
            initialCountry: "{{ old('country', $company->iso2) }}",
            utilsScript: "{{ asset('assets/js/plugins/intl-tel-input/js/utils.js') }}" // just for formatting/placeholders etc
        });

        // set it's initial value
        dialCode.value = '+' + iti.getSelectedCountryData().dialCode;
        countryDropdown.value = iti.getSelectedCountryData().iso2;

        // listen to the telephone input for changes
        input.addEventListener('countrychange', function(e) {
            dialCode.value = '+' + iti.getSelectedCountryData().dialCode;
            countryDropdown.value = iti.getSelectedCountryData().iso2;
        });

        // listen to the address dropdown for changes
        countryDropdown.addEventListener('change', function() {
            iti.setCountry(this.value);
        });
    </script>
@endpush
