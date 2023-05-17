<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanLaptopController;

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

Route::get('/peminjamanLaptop', [PeminjamanLaptopController::class, 'index']);
Route::post('/peminjamanLaptop/store', [PeminjamanLaptopController::class, 'store']);
Route::get('/peminjamanLaptop/token', [PeminjamanLaptopController::class, 'createToken']);
Route::patch('/peminjamanLaptop/{id}/update', [PeminjamanLaptopController::class, 'update']);
Route::delete('/peminjamanLaptop/{id}/delete', [PeminjamanLaptopController::class, 'destroy']);
Route::get('/peminjamanLaptop/show/trash', [PeminjamanLaptopController::class, 'trash']);
Route::get('/peminjamanLaptop/show/trash/{id}', [PeminjamanLaptopController::class, 'restore']);
Route::get('/peminjamanLaptop/show/trash/permanent/{id}', [PeminjamanLaptopController::class, 'permanentDelete']);

