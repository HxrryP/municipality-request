<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrdinanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest accessible pages
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/ordinances', [OrdinanceController::class, 'index'])->name('ordinances.index');
Route::get('/ordinances/{ordinance}', [OrdinanceController::class, 'show'])->name('ordinances.show');

// Google OAuth Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Authentication Routes
require __DIR__ . '/auth.php';

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->with('success', 'Email verified successfully!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Authenticated User Routes
Route::middleware(['auth', 'verified', 'track-activity'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Services and Requests
    Route::get('/services/{service}/request', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/services/{service}/request', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/{id}', [RequestController::class, 'show'])->name('requests.show');
    Route::get('/requests/{id}/track', [RequestController::class, 'track'])->name('requests.track');
    Route::get('/requests/{id}/edit', [RequestController::class, 'edit'])->name('requests.edit');
    Route::patch('/requests/{id}', [RequestController::class, 'cancel'])->name('requests.cancel');
    Route::patch('/requests/{id}/update', [RequestController::class, 'update'])->name('requests.update');

    // Payments
    Route::get('/requests/{request}/pay', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/requests/{request}/pay', [PaymentController::class, 'process'])->name('payments.process');
    Route::get('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');
    Route::get('/payments/success', [PaymentController::class, 'success'])->name('payments.success');
    Route::get('/payments/failed', [PaymentController::class, 'failed'])->name('payments.failed');
    Route::get('/payments/check-status', [PaymentController::class, 'checkStatus'])->name('payments.check-status');
    Route::post('/payments/webhook', [PaymentController::class, 'webhook'])->name('payments.webhook')->middleware('webhook');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

// Admin Routes
Route::middleware(['auth', 'admin', 'track-activity'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');

    // Request Management
    Route::get('/requests', [App\Http\Controllers\Admin\RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/{request}', [App\Http\Controllers\Admin\RequestController::class, 'show'])->name('requests.show');
    Route::post('/requests/{request}/update-status', [App\Http\Controllers\Admin\RequestController::class, 'updateStatus'])->name('requests.update-status');
    Route::post('/requests/{request}/require-payment', [App\Http\Controllers\RequestController::class, 'requirePayment'])->name('requests.require-payment');

    // Payment Management
    Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/verify', [App\Http\Controllers\Admin\PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('/requests/{request}/waive-payment', [App\Http\Controllers\Admin\PaymentController::class, 'waive'])->name('payments.waive');
    Route::get('/payments/recover', [App\Http\Controllers\Admin\PaymentController::class, 'recoverPayment'])->name('payments.recover');

    // Service Management
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('service-categories', App\Http\Controllers\Admin\ServiceCategoryController::class);

    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);

    // Ordinance Management
    Route::resource('ordinances', App\Http\Controllers\Admin\OrdinanceController::class);
    Route::resource('ordinance-categories', App\Http\Controllers\Admin\OrdinanceCategoryController::class);

    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/requests', [App\Http\Controllers\Admin\ReportController::class, 'requests'])->name('reports.requests');
    Route::get('/reports/payments', [App\Http\Controllers\Admin\ReportController::class, 'payments'])->name('reports.payments');
    Route::get('/reports/users', [App\Http\Controllers\Admin\ReportController::class, 'users'])->name('reports.users');
    Route::get('/reports/export/{type}', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');

    // Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store');
    Route::get('/notifications/unread', [App\Http\Controllers\Admin\NotificationController::class, 'getUnread'])->name('notifications.unread');

    // Search
    Route::get('/search', [App\Http\Controllers\Admin\SearchController::class, 'search'])->name('search');
});
