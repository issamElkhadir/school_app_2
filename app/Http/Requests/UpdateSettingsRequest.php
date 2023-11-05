<?php

namespace App\Http\Requests;

use App\Settings\Validation\ValidatableSettings;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
  /**
   * The form requests to use for each settings class.
   *
   * @var array<string, \Illuminate\Foundation\Http\FormRequest>
   */
  protected array $requests = [];

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
    $rules = [];

    $availableSettings = config('settings.settings');

    foreach ($availableSettings as $class) {
      /** @var \Spatie\LaravelSettings\Settings */
      $settings = app($class);

      if (!$settings instanceof ValidatableSettings)
        continue;

      foreach ($this->requests[$settings->group()]->rules() as $field => $fieldRules) {
        $rules[$settings->group() . '.' . $field] = $fieldRules;
      }
    }

    return $rules;
  }

  public function attributes()
  {
    $attributes = [];

    $availableSettings = config('settings.settings');

    foreach ($availableSettings as $class) {
      /** @var \Spatie\LaravelSettings\Settings */
      $settings = app($class);

      if (!$settings instanceof ValidatableSettings)
        continue;

      foreach (array_keys($settings->toArray()) as $field) {
        $attributes[$settings->group() . '.' . $field] = $field;
      }


      foreach ($this->requests[$settings->group()]->attributes() as $field => $fieldAttributes) {
        $attributes[$settings->group() . '.' . $field] = $fieldAttributes;
      }
    }

    return $attributes;
  }

  public function messages()
  {
    $messages = [];

    $availableSettings = config('settings.settings');

    foreach ($availableSettings as $class) {
      /** @var \Spatie\LaravelSettings\Settings */
      $settings = app($class);

      if (!$settings instanceof ValidatableSettings)
        continue;

      foreach ($this->requests[$settings->group()]->messages() as $field => $fieldMessages) {
        $messages[$settings->group() . '.' . $field] = $fieldMessages;
      }
    }

    return $messages;
  }

  public function prepareForValidation()
  {
    $availableSettings = config('settings.settings');

    foreach ($availableSettings as $class) {
      /** @var \Spatie\LaravelSettings\Settings */
      $settings = app($class);

      $formRequest = $this->makeFormRequest($settings->validator($this));

      $this->requests[$settings->group()] = $formRequest;
    }
  }

  private function makeFormRequest(string|FormRequest $class): FormRequest
  {
    if ($class instanceof FormRequest) {
      return $class;
    }

    $class = self::createFrom($this, new $class);

    return $class;
  }
}
