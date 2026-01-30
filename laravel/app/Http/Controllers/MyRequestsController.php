<?php

namespace App\Http\Controllers;

use App\Models\DopRequest;
use Illuminate\Support\Facades\Auth;

class MyRequestsController extends Controller
{
    public function userIndex()
    {
        $user = Auth::guard('web')->user();
        $requests = DopRequest::where('user_id', $user->id)
            ->orderByDesc('submitted_at')
            ->get();

        return view('requests.my', [
            'requests' => $requests,
            'isAdmin' => false,
        ]);
    }

    public function adminIndex()
    {
        $admin = Auth::guard('admin')->user();
        $requests = DopRequest::where('admin_id', $admin->id)
            ->orderByDesc('submitted_at')
            ->get();

        return view('requests.my', [
            'requests' => $requests,
            'isAdmin' => true,
        ]);
    }
}
