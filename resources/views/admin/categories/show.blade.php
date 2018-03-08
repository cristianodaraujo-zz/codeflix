@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Ver categoria</h3>
    </div>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th>#</th>
            <th>{{ $category->id }}</th>
        </tr>
        <tr>
            <th>Nome</th>
            <th>{{ $category->name }}</th>
        </tr> 
        <tr>
            <th colspan="2" style="vertical-align: middle;">
                {!! Button::primary(Icon::create('pencil'))->asLinkTo(route('admin.categories.edit', ['category' => $category->id])) !!}
                {!!
                    Button::danger(Icon::create('remove'))
                        ->asLinkTo(route('admin.categories.destroy', ['category' => $category->id]))
                        ->addAttributes([
                            'onclick' => "event.preventDefault();document.getElementById(\"delete-{$category->id}\").submit();"
                        ])
                !!}
                {!!
                    form(FormBuilder::plain([
                        'route' => ['admin.categories.destroy', 'category' => $category->id],
                        'method' => 'delete',
                        'hidden' => true,
                        'id' => "delete-{$category->id}"
                    ]))
                !!}
            </th>
        </tr>
        </tbody>
    </table>
</div>
@endsection
