<?php

namespace App\Http\Requests;

class UpdateSchoolRequest extends StoreSchoolRequest
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
    $rules = parent::rules();

    $rules['name'] = [
      'required',
      'string',
      'max:255',
      'unique:schools,name,' . $this->school->id
    ];

    return $rules;
  }
}
