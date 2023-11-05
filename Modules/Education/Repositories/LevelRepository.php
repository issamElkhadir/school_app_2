<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Filters\EnumFilter;
use App\Models\Enums\UserTheme;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Classroom;
use Modules\Education\Entities\Guardian;
use Modules\Education\Entities\Level;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Level
 */
class LevelRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['branch_id'] = $attributes['branch']['id'];

    unset($attributes['branch']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['branch_id'] = $attributes['branch']['id'];

    unset($attributes['branch']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Level::class;
  }

  public function allowedIncludes(): array
  {
    return ['branch'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "branch_id",
      "branches.id",
      "branches.name",
      "name",
      "rtl_name",
      "short_name",
      "status",
      "description",

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
      'short_name',
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
      AllowedFilter::exact('branch.id', 'branch_id'),
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
    return ['branch:id,name'];
  }

}
