<?php

namespace App\Http\Requests;

use App\Models\Enums\MeasureUnitType;
use App\Models\MeasureUnit;
use Illuminate\Validation\Rule;

class MeasureUnitCategoryRequest extends BaseFormRequest
{
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'units' => 'nullable|array',

      'units.*.name' => [
        'required',
        'string',
        'max:255',
        'distinct',
      ],

      'units.*.active' => 'required|boolean',
      'units.*.ratio' => 'required|numeric',
      'units.*.type' => [
        'required',
        Rule::enum(MeasureUnitType::class)
      ],
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => [
        'sometimes',
        Rule::unique('measure_unit_categories', 'name')
          ->ignore($this->measure_unit_category)
      ],

      'units.*.id' => [
        'nullable',
        'integer',

        Rule::exists(MeasureUnit::class, 'id')
          ->withoutTrashed()
          ->where('measure_unit_category_id', $this->measure_unit_category),
      ],

      'units.*.name' => Rule::unique('measure_units')
        ->whereNotIn('id', array_filter($this->input('units.*.id', [])))
        ->withoutTrashed()
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => Rule::unique('measure_unit_categories', 'name'),

      'units.*.name' => Rule::unique(MeasureUnit::class, 'name')
        ->withoutTrashed(),
    ];
  }

  public function attributes()
  {
    return [
      'units.*.id' => 'id',
      'units.*.name' => 'name',
      'units.*.ratio' => 'ratio',
      'units.*.active' => 'active',
      'units.*.type' => 'type',
    ];
  }
}
