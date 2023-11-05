<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\PaymentBillLine;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\PaymentBillLine
 */
class PaymentBillLineRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['payment_bill_id'] = $attributes['paymentBill']['id'];
    $attributes['unit_id'] = $attributes['unit']['id'];

    unset($attributes['paymentBill'], $attributes['unit']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['payment_bill_id'] = $attributes['paymentBill']['id'];
    $attributes['unit_id'] = $attributes['unit']['id'];

    unset($attributes['paymentBill'], $attributes['unit']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return PaymentBillLine::class;
  }

  public function allowedIncludes(): array
  {
    return ['paymentBill', 'unit'. 'item'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "payment_bills_id",
      "paymentBills.id",
      "paymentBills.name",
      "unit_id",
      "measureUnites.id",
      "measureUnites.name",
      "item_id",
      "item_type",


      "price_unit",
      "quantity",
      'vat',
      'subtotal',

      "created_at",
      "updated_at",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      "price_unit",
      "quantity",
      'vat',
      'subtotal',
      'unit',
      'created_at',
      'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::exact('quantity'),
      AllowedFilter::exact('unit.id', 'unit_id'),
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
    return ['paymentBill', 'unit:id,name', 'item'];
  }

}
