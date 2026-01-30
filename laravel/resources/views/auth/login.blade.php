@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">User Login</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">SAP ID</label>
                        <input type="text" name="sap_id" value="{{ old('sap_id') }}" class="form-control" placeholder="e.g. 23456789" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input id="login_password" type="password" name="password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#login_password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100">Login</button>
                    <div class="mt-3 text-center">
                        <a href="{{ route('signup') }}">Need an account? Sign up</a>
                    </div>
                    <div class="mt-2 text-center">
                        <a href="{{ route('password.reset') }}">Forgot password?</a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection
