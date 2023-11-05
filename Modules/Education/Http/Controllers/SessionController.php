<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Session;
use Modules\Education\Http\Requests\SessionRequest;
use Modules\Education\Repositories\SessionRepository;
use Modules\Education\Transformers\SessionResource;

class SessionController extends \App\Http\Controllers\Controller
{
  protected SessionRepository $repository;

  public function __construct(SessionRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.session.store')->only('store');
    $this->middleware('permission:education.session.update')->only('update');
    $this->middleware('permission:education.session.destroy')->only('destroy');
    $this->middleware('permission:education.session.index')->only('index');
    $this->middleware('permission:education.session.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return SessionResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(SessionRequest $request)
  {
    $data = $request->validated();

    $session = $this->repository->create($data);

    return SessionResource::make($session);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $session = $this->repository->find($id);

    return SessionResource::make($session);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(SessionRequest $request, Session $session)
  {
    $data = $request->validated();

    $session = $this->repository->update($session, $data);

    return SessionResource::make($session);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Session $session)
  {
    $this->repository->delete($session);

    return response()->json([
      'success' => true,
      'message' => 'Session deleted.',
    ]);
  }
}
