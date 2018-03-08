<?php

namespace App\Http\Controllers\Admin;

use App\Models\WebProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\WebProfileRepository;
use App\Forms\WebProfileForm;

class WebProfilesController extends Controller
{
    /**
     * @var WebProfileRepository
     */
    private $repository;

    /**
     * WebProfilesController constructor.
     * @param WebProfileRepository $repository
     */
    public function __construct(WebProfileRepository $repository)
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
        $webProfiles = $this->repository->paginate();
        
        return view('admin.web-profiles.index', compact('webProfiles'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = \FormBuilder::create(WebProfileForm::class, [
            'url' => route('admin.web-profiles.store'),
            'method' => 'POST'
        ]);
        
        return view('admin.web-profiles.create', compact('form'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = \FormBuilder::create(WebProfileForm::class);
        
        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->repository->create($form->getFieldValues());
        
        $request->session()->flash('success', 'Perfil PayPal cadastrado com sucesso!');
        
        return redirect()->route('admin.web-profiles.index');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WebProfile  $webProfile
     * @return \Illuminate\Http\Response
     */
    public function show(WebProfile $webProfile)
    {
        return view('admin.web-profiles.show', compact('webProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WebProfile  $webProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(WebProfile $webProfile)
    {
        $form = \FormBuilder::create(WebProfileForm::class, [
            'url' => route('admin.web-profiles.update', ['webProfile' => $webProfile->id]),
            'method' => 'PUT',
            'model' => $webProfile
        ]);

        return view('admin.web-profiles.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WebProfile  $webProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebProfile $webProfile)
    {
        $form = \FormBuilder::create(WebProfileForm::class);

        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->repository->update($form->getFieldValues(), $webProfile->id);

        $request->session()->flash('success', "Perfil PayPal alterado com sucesso!");

        return redirect()->route('admin.web-profiles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WebProfile  $webProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebProfile $webProfile)
    {
        $this->repository->delete($webProfile->id);

        \Session::flash('success', 'Perfil PayPal excluído com sucesso!');

        return redirect()->route('admin.web-profiles.index');
    }
}