@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-bold">My Admin Requests</div>
            <div class="card-body">
                @if($requests->isEmpty())
                    <div class="alert alert-info">You have not submitted any admin requests yet.</div>
                @else
                    <table id="admin-my-requests-table" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Work Order</th>
                                <th>Serial</th>
                                <th>Case Type</th>
                                <th>Status</th>
                                <th>Submitted At</th>
                                <th>Files</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $r)
                                <tr>
                                    <td>{{ $r->work_order }}</td>
                                    <td>{{ $r->serial_number }}</td>
                                    <td>{{ ucfirst($r->case_type) }}</td>
                                    <td>{{ ucfirst($r->status) }}</td>
                                    <td>{{ $r->submitted_at }}</td>
                                    <td>
                                        @if($r->warranty_card_url)
                                            @php $w = strtolower(pathinfo($r->warranty_card_url, PATHINFO_EXTENSION)); @endphp
                                            @if(in_array($w, ['jpg','jpeg','png','gif']))
                                                <img src="{{ $r->warranty_card_url }}" class="img-thumbnail" style="max-width:120px; max-height:80px; object-fit:cover;" alt="warranty">
                                                <div class="mt-1"><a href="{{ $r->warranty_card_url }}" target="_blank">Open</a></div>
                                            @else
                                                <a href="{{ $r->warranty_card_url }}" target="_blank">View File</a>
                                            @endif
                                        @endif
                                        @if($r->invoice_url)
                                            @php $i = strtolower(pathinfo($r->invoice_url, PATHINFO_EXTENSION)); @endphp
                                            @if(in_array($i, ['jpg','jpeg','png','gif']))
                                                <img src="{{ $r->invoice_url }}" class="img-thumbnail" style="max-width:120px; max-height:80px; object-fit:cover;" alt="invoice">
                                                <div class="mt-1"><a href="{{ $r->invoice_url }}" target="_blank">Open</a></div>
                                            @else
                                                &nbsp;|&nbsp;<a href="{{ $r->invoice_url }}" target="_blank">View File</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#admin-my-requests-table').length) {
            $('#admin-my-requests-table').DataTable({
                pageLength: 10,
                order: [[0, 'desc']],
                responsive: true,
                columnDefs: [ { orderable: false, targets: -1 } ]
            });
        }
    });
</script>
@endpush
