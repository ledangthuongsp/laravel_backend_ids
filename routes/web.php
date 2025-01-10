<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\App;  // Add this line to import the App facade
Route::get('/', function () {
    return inertia('HomePage');
});

Auth::routes();
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi'])) {
        App::setLocale($locale);
    }
    return redirect()->back();
});

Route::get('/home', [HomeController::class, 'index'])->name('home');


