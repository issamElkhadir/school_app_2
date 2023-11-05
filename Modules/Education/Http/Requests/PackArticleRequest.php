<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class PackArticleRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'currency.id' => 'required|integer|exists:currencies,id',
      'pack.id' => 'required|integer|exists:packs,id',
      'article.id' => 'required|integer|exists:articles,id',
      'sale_price' => 'required|numeric',
      'vat' => 'required|numeric',
      'discount' => 'required|numeric',
      'description' => 'nullable|string|max:255',
    ];
  }

  public function updateRules(): array
  {
    return [
      'currency.id' => 'sometimes',
      'sale_price' => 'sometimes',
      'vat' => 'sometimes',
      'discount' => 'sometimes',
      'pack.id' => 'sometimes',
      'article.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'currency.id' => 'currency',
      'pack.id' => 'pack',
      'article.id' => 'article',
    ];
  }
}
