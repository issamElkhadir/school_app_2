<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\StudentAbsenceAuthorizationRequest;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of StudentAbsenceAuthorizationRequest
 */
class StudentAbsenceAuthorizationRequestRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['subscription_id'] = $attributes['subscription']['id'];
    $attributes['accepted_by'] = $attributes['accepted_by']['id'];
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['subscription'], $attributes['accepted_by'], $attributes['school']);

    return parent::create($attributes);
  }
  public function update($model, array $attributes)
  {
    $attributes['subscription_id'] = $attributes['subscription']['id'];
    $attributes['accepted_by'] = $attributes['accepted_by']['id'];

    $attributes['school_id'] = $attributes['school']['id'];

    dd($attributes);
    unset($attributes['subscription'], $attributes['accepted_by'], $attributes['school']);

    return parent::update($model, $attributes);
  }

  public function allowedIncludes(): array
  {
    return [
      'subscription:id',
      'school:id, name',
    ];
  }
  public function defaultIncludes(): array
  {
    return ['subscription:id', 'school:id,name', 'acceptedBy:id,name'];
  }
  public function allowedSorts(): array
  {
    return [
      "start_date",
      "end_date",
      "accepted",
      "content",
      "file",
      "authorization_date",
    ];
  }
  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::exact('subscription.id', 'subscription_id'),
      AllowedFilter::exact('accepted_by.id', 'accepted_by'),
      AllowedFilter::exact('start_date'),
      AllowedFilter::exact('end_date'),
      AllowedFilter::custom('exempted', new BooleanFilter()),
      AllowedFilter::partial('content'),
      AllowedFilter::partial('file'),
      AllowedFilter::exact('authorization_date'),
      AllowedFilter::exact('school.id', 'school_id'),
    ];
  }
  public function allowedFields(): array
  {
    return [
      "start_date",
      "end_date",
      "accepted",
      "content",
      "file",
      "authorization_date",

      'subscription_id',
      'subscription.id',

      'school_id',
      'school.id',
      'school.name',
    ];
  }
  public function searchFields(): array
  {
    return [
      "start_date",
      "end_date",
      "accepted",
      "content",
      "file",
      "authorization_date",
    ];
  }
  public function model()
  {
    return StudentAbsenceAuthorizationRequest::class;
  }
}
