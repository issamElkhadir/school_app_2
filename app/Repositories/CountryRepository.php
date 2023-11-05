<?php

namespace App\Repositories;

use App\Models\Country;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @template T of \App\Models\Country
 */
class CountryRepository extends BaseRepository
{
  public function model()
  {
    return Country::class;
  }

  public function allowedIncludes(): array
  {
    return [
      'cities',
      'states',
    ];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
      "native",
      "region",
      "phone_code",
      "created_at",
      "updated_at",
    ];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('name'),
      AllowedSort::field('region'),
      AllowedSort::field('phone_code'),
      AllowedSort::field('native'),
      AllowedSort::field('created_at'),
      AllowedSort::field('updated_at'),
    ];
  }

  public function searchFields(): array
  {
    return ['name'];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('native'),
      AllowedFilter::partial('phone_code'),
      AllowedFilter::partial('region'),
    ];
  }
}
