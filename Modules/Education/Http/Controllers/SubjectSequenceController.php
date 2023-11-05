<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\SubjectSequence;
use Modules\Education\Http\Requests\SubjectSequenceRequest;
use Modules\Education\Repositories\SubjectSequenceRepository;
use Modules\Education\Transformers\SubjectSequenceResource;

class SubjectSequenceController extends \App\Http\Controllers\Controller
{
  protected SubjectSequenceRepository $repository;

  public function __construct(SubjectSequenceRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.subject-sequence.store')->only('store');
    $this->middleware('permission:education.subject-sequence.update')->only('update');
    $this->middleware('permission:education.subject-sequence.destroy')->only('destroy');
    $this->middleware('permission:education.subject-sequence.index')->only('index');
    $this->middleware('permission:education.subject-sequence.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return SubjectSequenceResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(SubjectSequenceRequest $request)
  {
    $data = $request->validated();

    $subjectSequence = $this->repository->create($data);

    return SubjectSequenceResource::make($subjectSequence);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $subjectSequence = $this->repository->find($id);

    return SubjectSequenceResource::make($subjectSequence);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(SubjectSequenceRequest $request, SubjectSequence $subjectSequence)
  {
    $data = $request->validated();

    $subjectSequence = $this->repository->update($subjectSequence, $data);

    return SubjectSequenceResource::make($subjectSequence);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(SubjectSequence $subjectSequence)
  {
    $this->repository->delete($subjectSequence);

    return response()->json([
      'success' => true,
      'message' => 'Subject Sequence deleted.',
    ]);
  }
}
