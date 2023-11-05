<?php

namespace App\Settings;

use App\Http\Requests\UpdateImportExportSettingsRequest;
use App\Settings\Validation\ValidatableSettings;
use Illuminate\Http\Request;
use Spatie\LaravelSettings\Settings;

class ImportExportSettings extends Settings implements ValidatableSettings
{
  /**
   * Separator to use in the CSV file.
   */
  public string $separator;

  /**
   * Enclosure to use in the CSV file.
   */
  public string $enclosure;

  /**
   * Escape to use in the CSV file.
   */
  public string $escape;

  /**
   * End of line to use in the CSV file.
   */
  public string $eol;

  public static function group(): string
  {
    return 'base/import_export';
  }

  public function validator(Request $request): string
  {
    return UpdateImportExportSettingsRequest::class;
  }
}
