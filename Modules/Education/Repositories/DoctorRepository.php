<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\Doctor;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of Doctor
 */
class DoctorRepository extends BaseRepository
{
  public function model()
  {
    return Doctor::class;
  }

  private function prepareAttributes(array $attributes): array
  {
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['school']);

    return $attributes;
  }

  public function create(array $attributes)
  {
    $attributes = $this->prepareAttributes($attributes);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes = $this->prepareAttributes($attributes);

    return parent::update($model, $attributes);
  }


  public function allowedIncludes(): array
  {
    return ['school:id,name'];
  }

  public function defaultIncludes(): array
  {
    return ['school:id,name'];
  }

  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
      'address',
      'phone',
      'email',
      'speciality'
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('address'),
      AllowedFilter::partial('phone'),
      AllowedFilter::partial('email'),
      AllowedFilter::partial('speciality')
    ];
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'name',
      'address',
      'phone',
      'email',
      'speciality',

      'school_id',
      'schools.id',
      'schools.name'
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'name',
      'address',
      'phone',
      'email',
      'speciality'
    ];
  }

}
