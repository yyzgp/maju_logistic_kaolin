@extends('layouts.administrator')
@section('title', 'Create Driver')
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
                        <button type="submit" class="btn btn-sm btn-danger" form="driverForm"><i
                                class="mdi mdi-database me-1"></i>Save</button>
                    </div>
                    <h4 class="page-title">Create Driver</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <form id="driverForm" method="POST" action="{{ route('administrator.drivers.store') }}"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Personal Details</h4>
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('firstname') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                        placeholder="Enter First Name" value="{{ old('firstname') }}">
                                    @error('firstname')
                                        <span id="firstname-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('lastname') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        placeholder="Enter Last Name" value="{{ old('lastname') }}">
                                    @error('lastname')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter Email Address" value="{{ old('email') }}">
                                    @error('email')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-2 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Enter Phone Number" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <input id="dial-code" name="dialcode" type="hidden"
                                        value="{{ isset($admin) ? $admin->dialcode : '' }}">
                                </div>

                                <div class="col-sm-6 mb-2 {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter Password" value="{{ old('password') }}"
                                        autocomplete="new-password">
                                    @error('password')
                                        <span id="password-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm Password"
                                        value="{{ old('password_confirmation') }}">
                                    @error('password_confirmation')
                                        <span id="password_confirmation-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <label class="col-form-label" for="gender">{{ __('Gender') }}</label>

                                    <select id="gender" class="form-select" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female
                                        </option>
                                    </select>

                                    @error('gender')
                                        <span id="gender-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <label class="col-form-label" for="statuses">{{ __('Status') }}</label>

                                    <select id="statuses" class="form-select" name="status">
                                        <option value="">Select Status</option>
                                        <option value="1" selected>Enable</option>
                                        <option value="0">Disable</option>
                                    </select>

                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label" for="avatar">Profile Picture</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="avatar" name="avatar"
                                            onchange="loadPreview(this);">
                                    </div>
                                    @if ($errors->has('avatar'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('avatar') }}</strong>
                                        </span>
                                    @endif
                                    <img id="preview_img" src="https://placehold.co/150x150/D82D36/FFF?text=Driver"
                                        class="mt-2" width="100" height="100" />
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Vehicle Details</h4>
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <label class="col-form-label" for="vehicle_type">{{ __('Vehicle Type') }}</label>

                                    <select id="vehicle_type" class="form-select" name="vehicle_type">
                                        <option value="">Select Vehicle Type</option>
                                        <option value="Car" {{ old('vehicle_type') == 'Car' ? 'selected' : '' }}>🚘 Car
                                        </option>
                                        <option value="Van" {{ old('vehicle_type') == 'Van' ? 'selected' : '' }}>🚚 Van
                                        </option>
                                        <option value="Truck" {{ old('vehicle_type') == 'Truck' ? 'selected' : '' }}>🚍
                                            Truck</option>
                                        <option value="Bike" {{ old('vehicle_type') == 'Bike' ? 'selected' : '' }}>🏍️
                                            Bike</option>
                                        <option value="Bicycle" {{ old('vehicle_type') == 'Bicycle' ? 'selected' : '' }}>
                                            🚴 Bicycle</option>
                                        <option value="Walking" {{ old('vehicle_type') == 'Walking' ? 'selected' : '' }}>
                                            🚶🏻 Walking</option>
                                    </select>

                                    @error('vehicle_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('vehicle_description') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="vehicle_description">Vehicle Description</label>
                                    <input type="text" class="form-control" id="vehicle_description"
                                        name="vehicle_description" placeholder="Enter Vehicle Description"
                                        value="{{ old('vehicle_description') }}">
                                    @error('vehicle_description')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div
                                    class="col-sm-6 mb-2 {{ $errors->has('vehicle_registration_no') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="vehicle_registration_no">Vehicle Registration
                                        Number</label>
                                    <input type="text" class="form-control" id="vehicle_registration_no"
                                        name="vehicle_registration_no" placeholder="Enter Vehicle Registration Number"
                                        value="{{ old('vehicle_registration_no') }}">
                                    @error('vehicle_registration_no')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Contact Details</h4>
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('address') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Enter Address" value="{{ old('address') }}">
                                    @error('address')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('city') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        placeholder="Enter City" value="{{ old('city') }}">
                                    @error('city')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('state') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        placeholder="Enter State" value="{{ old('state') }}">
                                    @error('state')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label class="col-form-label" for="country">{{ __('Country') }}</label>

                                    <select id="country" class="form-select" name="iso2">
                                        <option value="">Select Country</option>
                                    </select>

                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('zipcode') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="zipcode">Zipcode</label>
                                    <input type="text" class="form-control" id="zipcode" name="zipcode"
                                        placeholder="Enter Zipcode" value="{{ old('zipcode') }}">
                                    @error('zipcode')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                    class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                            <button type="submit" class="btn btn-sm btn-danger" form="driverForm"><i
                                    class="mdi mdi-database me-1"></i>Save</button>
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
@endpush
