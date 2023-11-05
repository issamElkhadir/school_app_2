<?php

namespace App\Http\Requests;

use Nwidart\Modules\Facades\Module;

class UserDefinedFilterRequest extends BaseFormRequest
{
   public function commonRules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'model' => [
        'required',
        'string',
        'max:255',

        // This is a custom rule that checks if the model exists in the
        function ($attribute, $value, $fail) {
          // Get the module, and model name
          [$module] = explode('.', $value);

          $instance = Module::find($module);

          if ($module !== 'base' && is_null($instance)) {
            $fail("The module {$module} does not exist.");
          } else {
            $qualifiedName = $this->qualifyModel();

            if (!class_exists($qualifiedName)) {
              $fail("The model {$value} does not exist.");
            }
          }
        },
      ],
      'filters' => ['required', 'array'],
      'description' => ['nullable', 'string'],
      'is_default' => ['required', 'boolean'],
      'is_enabled' => ['required', 'boolean'],
    ];
  }

  public function qualifyModel(): string
  {
    [$module, $model] = explode('.', $this->model);

    $module = \Str::studly($module);
    $model = \Str::studly($model);

    if ($module === 'Base') {
      return "App\\Models\\{$model}";
    }

    return "Modules\\{$module}\\Entities\\{$model}";
  }
}
