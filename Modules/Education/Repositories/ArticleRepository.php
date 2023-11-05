<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Article;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Category;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Article
 */
class ArticleRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['category_id'] = $attributes['category']['id'];
    $attributes['currency_id'] = $attributes['currency']['id'];
    $attributes['unit_id'] = $attributes['unit']['id'];
    unset($attributes['category'], $attributes['currency'], $attributes['unit']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['category_id'] = $attributes['category']['id'];
    $attributes['currency_id'] = $attributes['currency']['id'];
    $attributes['unit_id'] = $attributes['unit']['id'];
    unset($attributes['category'], $attributes['currency'], $attributes['unit']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Article::class;
  }

  public function allowedIncludes(): array
  {
    return ['category', 'currency', 'unit'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "category_id",
      "categories.id",
      "categories.name",
      "currency_id",
      "currencies.id",
      "currencies.name",
      "unit_id",
      "measureUnites.id",
      "measureUnites.name",
      "name",
      "rtl_name",
      "sale_price",
      "vat",
      "default_code",
      "barcode",
      'product_type',
      'invoicing_policy',

      "created_at",
      "updated_at",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
      'rtl_name',
      'category',
      'unit',
      'currency',
      'sale_price',
      'vat',
      'default_code',
      'barcode',
      'product_type',
      'invoicing_policy',

      'created_at',
      'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('rtl_name'),
      AllowedFilter::partial('default_code'),
      AllowedFilter::partial('barcode'),
      AllowedFilter::partial('product_type'),
      AllowedFilter::partial('invoicing_policy'),
      AllowedFilter::partial('sale_price'),
      AllowedFilter::partial('vat'),
      AllowedFilter::custom('status', new BooleanFilter('status')),
      AllowedFilter::exact('category.id', 'category_id'),
      AllowedFilter::exact('currency.id', 'currency_id'),
      AllowedFilter::exact('unit.id', 'unit_id'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'name',
    ];
  }

  public function defaultIncludes(): array
  {
    return ['category:id,name', 'currency:id,name', 'unit:id,name',];
  }

}
