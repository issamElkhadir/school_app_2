<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class StartsWithFilter implements Filter
{
  use Makeable;

  public function __invoke(Builder $query, $value, string $property)
  {
    return $query->where($property, 'like', $value . '%');
  }
}
