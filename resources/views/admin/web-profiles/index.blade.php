@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Listagem de perfis do PayPal</h3>
        {!! Button::primary('Novo perfil PayPal')->asLinkTo(route('admin.web-profiles.create'))->addClass(['pull-right']) !!}
    </div>
    <div class="row">
        {!!
            Table::withContents($webProfiles->items())->striped()->callback('Ações', function($field, $webProfile) {
                return (
                    Button::link(Icon::create('pencil'))->asLinkTo(route('admin.web-profiles.edit', ['webProfile' => $webProfile->id]))
                    . ' | ' .
                    Button::link(Icon::create('remove'))->asLinkTo(route('admin.web-profiles.show', ['webProfile' => $webProfile->id]))
                );
            })
        !!}
    </div>

    {!! $webProfiles->links() !!}
</div>
@endsection