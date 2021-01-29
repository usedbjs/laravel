<?php

use UseDB\UseDBController;
use Illuminate\Support\Facades\Route;


Route::post('/usedb', [UseDBController::class, 'index'])
    ->middleware('usedb');
