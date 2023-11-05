<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use Illuminate\Routing\Controller;
use Modules\Education\Entities\Staff;
use Modules\Education\Http\Requests\StaffRequest;
use Modules\Education\Repositories\StaffRepository;
use Modules\Education\Transformers\StaffResource;

class StaffController extends Controller
{
  protected StaffRepository $repository;

  public function __construct(StaffRepository $repository)
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
    return StaffResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StaffRequest $request)
  {
    $data = $request->validated();

    $staff = $this->repository->create($data);

    return StaffResource::make($staff);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $staff = $this->repository
      ->with('schools:id,name')
      ->findOrFail($id);

    return StaffResource::make($staff);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StaffRequest $request, Staff $staff)
  {
    $data = $request->validated();
    $staff = $this->repository
      ->update($staff, $data);
//      ->with("schools:id,name");

    return StaffResource::make($staff);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Staff $staff)
  {
    $this->repository->delete($staff);

    return response()->json([
      'success' => true,
      'message' => 'staff deleted.',
    ]);
  }
}
