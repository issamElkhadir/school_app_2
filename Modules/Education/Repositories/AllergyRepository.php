<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Allergy;

use Spatie\QueryBuilder\AllowedFilter;

class AllergyRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['school_id'] = $attributes['school']['id'];

    $attributes['allergy_type_id'] = $attributes['allergy_type']['id'];

    unset($attributes['school'], $attributes['allergy_type']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['school_id'] = $attributes['school']['id'];

    $attributes['allergy_type_id'] = $attributes['allergy_type']['id'];

    unset($attributes['school'], $attributes['allergy_type']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Allergy::class;
  }

  public function allowedIncludes(): array
  {
    return ['school', 'allergyType'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "school_id",
      "schools.id",
      "schools.name",
      "allergy_type_id",
      "allergy_types.id",
      "allergy_types.name",
      "name",
      "rtl_name",
      "short_name",
      "description",
      "status",

    ];
  }

  public function allowedSorts(): array
  {
    return [
        'id',
        'name',
        'rtl_name',
        'short_name',
        'created_at',
        'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('rtl_name'),
      AllowedFilter::partial('short_name'),
      AllowedFilter::partial('description'),
      AllowedFilter::custom('status', new BooleanFilter('status')),
      AllowedFilter::exact('school.id', 'school_id'),
      AllowedFilter::exact('allergy_type.id', 'allergy_type_id'),
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
    return ['school:id,name', 'allergyType:id,name'];
  }
}
