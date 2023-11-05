<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\ClassroomType;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\ClassroomType
 */
class ClassroomTypeRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    return parent::update($model, $attributes);
  }

  public function model()
  {
    return ClassroomType::class;
  }

  public function allowedIncludes(): array
  {
    return [];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
      "rtl_name",
      "status",
      "created_at",
      "created_by",
      "updated_at",
      "updated_by",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      "id",
      "name",
      "rtl_name",
      "status",
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('rtl_name'),
      AllowedFilter::custom('status', new BooleanFilter('status')),
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
    return [];
  }

}
