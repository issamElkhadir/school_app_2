<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {

  public function up(): void
  {
    $this->migrator->inGroup('base/import_export', function (SettingsBlueprint $blueprint): void {
      $blueprint->add('separator', ',');
      $blueprint->add('enclosure', '"');
      $blueprint->add('escape', '\\');
      $blueprint->add('eol', '\n');
    });
  }

  public function down(): void
  {
    $this->migrator->inGroup('base/import_export', function (SettingsBlueprint $blueprint): void {
      $blueprint->delete('separator');
      $blueprint->delete('enclosure');
      $blueprint->delete('escape');
      $blueprint->delete('eol');
    });
  }
};
