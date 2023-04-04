<?php

use App\Http\Controllers\PortalController;
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

Route::get('/portal', [PortalController::class, 'index'])->name('portal.index');
Route::get('/portal/search', [PortalController::class, 'index'])->name('news.search');
Route::get('/portal/{id}', [PortalController::class, 'show'])->name('news.show');
Route::get('/portal/news/edit/{id}', [PortalController::class, 'edit'])->name('news.edit');
Route::get('/portal/news/insert', [PortalController::class, 'insert'])->name('news.insert');
Route::get('/portal/news/delete/{id}', [PortalController::class, 'delete'])->name('news.delete');
Route::post('/portal', [PortalController::class, 'store'])->name('news.store');
Route::patch('/portal', [PortalController::class, 'update'])->name('news.update');
