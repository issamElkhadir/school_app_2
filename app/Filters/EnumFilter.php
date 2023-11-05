<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

/**
 * @method static static make(string $enumClass)
 */
class EnumFilter implements Filter
{
  use Makeable;

  protected string $enumClass;

  public function __construct(string $enumClass)
  {
    $this->enumClass = $enumClass;
  }

  public function __invoke(Builder $query, $value, string $property)
  {
    if (!is_array($value)) {
      $value = [$value];
    }

    $values = [];

    foreach ($value as $item) {
      try {
        $item = $this->enumClass::tryFrom($item);

        if (!is_null($item)) {
          $values[] = $item->value;
        }
      } catch (\Throwable $th) {
        // Do nothing
      }
    }

    if (empty($values)) return;

    $query->whereIn($property, $values);
  }

  /**
   * @param string $enumClass Enum class name
   *
   * @return static $this
   */
  public static function make(string $enumClass): self
  {
    return new static($enumClass);
  }
}
