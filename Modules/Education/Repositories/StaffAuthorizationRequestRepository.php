<?php

namespace Modules\Education\Repositories;

use App\Filters\DateAfterFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\StaffAuthorizationRequest;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of StaffAuthorizationRequest
 */
class StaffAuthorizationRequestRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['staff_id'] = $attributes['staff']['id'];
    $attributes['responsible_id'] = $attributes['responsible']['id'];
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['staff'], $attributes['responsible'], $attributes['school']);

    return parent::create($attributes);
  }
  public function update($model, array $attributes)
  {
    $attributes['staff_id'] = $attributes['staff']['id'];
    $attributes['responsible_id'] = $attributes['responsible']['id'];
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['staff'], $attributes['responsible'], $attributes['school']);

    return parent::update($model, $attributes);
  }

  public function allowedIncludes(): array
  {
    return [
      'staff:id, name',
      'responsible',
      'school'
    ];
  }
  public function defaultIncludes(): array
  {
    return ['staff:id,name', 'responsible:id', 'school:id'];
  }
  public function allowedSorts(): array
  {
    return [
      "confirmed_date",
      "content",
      "start_date_time",
      "end_date_time",
      "note",
    ];
  }
  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::exact('staff.id', 'staff_id'),
      AllowedFilter::exact('user.id', 'responsible_id'),
      AllowedFilter::partial('content'),
      AllowedFilter::exact('start_date_time'),
      AllowedFilter::exact('end_date_time'),
      AllowedFilter::partial('note'),
      AllowedFilter::exact('school.id', 'school_id'),
    ];
  }
  public function allowedFields(): array
  {
    return [
      'id',
      'confirmed_date',
      'content',
      'start_date_time',
      'end_date_time',
      'note',

      'staff_id',
      'staff.id',
      'staff.name',

      'responsible_id',
      'responsible.id',

      'school_id',
      'school.id',
    ];
  }
  public function searchFields(): array
  {
    return [
      'confirmed_date',
      'content',
      'start_date_time',
      'end_date_time',
      'note',
    ];
  }
  public function model()
  {
    return StaffAuthorizationRequest::class;
  }
}
