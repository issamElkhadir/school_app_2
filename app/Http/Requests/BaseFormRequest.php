<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseFormRequest extends FormRequest
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
    $rules = $this->formatRules($this->commonRules());

    $mergeWith = match ($this->method()) {
      Request::METHOD_POST => $this->storeRules(),
      Request::METHOD_PUT, Request::METHOD_PATCH => $this->updateRules(),
      default => [],
    };

    $mergeWith = $this->formatRules($mergeWith);

    foreach ($mergeWith as $key => $value) {
      $rules[$key] = array_merge($rules[$key] ?? [], $value);
    }

    return $rules;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function storeRules(): array
  {
    return [];
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function updateRules(): array
  {
    return [];
  }

  /**
   * Get the validation rules that apply on store and update requests.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public abstract function commonRules(): array;

  private function formatRules(array $rules): array
  {
    foreach ($rules as $key => $value) {
      if (is_string($value)) {
        $rules[$key] = explode('|', $value);
      } else {
        $rules[$key] = \Arr::wrap($value);
      }
    }

    return $rules;
  }
}
