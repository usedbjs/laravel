<?php

use UseDB\Controllers\UseDBController;
use Illuminate\Support\Facades\Route;


Route::post('/usedb', [UseDBController::class, 'index'])
    ->middleware(['usedb', 'model-usedb'])->middleware(config('usedb.middleware'));
