@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        @component('admin.videos.components.tabs', ['video' => $form->getModel()])
            <div class="col-md-12">
                <h4>Playlist e categorias</h4>
                {!!
                    form($form->add('salve', 'submit', [
                        'attr' => [
                            'class' => 'btn btn-primary btn-block'
                        ],
                        'label' => Icon::create('pencil')
                    ]))
                !!}
            </div>
        @endcomponent
    </div>
</div>
@endsection
