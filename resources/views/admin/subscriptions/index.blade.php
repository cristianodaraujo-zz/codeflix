@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <h3>Assinaturas</h3>
    </div>
    <div class="row">
        {!!
            Table::withContents($subscriptions->items())->striped()
        !!}
    </div>

    {!! $subscriptions->links() !!}
</div>
@endsection