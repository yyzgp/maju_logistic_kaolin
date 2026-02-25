<!doctype html>
<html lang="en">

<head>
    <title>Customer Request Form</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet"
        type="text/css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

    <div class="container">
        <div class="row my-4">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img src="{{ asset('assets/images/logo/logo.png') }}" title="logo" alt="logo"
                                    width="48%">
                            </div>
                            <div class="col-md-12 text-center">
                                <h4 class="text-danger pt-2">Customer Request Form</h4>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="{{ route('customer-request-form.store', $merchant->slug) }}"
                                    method="POST" id="customerRequestForm">
                                    @csrf
                                    @method('PUT')
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success alert-dismissible bg-yellow text-dark border-0 fade show"
                                            role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                            <strong><i class="dripicons-checkmark me-2"></i>
                                            </strong>{{ $message }}
                                        </div>
                                    @endif
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Breakdown Details</h5>
                                        </div>
                                        <div class="card-body">
                                            {{-- Recipient's Name --}}
                                            <div class="row mb-2">
                                                <label class="col-form-label col-sm-3" for="name">Name <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-sm-9 {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="uil uil-user"></i></span>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="name" name="name" placeholder="Recipient's name"
                                                            value="{{ old('name') }}" autofocus>

                                                    </div>
                                                    @error('name')
                                                        <span id="name-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Recipient's Phone Number --}}
                                            <div class="row mb-2">
                                                <label class="col-form-label col-sm-3" for="phone">Phone Number <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-sm-9 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                                    <input type="text"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        id="phone" name="phone"
                                                        placeholder="Recipient's phone number"
                                                        value="{{ old('phone') }}">
                                                    @error('phone')
                                                        <span id="name-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                    <input id="dial-code" name="dialcode" type="hidden"
                                                        value="{{ isset($admin) ? $admin->dialcode : '' }}">
                                                    <select id="country" class="form-select" name="iso2"
                                                        style="display: none">
                                                        <option value="">Select Country</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Recipient's Email Address --}}
                                            <div class="row mb-2">
                                                <label class="col-form-label col-sm-3" for="email">Email Address
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-sm-9 {{ $errors->has('email') ? 'has-error' : '' }}">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="uil uil-envelope"></i></span>
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            id="email" name="email"
                                                            placeholder="Recipient's email address"
                                                            value="{{ old('email') }}">

                                                    </div>
                                                    @error('email')
                                                        <span id="email-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Recipient's Breakdown Location --}}
                                            <div class="row mb-2">
                                                <label for="address" class="col-form-label col-sm-3">Breakdown
                                                    Location <span class="text-danger">*</span></label>
                                                <div
                                                    class="col-sm-9 {{ $errors->has('address') ? 'has-error' : '' }}">
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-text">
                                                            <i class="uil-map-pin-alt"></i>
                                                        </div>
                                                        <input id="latitude" type="hidden" class="form-control"
                                                            name="latitude" value="{{ old('latitude') }}">
                                                        <input id="longitude" type="hidden" class="form-control"
                                                            name="longitude" value="{{ old('longitude') }}">
                                                        <input id="address" type="text"
                                                            class="form-control @error('address') is-invalid @enderror"
                                                            name="address" value="{{ old('address') }}"
                                                            autocomplete="off"
                                                            placeholder="Breakdown Location Address">
                                                    </div>
                                                    @error('address')
                                                        <span id="address-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Recipient's Location Details --}}
                                            <div class="row mb-2">
                                                <label class="col-form-label col-sm-3" for="location">Location
                                                    Details</label>
                                                <div
                                                    class="col-sm-9 {{ $errors->has('location') ? 'has-error' : '' }}">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="uil uil-sign-alt"></i></span>
                                                        <input type="text"
                                                            class="form-control @error('location') is-invalid @enderror"
                                                            id="location" name="location"
                                                            placeholder="Building / Floor / Room / Nearby Places"
                                                            value="{{ old('location') }}">
                                                    </div>
                                                    @error('location')
                                                        <span id="location-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Recipient's Vehicle Type --}}
                                            <div class="row mb-2">
                                                <label class="col-form-label col-sm-3" for="vehicle_type">Vehicle Model
                                                    <span class="text-danger">*</span></label>
                                                <div
                                                    class="col-sm-9 {{ $errors->has('vehicle_type') ? 'has-error' : '' }}">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="uil uil-car-sideview"></i></span>
                                                        <input name="vehicle_type" id="vehicle_type"
                                                            class="form-control @error('vehicle_type') is-invalid @enderror" placeholder="Enter vehicle model" value="{{ old('vehicle_type') }}">


                                                    </div>
                                                    @error('vehicle_type')
                                                        <span id="vehicle_type-error"
                                                            class="error invalid-feedback">Please enter vehicle model.</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Recipient's Vehicle Details --}}
                                            <div class="row mb-2">
                                                <label class="col-form-label col-sm-3"
                                                    for="registration_number">Vehicle Plate Number <span
                                                        class="text-danger">*</span></label>
                                                <div
                                                    class="col-sm-9 {{ $errors->has('registration_number') ? 'has-error' : '' }}">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="uil uil-shield-check"></i></span>
                                                        <input type="text"
                                                            class="form-control @error('registration_number') is-invalid @enderror"
                                                            id="registration_number" name="registration_number"
                                                            placeholder="Recipient's vehicle plate number"
                                                            value="{{ old('registration_number') }}">
                                                    </div>
                                                    @error('registration_number')
                                                        <span id="registration_number-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Recipient's Vehicle Details --}}
                                            <div class="row mb-2">
                                                <label class="col-form-label col-sm-3" for="notes">Instructions /
                                                    Notes </label>
                                                <div class="col-sm-9 {{ $errors->has('notes') ? 'has-error' : '' }}">
                                                    <div class="input-group">
                                                        <textarea class="form-control" id="notes" name="notes" placeholder="Write Instructions / notes here"
                                                            rows="4">{{ old('notes') }}</textarea>
                                                        </textarea>
                                                    </div>
                                                    @error('notes')
                                                        <span id="notes-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                    @if ($merchant->slug == 'paynow')
                                        <div class="card">
                                            <div class="card-header">
                                                <input type="text" name="merchant_id" value="{{ $merchant->id }}"
                                                    hidden>
                                                <h5 class="card-title">Destination Details</h5>
                                            </div>
                                            <div class="card-body">
                                                {{-- Recipient's Name --}}
                                                <div class="row mb-2">
                                                    <label class="col-form-label col-sm-3" for="name">Destination
                                                        Contact Person <span class="text-danger"></span></label>
                                                    <div
                                                        class="col-sm-9 {{ $errors->has('destination_contact_name') ? 'has-error' : '' }}">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="uil uil-user"></i></span>
                                                            <input type="text"
                                                                class="form-control @error('destination_contact_name') is-invalid @enderror"
                                                                id="destination_contact_name"
                                                                name="destination_contact_name"
                                                                placeholder="Destination Contact Person's name"
                                                                value="{{ old('destination_contact_name') }}"
                                                                autofocus>

                                                        </div>
                                                        @error('name')
                                                            <span id="name-error"
                                                                class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Recipient's Phone Number --}}
                                                <div class="row mb-2">
                                                    <label class="col-form-label col-sm-3"
                                                        for="destination_phone">Destination Phone Number <span
                                                            class="text-danger"></span></label>
                                                    <div
                                                        class="col-sm-9 {{ $errors->has('destination_phone') ? 'has-error' : '' }}">
                                                        <input type="text"
                                                            class="form-control @error('destination_phone') is-invalid @enderror"
                                                            id="destination-phone" name="destination_phone"
                                                            placeholder="Destination Phone Number "
                                                            value="{{ old('destination_phone') }}">
                                                        @error('destination_phone')
                                                            <span id="name-error"
                                                                class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                        <input id="destination-dialcode" name="destination_dialcode"
                                                            type="hidden"
                                                            value="{{ isset($admin) ? $admin->dialcode : '' }}">
                                                        <select id="destination-country" class="form-select"
                                                            name="destination_iso2" style="display: none">
                                                            <option value="">Select Country</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Recipient's Email Address --}}
                                                <div class="row mb-2">
                                                    <label class="col-form-label col-sm-3"
                                                        for="destination_contact_email">Destination Email Address
                                                        <span class="text-danger"></span></label>
                                                    <div
                                                        class="col-sm-9 {{ $errors->has('destination_contact_email') ? 'has-error' : '' }}">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="uil uil-envelope"></i></span>
                                                            <input type="email"
                                                                class="form-control @error('destination_contact_email') is-invalid @enderror"
                                                                id="destination_contact_email"
                                                                name="destination_contact_email"
                                                                placeholder="Destination email address"
                                                                value="{{ old('destination_contact_email') }}">

                                                        </div>
                                                        @error('email')
                                                            <span id="email-error"
                                                                class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Recipient's Breakdown Location --}}
                                                <div class="row mb-2">
                                                    <label for="destination_address"
                                                        class="col-form-label col-sm-3">Destination Address
                                                        <span class="text-danger">*</span></label>
                                                    <div
                                                        class="col-sm-9 {{ $errors->has('destination_address') ? 'has-error' : '' }}">
                                                        <div class="input-group input-group-merge">
                                                            <div class="input-group-text">
                                                                <i class="uil-map-pin-alt"></i>
                                                            </div>
                                                            <input id="destination_latitude" type="hidden"
                                                                class="form-control" name="destination_latitude"
                                                                value="{{ old('destination_latitude') }}">
                                                            <input id="destination_longitude" type="hidden"
                                                                class="form-control" name="destination_longitude"
                                                                value="{{ old('destination_longitude') }}">
                                                            <input id="destination_address" type="text"
                                                                class="form-control @error('destination_address') is-invalid @enderror"
                                                                name="destination_address"
                                                                value="{{ old('destination_address') }}"
                                                                autocomplete="off" placeholder="Destination Address">
                                                        </div>
                                                        @error('destination_address')
                                                            <span id="destination_address-error"
                                                                class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Recipient's Location Details --}}
                                                <div class="row mb-2">
                                                    <label class="col-form-label col-sm-3"
                                                        for="destination_building_floor_room">Destination Location
                                                        Details</label>
                                                    <div
                                                        class="col-sm-9 {{ $errors->has('destination_building_floor_room') ? 'has-error' : '' }}">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="uil uil-sign-alt"></i></span>
                                                            <input type="text"
                                                                class="form-control @error('destination_building_floor_room') is-invalid @enderror"
                                                                id="destination_building_floor_room"
                                                                name="destination_building_floor_room"
                                                                placeholder="Building / Floor / Room / Nearby Places"
                                                                value="{{ old('destination_building_floor_room') }}">
                                                        </div>
                                                        @error('location')
                                                            <span id="location-error"
                                                                class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-12 d-grid">
                                                <button type="submit" class="btn btn-danger"
                                                    form="customerRequestForm">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
      @if ($merchant->slug == 'paynow')
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
    @endif
</body>

</html>
