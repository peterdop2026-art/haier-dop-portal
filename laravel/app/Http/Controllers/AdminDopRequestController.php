<?php

namespace App\Http\Controllers;

use App\Models\AdminDopRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminDopRequestController extends Controller
{
    public function showForm()
    {
        return view('admin.adminform');
    }

    public function store(Request $request)
    {
        $request->validate([
            'work_order' => ['required', 'string'],
            'requester_name' => ['nullable', 'string', 'max:255'],
            'requester_branch' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['required', 'string'],
            'current_dop' => ['required', 'date'],
            'dop_to_update' => ['required', 'date'],
            'reason' => ['required', 'string'],
            'case_type' => ['required', 'in:customer,dealer'],
            'warrantyCard' => ['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
            'invoice' => ['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
        ]);

        $admin = Auth::guard('admin')->user();

        $warrantyPath = $request->file('warrantyCard')->store('uploads', 'public');
        $invoicePath = $request->file('invoice')->store('uploads', 'public');

        AdminDopRequest::create([
            'admin_id' => $admin?->id,
            'work_order' => $request->work_order,
            'current_dop' => $request->current_dop,
            'dop_to_update' => $request->dop_to_update,
            'serial_number' => $request->serial_number,
            'reason' => $request->reason,
            'case_type' => $request->case_type,
            'warranty_card_url' => '/storage/' . $warrantyPath,
            'invoice_url' => '/storage/' . $invoicePath,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Admin request submitted successfully.');
    }

    public function myRequests()
    {
        $admin = Auth::guard('admin')->user();
        $requests = AdminDopRequest::where('admin_id', $admin->id)
            ->orderByDesc('submitted_at')
            ->get();

        return view('admin.requests.my', [
            'requests' => $requests,
        ]);
    }
}
