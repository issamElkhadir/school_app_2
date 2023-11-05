<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {

  public function up(): void
  {
    $this->migrator->inGroup('education/general', function (SettingsBlueprint $blueprint): void {
      $blueprint->add('subscription_sequence', null);
      $blueprint->add('payment_bill_sequence', null);
      $blueprint->add('start_month', 9);
      $blueprint->add('end_month', 6);
    });
  }

  public function down(): void
  {
    $this->migrator->inGroup('education/general', function (SettingsBlueprint $blueprint): void {
      $blueprint->delete('subscription_sequence');
      $blueprint->delete('payment_bill_sequence');
      $blueprint->delete('start_month');
      $blueprint->delete('end_month');
    });
  }
};
