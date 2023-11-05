<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\Classroom;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Classroom
 */
class ClassroomRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['school_id'] = $attributes['school']['id'];
    $attributes['classroom_type_id'] = $attributes['classroomType']['id'];

    unset($attributes['school'], $attributes['classroomType']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['school_id'] = $attributes['school']['id'];
    $attributes['classroom_type_id'] = $attributes['classroomType']['id'];

    unset($attributes['school'], $attributes['classroomType']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Classroom::class;
  }

  public function allowedIncludes(): array
  {
    return ['school', 'classroomType'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "school_id",
      "classroom_type_id",
      "schools.id",
      "schools.name",
      "classroomTypes.id",
      "classroomTypes.name",
      "name",
      "rtl_name",
      "capacity",
      "image",
      "created_at",
      "updated_at",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
      'rtl_name',
      'capacity',
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
      AllowedFilter::exact('capacity'),
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
    return ['school:id,name', 'classroomType'];
  }

}
