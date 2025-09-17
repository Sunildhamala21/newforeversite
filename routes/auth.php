<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Front\UserDashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login');
    // Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('auth.login');
    Route::view('register', 'auth.register')->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('auth.register');

    // Social
    Route::get('/auth/google/redirect', function () {
        return Socialite::driver('google')->redirect();
    })->name('auth.google.redirect');

    Route::get('/auth/google/callback', function () {
        $user = Socialite::driver('google')->user();
        $user = User::updateOrCreate([
            'email' => $user->email,
        ], [
            'google_id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar
        ]);

        Auth::login($user);

        return to_route('user.dashboard');
    })->name('auth.google.callback');

    Route::get('/auth/facebook/redirect', function () {
        return Socialite::driver('facebook')->redirect();
    })->name('auth.facebook.redirect');

    Route::get('/auth/facebook/callback', function () {
        $user = Socialite::driver('facebook')->user();
        $user = User::updateOrCreate([
            'email' => $user->email,
        ], [
            'facebook_id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar
        ]);

        Auth::login($user);

        return to_route('user.dashboard');
    })->name('auth.facebook.callback');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', UserDashboardController::class)->name('user.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    //     ->name('password.confirm');

    // Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});