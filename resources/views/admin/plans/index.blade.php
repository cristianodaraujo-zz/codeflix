@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Listagem de planos</h3>
        {!! Button::primary('Novo plano')->asLinkTo(route('admin.plans.create'))->addClass(['pull-right']) !!}
    </div>

    <div class="row">
        {!!
            Table::withContents($plans->items())->striped()->callback('Ações', function($field, $plan) {
                return (
                    Button::link(Icon::create('pencil'))->asLinkTo(route('admin.plans.edit', ['plan' => $plan->id]))
                    . ' | ' .
                    Button::link(Icon::create('remove'))->asLinkTo(route('admin.plans.show', ['plan' => $plan->id]))
                );
            })
        !!}

        {!! $plans->links() !!}
    </div>
</div>
@endsection
