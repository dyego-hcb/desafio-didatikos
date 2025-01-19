<?php

use Illuminate\Support\Facades\Route;

// IMPORT CONTROLLERS
use App\Http\Controllers\MarcaController;

Route::prefix('marca')->group(function () {
    Route::get('/getAll', [MarcaController::class, 'getAllMarcas']);
    Route::get('/get/{id}', [MarcaController::class, 'getMarcaById']);
    Route::post('/register', [MarcaController::class, 'registerMarca']);
    Route::put('/edit/{id}', [MarcaController::class, 'updateMarcaById']);
    Route::delete('/delete/{id}', [MarcaController::class, 'deleteMarcaById']);
});
