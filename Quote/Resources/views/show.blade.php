@extends('quote::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('quote.name') !!}
    </p>
    <h2>Cart</h2>
    <form action="{{route('quote.store')}}" method="post" style="display: inline-block">
        {{ csrf_field() }}
        <p>Just creates a session entry</p>
        <button type="submit">Create Cart</button>
    </form>
    <form action="{{route('quote.update')}}" method="post" style="display: inline-block">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <p>Updates the Currency for demo purpose to EUR</p>
        <button type="submit">Update Cart</button>
    </form>
    <form action="{{route('quote.destroy')}}" method="post" style="display: inline-block">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <p>Deletes the Session key</p>
        <button type="submit">Delete Cart</button>
    </form>
    <h2>Cartitems</h2>
    <form action="{{route('quote.item.store')}}" method="post">
        {{ csrf_field() }}
        <p>Adds an item</p>
        <label for="item_qty">Menge</label>
        <input type="number" id="item_qty" name="qty">
        <fieldset style="display: inline-block; border-style: dotted">
            <label for="item_product_id_1">Produkt 1</label>
            <input type="radio" id="item_product_id_1" name="product_id" value="1">
            <label for="item_product_id_2">Produkt 2</label>
            <input type="radio" id="item_product_id_2" name="product_id" value="2">
        </fieldset>

        <button type="submit">Add Cart Item</button>
    </form>
    <br/>
 @if($quote && count($quote->getItems()) > 0)
        <form action="{{route('quote.item.update',  ['id' => $quote->getItems()[0]->getItemId()])}}" method="post">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            <p>Updates the first Item</p>
            <label for="item_qty">Menge</label>
            <input type="number" id="item_qty" name="qty">
            <button type="submit">Update Cart Item</button>
        </form>
    @else
        <div>
            <p>Updates the first Item</p>
            <label for="item_qty">Menge</label>
            <input type="number" id="item_qty" name="qty">

            <button disabled="disabled" type="submit">Update Cart Item</button>
        </div>
    @endif
    <br/>
    @if($quote && count($quote->getItems()) > 0)
        <form action="{{route('quote.item.destroy', ['id' => $quote->getItems()[0]->getItemId()])}}" method="post">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <p>Destroys the first Item</p>
            <button type="submit">Delete Cart Item</button>
        </form>
    @else
        <div>
            <p>Destroys the first Item</p>

            <label for="item_qty">Menge</label>
            <input type="number" id="item_qty" name="qty">

            <button disabled="disabled" type="submit">Delete Cart Item</button>
        </div>
    @endif
    {!! var_dump($quote) !!}
@stop
