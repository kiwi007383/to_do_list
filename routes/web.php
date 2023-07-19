<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('create');
// });

Route::redirect('/', 'customer/createPage')->name('post#home');

Route::get('customer/createPage', [PostController::class, 'create'])->name('post#createPage');
Route::post('post/create', [PostController::class, 'postCreate'])->name('post#create');

Route::get('post/delete/{id}', [PostController::class, 'postDelete'])->name('post#delete');

Route::get('post/updatePage/{id}', [PostController::class, 'postUpdate'])->name('post#update');

Route::get('post/editPage/{id}', [PostController::class, 'postEdit'])->name('post#edit');

Route::post('post/update', [PostController::class, 'update'])->name('update');
