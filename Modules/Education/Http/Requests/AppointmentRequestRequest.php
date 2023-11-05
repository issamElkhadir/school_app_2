<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AppointmentRequestRequest extends BaseFormRequest
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
      'staff.id' => 'nullable|exists:staff,id',
      'student.id' => 'nullable|exists:students,id',
      'guardian.id' => 'nullable|exists:guardians,id',
      'title' => 'required|string|max:255',
      'content' => 'nullable|string',
      'accepted' => 'boolean',
      'response' => 'nullable|string|max:255',
      'appointment_date' => 'nullable|date',
    ];
  }

  public function updateRules(): array
  {
    return [
      'school.id' => 'sometimes',
      'staff.id' => 'sometimes',
      'student.id' => 'sometimes',
      'guardian.id' => 'sometimes',
      'title' => 'sometimes',
      'content' => 'sometimes',
      'accepted' => 'sometimes',
      'response' => 'sometimes',
      'appointment_date' => 'sometimes',
    ];
  }


  public function attributes(): array
  {
    return [
      'school.id' => 'School',
      'staff.id' => 'Staff',
      'student.id' => 'Student',
      'guardian.id' => 'Guardian',
      'appointment_date' => 'Appointment Date',
    ];
  }
}
