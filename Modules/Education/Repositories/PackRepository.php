<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Pack;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

/**
 * @template T of \Modules\Education\Entities\Pack
 */
class  PackRepository extends BaseRepository
{

  public function __construct(protected PackArticleRepository $packArticleRepository)
  {
    parent::__construct();
  }
  public function create(array $attributes)
  {
    $attributes['level_id'] = $attributes['level']['id'];
    $attributes['unit_id'] = $attributes['unit']['id'];
    unset($attributes['level'], $attributes['unit']);

    $pack = parent::create(\Arr::except($attributes, ['articles']));

    $articles = $attributes['articles'] ?? [];

    foreach ($articles as $article) {
      $article['pack'] = $pack->only(['id', 'name']);

      // Ignore id if it is set
      $this->packArticleRepository->create(\Arr::except($article, ['id']));
    }

    $pack->load('articles');

    return $pack;
  }

  public function update($model, array $attributes)
  {
    $attributes['level_id'] = $attributes['level']['id'];
    $attributes['unit_id'] = $attributes['unit']['id'];
    unset($attributes['level'], $attributes['unit']);

    $model = parent::update($model, \Arr::except($attributes, ['articles']));

    $articles = $attributes['articles'] ?? [];

    $this->packArticleRepository
      ->whereBelongsTo($model, 'pack');

    foreach ($articles as &$article) {
      $article['pack'] = $model->only(['id', 'name']);

      if (isset($article['id'])) {
        $this->packArticleRepository
          ->update($article['id'], \Arr::except($article, ['id']));
      } else {
        $article = $this->packArticleRepository->create(\Arr::except($article, ['id']));
      }
    }

    // remove articles that are not in the request
    $this->packArticleRepository
      ->whereBelongsTo($model, 'pack')
      ->whereNotIn('id', array_filter(\Arr::pluck($articles, 'id')))
      ->delete();

    $model->load([
      'articles' => fn($query) => $query->orderBy('id'),
      'articles.currency:id,name',
      'articles.article:id,name',
    ]);

    return $model;
  }

  public function model()
  {
    return Pack::class;
  }

  public function allowedIncludes(): array
  {
    return [
      AllowedInclude::relationship('level', 'level:id,name'),
      AllowedInclude::relationship('unit', 'unit:id,name'),
      AllowedInclude::relationship('articles', 'articles:id,name'),
    ];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "level_id",
      "levels.id",
      "levels.name",
      "unit_id",
      "measureUnites.id",
      "measureUnites.name",
      "name",
      "rtl_name",
      "short_name",
      "sale_price",
      "vat",
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
      'short_name',
      'level',
      'unit',
      'sale_price',
      'vat',
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
      AllowedFilter::partial('short_name'),
      AllowedFilter::partial('invoicing_policy'),
      AllowedFilter::partial('sale_price'),
      AllowedFilter::partial('vat'),
      AllowedFilter::custom('status', new BooleanFilter('status')),
      AllowedFilter::exact('level.id', 'level_id'),
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
    return [
      'level:id,name',
      'unit:id,name',
      'articles',
      'articles.currency:id,name',
      'articles.article:id,name',
    ];
  }

}
