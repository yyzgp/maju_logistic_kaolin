<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('administrator.invoices.index') }}">
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="invoice_no">Invoice No.</label>
                            <input type="text" class="form-control form-control-sm" id="invoice_no" name="invoice_no"
                                value="{{ $filter['invoice_no'] }}">
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
                            <label for="invoice_from">Invoice From</label>
                            <input type="date" class="form-control form-control-sm" id="invoice_from"
                                name="invoice_from" value="{{ $filter['invoice_from'] }}">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="invoice_upto">Invoice Upto</label>
                            <input type="date" class="form-control form-control-sm" id="invoice_upto"
                                name="invoice_upto" value="{{ $filter['invoice_upto'] }}">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="created_at">Created At</label>
                            <input type="date" class="form-control form-control-sm" id="created_at" name="created_at"
                                value="{{ $filter['created_at'] }}">
                        </div>
                        <div class="col-sm-9 mb-2 text-end">
                            <button type="submit" class="btn btn-sm btn-secondary"
                                style="margin-top:22px;">Filter</button>
                            <a href="{{ route('administrator.invoices.index') }}" class="btn btn-sm btn-dark ms-1"
                                style="margin-top:22px;">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
