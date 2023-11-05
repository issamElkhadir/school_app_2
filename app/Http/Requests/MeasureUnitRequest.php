<?php

namespace App\Http\Requests;

use App\Models\Enums\MeasureUnitType;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class MeasureUnitRequest extends BaseFormRequest
{
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',

      'category.id' => 'required|exists:measure_unit_categories,id',
      'active' => 'required|boolean',
      'ratio' => 'required|numeric',

      'type' => [
        'required',
        new Enum(MeasureUnitType::class)
      ],
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => Rule::unique('measure_units', 'name'),
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => [
        'sometimes',
        Rule::unique('measure_units', 'name')
          ->ignore($this->id)
      ],
      'category.id' => 'sometimes',
      'active' => 'sometimes',
      'ratio' => 'sometimes',
      'type' => 'sometimes',
    ];
  }

  public function attributes()
  {
    return [
      'category.id' => 'category',
    ];
  }
}
