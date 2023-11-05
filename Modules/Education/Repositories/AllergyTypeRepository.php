<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\AllergyType;
use Spatie\QueryBuilder\AllowedFilter;

class AllergyTypeRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['school']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['school']);
    
    return parent::update($model, $attributes);
  }

  public function model()
  {
    return AllergyType::class;
  }

  public function allowedIncludes(): array
  {
    return ['school'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "school_id",
      "schools.id",
      "schools.name",
      "name",
      "description",
      "symptoms",
      "treatment",
      "created_at",
      "updated_at",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
      'created_at',
      'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::exact('school.id', 'school_id'),
      
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
    return ['school:id,name'];
  }
}
