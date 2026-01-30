@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-4">Reset Password</h2>
        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-md">
            Back to Login
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.reset.post') }}">
        @csrf
        <div class="mb-3">
            <label for="sap_id" class="form-label">SAP ID</label>
            <input id="sap_id" type="text" class="form-control" name="sap_id" value="{{ old('sap_id') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <div class="input-group">
                <input id="password" type="password" class="form-control" name="password" required>
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password_confirmation">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
@endsection