<?php

namespace Modules\Education\Entities\Enum;
use App\Models\Enums\LabeledBackedEnum;

enum ProductType: string implements LabeledBackedEnum
{
  case SERVICE = 'service';
  case CONSUMABLE = 'consumable';
  case PRODUCT = 'product';

  public function label(): string
  {
    return match ($this) {
      ProductType::SERVICE => 'Service',
      ProductType::CONSUMABLE => 'Consumable',
      ProductType::PRODUCT => 'Product',
    };
  }
}
