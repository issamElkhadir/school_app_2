<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\Vacation;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Vacation
 */
class VacationRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['staff_id'] = $attributes['staff']['id'];
    $attributes['vacation_type_id'] = $attributes['vacation_type']['id'];

    unset($attributes['staff'], $attributes['vacation_type']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['staff_id'] = $attributes['staff']['id'];
    $attributes['vacation_type_id'] = $attributes['vacation_type']['id'];

    unset($attributes['staff'], $attributes['vacation_type']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Vacation::class;
  }

  public function allowedIncludes(): array
  {
    return ['staff', 'vacationType'];
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'start_date',
      'end_date',

      'staff_id',
      'staff.id',
      'staff.name',

      'vacation_type_id',
      'vacationTypes.id',
      'vacationTypes.name',

    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'start_date',
      'end_date',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::scope('start_date', 'filterByStartDate'),
      AllowedFilter::scope('end_date', 'filterByEndDate'),
      AllowedFilter::exact('staff.id', 'staff_id'),
      AllowedFilter::exact('vacation_type.id', 'vacation_type_id'),

    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
    ];
  }

  public function defaultIncludes(): array
  {
    return ['staff:id,name', 'vacationType:id,name'];
  }
}
