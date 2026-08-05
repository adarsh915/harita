<?php

use Illuminate\Support\Facades\Route;

// Landing Pages
Route::get('/', function () { return view('landing.index'); });
Route::get('/privacy', function () { return view('landing.privacy'); });

// Auth Pages
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('password.request');

// Admin Pages
Route::prefix('admin')->group(function () {
    Route::get('/', function () { return view('admin.dashboard'); });
    Route::get('/{page}', function ($page) { 
        if (view()->exists("admin.$page")) {
            return view("admin.$page");
        }
        abort(404);
    });
});

// Student Pages
Route::prefix('student')->group(function () {
    Route::get('/', function () { return view('student.dashboard'); });
    Route::get('/{page}', function ($page) { 
        if (view()->exists("student.$page")) {
            return view("student.$page");
        }
        abort(404);
    });
});

// Teacher Pages
Route::prefix('teacher')->group(function () {
    Route::get('/', function () { return view('teacher.dashboard'); });
    Route::get('/{page}', function ($page) { 
        if (view()->exists("teacher.$page")) {
            return view("teacher.$page");
        }
        abort(404);
    });
});
