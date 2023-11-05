<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Category;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Category
 */
class CategoryRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    if (isset($attributes['category'])) {
      $attributes['parent_category_id'] = $attributes['category']['id'];
    }
    unset($attributes['category']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    if (isset($attributes['category'])) {
      $attributes['parent_category_id'] = $attributes['category']['id'];
    }

    unset($attributes['category']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Category::class;
  }

  public function allowedIncludes(): array
  {
    return ['category', 'categories'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "parent_category_id",
      "categories.id",
      "categories.name",
      "name",
      "rtl_name",
      "short_name",
      "status",
      "description",

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
      'status',
      'parent_category_id',
      'created_at',
      'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::custom('status', new BooleanFilter('status')),
      AllowedFilter::exact('category.id', 'parent_category_id'),
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
    return ['category:id,name'];
  }

}
