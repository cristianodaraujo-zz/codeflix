@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Ver usuário</h3>
    </div>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th>#</th>
            <th>{{ $user->id }}</th>
        </tr>
        <tr>
            <th>Nome</th>
            <th>{{ $user->name }}</th>
        </tr>
        <tr>
            <th>E-mail</th>
            <th>{{ $user->email }}</th>
        </tr>
        <tr>
            <th colspan="2" style="vertical-align: middle;">
                {!! Button::primary(Icon::create('pencil'))->asLinkTo(route('admin.users.edit', ['user' => $user->id])) !!}
                {!!
                    Button::danger(Icon::create('remove'))
                        ->asLinkTo(route('admin.users.destroy', ['user' => $user->id]))
                        ->addAttributes([
                            'onclick' => "event.preventDefault();document.getElementById(\"delete-{$user->id}\").submit();"
                        ])
                !!}
                {!!
                    form(FormBuilder::plain([
                        'route' => ['admin.users.destroy', 'user' => $user->id],
                        'method' => 'delete',
                        'hidden' => true,
                        'id' => "delete-{$user->id}"
                    ]))
                !!}
            </th>
        </tr>
        </tbody>
    </table>
</div>
@endsection
