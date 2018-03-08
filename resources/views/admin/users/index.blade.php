@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Listagem de usuários</h3>
        {!! Button::primary('Novo usuário')->asLinkTo(route('admin.users.create'))->addClass(['pull-right']) !!}
    </div>
    <div class="row">
        {!!
            Table::withContents($users->items())->striped()->callback('Ações', function($field, $user) {
                return (
                    Button::link(Icon::create('pencil'))->asLinkTo(route('admin.users.edit', ['user' => $user->id]))
                    . ' | ' .
                    Button::link(Icon::create('remove'))->asLinkTo(route('admin.users.show', ['user' => $user->id]))
                );
            })
        !!}

        {!! $users->links() !!}
    </div>
</div>
@endsection
