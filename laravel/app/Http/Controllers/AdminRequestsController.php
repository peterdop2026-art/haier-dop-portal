<?php

namespace App\Http\Controllers;

use App\Models\DopRequest;
use Illuminate\Http\Request;

class AdminRequestsController extends Controller
{
    public function index()
    {
        // Only show requests submitted by users (not admin-submitted requests)
        $requests = DopRequest::with(['user', 'admin'])
            ->whereNotNull('user_id')
            ->orderByDesc('submitted_at')
            ->get();

        return view('admin.dashboard', [
            'requests' => $requests,
        ]);
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $dop = DopRequest::findOrFail($id);
        $dop->status = $request->status;
        $dop->save();

        return back()->with('success', 'Status updated');
    }
}
