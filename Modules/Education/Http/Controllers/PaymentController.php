<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Education\Entities\Payment;
use Modules\Education\Http\Requests\PaymentRequest;
use Modules\Education\Repositories\PaymentRepository;
use Modules\Education\Transformers\PaymentResource;

class PaymentController extends \App\Http\Controllers\Controller
{
  protected PaymentRepository $repository;

  public function __construct(PaymentRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.payment.store')->only('store');
    $this->middleware('permission:education.payment.update')->only('update');
    $this->middleware('permission:education.payment.destroy')->only('destroy');
    $this->middleware('permission:education.payment.index')->only('index');
    $this->middleware('permission:education.payment.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return PaymentResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(PaymentRequest $request)
  {
    $data = $request->validated();

    $payment = $this->repository->create($data);

    return PaymentResource::make($payment);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $payment = $this->repository->find($id);

    return PaymentResource::make($payment);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(PaymentRequest $request, Payment $payment)
  {
    $data = $request->validated();

    $payment = $this->repository->update($payment, $data);

    return PaymentResource::make($payment);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Payment $payment)
  {
    $this->repository->delete($payment);

    return response()->json([
      'success' => true,
      'message' => 'Payment deleted.',
    ]);
  }
}
