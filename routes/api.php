<?php

use App\Http\Controllers\Api\V1\ContentController;
use App\Http\Controllers\Api\V1\DersController;
use App\Http\Controllers\Api\V1\TopicController;
use App\Http\Controllers\Api\V1\UstazController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/content', ContentController::class);
    Route::get('/ustazes', [UstazController::class, 'index']);
    Route::get('/topics', [TopicController::class, 'index']);
    Route::get('/derses', [DersController::class, 'index']);
    Route::get('/derses/{id}', [DersController::class, 'show']);
});
