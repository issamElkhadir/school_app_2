<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Modules\Education\Entities\Enum\InvoicingPolicy;
use Modules\Education\Entities\PackArticle;

class PackRequest extends BaseFormRequest
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
      'short_name' => 'nullable|string|max:255',
      'invoicing_policy' => [
        'required',
        new Enum(InvoicingPolicy::class),
      ],
      'level.id' => 'required|integer|exists:levels,id',
      'unit.id' => 'required|integer|exists:measure_units,id',
      "articles" => 'nullable|array',
      "articles.*.id" => [
        'nullable',
        'integer',

        Rule::exists(PackArticle::class, 'id')
          ->when($this->pack, function ($rule, $value) {
            return $rule->where('pack_id', $this->pack->id);
          })
          ->withoutTrashed(),
      ],

      'articles.*.article.id' => 'required|exists:articles,id',
      'articles.*.currency.id' => 'required|exists:currencies,id',
      'articles.*.sale_price' => 'required|numeric',
      'articles.*.vat' => 'required|numeric',
      'articles.*.discount' => 'required|numeric',


      'sale_price' => 'required|numeric',
      'vat' => 'required|numeric',
      'status' => 'required|boolean',
      'description' => 'nullable|string|max:255',

    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:packs,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:packs,name,' . $this->pack->id,
      'level.id' => 'sometimes',
      'unit.id' => 'sometimes',
      'articles' => 'sometimes|array',
      'articles.*.id' => 'sometimes',

      'articles.*.article.id' => 'sometimes',
      'articles.*.currency.id' => 'sometimes',
      'articles.*.sale_price' => 'sometimes',
      'articles.*.vat' => 'sometimes',
      'articles.*.discount' => 'sometimes',

      'sale_price' => 'sometimes',
      'vat' => 'sometimes',
      'status' => 'sometimes',
      'description' => 'sometimes',
    ];
  }


  public function attributes(): array
  {
    return [
      'level.id' => 'level',
      'unit.id' => 'unit',
    ];
  }
}
