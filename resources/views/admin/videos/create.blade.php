@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        @component('admin.videos.components.tabs')
            <div class="col-md-12">
                <h4>Novo vídeo</h4>
                {!!
                    form($form->add('salve', 'submit', [
                        'attr' => [
                            'class' => 'btn btn-primary btn-block'
                        ],
                        'label' => Icon::create('floppy-disk')
                    ]))
                !!}
            </div>
        @endcomponent
    </div>
</div>
@endsection
