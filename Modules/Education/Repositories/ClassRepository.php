<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Clazz;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of Clazz
 */
class ClassRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['level_id'] = $attributes['level']['id'];
    $attributes['school_id'] = $attributes['school']['id'];

    if (isset($attributes['parentClass'])) {
      $attributes['class_id'] = $attributes['parentClass']['id'];
    }
    unset($attributes['level'], $attributes['school'], $attributes['parentClass']);

    $subjects = $attributes['subjects'];

    unset($attributes['subjects']);

    /** @var Clazz $model */
    $model = parent::create($attributes);

    $model->subjects()->sync(array_column($subjects, 'id'));

    return $model;

//    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['level_id'] = $attributes['level']['id'];
    $attributes['school_id'] = $attributes['school']['id'];
    if (isset($attributes['parentClass'])) {
      $attributes['class_id'] = $attributes['parentClass']['id'];
    }
    unset($attributes['level'], $attributes['school'], $attributes['parentClass']);

    /**
     * @var Clazz $model
     */
    $model->subjects()->sync(array_column($attributes['subjects'], 'id'));

    unset($attributes['subjects']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Clazz::class;
  }

  public function allowedIncludes(): array
  {
    return ['level', 'school', 'parentClass'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "level_id",
      "levels.id",
      "levels.name",
      "school_id",
      "schools.id",
      "schools.name",

      "class_id",
      "classes.id",
      "classes.name",
      "name",
      "rtl_name",
      "status",

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
      'status',
      'created_at',
      'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::custom('status', new BooleanFilter('status')),
      AllowedFilter::exact('level.id', 'level_id'),
      AllowedFilter::exact('school.id', 'school_id'),
      AllowedFilter::exact('class.id', 'class_id'),
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
    return ['level:id,name', 'school:id,name', 'parentClass:id,name'];
  }

}
