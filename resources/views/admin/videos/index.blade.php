@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Listagem de vídeos</h3>
        {!! Button::primary('Novo vídeo')->asLinkTo(route('admin.videos.create'))->addClass(['pull-right']) !!}
    </div>
    <div class="row">
        {!!
            Table::withContents($videos->items())->striped()->callback('Descrição', function ($_, $video) {
                return MediaObject::withContents([
                    'image' => $video->thumbnail_small_path,
                    'link' => $video->archive_path,
                    'heading' => $video->title,
                    'body' => $video->description
                ]);
            })->callback('Ações', function($_, $video) {
                return (
                    Button::link(Icon::create('pencil'))->asLinkTo(route('admin.videos.edit', ['video' => $video->id]))
                    . ' | ' .
                    Button::link(Icon::create('remove'))->asLinkTo(route('admin.videos.show', ['video' => $video->id]))
                );
            })
        !!}

        {!! $videos->links() !!}
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