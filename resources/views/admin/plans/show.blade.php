@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Ver plano</h3>
    </div>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th>#</th>
            <th>{{ $plan->id }}</th>
        </tr>
        <tr>
            <th>Nome</th>
            <th>{{ $plan->name }}</th>
        </tr>
        <tr>
            <th>Descrição</th>
            <th>{{ $plan->description }}</th>
        </tr>

        <tr>
            <th>Duração</th>
            <th>{{ $plan->duration($plan->duration) }}</th>
        </tr>
        <tr>
            <th colspan="2" style="vertical-align: middle;">
                {!! Button::primary(Icon::create('pencil'))->asLinkTo(route('admin.plans.edit', ['plan' => $plan->id])) !!}
                {!!
                    Button::danger(Icon::create('remove'))
                        ->asLinkTo(route('admin.plans.destroy', ['plan' => $plan->id]))
                        ->addAttributes([
                            'onclick' => "event.preventDefault();document.getElementById(\"delete-{$plan->id}\").submit();"
                        ])
                !!}
                {!!
                    form(FormBuilder::plain([
                        'route' => ['admin.plans.destroy', 'plan' => $plan->id],
                        'method' => 'delete',
                        'hidden' => true,
                        'id' => "delete-{$plan->id}"
                    ]))
                !!}
            </th>
        </tr>
        </tbody>
    </table>
</div>
@endsection
