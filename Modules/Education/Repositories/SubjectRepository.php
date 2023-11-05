<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\Subject;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Subject
 */
class SubjectRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['unity_id'] = $attributes['unity']['id'];
    $attributes['classroom_type_id'] = $attributes['classroomType']['id'];

    unset($attributes['unity'], $attributes['classroomType']);

    $periods = $attributes['periods'] ?? [];

    unset($attributes['periods']);

    /** @var Subject $model */
    $model = parent::create($attributes);

    $model->periods()->sync(array_column($periods, 'id'));

    return $model;

//    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['unity_id'] = $attributes['unity']['id'];
    $attributes['classroom_type_id'] = $attributes['classroomType']['id'];

    /**
     * @var Subject $model
     */
    $model->periods()->sync(array_column($attributes['periods'] ?? [], 'id'));

    unset($attributes['unity'], $attributes['classroomType'], $attributes['periods']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Subject::class;
  }

  public function allowedIncludes(): array
  {
    return ['unity', 'classroomType', 'periods'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "unity_id",
      "classroom_type_id",
      "unities.id",
      "unities.name",
      "classroomTypes.id",
      "classroomTypes.name",
      "name",
      "color",
      "massar_id",
      "order",
      "picture",
      "created_at",
      "updated_at",
      "periods.id",
      "periods.name",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
      'color',
      'massar_id',
      'order',
      'created_at',
      'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('massar_id'),
      AllowedFilter::exact('order'),
      AllowedFilter::exact('unity.id', 'unity_id'),
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
    return ['unity:id,name', 'classroomType:id,name'];
  }

}
