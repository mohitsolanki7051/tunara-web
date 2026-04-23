<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TunnelController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PlanSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ContactAdminController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/pricing', [LandingController::class, 'pricing'])->name('pricing');
Route::get('/download', [LandingController::class, 'download'])->name('download');
Route::post('/review/submit', [ReviewController::class, 'submit'])->name('review.submit');
Route::get('/about',   [LandingController::class, 'about'])->name('about');
Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
Route::get('/privacy', [LandingController::class, 'privacy'])->name('privacy');
Route::get('/terms',   [LandingController::class, 'terms'])->name('terms');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
// User Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// User Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/tunnel/register', [TunnelController::class, 'register'])->name('tunnel.register');
    Route::delete('/tunnel/{id}', [TunnelController::class, 'destroy'])->name('tunnel.destroy');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->middleware('auth')->name('analytics');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/token', [SettingsController::class, 'regenerateToken'])->name('settings.token');
    Route::delete('/settings/account', [SettingsController::class, 'deleteAccount'])->name('settings.delete');
});

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::patch('/users/{id}/plan', [UserController::class, 'updatePlan'])->name('users.plan');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/settings', [PlanSettingController::class, 'index'])->name('settings');
        Route::post('/settings', [PlanSettingController::class, 'update'])->name('settings.update');
        Route::get('/reviews', [ReviewAdminController::class, 'index'])->name('reviews');
        Route::post('/reviews/{id}/approve', [ReviewAdminController::class, 'approve'])->name('reviews.approve');
        Route::post('/reviews/{id}/reject', [ReviewAdminController::class, 'reject'])->name('reviews.reject');
        Route::post('/reviews/{id}/toggle-landing', [ReviewAdminController::class, 'toggleLanding'])->name('reviews.toggle');
        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{slug}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::post('/pages/{slug}', [PageController::class, 'update'])->name('pages.update');
        Route::get('/contacts', [ContactAdminController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{id}', [ContactAdminController::class, 'show'])->name('contacts.show');
        Route::delete('/contacts/{id}', [ContactAdminController::class, 'destroy'])->name('contacts.destroy');
    });
});
