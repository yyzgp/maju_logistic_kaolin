@extends('layouts.administrator')
@section('title', 'Edit Service')
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
                        <button type="submit" class="btn btn-sm btn-danger" form="superadminForm"><i
                                class="mdi mdi-database me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Edit Service</h4>
                </div>
            </div>
        </div>
        @include('administrator.includes.flash-message')
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <form id="superadminForm" method="POST" action="{{ route('administrator.services.update', $service->id) }}"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h4 class="text-dark">Service Details</h4>
                                </div>
                                <div class="col-sm-6 mb-2 {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="name">Service Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Service Name" value="{{ old('name', $service->name) }}">
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-2 {{ $errors->has('type') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="type">Type</label>
                                    <select name="type[]" id="type" class="form-select form-control-sm select2"
                                        data-toggle="select2" multiple data-placeholder="Choose Type(s)">
                                        <option></option>
                                        <option value="Towing"
                                            {{ in_array('Towing', old('type', $service->type)) ? 'selected' : '' }}>
                                            Towing
                                        </option>
                                        <option value="Battery/Tyre"
                                            {{ in_array('Battery/Tyre', old('type', $service->type)) ? 'selected' : '' }}>
                                            Battery/Tyre
                                        </option>
                                    </select>
                                </div>

                                <div class="col-sm-12 mb-2 {{ $errors->has('merchants') ? 'has-error' : '' }}">
                                    <label for="merchants">Workshops <span class="text-danger">*</span></label>
                                    @if (count($merchants) > 0)
                                        <div class="row ms-0 me-0 my-2"
                                            style="background-color: #ff00001a;">
                                            @foreach ($merchants as $merchant)
                                                <div class="col-md-3 mt-2">
                                                    <div class="form-check form-checkbox-danger mb-2">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="merchant-{{ $merchant->id }}" name="merchants[]"
                                                            value="{{ $merchant->id }}"
                                                            {{ in_array($merchant->id, old('merchants', $service->merchants)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" style="font-size:13px;"
                                                            for="merchant-{{ $merchant->id }}">{{ $merchant->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('merchants')
                                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>



                                <div class="col-sm-6 mb-2 {{ $errors->has('price') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="price">Base Price ($)<span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="price" name="price"
                                        placeholder="Enter Base Price" step="any"
                                        value="{{ old('price', $service->price) }}">
                                    @error('price')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-2 {{ $errors->has('extra_night_price') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="extra_night_price">Extra Night Charges ($)<span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="extra_night_price"
                                        name="extra_night_price" placeholder="Enter Extra Night Charges" step="any"
                                        value="{{ old('extra_night_price', $service->extra_night_price) }}">
                                    @error('extra_night_price')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <label class="col-form-label" for="statuses">{{ __('Status') }}</label>

                                    <select id="statuses" class="form-select" name="status">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ $service->status == '1' ? 'selected' : '' }}>Enable
                                        </option>
                                        <option value="0" {{ $service->status == '0' ? 'selected' : '' }}>Disable
                                        </option>
                                    </select>

                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                    class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                            <button type="submit" class="btn btn-sm btn-danger" form="superadminForm"><i
                                    class="mdi mdi-database me-1"></i>Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div> <!-- container -->
@endsection
