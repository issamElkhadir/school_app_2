<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Schedule;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

/**
 * @template T of Schedule
 */
class ScheduleRepository extends BaseRepository
{

  public function create(array $attributes)
  {
    $attributes['class_id'] = $attributes['class']['id'];
    $attributes['level_id'] = $attributes['level']['id'];
    $attributes['branch_id'] = $attributes['branch']['id'];

    unset($attributes['class'], $attributes['level'], $attributes['branch']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['class_id'] = $attributes['class']['id'];
    $attributes['level_id'] = $attributes['level']['id'];
    $attributes['branch_id'] = $attributes['branch']['id'];

    unset($attributes['class'], $attributes['level'], $attributes['branch']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Schedule::class;
  }


  public function allowedIncludes(): array
  {
    return [
      AllowedInclude::relationship('level', 'level:id,name'),
      AllowedInclude::relationship('class', 'class:id,name'),
      AllowedInclude::relationship('branch', 'branch:id,name'),
    ];
  }

  public function defaultIncludes(): array
  {
    return ['class:id,name', 'level:id,name', 'branch:id,name'];
  }

  public function allowedSorts(): array
  {
    return [
      'name',
      'start_date',
      'active',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::custom('active', new BooleanFilter('active')),
    ];
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'name',
      'start_date',
      'active',

      'class_id',
      'classes.id',
      'classes.name',

      'level_id',
      'levels.id',
      'levels.name',

      'branch_id',
      'branches.id',
      'branches.name',
    ];
  }

  public function searchFields(): array
  {
    return [
      'name'
    ];
  }


}
