@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">
                Submit DOP Update Request (Admin)
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.form.submit') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Work Order (Complain #)</label>
                            <input type="text" name="work_order" class="form-control" value="{{ old('work_order') }}" placeholder="PCPKLC2026XXXXXXXXXX" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Serial Number</label>
                            <input type="text" name="serial_number" class="form-control" value="{{ old('serial_number') }}" placeholder="BL044FE0001XXXXXXXXXX" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Current DOP</label>
                            <input type="date" name="current_dop" class="form-control" value="{{ old('current_dop') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">DOP to Update</label>
                            <input type="date" name="dop_to_update" class="form-control" value="{{ old('dop_to_update') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Case Type</label>
                            <select name="case_type" class="form-select" required>
                                <option value="customer" @selected(old('case_type')==='customer')>Customer</option>
                                <option value="dealer" @selected(old('case_type')==='dealer')>Dealer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Requester Name</label>
                            <input type="text" name="requester_name" class="form-control" value="{{ old('requester_name') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Requester Branch</label>
                            <input type="text" name="requester_branch" class="form-control" value="{{ old('requester_branch') }}" placeholder="i.e LHR-Num">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Reason to Update</label>
                            <textarea name="reason" class="form-control" rows="3" required>{{ old('reason') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Warranty Card (image/pdf)</label>
                            <input type="file" name="warrantyCard" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Invoice (image/pdf)</label>
                            <input type="file" name="invoice" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button class="btn btn-primary">Submit Request (Admin)</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
