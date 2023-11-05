<?php

namespace Modules\Education\Entities\Enum;
use App\Models\Enums\LabeledBackedEnum;

enum PaymentMethod: int implements LabeledBackedEnum
{
  case CASH = 1;
  case CHEQUE = 2;
  case BANK_TRANSFER = 3;
  case CREDIT_CARD = 4;
  case OTHER = 5;

  public function label(): string
  {
    return match ($this) {
      PaymentMethod::CASH => 'Cash',
      PaymentMethod::CHEQUE => 'Cheque',
      PaymentMethod::BANK_TRANSFER => 'Bank Transfer',
      PaymentMethod::CREDIT_CARD => 'Credit Card',
      PaymentMethod::OTHER => 'Other',

    };
  }
}
