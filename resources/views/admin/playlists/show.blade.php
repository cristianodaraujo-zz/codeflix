@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Ver playlist</h3>
    </div>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th>#</th>
            <th>{{ $playlist->id }}</th>
        </tr>
        <tr>
            <th>Título</th>
            <th>{{ $playlist->title }}</th>
        </tr>
        <tr>
            <th>Descrição</th>
            <th>{{ $playlist->description }}</th>
        </tr>
        <tr>
            <th colspan="2" style="vertical-align: middle;">
                {!! Button::primary(Icon::create('pencil'))->asLinkTo(route('admin.playlists.edit', ['playlist' => $playlist->id])) !!}
                {!!
                    Button::danger(Icon::create('remove'))
                        ->asLinkTo(route('admin.playlists.destroy', ['playlist' => $playlist->id]))
                        ->addAttributes([
                            'onclick' => "event.preventDefault();document.getElementById(\"delete-{$playlist->id}\").submit();"
                        ])
                !!}
                {!!
                    form(FormBuilder::plain([
                        'route' => ['admin.playlists.destroy', 'playlist' => $playlist->id],
                        'method' => 'delete',
                        'hidden' => true,
                        'id' => "delete-{$playlist->id}"
                    ]))
                !!}
            </th>
        </tr>
        </tbody>
    </table>
</div>
@endsection
