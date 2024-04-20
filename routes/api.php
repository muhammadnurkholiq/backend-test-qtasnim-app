<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('transactions')->group(function () {
  Route::get('/', [TransactionController::class, 'index']);
  Route::post('/', [TransactionController::class, 'store']);
  Route::get('/{id}', [TransactionController::class, 'show']);
  Route::put('/{id}', [TransactionController::class, 'update']);
  Route::delete('/{id}', [TransactionController::class, 'destroy']);
  Route::get('/most-sold-item', [TransactionController::class, 'getMostSoldItem']);
  Route::get('/least-sold-item', [TransactionController::class, 'getLeastSoldItem']);
});

