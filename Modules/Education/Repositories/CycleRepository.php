<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Cycle;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Cycle
 */
class CycleRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $schools = $attributes['schools'];

    unset($attributes['schools']);

    /** @var Cycle $model */
    $model = parent::create($attributes);

    $model->schools()->sync(array_column($schools, 'id'));

    return $model;
  }

  public function update($model, array $attributes)
  {
    /** @var Cycle $model */
    $model->schools()->sync(array_column($attributes['schools'], 'id'));

    unset($attributes['schools']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Cycle::class;
  }

  public function allowedIncludes(): array
  {
    return ['schools'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
      "rtl_name",
      "short_name",
      "status",
      "description",
      "created_at",
      "created_by",
      "updated_at",
      "updated_by",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      "id",
      "name",
      "rtl_name",
      "short_name",
      "status",
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('rtl_name'),
      AllowedFilter::custom('status', new BooleanFilter('status')),
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
    return [];
  }

}
