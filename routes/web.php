<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');

Route::get('/tours/{slug}/book', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{id}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::post('/bookings/{id}/payment', [BookingController::class, 'processPayment'])->name('bookings.payment');
    Route::get('/bookings/{id}/transactions', [BookingController::class, 'transactionHistory'])->name('bookings.transactions');
    Route::patch('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        
        Route::get('/banner', [AdminController::class, 'editBanner'])->name('banner');
        Route::post('/banner', [AdminController::class, 'updateBanner'])->name('banner.update');
        
        Route::get('/content', [AdminController::class, 'editContent'])->name('content');
        Route::post('/content', [AdminController::class, 'updateContent'])->name('content.update');
        
        Route::get('/tours-banner', [AdminController::class, 'editToursBanner'])->name('tours.banner');
        Route::post('/tours-banner', [AdminController::class, 'updateToursBanner'])->name('tours.banner.update');
        
        Route::get('/tours', [AdminController::class, 'tours'])->name('tours');
        Route::get('/tours/create', [AdminController::class, 'createTour'])->name('tours.create');
        Route::post('/tours', [AdminController::class, 'storeTour'])->name('tours.store');
        Route::get('/tours/{id}/edit', [AdminController::class, 'editTour'])->name('tours.edit');
        Route::put('/tours/{id}', [AdminController::class, 'updateTour'])->name('tours.update');
        Route::delete('/tours/{id}', [AdminController::class, 'destroyTour'])->name('tours.destroy');
        
        Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
        Route::get('/bookings/{id}', [AdminController::class, 'showBooking'])->name('bookings.show');
        Route::get('/bookings/{id}/edit', [AdminController::class, 'editBooking'])->name('bookings.edit');
        Route::get('/bookings/{id}/transactions', [AdminController::class, 'transactionHistory'])->name('bookings.transactions');
        Route::put('/bookings/{id}', [AdminController::class, 'updateBooking'])->name('bookings.update');
        Route::post('/bookings/{id}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.status');
        Route::post('/bookings/{id}/payment', [AdminController::class, 'updatePaymentStatus'])->name('bookings.payment');
        Route::post('/bookings/{id}/refund', [AdminController::class, 'processRefund'])->name('bookings.refund');
        Route::post('/bookings/{id}/assign-guide', [AdminController::class, 'assignGuide'])->name('bookings.assign-guide');
        Route::delete('/bookings/{id}', [AdminController::class, 'destroyBooking'])->name('bookings.destroy');
        
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings/{id}', [AdminController::class, 'updateSetting'])->name('settings.update');
    });
});
