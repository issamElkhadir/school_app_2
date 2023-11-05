<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class GuardianRequest extends BaseFormRequest
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
      'rtl_first_name' => 'nullable|string|max:255',
      'rtl_last_name' => 'nullable|string|max:255',
      'cni_number' => 'required|string|max:255',
      'phone_home' => 'nullable|string|max:255',
      'mobile_phone' => 'nullable|string|max:255',
      'city.id' => 'required|integer|exists:cities,id',
      'country.id' => 'required|integer|exists:countries,id',
      'email_address' => 'nullable|string|email|max:255',
      'gender' => 'required|string|max:255',

    ];
  }

  public function updateRules(): array
  {
    return [
      'first_name' => 'sometimes',
      'last_name' => 'sometimes',
      'cni_number' => 'sometimes',
      'city.id' => 'sometimes',
      'country.id' => 'sometimes',
      'gender' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'country.id' => 'country',
      'cni_number' => 'CNI Number',
      'city.id' => 'city',
      'rtl_first_name' => 'RTL First Name',
      'rtl_last_name' => 'RTL Last Name'
    ];
  }
}
