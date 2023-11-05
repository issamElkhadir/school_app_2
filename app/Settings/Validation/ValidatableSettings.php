<?php

namespace App\Settings\Validation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/** @mixin \Spatie\LaravelSettings\Settings */
interface ValidatableSettings
{
  /**
   * The form request to use for this settings class.
   *
   * @param Request $request The request to validate.
   *
   * @return string|FormRequest The form request to use.
   */
  public function validator(Request $request): string|FormRequest;
}
