<?php

namespace App\Http\Controllers\Admin;

use App\Forms\VideoRelationForm;
use App\Forms\VideoUploadForm;
use App\Models\Video;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoUploadsController extends Controller
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
        $form = \FormBuilder::create(VideoUploadForm::class, [
            'url' => route('admin.videos.uploads.update', ['video' => $video->id]),
            'method' => 'post',
            'model' => $video
        ]);

        return view('admin.videos.uploads', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $form = \FormBuilder::create(VideoUploadForm::class);

        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        if ($thumbnail = $request->file('thumbnail')) {
            $this->repository->uploadThumbnail($id, $thumbnail);
        }

        if ($archive = $request->file('archive')) {
            $this->repository->uploadArchive($id, $archive);
        }

        $this->repository->update([
            'duration' => $request->get('duration')
        ], $id);

        $request->session()->flash('success', 'Vídeo alterado com sucesso!');

        return redirect()->route('admin.videos.uploads.edit', ['video' => $id]);
    }

}
