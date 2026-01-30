@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header fw-bold">
        My Requests ({{ $isAdmin ? 'Admin' : 'User' }})
    </div>
    <div class="card-body">
        @if($requests->isEmpty())
        <p class="text-muted mb-0">No requests found.</p>
        @else
        <div class="table-responsive">
            <table id="my-requests-table" class="table table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Work Order</th>
                        <th>Serial</th>
                        <th>Current DOP</th>
                        <th>DOP To Update</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Warranty</th>
                        <th>Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                    <tr>
                        <td>{{ $req->id }}</td>
                        <td>{{ $req->work_order }}</td>
                        <td>{{ $req->serial_number }}</td>
                        <td>{{ $req->current_dop?->format('Y-m-d') }}</td>
                        <td>{{ $req->dop_to_update?->format('Y-m-d') }}</td>
                        <!-- <td class="text-capitalize">{{ $req->status }}</td> -->
                        <td>
                            @if($req->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                            @elseif($req->status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                            @else
                            <span class="badge bg-secondary">Pending</span>
                            @endif
                        <td>{{ $req->submitted_at?->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($req->warranty_card_url)
                                @php $w = strtolower(pathinfo($req->warranty_card_url, PATHINFO_EXTENSION)); @endphp
                                @if(in_array($w, ['jpg','jpeg','png','gif']))
                                    <img src="{{ $req->warranty_card_url }}" class="img-thumbnail" style="max-width:120px; max-height:80px; object-fit:cover;" alt="warranty">
                                    <div class="mt-1"><a href="{{ $req->warranty_card_url }}" target="_blank">Open</a></div>
                                @else
                                    <a href="{{ $req->warranty_card_url }}" target="_blank">View File</a>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($req->invoice_url)
                                @php $i = strtolower(pathinfo($req->invoice_url, PATHINFO_EXTENSION)); @endphp
                                @if(in_array($i, ['jpg','jpeg','png','gif']))
                                    <img src="{{ $req->invoice_url }}" class="img-thumbnail" style="max-width:120px; max-height:80px; object-fit:cover;" alt="invoice">
                                    <div class="mt-1"><a href="{{ $req->invoice_url }}" target="_blank">Open</a></div>
                                @else
                                    <a href="{{ $req->invoice_url }}" target="_blank">View File</a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
<div class="mt-3">
    <a href="{{ route('user.form') }}" class="btn btn-outline-dark btn-sm me-5">
        Back to Request Form
    </a>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#my-requests-table').length) {
            $('#my-requests-table').DataTable({
                pageLength: 10,
                order: [[0, 'desc']],
                responsive: true,
                columnDefs: [ { orderable: false, targets: -1 } ]
            });
        }
    });
</script>
@endpush