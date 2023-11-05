<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\StudentAuthorizationRequest;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of StudentAuthorizationRequest
 */
class StudentAuthorizationRequestRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['subscription_id'] = $attributes['subscription']['id'];
    $attributes['unity_id'] = $attributes['unity']['id'];
    $attributes['authorized_by'] = $attributes['authorized_by']['id'];
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['subscription'],$attributes['authorized_by'], $attributes['unity'], $attributes['school']);

    return parent::create($attributes);
  }
  public function update($model, array $attributes)
  {
    $attributes['subscription_id'] = $attributes['subscription']['id'];
    $attributes['unity_id'] = $attributes['unity']['id'];
    $attributes['authorized_by'] = $attributes['authorized_by']['id'];
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['subscription'],$attributes['authorized_by'], $attributes['unity'], $attributes['school']);

    return parent::update($model, $attributes);
  }

  public function allowedIncludes(): array
  {
    return [
      'subscription:id',
      'unity:id, name',
      'school:id, name',
    ];
  }
  public function defaultIncludes(): array
  {
    return ['subscription:id', 'unity:id,name', 'school:id,name', 'authorizedBy:id,name'];
  }
  public function allowedSorts(): array
  {
    return [
      "exempted",
      "content",
      "authorization_date",
      "file",
    ];
  }
  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::exact('subscription.id', 'subscription_id'),
      AllowedFilter::exact('unity.id', 'unity_id'),
      AllowedFilter::exact('authorizedBy.id', 'authorized_by'),
      AllowedFilter::custom('exempted', new BooleanFilter()),
      AllowedFilter::partial('content'),
      AllowedFilter::exact('authorization_date'),
      AllowedFilter::partial('file'),
      AllowedFilter::exact('school.id', 'school_id'),
    ];
  }
  public function allowedFields(): array
  {
    return [
      'id',
      'exempted',
      'content',
      'authorization_date',
      'file',

      'subscription_id',
      'subscription.id',

      'unity_id',
      'unity.id',
      'unity.name',

      'authorized_by',
      'user.id',
      'user.name',

      'school_id',
      'school.id',
      'school.name',
    ];
  }
  public function searchFields(): array
  {
    return [
      "exempted",
      "content",
      "authorization_date",
      "file",
    ];
  }
  public function model()
  {
    return StudentAuthorizationRequest::class;
  }
}
