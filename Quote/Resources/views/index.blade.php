@extends('quote::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('quote.name') !!}
    </p>
    <form action="{{route('quote.store')}}" method="post">
        {{ csrf_field() }}
        <button type="submit">Create Cart</button>
    </form>
    <form action="{{route('quote.update')}}" method="post">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <button type="submit">Update Cart</button>
    </form>
    <form action="{{route('quote.destroy')}}" method="post">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit">Delete Cart</button>
    </form>
    {!! var_dump($quote) !!}
@stop
