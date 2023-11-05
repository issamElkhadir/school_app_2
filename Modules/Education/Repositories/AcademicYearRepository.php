<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\AcademicYear;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of AcademicYear
 */
class AcademicYearRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    if (isset($attributes['parentAcademicYear']['id'])) {
      $attributes['parent_academic_year_id'] = $attributes['parentAcademicYear']['id'];
    }

    unset($attributes['parentAcademicYear']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    if (isset($attributes['parentAcademicYear']['id'])) {
      $attributes['parent_academic_year_id'] = $attributes['parentAcademicYear']['id'];
    }

    unset($attributes['parentAcademicYear']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return AcademicYear::class;
  }

  public function allowedIncludes(): array
  {
    return ['parentAcademicYear:id,name'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "parent_academic_year_id",
      "parentAcademicYear.id",
      "parentAcademicYears.name",
      "name",
      "rtl_name",
      "status",
      "is_locked",
      "start_date",
      "end_date",

      "created_at",
      "updated_at",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
      "rtl_name",
      "status",
      "is_locked",
      "start_date",
      "end_date",

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
      AllowedFilter::custom('is_locked', new BooleanFilter('is_locked')),
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'name',
    ];
  }


}
