<?php

use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReceivingItemController;
use App\Http\Controllers\OutgoingItemController;


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

Route::get('/test', function() {
    return view('Layouts.main');
});

Route::resource('/item', ItemController::class);
Route::resource('/received-item', ReceivingItemController::class);
Route::resource('/outgoing-item', OutgoingItemController::class);

Route::resource('/users', UserController::class);

Route::resource('/order', OrderProductController::class);

Route::get('detail-order/{order}', [OrderProductController::class, 'detail']);
Route::post('update-progress-order/{order}', [OrderProductController::class, 'updateProgress']);


Route::controller(MaterialController::class)->group(function() {
    Route::get('create-material/{order}', 'create');
    Route::get('edit-material/{material}', 'edit');
    Route::post('material', 'store');
    Route::post('material/{material}', 'update');
    Route::post('destroy-material/{material}', 'destroy');
});

Route::controller(WorkerController::class)->group(function() {
    Route::get('create-worker/{order}', 'create');
    Route::post('/worker', 'store');
    Route::post('destroy-worker/{worker}', 'destroy');
});

Route::controller(CommunicationController::class)->group(function() {
    Route::post('coment', 'store');
    Route::post('destroy-comment/{communication}', 'destroy');
});