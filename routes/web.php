<?php

use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReceivingItemController;
use App\Http\Controllers\OutgoingItemController;

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

Route::get('/', [OrderProductController::class, 'dashboard'])->middleware('isAdmin');

Route::resource('/item', ItemController::class)->middleware('isAdmin');
Route::resource('/received-item', ReceivingItemController::class)->middleware('isAdmin');
Route::resource('/outgoing-item', OutgoingItemController::class)->middleware('isAdmin');

Route::resource('/users', UserController::class)->middleware('isAdmin');

Route::resource('/order', OrderProductController::class)->middleware('isAdmin');

Route::get('detail-order/{order}', [OrderProductController::class, 'detail'])->middleware('isAdmin');
Route::post('update-progress-order/{order}', [OrderProductController::class, 'updateProgress']);

Route::post('/invoice/{order}', [OrderProductController::class, 'invoice'])->middleware('isAdmin');
Route::post('report-barang-masuk',[ReceivingItemController::class, 'invoice'])->middleware('isAdmin');
Route::post('report-barang-keluar',[OutgoingItemController::class, 'invoice'])->middleware('isAdmin');

Route::controller(MaterialController::class)->group(function() {
    Route::get('create-material/{order}', 'create')->middleware('isAdmin');
    Route::get('edit-material/{material}', 'edit')->middleware('isAdmin');
    Route::post('material', 'store')->middleware('isAdmin');
    Route::post('material/{material}', 'update')->middleware('isAdmin');
    Route::post('destroy-material/{material}', 'destroy')->middleware('isAdmin');
});

Route::controller(WorkerController::class)->group(function() {
    Route::get('create-worker/{order}', 'create')->middleware('isAdmin');
    Route::post('/worker', 'store')->middleware('isAdmin');
    Route::post('destroy-worker/{worker}', 'destroy')->middleware('isAdmin');
});

Route::controller(CommunicationController::class)->group(function() {
    Route::post('coment', 'store');
    Route::post('destroy-comment/{communication}', 'destroy');
});

Route::controller(AuthenticationController::class)->group(function() {
    Route::get('login', 'index')->name('login');
    Route::post('login', 'verify');
    Route::post('logout', 'logout');
});

// Route::get('/user-worker', [WorkerController::class, 'userWorker']);

Route::controller(WorkerController::class)->group(function() {
    Route::get('user-worker', 'userWorker')->middleware('isWorker');
    Route::get('detail-working/{order}', 'detailWorking')->middleware('isWorker');
});

// Route::get('/is-user', function() {
//     return auth()->user();
// });