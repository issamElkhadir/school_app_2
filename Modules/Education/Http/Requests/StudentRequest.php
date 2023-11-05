<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class StudentRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'birthday' => 'date',

      'city.id' => 'required|integer|exists:cities,id',
      'country.id' => 'required|integer|exists:countries,id',
      'birthCity.id' => 'required|integer|exists:cities,id',
      'nationality.id' => 'required|integer|exists:countries,id',
      'nativeLanguage.id' => 'nullable|integer|exists:languages,id',
      'secondLanguage.id' => 'nullable|integer|exists:languages,id',

      'image' => 'nullable|string',
      'rtl_first_name' => 'nullable|string|max:255',
      'rtl_last_name' => 'nullable|string|max:255',
      'gender' => 'nullable|string|max:255',
      'cin' => 'nullable|string|max:255',
      'cne' => 'nullable|string|max:255',
      'quotation' => 'nullable|string|max:255',
      'insurance_name' => 'nullable|string|max:255',
      'insurance_number' => 'nullable|string|max:255',
      'old_school' => 'nullable|string|max:255',
      'old_academy' => 'nullable|string|max:255',
      'old_delegation' => 'nullable|string|max:255',
      'notes' => 'nullable|string',
      'how_he_knew_the_school' => 'nullable|string',
      'has_scholarship' => 'nullable|boolean',
      'scholarship_holder' => 'nullable|string|max:255',

      //contact info
      'contact_address' => 'nullable|string',
      'contact_rtl_address' => 'nullable|string',
      'contact_name' => 'nullable|string|max:255',
      'contact_email' => 'nullable|string|max:255',
      'contact_whatsapp' => 'nullable|string|max:255',
      'contact_website' => 'nullable|string|max:255',
      'contact_phone_1' => 'nullable|string|max:255',
      'contact_phone_2' => 'nullable|string|max:255',
      'contact_mobile_1' => 'nullable|string|max:255',
      'contact_mobile_2' => 'nullable|string|max:255',
      'contact_fax_1' => 'nullable|string|max:255',
      'contact_fax_2' => 'nullable|string|max:255',
      'contact_street' => 'nullable|string|max:255',
      'contact_zip' => 'nullable|string|max:255',

    ];
  }

  public function updateRules(): array
  {
    return [
      'first_name' => 'sometimes',
      'last_name' => 'sometimes',
      'birthday' => 'sometimes',
      'city.id' => 'sometimes',
      'country.id' => 'sometimes',
      'birthCity.id' => 'sometimes',
      'nationality.id' => 'sometimes',
      'nativeLanguage.id' => 'sometimes',
      'secondLanguage.id' => 'sometimes',

    ];
  }

  public function attributes(): array
  {
    return [
      'country.id' => 'Country',
      'city.id' => 'City',
      'secondLanguage.id' => 'Second Language',
      'nativeLanguage.id' => 'Native Language',
    ];
  }
}
