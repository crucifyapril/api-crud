<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function() {
    Route::post('/', [UserController::class, 'create']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::put('{id}', [UserController::class, 'update']);
    Route::delete('{id}', [UserController::class, 'delete']);
});

Route::prefix('companies')->group(function() {
    Route::post('/', [CompanyController::class, 'create']);
    Route::get('{id}', [CompanyController::class, 'show']);
    Route::put('{id}', [CompanyController::class, 'update']);
    Route::delete('{id}', [CompanyController::class, 'delete']);
    Route::get('rating/top', [CompanyController::class, 'getTopCompanies']);
    Route::get('rating/{id}', [CompanyController::class, 'getCompanyRating']);
});

Route::prefix('comments')->group(function() {
    Route::post('/', [CommentController::class, 'create']);
    Route::get('{id}', [CommentController::class, 'show']);
    Route::put('{id}', [CommentController::class, 'update']);
    Route::delete('{id}', [CommentController::class, 'delete']);
    Route::get('company/{id}', [CommentController::class, 'getCommentsByCompany']);
});

