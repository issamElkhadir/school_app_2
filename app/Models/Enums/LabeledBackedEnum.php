<?php

namespace App\Models\Enums;

interface LabeledBackedEnum extends \BackedEnum
{
  public function label(): string;
}
