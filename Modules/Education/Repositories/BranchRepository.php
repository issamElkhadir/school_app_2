<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Branch;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Branch
 */
class BranchRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['cycle_id'] = $attributes['cycle']['id'];

    unset($attributes['cycle']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['cycle_id'] = $attributes['cycle']['id'];

    unset($attributes['cycle']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Branch::class;
  }

  public function allowedIncludes(): array
  {
    return ['cycle'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "cycle_id",
      "cycles.id",
      "cycles.name",
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
      AllowedFilter::exact('cycle.id', 'cycle_id'),
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
    return ['cycle:id,name'];
  }

}
