@extends('layouts.administrator')
@section('title', 'Create Task')
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
                        <button type="submit" class="btn btn-sm btn-danger" form="taskForm"><i
                                class="mdi mdi-database me-1"></i>Save</button>
                    </div>
                    <h4 class="page-title">Create Task</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <form id="taskForm" method="POST" action="{{ route('administrator.tasks.store') }}"
                    enctype="multipart/form-data" autocomplete="off" onsubmit="handleSubmit()">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4 mb-2 {{ $errors->has('priority') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="priority">Task Priority <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="priority" name="priority">
                                        <option value="">Select Priority</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low
                                        </option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : 'selected' }}>
                                            Medium
                                        </option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High
                                        </option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent
                                        </option>
                                    </select>
                                    @error('priority')
                                        <span id="priority-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-4 mb-2 {{ $errors->has('driver') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="driver">Driver <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2" id="driver" name="driver" data-toggle="select2"
                                        data-placeholder="Select Driver">
                                        <option></option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}"
                                                {{ old('driver') == $driver->id ? 'selected' : '' }}>
                                                {{ $driver->firstname . ' ' . $driver->lastname }}</option>
                                        @endforeach
                                    </select>
                                    @error('driver')
                                        <span id="driver-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-4 mb-2 {{ $errors->has('type') ? 'has-error' : '' }}"
                                    onchange="getServices()">
                                    <label class="col-form-label" for="type">Task Type <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="type" name="type">
                                        <option value="">Select Type</option>
                                        <option value="Towing" {{ old('type') == 'Towing' ? 'selected' : 'selected' }}>
                                            Towing
                                        </option>
                                        <option value="Battery/Tyre" {{ old('type') == 'Battery/Tyre' ? 'selected' : '' }}>
                                            Battery/Tyre</option>
                                        <option value="Towing & Battery/Tyre"
                                            {{ old('type') == 'Towing & Battery/Tyre' ? 'selected' : '' }}>
                                            Towing & Battery/Tyre</option>
                                    </select>
                                    @error('type')
                                        <span id="type-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-4 mb-2 btsize @if (is_null(old('battery_tyre_size'))) hidden @endif">
                                    <label class="col-form-label" for="type">Battery/Tyre Size </label>
                                    <input type="text" class="form-control" value="{{ old('battery_tyre_size') }}"
                                        name="battery_tyre_size" placeholder="Enter Battery Tyre Size" />
                                </div>


                                <div class="col-sm-4 mb-2 {{ $errors->has('merchant') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="merchant">Workshop <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2" id="merchant" name="merchant" data-toggle="select2"
                                        data-placeholder="Select Workshop" onchange="">
                                        <option></option>
                                        @foreach ($merchants as $merchant)
                                            <option value="{{ $merchant->id }}"
                                                {{ old('merchant') == $merchant->id ? 'selected' : '' }}>
                                                {{ $merchant->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('merchant')
                                        <span id="merchant-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-4 mb-2 {{ $errors->has('service') ? 'has-error' : '' }}"
                                    id="service_row">
                                    <label class="col-form-label" for="service">Task Service <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2" data-toggle="select2"
                                        data-placeholder="Choose Service" id="service" name="service"
                                        onchange="getPrice()">
                                        <option value=""></option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ old('service') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('service')
                                        <span id="service-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-sm-4 mb-2">
                                    <label class="col-form-label" for="towing_fee">Towing Fee (SGD)<span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('towing_fee') is-invalid @enderror"
                                        id="towing_fee" name="towing_fee" placeholder="Enter Towing Fee (SGD)"
                                        step="any" value="{{ old('towing_fee', 0.0) }}">
                                    @error('towing_fee')
                                        <span id="towing_fee-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <label class="col-form-label" for="ticket_no">Ticket Number </label>
                                    <input type="text" class="form-control" value="{{ old('ticket_no') }}"
                                        name="ticket_no" placeholder="Enter Ticket Number" />
                                </div>
                                {{-- <div class="col-sm-4 mb-2">
                                    <label class="col-form-label" for="due_amount">Due Amount (SGD)<span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('due_amount') is-invalid @enderror"
                                        id="due_amount" name="due_amount" placeholder="Enter Due Amount (SGD)"
                                        step="any" value="{{ old('due_amount', 0.0) }}">
                                    @error('due_amount')
                                        <span id="due_amount-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Breakdown Details</h4>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <label class="col-form-label" for="name">Recipient's Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Recipient's Name"
                                        value="{{ old('name') }}" autofocus>
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <label class="col-form-label" for="phone">Recipient's Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="Recipient's Phone Number"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <span id="phone-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <input id="dial-code" name="dialcode" type="hidden"
                                        value="{{ isset($admin) ? $admin->dialcode : '' }}">
                                    <select id="country" class="form-select" name="iso2" style="display: none">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <label class="col-form-label" for="email">Recipient's Email Address </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Recipient's Email Address"
                                        value="{{ old('email') }}" autofocus>
                                    @error('email')
                                        <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <label for="address" class="col-form-label">Breakdown
                                        Location <span class="text-danger">*</span></label>
                                    <input id="latitude" type="hidden" class="form-control" name="latitude"
                                        value="{{ old('latitude') }}">
                                    <input id="longitude" type="hidden" class="form-control" name="longitude"
                                        value="{{ old('longitude') }}">
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address') }}" autocomplete="off"
                                        placeholder="Type to search breakdown location">
                                    @error('address')
                                        <span id="address-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <label class="col-form-label" for="location">Building / Floor /
                                        Room</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                        placeholder="Building / Floor / Room" value="{{ old('location') }}">
                                    @error('location')
                                        <span id="location-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- <div class="col-sm-4 mb-2">
                                    <label class="col-form-label" for="email">Complete Before <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" step="any"
                                        class="form-control @error('due_time') is-invalid @enderror" id="due_time"
                                        name="due_time" value="{{ old('due_time', \Carbon\Carbon::now()) }}" >
                                    @error('due_time')
                                        <span id="due_time-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                <div class="col-sm-4 mb-2">
                                    <label class="col-form-label" for="vehicle_type">Vehicle Model
                                        <span class="text-danger">*</span></label>
                                        <input name="vehicle_type" id="vehicle_type"
                                        class="form-control @error('vehicle_type') is-invalid @enderror" placeholder="Enter vehicle model" value="{{ old('vehicle_type') }}">
                                    @error('vehicle_type')
                                        <span id="vehicle_type-error"
                                            class="error invalid-feedback">Please enter vehicle model.</span>
                                    @enderror
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <label class="col-form-label" for="registration_number">Vehicle Plate Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('registration_number') is-invalid @enderror"
                                        id="registration_number" name="registration_number"
                                        placeholder="Recipient's vehicle plate number"
                                        value="{{ old('registration_number') }}">
                                    @error('registration_number')
                                        <span id="registration_number-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>



                                <div class="col-sm-12 mb-2">
                                    <label class="col-form-label" for="notes">Instructions /
                                        Notes </label>
                                    <div class="input-group">
                                        <textarea class="form-control" id="notes" name="notes" placeholder="Write Instructions / notes here"
                                            rows="4">{{ old('notes') }}</textarea>
                                        </textarea>
                                    </div>
                                    @error('notes')
                                        <span id="notes-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card descard">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Destination Details</h4>
                                </div>
                                <div
                                    class="col-sm-6 mb-2 {{ $errors->has('destination_contact_name') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="destination_contact_name">Contact Name</label>
                                    <input type="text" class="form-control" id="destination_contact_name"
                                        name="destination_contact_name" placeholder="Enter Contact name"
                                        value="{{ old('destination_contact_name') }}">
                                    @error('destination_contact_name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-2 {{ $errors->has('destination_phone') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="destination_phone">Phone Number </label>
                                    <input type="text" class="form-control" id="destination-phone"
                                        name="destination_phone" placeholder="Enter Phone Number"
                                        value="{{ old('destination_phone') }}">
                                    @error('destination_phone')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <input id="destination-dialcode" name="destination_dialcode" type="hidden"
                                        value="{{ isset($admin) ? $admin->dialcode : '' }}">
                                    <select id="destination-country" class="form-select" name="destination_iso2"
                                        style="display: none">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>

                                <div
                                    class="col-sm-6 mb-2 {{ $errors->has('destination_contact_email') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="destination_contact_email">Contact Email</label>
                                    <input type="email" class="form-control" id="destination_contact_email"
                                        name="destination_contact_email" placeholder="Enter Contact name"
                                        value="{{ old('destination_contact_email') }}">
                                    @error('destination_contact_email')
                                        <span id="destination_contact_email-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2 {{ $errors->has('destination_address') ? 'has-error' : '' }}">
                                    <label for="destination_address" class="col-form-label">Address <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-text">
                                            <i class="uil-map-pin-alt"></i>
                                        </div>
                                        <input id="destination_latitude" type="hidden" class="form-control"
                                            name="destination_latitude" value="{{ old('destination_latitude') }}">
                                        <input id="destination_longitude" type="hidden" class="form-control"
                                            name="destination_longitude" value="{{ old('destination_longitude') }}">
                                        <input id="destination_address" type="text"
                                            class="form-control @error('destination_address') is-invalid @enderror"
                                            name="destination_address" value="{{ old('destination_address') }}"
                                            autocomplete="off" placeholder="Destination Address">
                                    </div>
                                    @error('address')
                                        <span id="address-error" class="error invalid-feedback">Please enter store
                                            address</span>
                                    @enderror
                                </div>

                                <div
                                    class="col-sm-12 mb-2 {{ $errors->has('destination_building_floor_room') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="destination_building_floor_room">Building / Floor /
                                        Room</label>
                                    <input type="text" class="form-control" id="destination_building_floor_room"
                                        name="destination_building_floor_room" placeholder="Building / Floor / Room"
                                        value="{{ old('destination_building_floor_room') }}">
                                    @error('destination_building_floor_room')
                                        <span id="destination_building_floor_room-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-12 mb-2 {{ $errors->has('destination_notes') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="destination_notes">Instruction / Notes</label>
                                    <textarea class="form-control" id="destination_notes" name="destination_notes" placeholder="Instruction or notes"
                                        rows="3">{{ old('destination_notes') }}</textarea>
                                    @error('destination_notes')
                                        <span id="notes-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12 mb-2">
                                <label class="col-form-label" for="remarks">Remarks </label>
                                <div class="input-group">
                                    <textarea class="form-control" id="remarks" name="remarks" placeholder="Write Remarks here"
                                        rows="4">{{ old('remarks') }}</textarea>
                                    </textarea>
                                </div>
                                @error('remarks')
                                    <span id="remarks-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="col-form-label" for="requirement">Requirements </label>
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" id="photos"
                                                value="photos" name="requirements[]"
                                                {{ in_array('photos', old('requirements', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="photos">Photos</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" id="signature"
                                                value="signature" name="requirements[]"
                                                {{ in_array('signature', old('requirements', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="signature">Signature</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input nreq" id="notes"
                                                value="notes" name="requirements[]"
                                                {{ in_array('notes', old('requirements', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="notes">Notes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" id="cash-on-delivery"
                                                value="cash-on-delivery" name="requirements[]"
                                                {{ in_array('cash-on-delivery', old('requirements', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cash-on-delivery">Cash On
                                                Delivery</label>
                                        </div>
                                    </div>
                                    @error('requirements')
                                        <span id="requirements-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-8">
                                    <label class="col-form-label" for="statuses">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="statuses" name="status">
                                        <option value="">Select Status</option>
                                        <option value="unassigned"
                                        {{ old('status') == null ? 'selected' : 'selected' }}>Unassigned
                                    </option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Assigned
                                        </option>
                                        <option value="arrived" {{ old('status') == 'arrived' ? 'selected' : '' }}>
                                            Arrived
                                        </option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                        <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed
                                        </option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled
                                        </option>
                                    </select>
                                    @error('status')
                                        <span id="status-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12 text-end">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                            class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                                    <button type="submit" class="btn btn-sm btn-danger" form="taskForm"><i
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
    <script>
        // get the country data from the plugin
        var dedCountryData = window.intlTelInputGlobals.getCountryData(),

            destination_input = document.querySelector("#destination-phone"),
            destination_dialCode = document.querySelector("#destination-dialcode");
        destination_countryDropdown = document.querySelector("#destination-country");

        for (var j = 0; j < dedCountryData.length; j++) {
            var country = dedCountryData[j];
            var optionNode = document.createElement("option");
            optionNode.value = country.iso2;
            var textNode = document.createTextNode(country.name);
            optionNode.appendChild(textNode);
            destination_countryDropdown.appendChild(optionNode);
        }

        // init plugin
        var alt_iti = window.intlTelInput(destination_input, {
            initialCountry: "{{ old('destination_iso2', 'SG') }}",
            utilsScript: "{{ asset('assets/js/plugins/intl-tel-input/js/utils.js') }}" // just for formatting/placeholders etc
        });

        // set it's initial value
        destination_dialCode.value = '+' + alt_iti.getSelectedCountryData().dialCode;
        destination_countryDropdown.value = alt_iti.getSelectedCountryData().iso2;

        // listen to the telephone input for changes
        destination_input.addEventListener('countrychange', function(e) {
            destination_dialCode.value = '+' + alt_iti.getSelectedCountryData().dialCode;
            destination_countryDropdown.value = alt_iti.getSelectedCountryData().iso2;
        });

        // listen to the address dropdown for changes
        destination_countryDropdown.addEventListener('change', function() {
            alt_iti.setCountry(this.value);
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
        let destination_address = document.getElementById('destination_address')
        let destination_autocomplete = new google.maps.places.Autocomplete(destination_address, {
            componentRestrictions: { country: 'sg' },
            fields: ['geometry']
        });
        destination_autocomplete.addListener("place_changed", () => {
            const destination_place = destination_autocomplete.getPlace();
            $('#destination_latitude').val(destination_place.geometry.location.lat())
            $('#destination_longitude').val(destination_place.geometry.location.lng())
        });
    </script>

    <script>
        function getServices() {
            let type = $("#type").val();
            let merchant = $("#merchant").val();
            if(merchant){
                if (merchant == 50) {
                $("#cash-on-delivery").attr("checked", true)
            } else {
                $("#cash-on-delivery").attr("checked", false)
            }
            if (type == "Other") {
                $("#service_row").hide();
            } 
            // else {
            //     $("#service_row").show();
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': "{{ csrf_token() }}",
            //         }
            //     });
            //     var formData = {
            //         type: $("#type").val(),
            //         merchant: $("#merchant").val()
            //     };
            //     $.ajax({
            //         type: 'POST',
            //         url: '{{ route('administrator.ajax.get-services') }}',
            //         data: formData,
            //         dataType: 'json',
            //         beforeSend: function() {
            //             $('#service').html('');
            //             $("#towing_fee").val(0.00);
            //         },
            //         success: function(res, status) {
            //             if (merchant) {
            //                 if (merchant != 30) {
            //                     $('#destination_contact_name').val(res.destination.name);
            //                     $('#destination-phone').val(res.destination.phone);
            //                     $('#destination_contact_email').val(res.destination.email);
            //                     $('#destination_address').val(res.destination.address);
            //                     $('#destination_latitude').val(res.destination.latitude);
            //                     $('#destination_longitude').val(res.destination.longitude);
            //                     $('#destination_building_floor_room').val(res.destination.building_floor_room);
            //                     $('#destination_notes').val(res.destination.notes);
            //                 } else {
            //                     $('#destination_contact_name').val('');
            //                     $('#destination-phone').val('');
            //                     $('#destination_contact_email').val('');
            //                     $('#destination_address').val('');
            //                     $('#destination_latitude').val('');
            //                     $('#destination_longitude').val('');
            //                     $('#destination_building_floor_room').val('');
            //                     $('#destination_notes').val('');
            //                 }
            //             }


            //             var newOption = new Option("", "", false, false);
            //             $('#service').append(newOption);
            //             res.services.forEach(function(service) {
            //                 var newOption = new Option(service.name, service.id, false, false);
            //                 $('#service').append(newOption);
            //             });
            //             $('#service').val("{{ old('service') }}");
            //         },
            //         error: function(res, status) {

            //         }
            //     });
            // }
            }else{
                $("#service_row").hide();
            }

        }
    </script>
    <script>
        function getPrice() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                }
            });
            var formData = {
                service: $("#service").val()
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('administrator.ajax.get-service-price') }}',
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    $("#towing_fee").val(0.00);
                },
                success: function(res, status) {
                    $("#towing_fee").val(res.service.price);
                },
                error: function(res, status) {

                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            getServices();

            $('#type').on('change', function(e) {
                let val = $(this).val();
                if (val && val != 'Towing') {
                    $('.btsize').removeClass('hidden');
                } else {
                    $('.btsize').addClass('hidden')
                }
            });

            $('#driver').on('change', function(e) {
                let dval = $(this).val();
                if (dval) {
                    $('#statuses').val('active');
                } else {
                    $('#statuses').val('');
                }
            });
            $('#taskForm').on('submit', function() {

                let photos = $('#photos').prop('checked');
                let signature = $('#signature').prop('checked');
                let notes = $('.nreq').prop('checked');
                let cod = $('#cash-on-delivery').prop('checked');
                if (!photos && !signature && !notes && !cod) {
                    alert('Please select atleast one requirement.');
                    return false;
                }
                return true;
            });
        });
    </script>
@endpush
