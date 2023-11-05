<?php

namespace App\Http\Controllers;

use App\Http\Resources\MailServerResource;
use App\Models\MailServer;
use App\Http\Requests\MailServerRequest;
use App\Repositories\MailServerRepository;

class MailServerController extends Controller
{
  protected MailServerRepository $repository;

  public function __construct(MailServerRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.mail-server.store')->only('store');
    $this->middleware('permission:base.mail-server.update')->only('update');
    $this->middleware('permission:base.mail-server.destroy')->only('destroy');
    $this->middleware('permission:base.mail-server.index')->only('index');
    $this->middleware('permission:base.mail-server.show')->only('show');
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return MailServerResource::collection(
      $this->paginate(request(), $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(MailServerRequest $request)
  {
    $attributes = $request->validated();

    $model = $this->repository->create($attributes);

    return MailServerResource::make($model);
  }

  /**
   * Display the specified resource.
   */
  public function show(MailServer $mailServer)
  {
    return MailServerResource::make($mailServer);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(MailServerRequest $request, MailServer $mailServer)
  {
    $attributes = $request->validated();

    $model = $this->repository->update($mailServer, $attributes);

    return MailServerResource::make($model);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(MailServer $mailServer)
  {
    $this->repository->delete($mailServer);

    return response()->noContent();
  }
}
