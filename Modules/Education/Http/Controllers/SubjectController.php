<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Subject;
use Modules\Education\Http\Requests\SubjectRequest;
use Modules\Education\Repositories\SubjectRepository;
use Modules\Education\Transformers\SubjectResource;

class SubjectController extends \App\Http\Controllers\Controller
{
  protected SubjectRepository $repository;

  public function __construct(SubjectRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.subject.store')->only('store');
    $this->middleware('permission:education.subject.update')->only('update');
    $this->middleware('permission:education.subject.destroy')->only('destroy');
    $this->middleware('permission:education.subject.index')->only('index');
    $this->middleware('permission:education.subject.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return SubjectResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(SubjectRequest $request)
  {
    $data = $request->validated();

    $subject = $this->repository->create($data);

    return SubjectResource::make($subject);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $subject = $this->repository->find($id);

    return SubjectResource::make($subject);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(SubjectRequest $request, Subject $subject)
  {
    $data = $request->validated();

    $subject = $this->repository->update($subject, $data);

    return SubjectResource::make($subject);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Subject $subject)
  {
    $this->repository->delete($subject);

    return response()->json([
      'success' => true,
      'message' => 'Subject deleted.',
    ]);
  }
}
