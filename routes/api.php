<?php

use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResources([
        'projeto' => ProjetoController::class,
        'projeto.tarefa' => TarefaController::class
    ]);
});
