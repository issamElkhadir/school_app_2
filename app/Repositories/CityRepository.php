<?php

namespace App\Repositories;

use App\Models\City;
use App\Sorts\BelongsToSort;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @template T of \App\Models\City
 */
class CityRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    // Exract state and country from attributes
    $attributes['state_id'] = $attributes['state']['id'];
    $attributes['country_id'] = $attributes['country']['id'];

    unset($attributes['state'], $attributes['country']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    if (isset($attributes['state']['id'])) {
      $attributes['state_id'] = $attributes['state']['id'];
    }

    if (isset($attributes['country']['id'])) {
      $attributes['country_id'] = $attributes['country']['id'];
    }

    unset($attributes['state'], $attributes['country']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return City::query()->with('state:id,name', 'country:id,name');
  }

  public function allowedIncludes(): array
  {
    return [
      AllowedInclude::relationship('state', 'state:id,name'),
      AllowedInclude::relationship('country', 'country:id,name'),
    ];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
      "state_id",
      "state_code",
      "country_id",
      "country_code",
      "latitude",
      "longitude",
      "flag",
      "wikiDataId",
      "states.id",
      "states.name",
      "countries.id",
      "countries.name",
      "region",
      "phone_code",
      "created_at",
      "updated_at"
    ];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('name'),
      AllowedSort::field('country', 'country_id'),
      AllowedSort::field('state', 'state_id'),
      AllowedSort::field('country', 'country_code'),
      AllowedSort::field('state', 'state_code'),
      AllowedSort::field('latitude', 'latitude'),
      AllowedSort::field('longitude', 'longitude'),
      AllowedSort::field('flag', 'flag'),
      AllowedSort::custom('country', new BelongsToSort('country')),
      AllowedSort::custom('state', new BelongsToSort('state')),
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::exact('country', 'country_id'),
      AllowedFilter::exact('state', 'state_id'),
      AllowedFilter::partial('country_code', 'country_code'),
      AllowedFilter::partial('state_code', 'state_code'),
      AllowedFilter::exact('latitude', 'latitude'),
      AllowedFilter::exact('longitude', 'longitude'),
      AllowedFilter::exact('flag', 'flag'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'name',
    ];
  }
}
