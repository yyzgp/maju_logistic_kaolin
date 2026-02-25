<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('administrator.tasks.index') }}">
                    <input type="hidden" name="task" value="{{ request()->get('task') }}"/>
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="name">Name</label>
                            <input type="text" class="form-control form-control-sm" id="name" name="name"
                                value="{{ $filter['name'] }}">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email"
                                value="{{ $filter['email'] }}">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone"
                                value="{{ $filter['phone'] }}">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="merchant">Workshop</label>
                            <select name="merchant" id="merchant" class="form-select form-control-sm select2"
                                data-toggle="select2" data-placeholder="All">
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
                        <div class="col-sm-3 mb-2">
                            <label for="priority">Priority</label>
                            <select name="priority" id="priority" class="form-select form-control-sm">
                                <option value="">All</option>
                                <option value="low" {{ $filter['priority'] == 'low' ? 'selected' : '' }}>Low
                                </option>
                                <option value="medium" {{ $filter['priority'] == 'medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="high" {{ $filter['priority'] == 'high' ? 'selected' : '' }}>High
                                </option>
                                <option value="urgent" {{ $filter['priority'] == 'urgent' ? 'selected' : '' }}>Urgent
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="name">Status</label>
                            <select name="status" id="statuses" class="form-select form-control-sm">
                                <option value="all">All</option>
                                <option value="unassigned" {{ $filter['status'] == 'unassigned' ? 'selected' : '' }}>
                                    Unassigned
                                </option>
                                <option value="in-transist" {{ $filter['status'] == 'in-transist' ? 'selected' : '' }}>
                                    In Transit
                                </option>

                                <option value="completed" {{ $filter['status'] == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>

                                <option value="cancelled" {{ $filter['status'] == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="created_at">Created At</label>
                            <input type="date"  value="{{ old('created_at', $filter['created_at'] ?? \Carbon\Carbon::now()->format('Y-m-d')) }}" class="form-control form-control-sm" id="created_at" name="created_at"
                                value="{{ $filter['created_at'] }}">
                        </div>
                        <div class="col-sm-12 text-end">
                            <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
                            <a href="{{ route('administrator.tasks.index') }}"
                                class="btn btn-sm btn-dark ms-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
