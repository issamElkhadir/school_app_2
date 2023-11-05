<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Filters\DateAfterFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\AppointmentRequest;
use Spatie\QueryBuilder\AllowedFilter;

class AppointmentRequestRepository extends BaseRepository
{

  public function model()
  {
    return AppointmentRequest::class;
  }

  private function prepareAttributes(array $attributes): array
  {
    $attributes['school_id'] = $attributes['school']['id'];
    unset($attributes['school']);

    if (isset($attributes['staff'])) {
      $attributes['staff_id'] = $attributes['staff']['id'];
      unset($attributes['staff']);
    }
    if (isset($attributes['student'])) {
      $attributes['student_id'] = $attributes['student']['id'];
      unset($attributes['student']);
    }

    if (isset($attributes['guardian'])) {
      $attributes['guardian_id'] = $attributes['guardian']['id'];
      unset($attributes['guardian']);
    }

    return $attributes;
  }

  public function create(array $attributes)
  {
    $attributes = $this->prepareAttributes($attributes);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes = $this->prepareAttributes($attributes);

    return parent::update($model, $attributes);
  }

  public function allowedIncludes(): array
  {
    return [
      'school:id,name',
      'staff:id,name',
      'student:id,first_name,last_name',
      'guardian:id,first_name,last_name',
    ];
  }

  public function defaultIncludes(): array
  {
    return [
      'school:id,name',
      'staff:id,name',
      'student:id,first_name,last_name',
      'guardian:id,first_name,last_name',
    ];
  }

  public function allowedSorts(): array
  {
    return [
      'id',
      'title',
      'content',
      'accepted',
      'response',
      'appointment_date',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('title'),
      AllowedFilter::custom('accepted', new BooleanFilter()),
      AllowedFilter::custom('appointment_date', new DateAfterFilter()),
      AllowedFilter::exact('school.id', 'school_id'),
      AllowedFilter::exact('staff.id', 'staff_id'),
      AllowedFilter::exact('student.id', 'student_id'),
      AllowedFilter::exact('guardian.id', 'guardian_id'),

    ];
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'school_id',
      'schools.id',
      'schools.name',
      'staff_id',
      'staff.id',
      'staff.name',
      'student_id',
      'students.id',
      'students.name',
      'guardian_id',
      'guardians.id',
      'guardians.name',
      'title',
      'content',
      'accepted',
      'response',
      'appointment_date',
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'title',
      'content',
      'accepted',
      'response',
      'appointment_date',
    ];
  }
}
