<?php

namespace App\Forms;

use App\Models\Category;
use App\Models\Playlist;
use Kris\LaravelFormBuilder\Form;

class VideoUploadForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('thumbnail', 'file', [
                'label' => 'Thumbnail',
                'required' => false,
                'rules' => 'image|max:1024'
            ])
            ->add('archive', 'file', [
                'label' => 'Vídeo',
                'required' => false,
                'rules' => 'mimetypes:video/mp4'
            ])
            ->add('duration', 'text', [
                'label' => 'Duração',
                'rules' => 'required|integer|min:1'
            ]);
    }
}
