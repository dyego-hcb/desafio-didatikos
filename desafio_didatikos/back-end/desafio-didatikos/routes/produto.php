<?php

use Illuminate\Support\Facades\Route;

// IMPORT CONTROLLERS
use App\Http\Controllers\ProdutoController;

Route::prefix('produtos')->group(function () {
    Route::get('/getAll', [ProdutoController::class, 'getAllProdutos']);
    Route::get('/get/{id}', [ProdutoController::class, 'getProdutoById']);
    Route::post('/register', [ProdutoController::class, 'registerProduto']);
    Route::put('/edit/{id}', [ProdutoController::class, 'updateProdutoById']);
    Route::delete('/delete/{id}', [ProdutoController::class, 'deleteProdutoById']);
});
