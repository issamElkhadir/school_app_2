<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateImportExportSettingsRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'separator' => ['required', 'string', Rule::in([',', ';', '|', '\t'])],
      'enclosure' => ['required', 'string', Rule::in('"', "'", '""', "''")],
      'escape' => ['required', 'string', 'in:\\,\\\\'],
      'eol' => ['required', 'string', 'in:\r\n,\n,\r'],
    ];
  }

  public function attributes()
  {
    return [
      'eol' => 'end of line',
    ];
  }
}
