<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('administrator.services.index') }}">
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="service">Service</label>
                            <select name="service" id="service" class="form-select form-control-sm select2"
                                data-toggle="select2" data-placeholder="All">
                                <option value=""></option>
                                @foreach ($all_services as $service)
                                    <option value="{{ $service->id }}"
                                        {{ $filter['service'] == $service->id ? 'selected' : '' }}>{{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="merchant">Merchant</label>
                            <select name="merchant" id="merchant" class="form-select form-control-sm select2"
                                data-toggle="select2" data-placeholder="All">
                                <option value=""></option>
                                @foreach ($merchants as $merchant)
                                    <option value="{{ $merchant->id }}"
                                        {{ $filter['merchant'] == $merchant->id ? 'selected' : '' }}>
                                        {{ $merchant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-select form-control-sm select2"
                                data-toggle="select2" data-placeholder="All">
                                <option value="">All</option>
                                <option value="Towing" {{ $filter['type'] == 'Towing' ? 'selected' : '' }}>Towing
                                </option>
                                <option value="Battery/Tyre" {{ $filter['type'] == 'Battery/Tyre' ? 'selected' : '' }}>
                                    Battery/Tyre</option>
                            </select>
                        </div>

                        <div class="col-sm-3 mb-2">
                            <label for="status">Status</label>
                            <select name="status" id="statuses" class="form-select form-control-sm">
                                <option value=""></option>
                                <option value="Yes" {{ $filter['status'] == 'Yes' ? 'selected' : '' }}>Enabled
                                </option>
                                <option value="No" {{ $filter['status'] == 'No' ? 'selected' : '' }}>Disabled
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-12 text-end">
                            <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
                            <a href="{{ route('administrator.services.index') }}"
                                class="btn btn-sm btn-dark ms-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
