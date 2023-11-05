<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Spatie\QueryBuilder\AllowedInclude;

class DiseaseRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['school']);

    return parent::create($attributes);
  }

  public function update($id, array $attributes)
  {
    if (isset($attributes['school']['id'])) {
      $attributes['school_id'] = $attributes['school']['id'];
    }

    unset($attributes['school']);

    return parent::update($id, $attributes);
  }

  public function model(): string
  {
    return \Modules\Education\Entities\Disease::class;
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'name',
      'description',
    ];
  }

  // public function defaultIncludes(): array
  // {
  //   return [
  //     'school:id,name',
  //   ];
  // }

  public function allowedIncludes(): array
  {
    return [
      AllowedInclude::relationship('school', 'school:id,name'),
    ];
  }

  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
    ];
  }
}
