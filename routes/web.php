<?php

use App\Exports\ActivityExport;
use App\Exports\ItemsExport;
use App\Exports\LoanExport;
use App\Exports\ReturnExport;
use App\Exports\UsersExport;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->user()) {
        return redirect('dashboard');
    }
    return redirect('auth/login');
});

Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
    Route::get('forgot-password-email', [AuthController::class, 'forgotPasswordEmail'])->name('forgot-password-email');
    Route::post('forgot-password-email', [AuthController::class, 'forgotPasswordEmailPost'])->name('forgot-password-email.post');
    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [AuthController::class, 'forgotPasswordPost'])->name('forgot-password.post');
});

Route::middleware(['auth', 'user.access:admin'])->group(function () {
    Route::get('dashboard/users', [AdminController::class, 'users'])->name('dashboard.users');
    Route::get('dashboard/users/add', [AdminController::class, 'usersAdd'])->name('dashboard.users.add');
    Route::post('dashboard/users/add', [AdminController::class, 'usersPostUpdate'])->name('dashboard.users.add.post.update');
    Route::get('dashboard/users/update/{id}', [AdminController::class, 'usersUpdate'])->name('dashboard.users.update');
    Route::delete('dashboard/users/delete/{id}', [AdminController::class, 'usersDelete'])->name('dashboard.users.delete');
    Route::get('dashboard/users/export', [UsersExport::class, 'export'])->name('dashboard.users.export');
    Route::get('dashboard/items/add', [AdminController::class, 'itemsAdd'])->name('dashboard.items.add');
    Route::post('dashboard/items/add', [AdminController::class, 'itemsPostUpdate'])->name('dashboard.items.add.post.update');
    Route::get('dashboard/items/update/{id}', [AdminController::class, 'itemsUpdate'])->name('dashboard.items.update');
    Route::delete('dashboard/items/delete/{id}', [AdminController::class, 'itemsDelete'])->name('dashboard.items.delete');
    Route::get('dashboard/items/export', [ItemsExport::class, 'export'])->name('dashboard.items.export');
});


Route::middleware(['auth', 'user.access:user'])->group(function () {
    Route::get('dashboard/loan', [UserController::class, 'loan'])->name('dashboard.loan');
    Route::get('dashboard/loan/add', [UserController::class, 'loanAdd'])->name('dashboard.loan.add');
    Route::post('dashboard/loan/add', [UserController::class, 'loanPostUpdate'])->name('dashboard.loan.add.post.update');
    Route::get('dashboard/loan/export', [LoanExport::class, 'export'])->name('dashboard.loan.export');
    Route::get('dashboard/return', [UserController::class, 'return'])->name('dashboard.return');
    Route::get('dashboard/return/add', [UserController::class, 'returnAdd'])->name('dashboard.return.add');
    Route::post('dashboard/return/add', [UserController::class, 'returnPostUpdate'])->name('dashboard.return.add.post.update');
    Route::get('dashboard/return/export', [ReturnExport::class, 'export'])->name('dashboard.return.export');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/profile', [HomeController::class, 'profile'])->name('dashboard.profile');
    Route::post('dashboard/profile', [HomeController::class, 'profilePostUpdate'])->name('dashboard.profile.post.update');
    Route::post('dashboard/profile/password', [HomeController::class, 'profilePasswordPostUpdate'])->name('dashboard.profile.password.post.update');
    Route::get('dashboard/items', [HomeController::class, 'items'])->name('dashboard.items');
    Route::get('dashboard/activities', [HomeController::class, 'activities'])->name('dashboard.activities');
    Route::get('dashboard/activities/export', [ActivityExport::class, 'export'])->name('dashboard.activities.export');
});
