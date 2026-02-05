<?php

use App\Http\Controllers\AdminActionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
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

Route::prefix('dashboard/admin/users')
    ->middleware('role:admin')
    ->name('admin.users.')
    ->group(function () {
        Route::get('/teachers', [AdminUserController::class, 'teachers'])->name('teachers.index');
        Route::get('/teachers/create', [AdminUserController::class, 'createTeacher'])->name('teachers.create');
        Route::post('/teachers', [AdminUserController::class, 'storeTeacher'])->name('teachers.store');
        Route::get('/teachers/{user}/created', [AdminUserController::class, 'createdTeacher'])->name('teachers.created');
        Route::get('/students', [AdminUserController::class, 'students'])->name('students.index');
        Route::get('/students/create', [AdminUserController::class, 'createStudent'])->name('students.create');
        Route::post('/students', [AdminUserController::class, 'storeStudent'])->name('students.store');
        Route::get('/students/{user}/created', [AdminUserController::class, 'createdStudent'])->name('students.created');
        Route::post('/users/{user}/toggle', [AdminUserController::class, 'toggleStatus'])->name('toggle');
        Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('reset');
        Route::get('/users/{user}/password-reset', [AdminUserController::class, 'showPasswordReset'])->name('password-reset');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('delete');
    });

Route::view('/dashboard/teacher', 'dashboards.teacher')
    ->middleware('role:teacher')
    ->name('dashboard.teacher');

Route::view('/dashboard/student', 'dashboards.student')
    ->middleware('role:student')
    ->name('dashboard.student');

