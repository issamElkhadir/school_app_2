<?php

namespace App\Repositories;

use App\Filters\BooleanFilter;
use App\Models\Currency;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @template T of \App\Models\Currency
 */
class CurrencyRepository extends BaseRepository
{
  public function model()
  {
    return Currency::class;
  }

  public function allowedIncludes(): array
  {
    return [];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "code",
      "name",
      "symobl",
      "is_active",
      "symbol_native",
      "decimal_digits",
      "rounding",
      "name_plural",
      "created_at",
      "updated_at"
    ];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('name'),
      AllowedSort::field('status'),
      AllowedSort::field('symbol_native'),
      AllowedSort::field('decimal_digits'),
      AllowedSort::field('rounding'),
      AllowedSort::field('symbol'),
      AllowedSort::field('name_plural'),
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('code'),
      AllowedFilter::partial('symbol'),
      AllowedFilter::custom('is_active', new BooleanFilter()),
      AllowedFilter::partial('symbol_native'),
      AllowedFilter::exact('decimal_digits'),
      AllowedFilter::exact('rounding'),
      AllowedFilter::partial('name_plural'),
    ];
  }

  public function searchFields(): array
  {
    return ['name'];
  }
}
