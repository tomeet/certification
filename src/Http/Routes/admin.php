<?php

use Illuminate\Support\Facades\Route;
use Tomeet\Certification\Http\Controllers\Admin\OfficialController;
use Tomeet\Certification\Http\Controllers\Admin\PersonalController;


Route::prefix('admin/api')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        /**
         * 实名认证（个人认证|官方认证）
         */
        Route::prefix('certification')->name('certification.')->group(function () {
            // 个人认证
            Route::delete('personals', [PersonalController::class, 'massDestroy'])->name('personals.mass.destroy');
            Route::put('personals', [PersonalController::class, 'massUpdate'])->name('personals.mass.update');
            Route::patch('personals/{personal}/pass', [PersonalController::class, 'success'])->name('personals.success');
            Route::patch('personals/{personal}/fail', [PersonalController::class, 'fail'])->name('personals.fail');
            // 官方认证
            Route::delete('officials', [OfficialController::class, 'massDestroy'])->name('officials.mass.destroy');
            Route::put('officials', [OfficialController::class, 'massUpdate'])->name('officials.mass.update');
            Route::patch('officials/{official}/pass', [OfficialController::class, 'success'])->name('officials.success');
            Route::patch('officials/{official}/fail', [OfficialController::class, 'fail'])->name('officials.fail');
            Route::apiResources([
                'personals' => PersonalController::class,
                'officials' => OfficialController::class,
            ]);
        });
    });
});


