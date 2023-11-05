<?php

use App\Http\Controllers\ArtisanCommandRunner;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MailServerController;
use App\Http\Controllers\MeasureUnitCategoryController;
use App\Http\Controllers\MeasureUnitController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SequenceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDefinedFilterController;
use Illuminate\Support\Facades\Route;
use Modules\Education\Http\Controllers\PreInscriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('api.')
  ->middleware('api')
  ->prefix('v1')
  ->group(function () {

    // Auth routes
    Route::group(['prefix' => 'auth'], function () {
      Route::post('login', [AuthController::class, 'login']);
      Route::post('logout', [AuthController::class, 'logout']);
      Route::post('refresh', [AuthController::class, 'refresh']);
      Route::post('me', [AuthController::class, 'me']);
    });

    Route::middleware('auth:api')->group(function () {
      Route::get('countries/export', [CountryController::class, 'export']);
      Route::get('cities/export', [CityController::class, 'export']);
      Route::get('states/export', [StateController::class, 'export']);

      Route::apiResources([
        'users' => UserController::class,
        'countries' => CountryController::class,
        'states' => StateController::class,
        'cities' => CityController::class,
        'currencies' => CurrencyController::class,
        'languages' => LanguageController::class,
        'translations' => TranslationController::class,
        'user-defined-filters' => UserDefinedFilterController::class,
        'measure-unit-categories' => MeasureUnitCategoryController::class,
        'measure-units' => MeasureUnitController::class,
        'sequences' => SequenceController::class,
        'mail-servers' => MailServerController::class,
        'schools' => SchoolController::class,
      ]);

      Route::post('users/set-theme', [UserController::class, 'setTheme']);

      Route::post('users/set-locale', [UserController::class, 'setLocale']);

      // Settings
      Route::get('settings', [SettingsController::class, 'index']);
      Route::put('settings', [SettingsController::class, 'update']);

      // Notifications
      Route::get('notifications', [NotificationController::class, 'index']);

      Route::put('notifications/{notification}/read', [NotificationController::class, 'read'])
        ->whereUuid('notification');

      Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])
        ->whereUuid('notification');

      Route::post('notifications/read-all', [NotificationController::class, 'readAll']);

      // Translation routes
      Route::get('t', [TranslationController::class, 'getTranslations']);

      if (!app()->isProduction()) {
        Route::post('artisan', ArtisanCommandRunner::class);

        Route::post('artisan/serve', [ArtisanCommandRunner::class, 'serve']);
      }

      Route::get('permissions/all', [PermissionController::class, 'all']);
      Route::get('roles/all', [RoleController::class, 'all']);

      Route::put('permissions', [PermissionController::class, 'update']);
    });

    // get pre inscription using slug
    Route::get('pre-inscription/{slug}', [PreInscriptionController::class , 'getPreInscriptionBySlug']);

    // check if email exists for pre insciption auth
    Route::post('pre-inscription/check-email', [PreInscriptionController::class , 'checkEmail']);
    // check if email and password are correct to allow the user to update the form
    Route::post('pre-inscription/check-email-password', [PreInscriptionController::class , 'checkEmailPassword']);

    // submit form
    Route::post('pre-inscription/save-form', [PreInscriptionController::class , 'submitForm']);
    // update form
    Route::post('pre-inscription/update-form', [PreInscriptionController::class , 'updateForm']);
  });
