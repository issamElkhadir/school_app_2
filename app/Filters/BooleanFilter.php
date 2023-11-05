<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

/** @method static static make() */
class BooleanFilter implements Filter
{
  use Makeable;

  public function __invoke(Builder $query, $value, string $property)
  {
    if (in_array($value, ['true', true, 1, '1'], true)) {
      $value = true;
    } elseif (in_array($value, ['false', false, 0, '0'], true)) {
      $value = false;
    } else {
      return;
    }

    $query->where($property, $value);
  }
}
