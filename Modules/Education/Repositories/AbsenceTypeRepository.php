<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\AbsenceType;
use Spatie\QueryBuilder\AllowedFilter;

class AbsenceTypeRepository extends BaseRepository
{
  public function model()
  {
    return AbsenceType::class;
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'name',
      'rtl_name',
      'status',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('rtl_name'),
      AllowedFilter::custom('status', new BooleanFilter()),
    ];
  }
  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
      'rtl_name',
      'status',
    ];
  }
  public function searchFields(): array
    {
        return [
          'id',
          'name',
          'rtl_name',
          'status',
        ];
    }
}
