<?php

use Illuminate\Support\Facades\Route;

// IMPORT CONTROLLERS
use App\Http\Controllers\CidadeController;

Route::prefix('cidade')->group(function () {
    Route::get('/getAll', [CidadeController::class, 'getAllCidades']);
    Route::get('/get/{id}', [CidadeController::class, 'getCidadeById']);
    Route::post('/register', [CidadeController::class, 'registerCidade']);
    Route::put('/edit/{id}', [CidadeController::class, 'updateCidadeById']);
    Route::delete('/delete/{id}', [CidadeController::class, 'deleteCidadeById']);
});
