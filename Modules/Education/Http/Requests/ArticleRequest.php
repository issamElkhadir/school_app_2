<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Education\Entities\Enum\InvoicingPolicy;
use Modules\Education\Entities\Enum\ProductType;

class ArticleRequest extends BaseFormRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'rtl_name' => 'nullable|string|max:255',
      'product_type' => [
        'required',
        new Enum(ProductType::class),
      ],
      'invoicing_policy' => [
        'required',
        new Enum(InvoicingPolicy::class)
      ],
      'category.id' => 'required|integer|exists:categories,id',
      'currency.id' => 'required|integer|exists:currencies,id',
      'unit.id' => 'required|integer|exists:measure_units,id',
      'sale_price' => 'required|numeric',
      'vat' => 'required|numeric',
      'default_code' => 'nullable|string|max:255',
      'barcode' => 'nullable|string|max:255',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:articles,name,' . $this->article->id,
      'product_type' => 'sometimes',
      'invoicing_policy' => 'sometimes',
      'category.id' => 'sometimes',
      'currency.id' => 'sometimes',
      'unit.id' => 'sometimes',
      'sale_price' => 'sometimes',
      'vat' => 'sometimes',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:articles,name',
    ];
  }

  public function attributes(): array
  {
    return [
      'category.id' => 'category',
      'currency.id' => 'currency',
      'unit.id' => 'unit',
    ];
  }
}
