<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // User login
    public function showUserLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.form');
        }
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'sap_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('web')->attempt(['sap_id' => $request->sap_id, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();
            if ($request->expectsJson()) {
                return response()->json(['user' => $user]);
            }
            return redirect()->intended('/form');
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return back()->withErrors(['sap_id' => 'Invalid credentials'])->withInput();
    }

    // User signup (simple)
    public function showSignup()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'sap_id' => ['required', 'string', 'max:255', 'unique:users,sap_id'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'sap_id' => $request->sap_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Do not auto-login after signup. Require explicit login for security.
        if ($request->expectsJson()) {
            return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
        }

        return redirect()->route('login')->with('success', 'Account created. Please login with your credentials.');
    }

    public function userLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Admin login
    public function showAdminLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.admin_login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $admin = Auth::guard('admin')->user();
            if ($request->expectsJson()) {
                return response()->json(['user' => $admin]);
            }
            return redirect()->intended('/admin/dashboard');
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    // Password reset by SAP ID (no email verification)
    public function showPasswordReset()
    {
        return view('auth.password_reset');
    }

    public function passwordReset(Request $request)
    {
        $request->validate([
            'sap_id' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::where('sap_id', $request->sap_id)->where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'The email does not match the provided SAP ID. Check your SAP ID and email.'])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password updated. You can now login.');
    }
}
