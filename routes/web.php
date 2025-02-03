<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/upload', [UploadController::class, 'index'])->name('upload');
    Route::post('/upload', [UploadController::class, 'uploadFile'])->name('fileUpload');
    Route::post('/upload/{file}/file-conf', [UploadController::class, 'fileConf'])->name('fileConf');
    Route::post('/upload/{file}/file-post-conf', [UploadController::class, 'filePostConf'])->name('filePostConf');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   
    // Route::resource('roles', RoleController::class)->names([
    //     'index','roles.index',
    //     'create','roles.create',
    // ]);

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::put('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}', [RoleController::class, 'show'])->name('roles.show');
    //Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');

    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.delete');

    
    // Route::resource('users', UserController::class)->names([
    //     'index','users.index',
    //     'create','users.create'
    // ]);
   
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
   // Route::get('roles/edit/{id}', [UserController::class, 'edit'])->name('roles.edit');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.delete');
   
    
   
});

require __DIR__.'/auth.php';
