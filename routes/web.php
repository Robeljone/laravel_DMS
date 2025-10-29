<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DMSController;

Route::get('/login', [DMSController::class, 'login'])->name('index');
Route::get('/dashboard', [DMSController::class, 'dashboard']);
Route::get('/users', [DMSController::class, 'users_pg']);
Route::get('/roles_perm', [DMSController::class, 'roles_perm']);
Route::get('/folders', [DMSController::class, 'index']);
Route::post('/login', [DMSController::class, 'login_user'])->name('login-page');

Route::post('/newFolder', [DMSController::class, 'new_folder'])->name('newFolder');
Route::post('/newFile', [DMSController::class, 'new_file'])->name('newFile');
Route::post('/newUser', [DMSController::class, 'new_user'])->name('newUser');

Route::get('/dms', [DMSController::class, 'index'])->name('index');
Route::get('/dms/{dir?}', [DMSController::class, 'show'])
    ->where('dir', '.*') // allows subdirectories
    ->name('show');
