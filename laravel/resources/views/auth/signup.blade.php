@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">User Signup</div>
            <div class="card-body">
                <form method="POST" action="{{ route('signup.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">SAP ID</label>
                        <input type="text" name="sap_id" value="{{ old('sap_id') }}" class="form-control" placeholder="e.g. 23456789" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="user@company.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input id="signup_password" type="password" name="password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#signup_password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input id="signup_password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#signup_password_confirmation">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100">Sign Up</button>
                    <div class="mt-2 text-center">
                        <a href="{{ route('login') }}">Already have an account? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
