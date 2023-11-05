<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Session;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Session
 */
class SessionRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['staff_id'] = $attributes['staff']['id'];
    $attributes['subject_id'] = $attributes['subject']['id'];
    $attributes['classroom_id'] = $attributes['classroom']['id'];
    $attributes['schedule_id'] = $attributes['schedule']['id'];

    unset($attributes['staff'], $attributes['subject'], $attributes['classroom'], $attributes['schedule']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['staff_id'] = $attributes['staff']['id'];
    $attributes['subject_id'] = $attributes['subject']['id'];
    $attributes['classroom_id'] = $attributes['classroom']['id'];
    $attributes['schedule_id'] = $attributes['schedule']['id'];

    unset($attributes['staff'], $attributes['subject'], $attributes['classroom'], $attributes['schedule']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Session::class;
  }

  public function allowedIncludes(): array
  {
    return ['schedule', 'classroom', 'subject', 'staff', 'achievements'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "schedule_id",
      "schedule.id",
      "schedule.name",
      "classroom_id",
      "classroom.id",
      "classroom.name",
      "subject_id",
      "subject.id",
      "subject.name",
      "staff_id",
      "staff.id",
      "staff.name",
      "start_time",
      "end_time",
      "day",
      "content",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
      'start_time',
      'end_time',
      "content",
      'day',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::exact('start_time'),
      AllowedFilter::exact('end_time'),
      AllowedFilter::exact('staff.id', 'staff_id'),
      AllowedFilter::exact('subject.id', 'subject_id'),
      AllowedFilter::exact('classroom.id', 'classroom_id'),
      AllowedFilter::exact('schedule.id', 'schedule_id'),
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
    return ['schedule:id,name', 'classroom:id,name', 'subject:id,name', 'staff:id', 'achievements'];
  }

}
