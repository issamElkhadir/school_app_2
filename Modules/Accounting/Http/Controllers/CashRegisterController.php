<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExportableResource;
use App\Models\School;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Modules\Accounting\Entities\CashRegister;
use Modules\Accounting\Exports\CashRegistersExport;
use Modules\Accounting\Http\Requests\CashRegisterRequest;
use Modules\Accounting\Repositories\CashRegisterRepository;
use Modules\Accounting\Transformers\CashRegisterResource;

class CashRegisterController extends Controller
{
  use ExportableResource;

  protected CashRegisterRepository $repository;

  public function __construct(CashRegisterRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:accounting.cash-register.store')->only('store');
    $this->middleware('permission:accounting.cash-register.update')->only('update');
    $this->middleware('permission:accounting.cash-register.destroy')->only('destroy');
    $this->middleware('permission:accounting.cash-register.index')->only('index');
    $this->middleware('permission:accounting.cash-register.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return CashRegisterResource::collection(
      $this->paginate($request, $this->repository)
    );

  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CashRegisterRequest $request)
  {
    $data = $request->validated();


    $morphMap = Relation::$morphMap;

    $ownerType = School::class;

    foreach ($morphMap as $key => $class) {
      if ($class === $ownerType) {
        $ownerType = $key;
        break;
      }
    }

    $data['owner_type'] = $ownerType;
    $data['owner_id'] = $data['owner']['id'];
    $data['is_real'] = true;

    unset($data['owner']);

    $cashRegister = $this->repository->create($data);

    return CashRegisterResource::make($cashRegister);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $cashRegister = $this->repository->find($id);

    return CashRegisterResource::make($cashRegister);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CashRegisterRequest $request, CashRegister $cashRegister)
  {
    $data = $request->validated();

    if (isset($data['owner']['id'])) {
      $data['owner_id'] = $data['owner']['id'];
    }

    unset($data['owner']);

    $cashRegister = $this->repository->update($cashRegister, $data);

    return CashRegisterResource::make($cashRegister);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(CashRegister $cashRegister)
  {
    $this->repository->delete($cashRegister);

    return response()->json([
      'success' => true,
      'message' => 'Cash Register deleted.',
    ]);
  }

  public function exporter(): string
  {
    return CashRegistersExport::class;
  }
}
