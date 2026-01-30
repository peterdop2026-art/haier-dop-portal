@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Admin Login</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="e.g. admin@haier.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input id="admin_password" type="password" name="password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#admin_password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100">Login</button>

                </form>
            </div>
        </div>
    </div>
@endsection
