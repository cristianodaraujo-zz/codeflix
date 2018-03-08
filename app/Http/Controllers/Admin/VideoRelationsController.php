<?php

namespace App\Http\Controllers\Admin;

use App\Forms\VideoRelationForm;
use App\Models\Video;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoRelationsController extends Controller
{
    /**
     * @var VideoRepository
     */
    private $repository;

    /**
     * VideoRelationsController constructor.
     * @param VideoRepository $repository
     */
    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        $form = \FormBuilder::create(VideoRelationForm::class, [
            'url' => route('admin.videos.relations.update', ['video' => $video->id]),
            'method' => 'post',
            'model' => $video
        ]);

        return view('admin.videos.relations', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $form = \FormBuilder::create(VideoRelationForm::class);

        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->repository->update($form->getFieldValues(), $id);

        $request->session()->flash('success', 'Vídeo alterado com sucesso!');

        return redirect()->route('admin.videos.relations.edit', ['video' => $id]);
    }

}
