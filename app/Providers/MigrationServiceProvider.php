<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class MigrationServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    $this->registerMacros();
  }

  /**
   * Register macros.
   */
  private function registerMacros(): void
  {
    Blueprint::macro('trackingColumns', function () {
      /** @var Blueprint $this */
      $this->unsignedBigInteger('created_by')->nullable();
      $this->unsignedBigInteger('updated_by')->nullable();
      $this->unsignedBigInteger('deleted_by')->nullable();
      $this->boolean('archived_automatic')->nullable()->default(null);

      $this->foreignId('archived_by')->nullable()->constrained('users');
      $this->timestampTz('archived_at')->nullable();

      $this->timestampsTz();
      $this->softDeletesTz();

      $this->foreign('created_by')->references('id')->on('users');
      $this->foreign('updated_by')->references('id')->on('users');
      $this->foreign('deleted_by')->references('id')->on('users');
    });

    Blueprint::macro('dropTrackingColumns', function () {
      /** @var Blueprint $this */

      $this->dropForeign(['created_by']);
      $this->dropForeign(['updated_by']);
      $this->dropForeign(['deleted_by']);

      $this->dropConstrainedForeignId('archived_by');
      $this->dropColumn('archived_automatic');
      $this->dropColumn('archived_at');

      $this->dropTimestampsTz();
      $this->dropSoftDeletesTz();

      $this->removeColumn('created_by');
      $this->removeColumn('updated_by');
      $this->removeColumn('deleted_by');
    });


    Blueprint::macro('contactColumns', function () {
      /** @var Blueprint $this */

      $this->text('contact_address')->nullable();
      $this->text('contact_rtl_address')->nullable();
      $this->string('contact_name')->nullable();
      $this->string('contact_email')->nullable();
      $this->string('contact_whatsapp')->nullable();
      $this->string('contact_website')->nullable();
      $this->string('contact_phone_1')->nullable();
      $this->string('contact_phone_2')->nullable();
      $this->string('contact_mobile_1')->nullable();
      $this->string('contact_mobile_2')->nullable();
      $this->string('contact_fax_1')->nullable();
      $this->string('contact_fax_2')->nullable();
      $this->foreignId('contact_country_id')->nullable()->constrained('countries');
      $this->foreignId('contact_city_id')->nullable()->constrained('cities');
      $this->string('contact_street')->nullable();
      $this->string('contact_zip')->nullable();
    });

    Blueprint::macro('dropContactColumns', function () {
      /** @var Blueprint $this */

      $this->dropColumn([
        'contact_address',
        'contact_rtl_address',
        'contact_name',
        'contact_email',
        'contact_whatsapp',
        'contact_website',
        'contact_phone_1',
        'contact_phone_2',
        'contact_mobile_1',
        'contact_mobile_2',
        'contact_fax_1',
        'contact_fax_2',
        'contact_street',
        'contact_zip'
      ]);

      $this->dropConstrainedForeignId('contact_country_id');
      $this->dropConstrainedForeignId('contact_city_id');
    });
  }
}
