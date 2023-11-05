<?php

namespace App\Models\Enums;

enum MeasureUnitType: string
{
  case SMALLER = 'smaller';

  case REFERENCE = 'reference';

  case BIGGER = 'bigger';

  public function label(): string
  {
    return match ($this) {
      MeasureUnitType::SMALLER => 'Smaller than reference Unit of Measure',
      MeasureUnitType::REFERENCE => 'Reference Unit of Measure for this category',
      MeasureUnitType::BIGGER => 'Bigger than reference Unit of Measure',
    };
  }

  public function toArray(): array
  {
    return [
      'value' => $this->value,
      'label' => $this->label(),
    ];
  }
}
