@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Listagem de playlists</h3>
        {!! Button::primary('Nova playlist')->asLinkTo(route('admin.playlists.create'))->addClass(['pull-right']) !!}
    </div>
    <div class="row">
        {!!
            Table::withContents($playlists->items())->striped()->callback('Descrição', function ($_, $playlist) {
                return MediaObject::withContents([
                    'image' => $playlist->thumbnail_small_path,
                    'link' => '#',
                    'heading' => $playlist->title,
                    'body' => $playlist->description
                ]);
            })->callback('Ações', function($_, $playlist) {
                return (
                    Button::link(Icon::create('pencil'))->asLinkTo(route('admin.playlists.edit', ['playlist' => $playlist->id]))
                    . ' | ' .
                    Button::link(Icon::create('remove'))->asLinkTo(route('admin.playlists.show', ['playlist' => $playlist->id]))
                );
            })
        !!}

        {!! $playlists->links() !!}
    </div>
</div>
@endsection

<!-- Styles -->
@push('styles')
<style>
    .media-body {
        width: auto;
    }
</style>
@endpush
