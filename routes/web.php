<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PgwebController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PermissionController;


// Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
// Route pour supprimer un utilisateur
Route::post('/users/{id}/delete', [UsersController::class, 'deleteUser'])->middleware('auth');



Route::get('/permissions', [PermissionController::class, 'showPermissions'])->name('permissions.index');
Route::put('/permissions/{user}', [PermissionController::class, 'updatePermissions'])->name('permissions.update');


// Route pour stocker un nouveau module
Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');




Route::get('/users', [UsersController::class, 'index'])->name('users.index');






Route::get('/dashboard', [CardController::class, 'index'])->name('dashboard');
Route::post('/cards', [CardController::class, 'store'])->name('cards.store');
Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');


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
Route::get('/pgweb', [PgwebController::class, 'index'])->name('pgweb.index');







Route::get('/', function () {
    return view('welcome');
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
