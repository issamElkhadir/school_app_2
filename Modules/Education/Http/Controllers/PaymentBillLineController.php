<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Education\Entities\PaymentBillLine;
use Modules\Education\Http\Requests\PaymentBillLineRequest;
use Modules\Education\Repositories\PaymentBillLineRepository;
use Modules\Education\Transformers\PaymentBillLineResource;

class PaymentBillLineController extends \App\Http\Controllers\Controller
{
  protected PaymentBillLineRepository $repository;

  public function __construct(PaymentBillLineRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.payment-bill-line.store')->only('store');
    $this->middleware('permission:education.payment-bill-line.update')->only('update');
    $this->middleware('permission:education.payment-bill-line.destroy')->only('destroy');
    $this->middleware('permission:education.payment-bill-line.index')->only('index');
    $this->middleware('permission:education.payment-bill-line.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return PaymentBillLineResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(PaymentBillLineRequest $request)
  {
    $data = $request->validated();

    $paymentBillLine = $this->repository->create($data);

    return PaymentBillLineResource::make($paymentBillLine);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $paymentBillLine = $this->repository->find($id);

    return PaymentBillLineResource::make($paymentBillLine);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(PaymentBillLineRequest $request, PaymentBillLine $paymentBillLine)
  {
    $data = $request->validated();

    $paymentBillLine = $this->repository->update($paymentBillLine, $data);

    return PaymentBillLineResource::make($paymentBillLine);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PaymentBillLine $paymentBillLine)
  {
    $this->repository->delete($paymentBillLine);

    return response()->json([
      'success' => true,
      'message' => 'Payment Bill Line deleted.',
    ]);
  }
}
