<?php

use Illuminate\Support\Facades\Route;
use Tomeet\Certification\Http\Controllers\APIs\OfficialController;
use Tomeet\Certification\Http\Controllers\APIs\PersonalController;


Route::prefix('app/api')->group(function () {
    Route::middleware('auth:api')->group(function () {
        /**
         * 实名认证（个人认证|官方认证）
         */
        Route::prefix('certification')->name('certification.')->group(function () {
            //个人认证
            Route::post('personal/upload', [PersonalController::class, 'upload'])->name('personal.upload');
            Route::post('personal', [PersonalController::class, 'store'])->name('personal.store');
            Route::get('personal', [PersonalController::class, 'show'])->name('personal.show');
            Route::put('personal', [PersonalController::class, 'update'])->name('personal.update');
            //官方认证
            Route::post('official/upload', [OfficialController::class, 'upload'])->name('official.upload');
            Route::post('official', [OfficialController::class, 'store'])->name('official.store');
            Route::get('official', [OfficialController::class, 'show'])->name('official.show');
            Route::put('official', [OfficialController::class, 'update'])->name('official.update');
        });
    });
});

