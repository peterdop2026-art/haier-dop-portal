<?php

namespace App\Http\Controllers;

use App\Models\DopRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RequestController extends Controller
{
    public function showForm()
    {
        return view('requests.form');
    }

    public function submit(Request $request)
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

        $user = Auth::guard('web')->user();
        $admin = Auth::guard('admin')->user();

        $warrantyPath = $request->file('warrantyCard')->store('uploads', 'public');
        $invoicePath = $request->file('invoice')->store('uploads', 'public');

        $dop = DopRequest::create([
            'user_id' => $user?->id,
            'admin_id' => $admin?->id,
            'work_order' => $request->work_order,
            'requester_name' => $request->requester_name,
            'requester_branch' => $request->requester_branch,
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

        return back()->with('success', 'Request submitted successfully.');
    }
}
