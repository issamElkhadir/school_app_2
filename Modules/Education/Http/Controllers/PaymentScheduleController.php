<?php

namespace Modules\Education\Http\Controllers;

use Modules\Education\Entities\Subscription;
use Modules\Education\Http\Requests\PaymentScheduleRequest;
use Modules\Education\Repositories\PaymentScheduleRepository;

class PaymentScheduleController extends \App\Http\Controllers\Controller
{
  protected PaymentScheduleRepository $repository;

  public function __construct(PaymentScheduleRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.payment-schedule.store')->only('store');
    $this->middleware('permission:education.payment-schedule.update')->only('update');
    $this->middleware('permission:education.payment-schedule.destroy')->only('destroy');
    $this->middleware('permission:education.payment-schedule.index')->only('index');
    $this->middleware('permission:education.payment-schedule.show')->only('show');
  }

  public function index(Subscription $subscription)
  {
    $scheduledLines = $this->repository->loadBySubscription($subscription);

    return [
      'record' => $scheduledLines
    ];
  }

  public function generate(Subscription $subscription)
  {
    $scheduleLines = $this->repository->generate($subscription);

    return [
      'success' => true,
      'message' => 'Payment schedule generated.',
      'record' => $scheduleLines,
    ];
  }

  public function update(PaymentScheduleRequest $request, Subscription $subscription)
  {
    $data = $request->validated();

    $scheduledLines = $this->repository->update($subscription, $data);

    return [
      'success' => true,
      'record' => $scheduledLines,
    ];
  }

}
