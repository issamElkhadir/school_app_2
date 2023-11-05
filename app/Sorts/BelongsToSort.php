<?php

namespace App\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class BelongsToSort implements Sort
{
  protected string $relation;

  protected string $property;

  /**
   * @param string $relation The name of the relation to sort by
   * @param string $property The property of the relation to sort by
   *
   * @return void
   */
  public function __construct(string $relation, string $property = 'name')
  {
    $this->relation = $relation;

    $this->property = $property;
  }

  public function __invoke(Builder $query, bool $descending, string $property)
  {
    $model = $query->getModel();

    $relation = $model->{$this->relation}();

    $relatedTable = $relation->getRelated()->getTable();

    $relatedKey = $relation->getQualifiedOwnerKeyName();

    return $query->join($relatedTable, $relatedKey, "{$model->getTable()}.{$relation->getForeignKeyName()}")
      ->orderBy("{$relatedTable}.{$this->property}", $descending ? 'desc' : 'asc');
  }
}
