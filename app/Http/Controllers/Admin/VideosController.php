<?php

namespace App\Http\Controllers\Admin;

use App\Forms\VideoForm;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    /**
     * @var VideoRepository
     */
    private $repository;

    /**
     * VideosController constructor.
     * @param VideoRepository $repository
     */
    public function __construct(VideoRepository $repository)
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
        $videos = $this->repository->paginate(10);

        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = \FormBuilder::create(VideoForm::class, [
            'url' => route('admin.videos.store'),
            'method' => 'post'
        ]);

        return view('admin.videos.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $form = \FormBuilder::create(VideoForm::class);

        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->repository->create($form->getFieldValues());

        $request->session()->flash('success', 'Vídeo cadastrado com sucesso!');

        return redirect()->route('admin.videos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        $form = \FormBuilder::create(VideoForm::class, [
            'url' => route('admin.videos.update', ['playlist' => $video->id]),
            'method' => 'put',
            'model' => $video
        ]);

        return view('admin.videos.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $form = \FormBuilder::create(VideoForm::class);

        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->repository->update($form->getFieldValues(), $id);

        $request->session()->flash('success', 'Vídeo alterado com sucesso!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);

        $request->session()->flash('success', 'Vídeo excluído com sucesso!');

        return redirect()->route('admin.videos.index');
    }

    public function archivePath(Video $video)
    {
        return response()->download($video->archive_file);
    }

    public function thumbnailPath(Video $video)
    {
        return response()->download($video->thumbnail_file);
    }

    public function thumbnailSmallPath(Video $video)
    {
        return response()->download($video->thumbnail_small_file);
    }
}
