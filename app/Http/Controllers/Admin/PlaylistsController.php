<?php

namespace App\Http\Controllers\Admin;

use App\Forms\PlaylistForm;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PlaylistRepository;

class PlaylistsController extends Controller
{
    /**
     * @var PlaylistRepository
     */
    private $repository;

    /**
     * PlaylistsController constructor.
     * @param PlaylistRepository $repository
     */
    public function __construct(PlaylistRepository $repository)
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
        $playlists = $this->repository->paginate(10);

        return view('admin.playlists.index', compact('playlists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = \FormBuilder::create(PlaylistForm::class, [
            'url' => route('admin.playlists.store'),
            'method' => 'post'
        ]);

        return view('admin.playlists.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $form = \FormBuilder::create(PlaylistForm::class);

        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->repository->create($form->getFieldValues());

        $request->session()->flash('success', 'Playlist cadastrada com sucesso!');

        return redirect()->route('admin.playlists.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        return view('admin.playlists.show', compact('playlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        $form = \FormBuilder::create(PlaylistForm::class, [
            'url' => route('admin.playlists.update', ['playlist' => $playlist->id]),
            'method' => 'put',
            'data' => ['id' => $playlist->id],
            'model' => $playlist
        ]);

        return view('admin.playlists.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $form = \FormBuilder::create(PlaylistForm::class, [
            'data' => ['id' => $id]
        ]);

        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->repository->update(array_except($form->getFieldValues(), 'thumbnail'), $id);

        $request->session()->flash('success', 'Playlist alterada com sucesso!');

        return redirect()->route('admin.playlists.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);

        $request->session()->flash('success', 'Playlist excluída com sucesso!');

        return redirect()->route('admin.playlists.index');
    }

    public function thumbnailPath(Playlist $playlist)
    {
        return response()->download($playlist->thumbnail_file);
    }

    public function thumbnailSmallPath(Playlist $playlist)
    {
        return response()->download($playlist->thumbnail_small_file);
    }
}
