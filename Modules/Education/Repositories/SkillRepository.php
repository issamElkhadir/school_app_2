<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\Skill;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of Skill
 */
class SkillRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['staff_id'] = $attributes['staff']['id'];
    $attributes['subject_id'] = $attributes['subject']['id'];
    $attributes['level_id'] = $attributes['level']['id'];

    unset($attributes['staff'], $attributes['subject'], $attributes['level']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['staff_id'] = $attributes['staff']['id'];
    $attributes['subject_id'] = $attributes['subject']['id'];
    $attributes['level_id'] = $attributes['level']['id'];

    unset($attributes['staff'], $attributes['subject'], $attributes['level']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Skill::class;
  }

  public function allowedIncludes(): array
  {
    return ['staff', 'subject', 'level'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "staff_id",
      "staff.id",
      "staff.name",
      "subject_id",
      "subjects.id",
      "subjects.name",
      "level_id",
      "levels.id",
      "levels.name",
      "note",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'note',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('note'),
      AllowedFilter::exact('staff.id', 'staff_id'),
      AllowedFilter::exact('subject.id', 'subject_id'),
      AllowedFilter::exact('level.id', 'level_id'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'note',
    ];
  }

  public function defaultIncludes(): array
  {
    return ['staff', 'subject', 'level'];
  }

}
