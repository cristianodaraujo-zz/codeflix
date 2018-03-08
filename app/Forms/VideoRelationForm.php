<?php

namespace App\Forms;

use App\Models\Category;
use App\Models\Playlist;
use Kris\LaravelFormBuilder\Form;

class VideoRelationForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('categories', 'entity', [
                'class' => Category::class,
                'property' => 'name',
                'multiple' => true,
                // 'selected' => $this->model ? $this->model->categories->pluck('id')->toArray() : null,
                'attr' => [
                    'name' => 'categories[]'
                ],
                'label' => 'Categorias',
                'rules' => 'required|exists:categories,id'
            ])
            ->add('playlist_id', 'entity', [
                'class' => Playlist::class,
                'property' => 'title',
                'empty_value' => 'Selecione',
                'label' => 'Playlist',
                'rules' => 'nullable|exists:playlists,id'
            ]);
    }
}
