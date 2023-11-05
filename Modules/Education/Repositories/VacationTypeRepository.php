<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\VacationType;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of VacationType
 */
class VacationTypeRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['school']);

    return parent::create($attributes);
  }


  public function update($model, array $attributes)
  {
    dd($attributes);
    $attributes['school_id'] = $attributes['school']['id'];


    unset($attributes['school']);

    return parent::update($model, $attributes);
  }


  public function model()
  {
    return VacationType::class;
  }

  public function allowedIncludes(): array
  {
    return ['school:id,name'];
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'name',
      'rtl_name',
      'short_name',
      'status',

      'school_id',
      'schools.id',
      'schools.name',

    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
      'rtl_name',
      'short_name',
      'status'
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('rtl_name'),
      AllowedFilter::partial('short_name'),
      AllowedFilter::custom('status', new BooleanFilter()),
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
    return ['school:id,name'];
  }
}
