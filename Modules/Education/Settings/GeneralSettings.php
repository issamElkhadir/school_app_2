<?php

namespace Modules\Education\Settings;

use App\Models\Sequence;
use App\Settings\Casts\BelongsToCast;
use App\Settings\Validation\ValidatableSettings;
use Modules\Education\Http\Requests\UpdateGeneralSettingsRequest;
use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings implements ValidatableSettings
{
  /** @var Sequence|null */
  public $subscription_sequence;

  /** @var Sequence|null */
  public $payment_bill_sequence;

  public int $start_month;

  public int $end_month;

  public static function group(): string
  {
    return 'education/general';
  }

  public function validator(\Illuminate\Http\Request $request): string
  {
    return UpdateGeneralSettingsRequest::class;
  }

  public static function casts(): array
  {
    return [
      'subscription_sequence' => new BelongsToCast(Sequence::class, ['id', 'name','code']),
      'payment_bill_sequence' => new BelongsToCast(Sequence::class, ['id', 'name','code']),
    ];
  }
}
