<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Education\Entities\Subscription;
use Modules\Education\Http\Requests\SubscriptionRequest;
use Modules\Education\Repositories\SubscriptionRepository;
use Modules\Education\Transformers\SubscriptionResource;

class SubscriptionController extends \App\Http\Controllers\Controller
{
  protected SubscriptionRepository $repository;

  public function __construct(SubscriptionRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.subscription.store')->only('store');
    $this->middleware('permission:education.subscription.update')->only('update');
    $this->middleware('permission:education.subscription.destroy')->only('destroy');
    $this->middleware('permission:education.subscription.index')->only('index');
    $this->middleware('permission:education.subscription.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return SubscriptionResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(SubscriptionRequest $request)
  {
    $data = $request->validated();

    $subscription = $this->repository->create($data);

    return SubscriptionResource::make($subscription);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $subscription = $this->repository->find($id);

    return SubscriptionResource::make($subscription);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(SubscriptionRequest $request, Subscription $subscription)
  {
    $data = $request->validated();

    $subscription = $this->repository->update($subscription, $data);

    return SubscriptionResource::make($subscription);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Subscription $subscription)
  {
    $this->repository->delete($subscription);

    return response()->json([
      'success' => true,
      'message' => 'Subscription deleted.',
    ]);
  }
}
