<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Skill;
use Modules\Education\Http\Requests\SkillRequest;
use Modules\Education\Repositories\SkillRepository;
use Modules\Education\Transformers\SkillResource;

class SkillController extends \App\Http\Controllers\Controller
{
  protected SkillRepository $repository;

  public function __construct(SkillRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.staff.store')->only('store');
    $this->middleware('permission:education.staff.update')->only('update');
    $this->middleware('permission:education.staff.destroy')->only('destroy');
    $this->middleware('permission:education.staff.index')->only('index');
    $this->middleware('permission:education.staff.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return SkillResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(SkillRequest $request)
  {
    $data = $request->validated();

    $skill = $this->repository->create($data);

    return SkillResource::make($skill);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $skill = $this->repository->find($id);

    return SkillResource::make($skill);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(SkillRequest $request, Skill $skill)
  {
    $data = $request->validated();

    $skill = $this->repository->update($skill, $data);

    return SkillResource::make($skill);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Skill $skill)
  {
    $this->repository->delete($skill);

    return response()->json([
      'success' => true,
      'message' => 'Skill deleted.',
    ]);
  }
}
