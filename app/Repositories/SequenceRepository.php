<?php

namespace App\Repositories;

use App\Models\Sequence;
use App\Sorts\BelongsToSort;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @template T of \App\Models\Sequence
 */
class SequenceRepository extends BaseRepository
{
  public function create(array $data): Sequence
  {
    $data['school_id'] = $data['school']['id'];

    unset($data['school']);

    return parent::create($data);
  }

  public function update($model, array $attributes)
  {
    if (isset($attributes['school']['id'])) {
      $attributes['school_id'] = $attributes['school']['id'];
    }
    
    unset($attributes['school']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Sequence::class;
  }

  public function allowedIncludes(): array
  {
    return ['school'];
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'name',
      'code',
      'start_value',
      'end_value',
      'next_value',
      'prefix',
      'suffix',
      'length',
      'step'
    ];
  }

  public function defaultIncludes(): array
  {
    return ['school:id,name'];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('name'),
      AllowedSort::field('code'),
      AllowedSort::field('start_value'),
      AllowedSort::field('end_value'),
      AllowedSort::field('next_value'),
      AllowedSort::field('prefix'),
      AllowedSort::field('suffix'),
      AllowedSort::field('length'),
      AllowedSort::field('step'),
      AllowedSort::custom('school', new BelongsToSort('school')),
    ];
  }

  public function searchFields(): array
  {
    return [
      'name',
      'code',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('code'),
      AllowedFilter::exact('start_value'),
      AllowedFilter::exact('end_value'),
      AllowedFilter::exact('next_value'),
      AllowedFilter::partial('prefix'),
      AllowedFilter::partial('suffix'),
      AllowedFilter::exact('length'),
      AllowedFilter::exact('step'),
      AllowedFilter::exact('school', 'school_id'),
    ];
  }
}
