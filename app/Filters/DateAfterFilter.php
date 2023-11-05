<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DateAfterFilter implements Filter
{
  public function __invoke(Builder $query, $value, string $property)
  {
    $query->whereDate($property, '>=', $value);
  }
}
