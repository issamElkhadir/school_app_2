<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralSettingsRequest extends FormRequest
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
      'records_per_page' => ['required', 'integer', 'min:1'],
      'timezone' => ['required', 'timezone'],
      'date_format' => ['required', 'string'],
      'is_24_hours' => ['required', 'boolean'],
      'notification' => ['required', 'boolean'],
      'academic_year.id' => ['nullable', 'exists:cities,id'],
    ];
  }

  public function attributes(): array
  {
    return [
      'records_per_page' => 'records per page',
      'academic_year.id' => 'academic year',
      'date_format' => 'date format',
      'is_24_hours' => '24 hours format',
    ];
  }
}
