<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;

// AUTH
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/logout',[AuthController::class,'logout']); 

// USER 
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::get('/articles/category/{id}', [ArticleController::class, 'searchByCategory']);


// ADMIN
Route::middleware(['auth:api', 'AdminJWT'])->group(function () {
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{id}', [ArticleController::class, 'update']);
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
});


Route::apiResource('categories', CategoryController::class); 

