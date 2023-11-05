<?php

namespace App\Repositories;

use App\Filters\BooleanFilter;
use App\Models\State;
use App\Sorts\BelongsToSort;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @template T of \App\Models\State
 */
class StateRepository extends BaseRepository
{
  public function create(array $data): State
  {
    $data['country_id'] = $data['country']['id'];

    unset($data['country']);

    return parent::create($data);
  }

  public function update($model, array $attributes)
  {
    if (isset($attributes['country']['id'])) {
      $attributes['country_id'] = $attributes['country']['id'];
    }

    unset($attributes['country']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return State::class;
  }

  public function allowedIncludes(): array
  {
    return ['cities', 'country'];
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'name',
      'country_id',
      'country_code',
      'fips_code',
      'iso2',
      'type',
      'latitude',
      'longitude',
      'flag',
      'wikiDataId',
      'countries.id',
      'countries.name',
      'created_at',
      'updated_at',
    ];
  }

  public function defaultIncludes(): array
  {
    return ['country:id,name'];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('name'),
      AllowedSort::field('country_id'),
      AllowedSort::field('country_code'),
      AllowedSort::field('fips_code'),
      AllowedSort::field('iso2'),
      AllowedSort::field('type'),
      AllowedSort::field('latitude'),
      AllowedSort::field('longitude'),
      AllowedSort::custom('country', new BelongsToSort('country')),
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
      AllowedFilter::partial('type'),
      AllowedFilter::partial('fips_code'),
      AllowedFilter::partial('country_code'),
      AllowedFilter::exact('country', 'country_id'),
      AllowedFilter::partial('iso2'),
      AllowedFilter::exact('latitude'),
      AllowedFilter::exact('longitude'),
      AllowedFilter::custom('flag', BooleanFilter::make()),
    ];
  }
}
