<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:api')->group(function () {
  Route::get('download/{filename}', function ($filename) {

    $file = storage_path('app/' . $filename);

    $name = \Str::before($filename, '-');

    $extension = \Str::afterLast($filename, '.');

    return response()
      ->download($file, "{$name}.{$extension}");
  })->name('download');
});
