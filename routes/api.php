<?php

use App\Http\Controllers\MagazineController;
use App\Http\Controllers\PublicationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('magazines', MagazineController::class);
Route::apiResource('publications', PublicationController::class);
