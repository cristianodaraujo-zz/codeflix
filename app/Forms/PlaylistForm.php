<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PlaylistForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'label' => 'Título',
                'rules' => 'required|max:255'
            ])
            ->add('description', 'textarea', [
                'label' => 'Descrição',
                'rules' => 'required'
            ])
            ->add('thumbnail_file', 'file', [
                'label' => 'Thumbnail',
                'required' => $this->getData('id') ? false : true,
                'rules' => ($this->getData('id') ? '' : 'required|') . 'image|max:1024'
            ]);
    }
}
