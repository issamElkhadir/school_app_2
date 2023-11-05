<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\AchievementType;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of AchievementType
 */
class AchievementTypeRepository extends BaseRepository
{

  public function create(array $attributes)
  {
    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    return parent::update($model, $attributes);
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name')
    ];
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'name'
    ];
  }

  public function searchFields(): array
  {
    return [
      'name'
    ];
  }

  public function model()
  {
    return AchievementType::class;
  }
}
