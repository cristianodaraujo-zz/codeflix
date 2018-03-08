@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Novo plano</h3>
    </div>
    <div class="row">
        {!!
            form($form->add('salve', 'submit', [
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                ],
                'label' => Icon::create('floppy-disk')
            ]))
        !!}
    </div>
</div>
@endsection
