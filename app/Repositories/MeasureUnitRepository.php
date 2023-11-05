<?php

namespace App\Repositories;

use App\Filters\BooleanFilter;
use App\Filters\EnumFilter;
use App\Models\Enums\MeasureUnitType;
use App\Models\MeasureUnit;
use App\Sorts\BelongsToSort;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @template T of MeasureUnit
 */
class MeasureUnitRepository extends BaseRepository
{
  public function model()
  {
    return MeasureUnit::query()->with('category:id,name');
  }

  public function allowedIncludes(): array
  {
    return ['category'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
    ];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('name'),
      AllowedSort::field('active'),
      AllowedSort::field('ratio'),
      AllowedSort::field('type'),
      AllowedSort::custom('category', new BelongsToSort('category')),
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::custom('active', BooleanFilter::make()),
      AllowedFilter::exact('ratio'),
      AllowedFilter::custom('type', EnumFilter::make(MeasureUnitType::class)),
      AllowedFilter::exact('category', 'measure_unit_category_id'),
    ];
  }

  public function searchFields(): array
  {
    return ['name', 'type', 'ratio'];
  }

  public function create(array $attributes)
  {
    $attributes['measure_unit_category_id'] = $attributes['category']['id'];

    unset($attributes['category']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes = $this->rename($attributes, [
      'category.id' => 'measure_unit_category_id'
    ]);

    return parent::update($model, $attributes);
  }
}
