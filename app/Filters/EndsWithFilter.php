<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class EndsWithFilter implements Filter
{
  public function __invoke(Builder $query, $value, string $property)
  {
    return $query->where($property, 'like', '%' . $value);
  }
}
