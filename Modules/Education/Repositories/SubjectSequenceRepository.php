<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Filters\EnumFilter;
use App\Models\Enums\UserTheme;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Classroom;
use Modules\Education\Entities\Guardian;
use Modules\Education\Entities\SubjectSequence;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\SubjectSequence
 */
class SubjectSequenceRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['subject_id'] = $attributes['subject']['id'];

    unset($attributes['subject']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['subject_id'] = $attributes['subject']['id'];

    unset($attributes['subject']);


    return parent::update($model, $attributes);
  }

  public function model()
  {
    return SubjectSequence::class;
  }

  public function allowedIncludes(): array
  {
    return ['subject:id,name'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "subject_id",
      "subjects.id",
      "subjects.name",
      "content",
      "nbh",
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
      'content',
      'nbh',
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
      AllowedFilter::exact('subject.id', 'subject_id'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'content',
    ];
  }

  public function defaultIncludes(): array
  {
    return ['subject:id,name'];
  }

}
