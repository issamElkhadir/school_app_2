<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\Staff;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of Staff
 */
class StaffRepository extends BaseRepository
{

  public function __construct(protected SkillRepository $skillRepository)
  {
    parent::__construct();
  }

  public function create(array $attributes)
  {
    $schools = $attributes['schools'];

    unset($attributes['schools']);

    /** @var Staff $model */
    $model = parent::create(\Arr::except($attributes, ['skills']));

    $skills = $attributes['skills'] ?? [];

    foreach ($skills as $skill) {
      $skill['staff'] = $model->only(['id']);

      // Ignore id if it is set
      $this->skillRepository->create(\Arr::except($skill, ['id']));
    }

    $model->schools()->sync(array_column($schools, 'id'));

    $model->load(['skills', 'skills.level:id,name', 'skills.subject:id,name']);

    return $model;

  }

  /**
   * @param T $model
   * @param array $attributes
   * @return T
   */
  public function update($model, array $attributes)
  {
    /**
     * @var Staff $model
     */
    $model->schools()->sync(array_column($attributes['schools'], 'id'));

    unset($attributes['schools']);

    $model = parent::update($model, \Arr::except($attributes, ['skills']));

    $skills = $attributes['skills'] ?? [];


    $this->skillRepository
      ->whereBelongsTo($model, 'staff');

    foreach ($skills as &$skill) {

      $skill['staff'] = $model->only(['id']);

      if (isset($skill['id'])) {
        $this->skillRepository
          ->update($skill['id'], \Arr::except($skill, ['id']));
      } else {
        $skill = $this->skillRepository->create(\Arr::except($skill, ['id']));
      }
    }

    // remove skills that are not in the request
    $this->skillRepository
      ->whereBelongsTo($model, 'staff')
      ->whereNotIn('id', array_filter(\Arr::pluck($skills, 'id')))
      ->delete();

    $model->load([
      'skills' => fn($query) => $query->orderBy('id'),
      'skills.level:id,name',
      'skills.subject:id,name',
    ]);

    return $model;
  }

  public function model()
  {
    return Staff::class;
  }

  public function allowedIncludes(): array
  {
    return [
      'schools',
      'skills'
    ];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
      "email",
      "phone",
      "address",
      "salary",
      "week_hours",
      "schools.id",
      "schools.name",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      "id",
      "name",
      "email",
      "phone",
      "address",
      "salary",
      "week_hours",
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('email'),
      AllowedFilter::partial('address'),
      AllowedFilter::partial('phone'),
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
    return [
      'schools',
      'skills',
      'skills.level:id,name',
      'skills.subject:id,name'
    ];
  }

}
