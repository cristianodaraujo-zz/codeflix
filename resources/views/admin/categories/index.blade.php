@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Listagem de categorias</h3>
        {!! Button::primary('Nova categoria')->asLinkTo(route('admin.categories.create'))->addClass(['pull-right']) !!}
    </div>
    <div class="row">
        {!!
            Table::withContents($categories->items())->striped()->callback('Ações', function($field, $category) {
                return (
                    Button::link(Icon::create('pencil'))->asLinkTo(route('admin.categories.edit', ['category' => $category->id]))
                    . ' | ' .
                    Button::link(Icon::create('remove'))->asLinkTo(route('admin.categories.show', ['category' => $category->id]))
                );
            })
        !!}

        {!! $categories->links() !!}
    </div>
</div>
@endsection
