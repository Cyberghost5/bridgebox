<?php

use App\Http\Controllers\AdminActionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('landing');

Route::get('/login/{role}', [AuthController::class, 'showLogin'])
    ->whereIn('role', ['admin', 'teacher', 'student'])
    ->name('login');

Route::post('/login/{role}', [AuthController::class, 'login'])
    ->whereIn('role', ['admin', 'teacher', 'student'])
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])
    ->middleware('role:admin')
    ->name('dashboard.admin');

Route::get('/dashboard/admin/status', [AdminDashboardController::class, 'status'])
    ->middleware('role:admin')
    ->name('dashboard.admin.status');

Route::post('/dashboard/admin/actions/{action}', [AdminActionController::class, 'run'])
    ->middleware('role:admin')
    ->name('dashboard.admin.actions');

Route::view('/dashboard/teacher', 'dashboards.teacher')
    ->middleware('role:teacher')
    ->name('dashboard.teacher');

Route::view('/dashboard/student', 'dashboards.student')
    ->middleware('role:student')
    ->name('dashboard.student');

