<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Filters\EnumFilter;
use App\Models\Enums\UserTheme;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Classroom;
use Modules\Education\Entities\Guardian;
use Modules\Education\Entities\Period;
use Modules\Education\Entities\Unity;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Period
 */
class PeriodRepository extends BaseRepository
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
    return Period::class;
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
      'rtl_name',
      'start_date',
      'end_date',
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
