@extends('layouts.administrator')
@section('title', 'Create Workshop')
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
                        <button type="submit" class="btn btn-sm btn-danger" form="merchantForm"><i
                                class="mdi mdi-database me-1"></i>Save</button>
                    </div>
                    <h4 class="page-title">Create Workshop</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <form id="merchantForm" method="POST" action="{{ route('administrator.merchants.store') }}"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Workshop Details</h4>
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="name">Workshop Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Workshop Name" value="{{ old('name') }}">
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="statuses">Workshop Status</label>
                                    <select name="status" id="statuses" class="form-select form-control-sm">
                                        <option value="">Choose Status</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Blocked
                                        </option>
                                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>
                                            Suspended
                                        </option>
                                    </select>
                                    @error('status')
                                        <span id="status-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="email">Login Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter login email" value="{{ old('email') }}">
                                    @error('email')
                                        <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="password">Temporary Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter temporary password" value="{{ old('password') }}">
                                    @error('password')
                                        <span id="password-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label class="col-form-label"
                                        for="invoice_frequency">{{ __('Invoice Frequency') }}</label>

                                    <select id="invoice_frequency" class="form-select" name="invoice_frequency">
                                        <option value="">Select Frequency</option>
                                        <option value="weekly"
                                            {{ old('invoice_frequency') == 'weekly' ? 'selected' : '' }}>
                                            Weekly</option>
                                        <option value="monthly"
                                            {{ old('invoice_frequency') == 'monthly' ? 'selected' : '' }}>Monthly
                                        </option>
                                        <option value="quarterly"
                                            {{ old('invoice_frequency') == 'quarterly' ? 'selected' : '' }}>Quarterly
                                        </option>
                                        <option value="annually"
                                            {{ old('invoice_frequency') == 'annually' ? 'selected' : '' }}>Annually
                                        </option>
                                    </select>

                                    @error('invoice_frequency')
                                        <span id="invoice_frequency-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Workshop Store Details</h4>
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('store_contact_name') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="store_contact_name">Contact Name</label>
                                    <input type="text" class="form-control" id="store_contact_name"
                                        name="store_contact_name" placeholder="Enter Contact name"
                                        value="{{ old('store_contact_name') }}">
                                    @error('store_contact_name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-2 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="phone">Phone Number </label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Enter Phone Number" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <input id="dial-code" name="dialcode" type="hidden"
                                        value="{{ isset($admin) ? $admin->dialcode : '' }}">
                                    <select id="country" class="form-select" name="iso2" style="display: none">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-2 {{ $errors->has('store_contact_email') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="store_contact_email">Contact Email</label>
                                    <input type="email" class="form-control" id="store_contact_email"
                                        name="store_contact_email" placeholder="Enter Contact name"
                                        value="{{ old('store_contact_email') }}">
                                    @error('store_contact_email')
                                        <span id="store_contact_email-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2 {{ $errors->has('address') ? 'has-error' : '' }}">
                                    <label for="address" class="col-form-label">Address <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-text">
                                            <i class="uil-map-pin-alt"></i>
                                        </div>
                                        <input id="latitude" type="hidden" class="form-control" name="latitude"
                                            value="{{ old('latitude') }}">
                                        <input id="longitude" type="hidden" class="form-control" name="longitude"
                                            value="{{ old('longitude') }}">
                                        <input id="address" type="text"
                                            class="form-control @error('address') is-invalid @enderror" name="address"
                                            value="{{ old('address') }}" autocomplete="off" placeholder="Store Address">
                                    </div>
                                    @error('address')
                                        <span id="address-error" class="error invalid-feedback">Please enter store
                                            address</span>
                                    @enderror
                                </div>

                                <div class="col-sm-12 mb-2 {{ $errors->has('building_floor_room') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="building_floor_room">Building / Floor /
                                        Room</label>
                                    <input type="text" class="form-control" id="building_floor_room"
                                        name="building_floor_room" placeholder="Building / Floor / Room"
                                        value="{{ old('building_floor_room') }}">
                                    @error('building_floor_room')
                                        <span id="building_floor_room-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-12 mb-2 {{ $errors->has('notes') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="notes">Instruction / Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" placeholder="Instruction or notes" rows="3">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <span id="notes-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Workshop Billing Details</h4>
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('billing_name') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="billing_name">Billing Name</label>
                                    <input type="text" class="form-control" id="billing_name" name="billing_name"
                                        placeholder="Enter Billing name" value="{{ old('billing_name') }}">
                                    @error('billing_name')
                                        <span id="billing_name-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('billing_phone') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="billing_phone">Billing Phone Number </label>
                                    <input type="text" class="form-control" id="billing_phone" name="billing_phone"
                                        placeholder="Enter Billing Phone Number" value="{{ old('billing_phone') }}">
                                    @error('billing_phone')
                                        <span id="billing_phone-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <input id="billing-dial-code" name="billing_dialcode" type="hidden"
                                        value="{{ isset($admin) ? $admin->dialcode : '' }}">
                                    <select id="billing_country" class="form-select" name="billing_iso2"
                                        style="display: none">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('billing_email') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="billing_email">Billing Email</label>
                                    <input type="email" class="form-control" id="billing_email" name="billing_email"
                                        placeholder="Enter Billing Email" value="{{ old('billing_email') }}">
                                    @error('billing_email')
                                        <span id="billing_email-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2 {{ $errors->has('billing_address') ? 'has-error' : '' }}">
                                    <label for="billing_address" class="col-form-label">Billing Address <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-text">
                                            <i class="uil-map-pin-alt"></i>
                                        </div>
                                        <input id="billing_latitude" type="hidden" class="form-control"
                                            name="billing_latitude" value="{{ old('billing_latitude') }}">
                                        <input id="billing_longitude" type="hidden" class="form-control"
                                            name="billing_longitude" value="{{ old('billing_longitude') }}">
                                        <input id="billing_address" type="text"
                                            class="form-control @error('billing_address') is-invalid @enderror"
                                            name="billing_address" value="{{ old('billing_address') }}"
                                            autocomplete="off" placeholder="Billing Address">
                                    </div>
                                    @error('billing_address')
                                        <span id="billing_address-error" class="error invalid-feedback">Please enter billing
                                            address</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Services</h4>
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <label for="service">Services</label>
                                    {{--@if( count($services) > 0)
                                    <div class="row">
                                    @foreach ($services as $service)

                                    <div class="col-md-3">
                                    <input type="checkbox" 
                                    id="service-{{$service->id}}" value="{{$service->id}}" name="services[{{$service->id}}]">
                                    <label for="service-{{$service->id}}">{{$service->name}}</label>
                                    </div>

                                    @endforeach
                                    </div>
                                    @endif--}}

                                    <select name="services[]" id="service" class="form-select form-control-sm select2"
                                        data-toggle="select2" data-placeholder="Select Service(s)" multiple>
                                        <option></option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ in_array($service->id, old('services', [])) ? 'selected' : '' }}>
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12 text-end">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                            class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                                    <button type="submit" class="btn btn-sm btn-danger" form="merchantForm"><i
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
    <script>
        function loadPreview(input, id) {
            id = id || '#preview_img';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width(100)
                        .height(100);
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
            initialCountry: "{{ old('iso2', 'SG') }}",
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
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_api_key') }}&libraries=places&callback=Function.prototype">
    </script>
    <script>
        let address = document.getElementById('address')
        let autocomplete = new google.maps.places.Autocomplete(address, {
            componentRestrictions: { country: 'sg' },
            fields: ['geometry']
        });
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            $('#latitude').val(place.geometry.location.lat())
            $('#longitude').val(place.geometry.location.lng())
        });
    </script>

    <script>
        let billing_address = document.getElementById('billing_address')
        let billing_autocomplete = new google.maps.places.Autocomplete(billing_address, {
            componentRestrictions: { country: 'sg' },
            fields: ['geometry']
        });
        billing_autocomplete.addListener("place_changed", () => {
            const billing_place = billing_autocomplete.getbilling_();
            $('#billing_latitude').val(billing_place.geometry.location.lat())
            $('#billing_longitude').val(billing_place.geometry.location.lng())
        });
    </script>
    <script>
        // get the country data from the plugin
        var countryData = window.intlTelInputGlobals.getCountryData(),

            alt_input = document.querySelector("#billing_phone"),
            alt_dialCode = document.querySelector("#billing-dial-code");
        alt_countryDropdown = document.querySelector("#billing_country");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            var optionNode = document.createElement("option");
            optionNode.value = country.iso2;
            var textNode = document.createTextNode(country.name);
            optionNode.appendChild(textNode);
            alt_countryDropdown.appendChild(optionNode);
        }

        // init plugin
        var alt_iti = window.intlTelInput(alt_input, {
            initialCountry: "{{ old('iso2', 'SG') }}",
            utilsScript: "{{ asset('assets/js/plugins/intl-tel-input/js/utils.js') }}" // just for formatting/placeholders etc
        });

        // set it's initial value
        alt_dialCode.value = '+' + alt_iti.getSelectedCountryData().dialCode;
        alt_countryDropdown.value = alt_iti.getSelectedCountryData().iso2;

        // listen to the telephone input for changes
        input.addEventListener('countrychange', function(e) {
            alt_dialCode.value = '+' + alt_iti.getSelectedCountryData().dialCode;
            alt_countryDropdown.value = alt_iti.getSelectedCountryData().iso2;
        });

        // listen to the address dropdown for changes
        alt_countryDropdown.addEventListener('change', function() {
            alt_iti.setCountry(this.value);
        });
    </script>
@endpush
