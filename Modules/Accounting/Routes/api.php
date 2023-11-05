<?php

use Illuminate\Http\Request;
use Modules\Accounting\Http\Controllers\CashRegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api.')
  ->middleware('auth:api')
  ->prefix('v1/accounting')
  ->group(function () {

    Route::get('cash-registers/export', [CashRegisterController::class, 'export'])
      ->name('cash-registers.export');

    Route::apiResources([
      'cash-registers' => CashRegisterController::class,
    ]);

  });;
