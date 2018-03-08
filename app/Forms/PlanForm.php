<?php

namespace App\Forms;

use App\Models\Plan;
use App\Models\WebProfile;
use Kris\LaravelFormBuilder\Form;

class PlanForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('duration', 'select', [
                'choices' => Plan::$duration,
                'rules' => 'required|in:'. implode(',', array_keys(Plan::$duration)),
                'label' => 'Duração'
            ])
            ->add('web_profile_id', 'entity', [
                'class' => WebProfile::class,
                'property' => 'name',
                'empty_value' => 'Selecione o perfil PayPal',
                'label' => 'Perfil web PayPal',
                'rules' => 'required|exists:web_profiles,id'
            ])
            ->add('name', 'text', [
                'rules' => 'required|max:255',
                'label' => 'Nome'
            ])
            ->add('description', 'text', [
                'rules' => 'required|max:255',
                'label' => 'Descrição'
            ])
            ->add('value', 'text', [
                'rules' => 'required|numeric',
                'label' => 'Valor'
            ]);
    }
}
