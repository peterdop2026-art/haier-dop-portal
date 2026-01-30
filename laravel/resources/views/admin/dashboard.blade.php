@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Admin Dashboard</h4>
    </div>

    <!-- <style>
        /* Allow table cells to wrap and break long words */
        #requests-table th, #requests-table td { white-space: normal; word-break: break-word; }
        /* Make submitted-by column narrower and wrap text */
        #requests-table td.submitted-by { max-width: 220px; }
        /* Keep action controls on one line */
        #requests-table td.actions { white-space: nowrap; }
        /* Align cell contents to top for better multi-line rows */
        #requests-table td, #requests-table th { vertical-align: top; }
        /* Small visual tweaks */
        #requests-table th { background:#f5f7fa; }
    </style> -->
        @if($requests->isEmpty())
            <p class="text-muted mb-0">No requests found.</p>
        @else
            <div class="table-responsive">
                <table id="requests-table" class="table table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Work Order</th>
                            <th>Serial</th>
                            <th>Current DOP</th>
                            <th>DOP To Update</th>
                            <th>Case Type</th>
                            <th>Requester Name</th>
                            <th>Branch</th>
                            <th>Submitted At</th>
                            <th>Status</th>
                            <th>Warranty</th>
                            <th>Requester</th>
                            <th>Invoice</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ $req->work_order }}</td>
                                <td>{{ $req->serial_number }}</td>
                                <td>{{ optional($req->current_dop)->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ optional($req->dop_to_update)->format('Y-m-d') ?? '-' }}</td>
                                <td class="text-capitalize">{{ $req->case_type ?? '-' }}</td>
                                <td>{{ $req->requester_name ?? '-' }}</td>
                                <td>{{ $req->requester_branch ?? '-' }}</td>
                                <td>{{ $req->submitted_at?->format('Y-m-d H:i') ?? '-' }}</td>
                                <td>
                                    @if($req->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($req->status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $req->requester_name ?? ($req->user->requester_name ?? ($req->user->sap_id ?? '-')) }}</td>
                                <td>
                                    @if($req->warranty_card_url)
                                        @php $w = strtolower(pathinfo($req->warranty_card_url, PATHINFO_EXTENSION)); @endphp
                                        @if(in_array($w, ['jpg','jpeg','png','gif']))
                                            <img src="{{ $req->warranty_card_url }}" class="img-thumbnail" style="max-width:140px; max-height:90px; object-fit:cover;" alt="warranty">
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
                                            <img src="{{ $req->invoice_url }}" class="img-thumbnail" style="max-width:140px; max-height:90px; object-fit:cover;" alt="invoice">
                                            <div class="mt-1"><a href="{{ $req->invoice_url }}" target="_blank">Open</a></div>
                                        @else
                                            <a href="{{ $req->invoice_url }}" target="_blank">View File</a>
                                        @endif
                                    @endif
                                </td>
                                <td class="actions">
                                    <form method="POST" action="{{ route('admin.requests.status', $req->id) }}" class="d-flex gap-1">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="pending" @selected($req->status==='pending')>Pending</option>
                                            <option value="approved" @selected($req->status==='approved')>Approved</option>
                                            <option value="rejected" @selected($req->status==='rejected')>Rejected</option>
                                        </select>
                                        <button class="btn btn-sm btn-primary">Save</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#requests-table').length) {
            $('#requests-table').DataTable({
                pageLength: 10,
                order: [[0, 'desc']],
                responsive: true,
                columnDefs: [ { orderable: false, targets: -1 } ]
            });
        }
    });
</script>
@endpush
@endsection
