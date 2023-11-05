<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {

  public function up(): void
  {
    $this->migrator->inGroup('base/general', function (SettingsBlueprint $blueprint): void {
      $blueprint->add('records_per_page', 10);
      $blueprint->add('timezone', config('app.timezone'));
      $blueprint->add('date_format', 'Y-m-d');
      $blueprint->add('is_24_hours', true);
      $blueprint->add('notification', true);
      $blueprint->add('academic_year', null);
    });
  }

  public function down(): void
  {
    $this->migrator->inGroup('base/general', function (SettingsBlueprint $blueprint): void {
      $blueprint->delete('records_per_page');
      $blueprint->delete('timezone');
      $blueprint->delete('date_format');
      $blueprint->delete('is_24_hours');
      $blueprint->delete('notification');
      $blueprint->delete('academic_year');
    });
  }
};
