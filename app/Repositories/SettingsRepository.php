<?php

namespace App\Repositories;

use Spatie\LaravelSettings\Models\SettingsProperty;
use Spatie\LaravelSettings\Settings;

class SettingsRepository extends BaseRepository
{
  public function model()
  {
    return SettingsProperty::class;
  }

  /**
   * @param \Spatie\LaravelSettings\Settings $model
   * @param array<string, mixed> $attributes
   *
   * @return \Spatie\LaravelSettings\Settings
   */
  public function update($model, array $attributes)
  {
    $model->fill($attributes);

    $model->save();

    $model->refresh();

    return $model;
  }
}
