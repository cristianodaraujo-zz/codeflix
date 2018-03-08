<?php

namespace App\Http\Controllers\Admin;

use App\Forms\PlanForm;
use App\Models\Plan;
use App\Repositories\PlanRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlansController extends Controller
{
    /**
     * @var PlanRepository
     */
    private $repository;

    /**
     * PlansController constructor.
     * @param PlanRepository $repository
     */
    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = $this->repository->paginate(10);

        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = \FormBuilder::create(PlanForm::class, [
            'url' => route('admin.plans.store'),
            'method' => 'post'
        ]);

        return view('admin.plans.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = \FormBuilder::create(PlanForm::class);

        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->repository->create($form->getFieldValues());

        $request->session()->flash('success', 'Plano cadastrado com sucesso!');

        return redirect()->route('admin.plans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        return view('admin.plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        $form = \FormBuilder::create(PlanForm::class, [
            'url' => route('admin.plans.update', ['plan' => $plan->id]),
            'method' => 'put',
            'model' => $plan
        ]);

        return view('admin.plans.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form = \FormBuilder::create(PlanForm::class);

        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->repository->update($form->getFieldValues(), $id);

        $request->session()->flash('success', 'Plano alterado com sucesso!');

        return redirect()->route('admin.plans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\Models\Plan $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);

        $request->session()->flash('success', 'Plano excluído com sucesso!');

        return redirect()->route('admin.plans.index');
    }
}
