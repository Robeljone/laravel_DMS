<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DMSController;

Route::get('/login', [DMSController::class, 'login'])->name('index');
Route::get('/dashboard', [DMSController::class, 'dashboard'])->middleware('checkAuth');
Route::get('/users', [DMSController::class, 'users_pg'])->middleware('checkAuth');
Route::get('/roles_perm', [DMSController::class, 'roles_perm'])->middleware('checkAuth');
Route::get('/folders', [DMSController::class, 'index'])->middleware('checkAuth');
Route::post('/login', [DMSController::class, 'login_user'])->name('login-page');
Route::get('/logout', [DMSController::class, 'logout_user'])->name('logout-page');

Route::post('/newFolder', [DMSController::class, 'new_folder'])->middleware('checkAuth')->name('newFolder');
Route::post('/newFile', [DMSController::class, 'new_file'])->middleware('checkAuth')->name('newFile');
Route::post('/newUser', [DMSController::class, 'new_user'])->middleware('checkAuth')->name('newUser');
Route::post('/updateAccess', [DMSController::class, 'update_access'])->middleware('checkAuth')->name('updateAccess');

Route::post('/newRole', [DMSController::class, 'new_role'])->middleware('checkAuth')->name('newRole');
Route::post('/newPermission', [DMSController::class, 'new_permission'])->middleware('checkAuth')->name('newPermission');
Route::post('/folderAccess', [DMSController::class, 'folderAccess'])->middleware('checkAuth')->name('folderAccess');
Route::get('/getFolders/{id}', [DMSController::class, 'getFolders'])->middleware('checkAuth')->name('getFolders');

Route::get('/roles', [DMSController::class, 'roles_pg'])->middleware('checkAuth');
Route::get('/permission', [DMSController::class, 'permission_pg'])->middleware('checkAuth');
Route::get('/access', [DMSController::class, 'access_pg'])->middleware('checkAuth');
Route::get('/fld_access/{id}', [DMSController::class, 'fdaccess_pg'])->middleware('checkAuth');
Route::get('/create_folder_tb', [DMSController::class, 'create_folder_tb'])->middleware('checkAuth');

Route::get('/dms', [DMSController::class, 'index'])->name('index');
Route::get('/dms/{dir?}', [DMSController::class, 'show'])
    ->where('dir', '.*')
    ->middleware('checkAuth')
    ->name('show');
