<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\Form;
use Modules\Education\Http\Requests\FormRequest;
use Modules\Education\Repositories\FormRepository;
use Modules\Education\Transformers\FormResource;

class FormController extends Controller
{
    protected FormRepository $repository;

    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;

        $this->middleware('permission:education.form.index')->only('index');
        $this->middleware('permission:education.form.show')->only('show');
        $this->middleware('permission:education.form.store')->only('store');
        $this->middleware('permission:education.form.update')->only('update');
        $this->middleware('permission:education.form.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        return FormResource::collection(
            $this->paginate($request, $this->repository)
        );
    }

    public function store(FormRequest $request)
    {
        $data = $request->validated();

        $form = $this->repository->create($data);

        return FormResource::make($form);
    }



    public function update(FormRequest $request, Form $form)
    {
        $data = $request->validated();

        $form = $this->repository->update($form , $data);

        return FormResource::make($form);
    }

    public function show(int $id)
    {
        $form = $this->repository->find($id);

        return FormResource::make($form);
    }

    public function destroy(Form $form)
    {
        $this->repository->delete($form);
        return response()->json([
            'success' => true,
            'message' => ' form successfully deleted'
        ]);
    }
}
