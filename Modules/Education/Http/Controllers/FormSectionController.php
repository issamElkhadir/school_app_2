<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\FormSection;
use Modules\Education\Http\Requests\FormSectionRequest;
use Modules\Education\Repositories\FormSectionRepository;
use Modules\Education\Transformers\FormSectionResource;

class FormSectionController extends Controller
{
    protected FormSectionRepository $repository ;

    public function __construct(FormSectionRepository $repository){
        $this->repository = $repository;

        $this->middleware('permission:education.form-section.index')->only('index');
        $this->middleware('permission:education.form-section.store')->only('store');
        $this->middleware('permission:education.form-section.update')->only('update');
        $this->middleware('permission:education.form-section.destory')->only('destory');
        $this->middleware('permission:education.form-section.show')->only('show');
    }

    public function index(Request $request)
    {
        return FormSectionResource::collection(
        $this->paginate($request, $this->repository)
        );
    }

    public function store(FormSectionRequest  $request){
        $data = $request->validated();
        $formSection = $this->repository->create($data);
        return FormSectionResource::make($formSection);
    }
    public function update(FormSectionRequest  $request , FormSection $formSection){
        $data = $request->validated();
        $formSection = $this->repository->update($formSection , $data);
        return FormSectionResource::make($formSection);
    }
    public function destroy(FormSection $formSection){
        $this->repository->delete($formSection);
        return response()->json([
            'success' => true,
            'message' => 'form section deleted',
        ]);
    }
    public function show(int $id){
        $formSection = $this->repository->find($id);
        return FormSectionResource::make($formSection); 
    }
}
