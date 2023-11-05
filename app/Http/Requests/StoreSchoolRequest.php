<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Education\Entities\Classroom;

class StoreSchoolRequest extends FormRequest
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
      'name' => 'required|unique:schools|string|max:255',
      'short_name' => 'nullable|string|max:255',
      'rtl_name' => 'nullable|string|max:255',
      'active' => 'nullable|boolean',
      'authorization_date' => 'nullable|date',
      "cashRegisters" => 'nullable|array',
      "classrooms" => 'nullable|array',
      "classrooms.*.id" => [
        'nullable',
        'integer',

        Rule::exists(Classroom::class, 'id')
          ->when($this->school, function ($rule, $value) {
            return $rule->where('school_id', $this->school->id);
          })
          ->withoutTrashed(),
      ],

      'classrooms.*.name' => Rule::forEach(function (string|null $value, string $attribute, array $values) {
        $idAttr = str_replace('name', 'id', $attribute);
        return [
          'required',
          'string',
          'max:255',
          Rule::unique(Classroom::class, 'name')
            ->withoutTrashed()
            ->when($values[$idAttr] ?? null, fn($rule, $value) => $rule->ignore($value))
        ];
      }),
      'classrooms.*.rtl_name' => 'nullable|string|max:255',
      'classrooms.*.image' => 'nullable|string|max:255',
      'classrooms.*.capacity' => 'integer|min:0',
      'classrooms.*.classroomType.id' => 'required|exists:classroom_types,id',

      //      'cashRegisters.*.id' => 'exists:cash_registers,id',

      'city.id' => 'required|integer|exists:cities,id',
      'country.id' => 'required|integer|exists:countries,id',

      'authorization_number' => 'nullable|string|max:255',
      'authorization_information' => 'nullable|string|max:255',
      'rtl_authorization_information' => 'nullable|string|max:255',
      'cnss' => 'nullable|string|max:255',
      'rc' => 'nullable|string|max:255',
      'ice' => 'nullable|string|max:255',
      'establishment_type' => 'nullable|string|max:255',
      'responsible_name' => 'nullable|string|max:255',
      'responsible_phone_number' => 'nullable|string|max:255',

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

  public function attributes()
  {
    return [
      'country.id' => 'country',
      'city.id' => 'city',

      'cnss' => 'CNSS',
      'rc' => 'RC',
      'ice' => 'ICE',

      'classrooms.*.classroomType.id' => 'classroom type',
      'classrooms.*.name' => 'classroom name',
      'classrooms.*.rtl_name' => 'classroom rtl name',
      'classrooms.*.image' => 'classroom image',
      'classrooms.*.capacity' => 'classroom capacity',

    ];
  }
}
