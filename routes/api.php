<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;

Route::get('posts/{post}', [PostController::class, 'getPost']);
Route::get('posts', [PostController::class, 'index']);
Route::post('posts', [PostController::class, 'store']);

Route::post('posts/{post}/setComment', [PostController::class, 'setComment']);

Route::get('/tags', [TagController::class, 'index']);