<?php

namespace Modules\Accounting\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Accounting\Entities\CashRegister;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

/**
 * @template T of \Modules\Accounting\Entities\CashRegister
 */
class CashRegisterRepository extends BaseRepository
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
    return CashRegister::class;
  }

  public function allowedIncludes(): array
  {
    return [
      AllowedInclude::relationship('owner', 'owner:id,name')
    ];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
      "rtl_name",
      "status",
      "is_real",
      "initial_balance",

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
      'status',
      "is_real",
      "initial_balance",
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
      AllowedFilter::custom('is_real', new BooleanFilter('is_real')),
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
    return ['owner'];
  }

}
