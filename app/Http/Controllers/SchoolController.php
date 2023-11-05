<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Repositories\SchoolRepository;
use App\Http\Resources\SchoolResource;

class SchoolController extends Controller
{
  protected SchoolRepository $repository;

  public function __construct(SchoolRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.school.store')->only('store');
    $this->middleware('permission:base.school.update')->only('update');
    $this->middleware('permission:base.school.destroy')->only('destroy');
    $this->middleware('permission:base.school.index')->only('index');
    $this->middleware('permission:base.school.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return SchoolResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreSchoolRequest $request)
  {
    $data = $request->validated();

    $school = $this->repository->create($data);

    return SchoolResource::make($school);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $school = $this->repository->findOrFail($id);

    return SchoolResource::make($school);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateSchoolRequest $request, School $school)
  {
    $data = $request->validated();

    $school = $this->repository->update($school, $data);

    return SchoolResource::make($school);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(School $school)
  {
    $this->repository->delete($school);

    return response()->json([
      'success' => true,
      'message' => 'School deleted.',
    ]);
  }
}
