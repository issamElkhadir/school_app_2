<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class NotNullFilter implements Filter
{
  public function __invoke(Builder $query, $value, string $property): Builder
  {
    if (is_array($value)) {
      foreach ($value as $v) {
        $query = $this->buildQuery($query, $v);
      }

      return $query;
    }

    return $this->buildQuery($query, $value);
  }

  protected function buildQuery($query, $value)
  {
    return $query->where(function (Builder $query) use ($value) {
      return $query->whereNotNull($value)
        ->where($value, '!=', '');
    });
  }
}
