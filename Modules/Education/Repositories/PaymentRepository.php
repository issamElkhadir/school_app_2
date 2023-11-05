<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\Payment;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Payment
 */
class PaymentRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['staff_id'] = $attributes['staff']['id'];
    $attributes['currency_id'] = $attributes['currency']['id'];
    $attributes['source_cash_register_id'] = $attributes['sourceCashRegister']['id'];
    $attributes['destination_cash_register_id'] = $attributes['destinationCashRegister']['id'];

    unset($attributes['staff'], $attributes['currency'], $attributes['sourceCashRegister'], $attributes['destinationCashRegister']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['staff_id'] = $attributes['staff']['id'];
    $attributes['currency_id'] = $attributes['currency']['id'];
    $attributes['source_cash_register_id'] = $attributes['sourceCashRegister']['id'];
    $attributes['destination_cash_register_id'] = $attributes['destinationCashRegister']['id'];

    unset($attributes['staff'], $attributes['currency'], $attributes['sourceCashRegister'], $attributes['destinationCashRegister']);


    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Payment::class;
  }

  public function allowedIncludes(): array
  {
    return ['staff', 'currency', 'sourceCashRegister', 'destinationCashRegister', 'customer', 'payable'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "staff_id",
      "staff.id",
      "staff.name",

      "currency_id",
      "currencies.id",
      "currencies.name",

      "source_cash_register_id",
      "sourceCashRegisters.id",
      "sourceCashRegisters.name",

      "destination_cash_register_id",
      "destinationCashRegisters.id",
      "destinationCashRegisters.name",

      "memo",
      "amount",
      "payment_date",


      "created_at",
      "updated_at",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'staff_id',
      'currency_id',
      'source_cash_register_id',
      'destination_cash_register_id',
      'memo',
      'amount',
      'payment_date',
      'invoicing_policy',

      'created_at',
      'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('memo'),
      AllowedFilter::exact('amount_paid'),
      AllowedFilter::exact('payment_date'),
      AllowedFilter::partial('payment_date'),
      AllowedFilter::exact('staff.id', 'staff_id'),
      AllowedFilter::exact('currency.id', 'currency_id'),
      AllowedFilter::exact('sourceCashRegister.id', 'source_cash_register_id'),
      AllowedFilter::exact('destinationCashRegister.id', 'destination_cash_register_id'),
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
    return ['staff', 'currency', 'sourceCashRegister', 'destinationCashRegister', 'payable'];
  }

}
