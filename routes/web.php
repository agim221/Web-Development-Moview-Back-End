<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\MailController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';

Route::get('auth/google', [SocialAuthController::class, 'googleRedirect']);
Route::get('auth/google/callback', [SocialAuthController::class, 'handleProviderCallback']);

Route::post('send-mail', [MailController::class, 'sendVerificationEmail']);