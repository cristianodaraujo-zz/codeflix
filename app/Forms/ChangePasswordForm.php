<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ChangePasswordForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('password', 'password', [
                'label' => 'Senha',
                'rules' => 'required|min:6|max:255|confirmed'
            ])
            ->add('password_confirmation', 'password', [
                'label' => 'Confirmar Senha',
                'rules' => 'required'
            ]);
    }
}
