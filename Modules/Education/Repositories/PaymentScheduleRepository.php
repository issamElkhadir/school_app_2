<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Modules\Education\Entities\Enum\InvoicingPolicy;
use Modules\Education\Entities\PaymentBill;
use Modules\Education\Entities\PaymentBillLine;
use Modules\Education\Entities\PaymentSchedule;
use Modules\Education\Entities\Subscription;
use Modules\Education\Settings\GeneralSettings;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\PaymentSchedule
 */
class PaymentScheduleRepository
{
  public function update(Subscription $subscription, array $data): array
  {
    $paymentBill = PaymentBill::query()->with('lines.item')->where('subscription_id', $subscription->id)->first();

    // Load all payment bill lines
    $paymentBillLines = $paymentBill->lines;

    // Delete already planned payments
    PaymentSchedule::query()
      ->whereRelation('paymentBill', 'subscription_id', $subscription->id)
      ->delete();

    $scheduledLines = [
      'lines' => [],
      'planned_total' => 0,
      'all_total' => 0,
    ];

    // Calculate total monthly
    $scheduledLines['monthly_total'] = $paymentBillLines->filter(function ($item) {
      return $item->item->invoicing_policy === InvoicingPolicy::MONTHLY;
    })->reduce(function ($res, $item) {
      return $res + ($item->subtotal * (1 + $item->vat / 100.0));
    }, 0);

    // Calculate total yearly
    $scheduledLines['annual_total'] = $paymentBillLines->filter(function ($item) {
      return $item->item->invoicing_policy === InvoicingPolicy::YEARLY;
    })->reduce(function ($res, $item) {
      return $res + ($item->subtotal * (1 + $item->vat / 100.0));
    }, 0);

    foreach (InvoicingPolicy::cases() as $case) {
//      $lines = $data['paymentScheduled']['lines'][$case->name] ?? [];
      $lines = data_get($data, 'lines.' . $case->name, []);

      foreach ($lines as $line) {
        $scheduledLines['planned_total'] += $line['amount_to_pay'];

        $scheduledLines['lines'][$case->name][] = PaymentSchedule::query()->create([
          'amount_paid' => $line['amount_paid'],
          'amount_to_pay' => $line['amount_to_pay'],
          'payment_date' => $line['payment_date'],
          'payment_bill_id' => $paymentBill->id,
          'invoicing_policy' => $case->value
        ]);
      }
    }

    foreach ($paymentBillLines as $paymentBillLine) {
      $invoicingPolicy = $paymentBillLine->item->invoicing_policy;

      if ($invoicingPolicy === InvoicingPolicy::YEARLY) {
        $scheduledLines['all_total'] += $paymentBillLine->subtotal * (1 + $paymentBillLine->vat / 100.0);
      } elseif ($invoicingPolicy === InvoicingPolicy::MONTHLY) {
        $scheduledLines['all_total'] += $paymentBillLine->subtotal * (1 + $paymentBillLine->vat / 100.0);
      }
    }

    $scheduledLines['all_total'] = round($scheduledLines['all_total'], 2);
    $scheduledLines['planned_total'] = round($scheduledLines['planned_total'], 2);
    $scheduledLines['monthly_total'] = round($scheduledLines['monthly_total'], 2);
    $scheduledLines['annual_total'] = round($scheduledLines['annual_total'], 2);

    return $scheduledLines;
  }

  public function defaultIncludes(): array
  {
    return ['paymentBill:id,name'];
  }

  public function loadBySubscription(Subscription|int $subscription)
  {

    $subscriptionId = $subscription instanceof Subscription ? $subscription->id : $subscription;

    $paymentBillLines = PaymentBillLine::query()
      ->with('item')
      ->whereRelation('paymentBill', 'subscription_id', $subscriptionId)
      ->get();

    $paymentSchedule = PaymentSchedule::query()
      ->whereRelation('paymentBill.subscription', 'subscription_id', $subscriptionId)
      ->get();

    $scheduledLines = [
      'lines' => [
        'YEARLY' => [],
        'MONTHLY' => []
      ],
      'planned_total' => 0,
      'all_total' => 0,
    ];

    // Calculate total monthly
    $scheduledLines['monthly_total'] = $paymentBillLines->filter(function ($item) {
      return $item->item->invoicing_policy === InvoicingPolicy::MONTHLY;
    })->reduce(function ($res, $item) {
      return $res + ($item->subtotal * (1 + $item->vat / 100.0));
    }, 0);

    // Calculate total yearly
    $scheduledLines['annual_total'] = $paymentBillLines->filter(function ($item) {
      return $item->item->invoicing_policy === InvoicingPolicy::YEARLY;
    })->reduce(function ($res, $item) {
      return $res + ($item->subtotal * (1 + $item->vat / 100.0));
    }, 0);

    foreach (InvoicingPolicy::cases() as $case) {
      $scheduledLines['lines'][$case->name] = $paymentSchedule->filter(function ($item) use ($case) {
        return $item->invoicing_policy === $case;
      })->values();
    }

    foreach ($paymentSchedule as $line) {
      $scheduledLines['planned_total'] += $line['amount_to_pay'];
    }

    foreach ($paymentBillLines as $paymentBillLine) {
      $invoicingPolicy = $paymentBillLine->item->invoicing_policy;

      if ($invoicingPolicy === InvoicingPolicy::YEARLY) {
        $scheduledLines['all_total'] += $paymentBillLine->subtotal * (1 + $paymentBillLine->vat / 100.0);
      } elseif ($invoicingPolicy === InvoicingPolicy::MONTHLY) {
        $scheduledLines['all_total'] += $paymentBillLine->subtotal * (1 + $paymentBillLine->vat / 100.0);
      }
    }

    return $scheduledLines;
  }

