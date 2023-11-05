<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\PackArticle;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

/**
 * @template T of \Modules\Education\Entities\PackArticle
 */
class  PackArticleRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['pack_id'] = $attributes['pack']['id'];
    $attributes['article_id'] = $attributes['article']['id'];
    $attributes['currency_id'] = $attributes['currency']['id'];
    unset($attributes['pack'], $attributes['article'], $attributes['currency']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['pack_id'] = $attributes['pack']['id'];
    $attributes['article_id'] = $attributes['article']['id'];
    $attributes['currency_id'] = $attributes['currency']['id'];
    unset($attributes['pack'], $attributes['article'], $attributes['currency']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return PackArticle::class;
  }

  public function allowedIncludes(): array
  {
    return [
      AllowedInclude::relationship('pack', 'pack:id,name'),
      AllowedInclude::relationship('article', 'article:id,name'),
      AllowedInclude::relationship('currency', 'currency:id,name'),
    ];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "pack_id",
      "packs.id",
      "packs.name",
      "article_id",
      "articles.id",
      "articles.name",
      "currency_id",
      "currencies.id",
      "currencies.name",

      "sale_price",
      "vat",
      "discount",

      "created_at",
      "updated_at",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'article',
      'pack',
      'currency',

      "sale_price",
      "vat",
      "discount",

      'created_at',
      'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::exact('sale_price'),
      AllowedFilter::exact('vat'),
      AllowedFilter::exact('discount'),
      AllowedFilter::exact('currency.id', 'currency_id'),
      AllowedFilter::exact('pack.id', 'pack_id'),
      AllowedFilter::exact('article.id', 'article_id'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'sale_price',
      'vat',
      'discount',
    ];
  }

  public function defaultIncludes(): array
  {
    return ['pack:id,name', 'article:id,name', 'currency:id,name'];
  }

}
