<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('administrator.merchants.delivery-orders', $merchant->slug) }}">
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
                            <label for="completion_date">Completed At</label>
                            <input type="date" class="form-control form-control-sm" id="completion_date"
                                name="completion_date" value="{{ $filter['completion_date'] }}">
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
