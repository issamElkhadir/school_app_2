<?php

namespace App\Filters;

trait Makeable
{
  public static function make(...$args): self
  {
    return new static(...$args);
  }
}
