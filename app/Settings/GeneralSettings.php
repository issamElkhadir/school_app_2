<?php

namespace App\Settings;

use App\Http\Requests\UpdateGeneralSettingsRequest;
use App\Models\City;
use App\Settings\Casts\BelongsToCast;
use App\Settings\Validation\ValidatableSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings implements ValidatableSettings
{
  /**
   * Records per page to show in the table.
   */
  public int $records_per_page;

  /**
   * Timezone to use in the application.
   */
  public string $timezone;

  /**
   * Date format to use in the application.
   */
  public string $date_format;

  /**
   * Whether to use 24 hours format or not.
   */
  public bool $is_24_hours;

  /**
   * Whether to send notification or not.
   */
  public bool $notification;

  /**
   * Academic year to use in the application.
   */
  public null|array|City $academic_year;

  public static function group(): string
  {
    return 'base/general';
  }

  public static function casts(): array
  {
    return [
      'academic_year' => new BelongsToCast(City::class, ['id', 'name']),
    ];
  }
  public function validator(Request $request): FormRequest|string
  {
    return UpdateGeneralSettingsRequest::class;
  }
}
