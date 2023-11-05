<?php

namespace Modules\Education\Repositories;

use App\Models\School;
use App\Repositories\BaseRepository;
use App\Services\SequenceGeneratorService;
use Modules\Education\Entities\PaymentBill;
use Modules\Education\Settings\GeneralSettings;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\PaymentBill
 */
class PaymentBillRepository extends BaseRepository
{

  protected GeneralSettings $settings;
  protected SequenceGeneratorService $generator;
  public function __construct(GeneralSettings $settings, SequenceGeneratorService $generator, protected PaymentBillLineRepository $paymentBillLineRepository)
  {
    parent::__construct();
    $this->settings = $settings;
    $this->generator = $generator;
  }

  public function create(array $attributes)
  {
    $attributes['subscription_id'] = $attributes['subscription']['id'];
    $attributes['currency_id'] = $attributes['currency']['id'];

    if (!isset($attributes['sequence'])) {
      if (!$this->settings->payment_bill_sequence) {
        throw new \Exception("Payment Bill Sequence is not set yet");
      }
      $attributes['sequence'] = $this->generator->generate($this->settings->payment_bill_sequence->code);
    }

    unset($attributes['subscription'], $attributes['currency']);

    $attributes['untaxed_amount'] = self::getAmount($attributes, false);
    $attributes['tax_amount'] = self::getAmount($attributes) - self::getAmount($attributes, false);
    $attributes['total_amount'] = self::getAmount($attributes);;
    $attributes['paid_amount'] = 0;
    $attributes['unpaid_amount'] = $attributes['total_amount'];

    $paymentBill = parent::create(\Arr::except($attributes, ['lines']));

    $paymentBillLines = $attributes['lines'] ?? [];

    foreach ($paymentBillLines as $paymentBillLine) {
      $paymentBillLine['paymentBill'] = $paymentBill->only(['id']);
      $paymentBillLine['name'] = $paymentBillLine['item']['name'];
      $paymentBillLine['item_id'] = $paymentBillLine['item']['id'];

      $paymentBillLine['subtotal'] = $paymentBillLine['quantity'] * $paymentBillLine['price_unit'];
      $paymentBillLine['item_type'] = $paymentBillLine['item']['item_type'];

      unset($paymentBillLine['item']);

      // Ignore id if it is set
      $this->paymentBillLineRepository->create(\Arr::except($paymentBillLine, ['id']));
    }

    $paymentBill->load(['lines', 'lines.item', 'lines.unit', 'currency:id,name', 'subscription:id']);

    return $paymentBill;
  }

  public function update($model, array $attributes)
  {
    $attributes['subscription_id'] = $attributes['subscription']['id'];
    $attributes['currency_id'] = $attributes['currency']['id'];

    unset($attributes['subscription'], $attributes['currency']);

    if (!isset($attributes['sequence'])) {
      if (!$this->settings->payment_bill_sequence) {
        throw new \Exception("Payment Bill Sequence is not set yet");
      }
      $attributes['sequence'] = $this->generator->generate($this->settings->payment_bill_sequence->code);
    }

    $attributes['untaxed_amount'] = self::getAmount($attributes, false);
    $attributes['tax_amount'] = self::getAmount($attributes) - self::getAmount($attributes, false);
    $attributes['total_amount'] = self::getAmount($attributes);;
    $attributes['paid_amount'] = 0;
    $attributes['unpaid_amount'] = $attributes['total_amount'];

    $model = parent::update($model, \Arr::except($attributes, ['lines']));

    $lines = $attributes['lines'] ?? [];

    $this->paymentBillLineRepository
      ->whereBelongsTo($model, 'paymentBill');

    foreach ($lines as &$line) {
      $line['paymentBill'] = $model->only(['id']);
      $line['name'] = $line['item']['name'];
      $line['item_id'] = $line['item']['id'];
      $line['subtotal'] = $line['quantity'] * $line['price_unit'];
      $line['item_type'] = $line['item']['item_type'];

      unset($line['item']);

      if (isset($line['id'])) {
        $this->paymentBillLineRepository
          ->update($line['id'], \Arr::except($line, ['id']));
      } else {
        $line = $this->paymentBillLineRepository->create(\Arr::except($line, ['id']));
      }
    }

    // remove lines that are not in the request
    $this->paymentBillLineRepository
      ->whereBelongsTo($model, 'paymentBill')
      ->whereNotIn('id', array_filter(\Arr::pluck($lines, 'id')))
      ->delete();

    $model->load([
      'lines' => fn($query) => $query->orderBy('id'),
      'lines.item', 'lines.unit', 'currency:id,name', 'subscription:id'
    ]);

    return $model;
  }

  private static function getAmount($paymentBill, $includeVat = true): float
  {
    $total = 0;

    foreach ($paymentBill['lines'] as $line) {
      $total += $line['quantity'] * $line['price_unit'] * ($includeVat ? (1 + $line['vat'] / 100) : 1);
    }

    return $total;
  }

  public function model()
  {
    return PaymentBill::class;
  }

  public function allowedIncludes(): array
  {
    return ['subscription', 'currency'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "currency_id",
      "currencies.id",
      "currencies.name",
      "subscription_id",
      "subscriptions.id",
      "subscriptions.name",

      "untaxed_amount",
      "tax_amount",
      "total_amount",
      "paid_amount",
      "unpaid_amount",
      "sequence",

      "created_at",
      "updated_at",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'untaxed_amount',
      'tax_amount',
      'total_amount',
      'paid_amount',
      'unpaid_amount',
      'sequence',
      'created_at',
      'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('sequence'),
      AllowedFilter::exact('currency.id', 'currency_id'),
      AllowedFilter::exact('subscription.id', 'subscription_id'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'name',
    ];
  }

  public function defaultIncludes(): array
  {
    return ['currency:id,name', 'subscription:id'];
  }

}
