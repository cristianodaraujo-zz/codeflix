@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Ver vídeo</h3>
    </div>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th>Thumbnail</th>
            <th>
                <img src="{{ $video->thumbnail_path }}" alt="{{ $video->title }}" style="max-width: 100%;" />
            </th>
        </tr>
        <tr>
            <th>Vídeo</th>
            <th>
                <a href="{{ $video->archive_path }}" title="{{ $video->title }}" target="_blank">Download</a>
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th>{{ $video->id }}</th>
        </tr>
        <tr>
            <th>Título</th>
            <th>{{ $video->title }}</th>
        </tr>
        <tr>
            <th>Description</th>
            <th>{{ $video->description }}</th>
        </tr>
        <tr>
            <th colspan="2" style="vertical-align: middle;">
                {!! Button::primary(Icon::create('pencil'))->asLinkTo(route('admin.videos.edit', ['video' => $video->id])) !!}
                {!!
                    Button::danger(Icon::create('remove'))
                        ->asLinkTo(route('admin.videos.destroy', ['video' => $video->id]))
                        ->addAttributes([
                            'onclick' => "event.preventDefault();document.getElementById(\"delete-{$video->id}\").submit();"
                        ])
                !!}
                {!!
                    form(FormBuilder::plain([
                        'route' => ['admin.videos.destroy', 'video' => $video->id],
                        'method' => 'delete',
                        'hidden' => true,
                        'id' => "delete-{$video->id}"
                    ]))
                !!}
            </th>
        </tr>
        </tbody>
    </table>
</div>
@endsection
