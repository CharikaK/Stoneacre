<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DataFilesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload-data',[DataFilesController::class, 'index']);
Route::post('/upload-file',[DataFilesController::class, 'store'])->name('file.upload');
Route::get('/download-file',[DataFilesController::class, 'downloadDataForm']);
Route::post('/download',[DataFilesController::class, 'download'])->name('file.download');