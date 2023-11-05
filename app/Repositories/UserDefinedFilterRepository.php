<?php

namespace App\Repositories;

use App\Filters\BooleanFilter;
use App\Models\UserDefinedFilter;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \App\Models\UserDefinedFilter
 */
class UserDefinedFilterRepository extends BaseRepository
{
  public function model()
  {
    return UserDefinedFilter::class;
  }

  public function allowedIncludes(): array
  {
    return ['user'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
      "filter",
      "user_id",
      "created_at",
      "updated_at"
    ];
  }

  public function allowedSorts(): array
  {
    return [];
  }

  public function searchFields(): array
  {
    return ['name', 'model'];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::partial('name'),
      AllowedFilter::exact('model'),
      AllowedFilter::custom('is_default', BooleanFilter::make()),
      AllowedFilter::custom('is_enabled', BooleanFilter::make()),
    ];
  }
}
