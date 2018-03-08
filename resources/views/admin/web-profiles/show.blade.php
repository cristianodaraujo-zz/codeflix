@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Ver perfil PayPal</h3>
    </div>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th>#</th>
            <th>{{ $webProfile->id }}</th>
        </tr>
        <tr>
            <th>Nome</th>
            <th>{{ $webProfile->name }}</th>
        </tr>
        <tr>
            <th>Logo</th>
            <td>{!! \Image::thumbnail($webProfile->logo_url, 'thumbnail') !!}</td>
        </tr>
        <tr>
            <th colspan="2" style="vertical-align: middle;">
                {!! Button::primary(Icon::create('pencil'))->asLinkTo(route('admin.web-profiles.edit', ['webProfile' => $webProfile->id])) !!}
                {!!
                    Button::danger(Icon::create('remove'))
                        ->asLinkTo(route('admin.web-profiles.destroy', ['webProfile' => $webProfile->id]))
                        ->addAttributes([
                            'onclick' => "event.preventDefault();document.getElementById(\"delete-{$webProfile->id}\").submit();"
                        ])
                !!}
                {!!
                    form(FormBuilder::plain([
                        'route' => ['admin.web-profiles.destroy', 'webProfile' => $webProfile->id],
                        'method' => 'delete',
                        'hidden' => true,
                        'id' => "delete-{$webProfile->id}"
                    ]))
                !!}
            </th>
        </tr>
        </tbody>
    </table>
</div>
@endsection
