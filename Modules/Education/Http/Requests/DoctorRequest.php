<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class DoctorRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function commonRules(): array
  {
    return [
      'school.id' => 'required|exists:schools,id',
      'name' => 'required|string|max:255',
      'address' => 'nullable|string|max:255',
      'phone' => 'required|string|max:20',
      'email' => 'required|email',
      'speciality' => 'required|string|max:100',
    ];
  }

  public function updateRules(): array
  {
    return [
      'school.id' => 'sometimes',
      'name' => 'sometimes',
      'address' => 'sometimes',
      'phone' => 'sometimes',
      'email' => 'sometimes|unique:doctors,email,' . $this->doctor->id,
      'speciality' => 'sometimes',
    ];
  }

  public function storeRules(): array
  {
    return [
      'email' => 'unique:doctors,email',
    ];
  }


  /**
   * @return array
   */
  public function attributes(): array
  {
    return [
      'school.id' => 'School',
      'name' => 'Doctor Name',
      'phone' => 'Phone Number',
      'email' => 'Email Address',
    ];
  }
}
