<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\SanctionType;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of SanctionType
 */
class SanctionTypeRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['school']);
    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['school_id'] = $attributes['school']['id'];

    unset($attributes['school']);
    return parent::update($model, $attributes);
  }

  public function model()
  {
    return SanctionType::class;
  }

  public function allowedIncludes(): array
  {
    return ['school'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "school_id",
      "name",
      "rtl_name",
      "short_name",
      "description",
      "status",
      "school.id",
      "school.name",
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
      AllowedFilter::exact('school', 'school_id'),
      AllowedFilter::partial('name'),
      AllowedFilter::custom('status', BooleanFilter::make()),
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
    return ['school:id,name'];
  }
}
