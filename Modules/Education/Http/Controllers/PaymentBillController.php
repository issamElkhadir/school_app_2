<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Education\Entities\PaymentBill;
use Modules\Education\Http\Requests\PaymentBillRequest;
use Modules\Education\Repositories\PaymentBillRepository;
use Modules\Education\Transformers\PaymentBillResource;

class PaymentBillController extends \App\Http\Controllers\Controller
{
  protected PaymentBillRepository $repository;

  public function __construct(PaymentBillRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.payment-bill.store')->only('store');
    $this->middleware('permission:education.payment-bill.update')->only('update');
    $this->middleware('permission:education.payment-bill.destroy')->only('destroy');
    $this->middleware('permission:education.payment-bill.index')->only('index');
    $this->middleware('permission:education.payment-bill.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return PaymentBillResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(PaymentBillRequest $request)
  {
    $data = $request->validated();

    $paymentBill = $this->repository->create($data);

    return PaymentBillResource::make($paymentBill);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $paymentBill = $this->repository->find($id);

    return PaymentBillResource::make($paymentBill);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(PaymentBillRequest $request, PaymentBill $paymentBill)
  {
    $data = $request->validated();

    $paymentBill = $this->repository->update($paymentBill, $data);

    return PaymentBillResource::make($paymentBill);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PaymentBill $paymentBill)
  {
    $this->repository->delete($paymentBill);

    return response()->json([
      'success' => true,
      'message' => 'Payment Bill deleted.',
    ]);
  }
}