  public function generate(Subscription|int $subscription)
  {
    $subscriptionId = $subscription instanceof Subscription ? $subscription->id : $subscription;

    $paymentBill = PaymentBill::with('lines.item')->whereRelation('subscription', 'id', $subscriptionId)->first();

    if (!$paymentBill) return ;

    $scheduleLines = [
      'lines' => [],
      'monthly_total' => 0,
      'annual_total' => 0,
      'all_total' => 0,
      'planned_total' => 0
    ];

    $settings = app(GeneralSettings::class);
    $startMonth = $settings->start_month ?? 9;
    $endMonth = $settings->end_month ?? 6;

    $fromDate = CarbonImmutable::create(null, $startMonth);

    $toDate = $fromDate->addYear()->setMonth($endMonth);

    $monthlySchedule = $this->generateMonthlyPaymentSchedule($paymentBill, $fromDate, $toDate);

    $yearlySchedule = $this->generateYearlyPaymentSchedule($paymentBill);

    $scheduleLines['monthly_total'] += $monthlySchedule['monthly_total'];
    $scheduleLines['annual_total'] += $yearlySchedule['annual_total'];
    $scheduleLines['all_total'] += $monthlySchedule['monthly_total'] + $yearlySchedule['annual_total'];
    $scheduleLines['planned_total'] += $monthlySchedule['planned_total'] + $yearlySchedule['planned_total'];

    $scheduleLines['lines'][InvoicingPolicy::MONTHLY->name] = $monthlySchedule['lines'];
    $scheduleLines['lines'][InvoicingPolicy::YEARLY->name] = $yearlySchedule['lines'];

    // Round the totals
    $scheduleLines['monthly_total'] = round($scheduleLines['monthly_total'], 2);
    $scheduleLines['annual_total'] = round($scheduleLines['annual_total'], 2);
    $scheduleLines['all_total'] = round($scheduleLines['all_total'], 2);
    $scheduleLines['planned_total'] = round($scheduleLines['planned_total'], 2);

    return $scheduleLines;
  }

  private function generateYearlyPaymentSchedule(PaymentBill $paymentBill): array
  {
    $yearlySchedule = $paymentBill->lines->filter(function ($item) {
      return $item->item->invoicing_policy === InvoicingPolicy::YEARLY;
    });

    $schedule = [
      'lines' => [],
      'annual_total' => 0,
      'all_total' => 0,
      'planned_total' => 0,
    ];

    foreach ($yearlySchedule as $item) {
      foreach (range(0, $item->quantity - 1) as $i) {
        $amountToPay = $item->price_unit * (1 + $item->vat / 100.0);

        $schedule['annual_total'] += $amountToPay;
        $schedule['all_total'] += $amountToPay;
        $schedule['planned_total'] += $amountToPay;

        $schedule['lines'][] = [
          'amount_paid' => 0,
          'amount_to_pay' => $amountToPay,
          'payment_date' => now()->addYears($i),
          'payment_bill_id' => $paymentBill->id,
          'invoicing_policy' => InvoicingPolicy::YEARLY
        ];
      }
    }

    return $schedule;
  }

  private function generateMonthlyPaymentSchedule(PaymentBill $paymentBill, CarbonImmutable $fromDate, CarbonImmutable $toDate): array
  {
    $monthlySchedule = $paymentBill->lines->filter(function ($item) {
      return $item->item->invoicing_policy === InvoicingPolicy::MONTHLY;
    });

    $months = CarbonPeriod::create($fromDate, '1 month', $toDate)->toArray();

    $schedule = [
      'monthly_total' => 0,
      'all_total' => 0,
      'planned_total' => 0,
      'lines' => []
    ];

    if (!empty($monthlySchedule)) {

      // Calculate total monthly for each month
      // The quantity is divided by the number of months
      // Ex. if quantity of an item is 3
      // Then the item should be calculated for the first 3 months
      // And the quantity should be 1 for each month
      foreach ($months as $key => $month) {
        $total = 0;

        /** @var PaymentBillLine */
        foreach ($monthlySchedule as $item) {
          if ($item->quantity > $key) {
            $total = $total + $item->price_unit * (1 + $item->vat / 100.0);
          }
        }

        if ($total == 0) {
          continue;
        }

        $schedule['monthly_total'] += $total;
        $schedule['all_total'] += $total;
        $schedule['planned_total'] += $total;

        $schedule['lines'][] = [
          'amount_paid' => 0,
          'amount_to_pay' => round($total, 2),
          'payment_date' => $month,
          'payment_bill_id' => $paymentBill->id,
          'invoicing_policy' => InvoicingPolicy::MONTHLY
        ];
      }
    }

    return $schedule;
  }

}
