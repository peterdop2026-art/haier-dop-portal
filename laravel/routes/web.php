<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\MyRequestsController;
use App\Http\Controllers\AdminRequestsController;

// Guest routes
// Provide a named 'home' route so RedirectIfAuthenticated has a safe target
Route::get('/home', function () {
    return redirect()->route('user.form');
})->name('home');

// Quick debug route to verify admin login endpoint is reachable (bypasses auth middleware)
Route::get('/admin/login-debug', function () {
    return response('ADMIN LOGIN PAGE', 200)->header('Content-Type', 'text/plain');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showUserLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showUserLogin']);
    Route::post('/login', [AuthController::class, 'userLogin'])->name('login.post');

    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');

    // Password reset by SAP ID (no email required)
    Route::get('/password-reset', [AuthController::class, 'showPasswordReset'])->name('password.reset');
    Route::post('/password-reset', [AuthController::class, 'passwordReset'])->name('password.reset.post');
});

// Admin login routes should use the admin guard only so an authenticated user
// (web guard) doesn't block access to the admin login page. Use `guest:admin`.
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
});

// User routes
Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [AuthController::class, 'userLogout'])->name('logout');
    Route::get('/form', [RequestController::class, 'showForm'])->name('user.form');
    Route::post('/form', [RequestController::class, 'submit'])->name('user.form.submit');
    Route::get('/my-requests', [MyRequestsController::class, 'userIndex'])->name('user.requests');
});

// Admin routes
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');
    // Admin-specific request pages now handled by AdminDopRequestController
    Route::get('/form', [\App\Http\Controllers\AdminDopRequestController::class, 'showForm'])->name('admin.form');
    Route::post('/form', [\App\Http\Controllers\AdminDopRequestController::class, 'store'])->name('admin.form.submit');
    Route::get('/my-requests', [\App\Http\Controllers\AdminDopRequestController::class, 'myRequests'])->name('admin.requests.mine');
    Route::get('/dashboard', [AdminRequestsController::class, 'index'])->name('admin.dashboard');
    Route::post('/requests/{id}/status', [AdminRequestsController::class, 'updateStatus'])->name('admin.requests.status');
});
