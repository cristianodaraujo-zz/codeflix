<?php

namespace App\Http\Controllers\Auth;

use App\Forms\ChangePasswordForm;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * ChangePasswordController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $form = \FormBuilder::create(ChangePasswordForm::class, [
            'url' => route('password.update'),
            'method' => 'put'
        ]);

        return view('auth.passwords.change', compact('form'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $form = \FormBuilder::create(ChangePasswordForm::class);

        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->repository->update($form->getFieldValues(), \Auth::user()->id);

        $request->session()->flash('success', 'Senha alterada com sucesso!');

        return redirect()->route('home');
    }
}
