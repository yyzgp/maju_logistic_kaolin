<div class="card">
    <div class="card-body">
        <form action="{{ route('administrator.calendar-management.index') }}">
            <div class="row">
                <div class="col-sm-3 mb-2">
                    <label for="merchant">Workshop</label>
                    <select name="merchant" id="merchant" class="form-select form-control-sm select2" data-toggle="select2"
                        data-placeholder="All">
                        <option></option>
                        @foreach ($merchants as $merchant)
                            <option value="{{ $merchant->id }}"
                                {{ $filter['merchant'] == $merchant->id ? 'selected' : '' }}>
                                {{ $merchant->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3 mb-2">
                    <label for="driver">Driver</label>
                    <select name="driver" id="driver" class="form-select form-control-sm select2"
                        data-toggle="select2" data-placeholder="All">
                        <option></option>
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->id }}"
                                {{ $filter['driver'] == $driver->id ? 'selected' : '' }}>
                                {{ $driver->firstname }} {{ $driver->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="col-sm-3 mb-2">
                    <label for="name">Status</label>
                    <select name="status" id="statuses" class="form-select form-control-sm">
                        <option value="">All</option>
                        <option value="active" {{ $filter['status'] == 'active' ? 'selected' : '' }}>Active
                        </option>
                        <option value="completed" {{ $filter['status'] == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="failed" {{ $filter['status'] == 'failed' ? 'selected' : '' }}>Failed
                        </option>
                        <option value="cancelled" {{ $filter['status'] == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div> --}}
                <div class="col-sm-3 mb-2 text-end">
                    <button type="submit" class="btn btn-sm btn-secondary" style="margin-top:22px;">Filter</button>
                    <a href="{{ route('administrator.calendar-management.index') }}" class="btn btn-sm btn-dark ms-1"
                        style="margin-top:22px;">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>
