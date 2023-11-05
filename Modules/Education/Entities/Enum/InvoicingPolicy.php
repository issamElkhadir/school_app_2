<?php

namespace Modules\Education\Entities\Enum;
use App\Models\Enums\LabeledBackedEnum;

enum InvoicingPolicy: int implements LabeledBackedEnum
{
    case YEARLY = 1;
    case MONTHLY = 2;

    public function label(): string
    {
        return match ($this) {
            InvoicingPolicy::YEARLY => 'Yearly',
            InvoicingPolicy::MONTHLY => 'Monthly',
        };
    }
}
