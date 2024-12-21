<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PersonalizeController;
use App\Http\Controllers\PreviewController;

//routes/web.php
//Route::get('/', [IndexController::class, 'index'])->name('home');
// 指向 showMenu 方法
Route::get('/', [IndexController::class, 'showMenu'])->name('home');

Route::get('/init', function () {
    return view('init');
});

// 主页面路由
Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/categories', [IndexController::class, 'categories'])->name('categories');

Route::get('/books/{id}', [BookController::class, 'showBook'])->name('books.show');


Route::get('/personalize', [PersonalizeController::class, 'showCharacterForm']);
Route::post('/personalize/save', [PersonalizeController::class, 'saveCharacterInfo'])->name('personalize.save');

Route::get('/personalize/preview/{bookid}', [PreviewController::class, 'previewBook'])->name('preview');;

//Route::get('/index', function () {
//    return view('index');
//});
