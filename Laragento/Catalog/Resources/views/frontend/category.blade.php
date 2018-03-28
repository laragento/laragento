@extends('app')

@section('content')
    <div class="row">
        <div class="medium-12 large-12 columns">
            <h1>{{ $category->name }}</h1>
            <p><strong>{!! $category->description or '' !!}</strong></p>
        </div>
    </div>
    <div class="column row">
        <div class="medium-12 large-3 columns">
            @foreach($category->children->data as $child)
                <div class="column">
                    <a href="{{ url('/category/'.$child->id) }}" class="button hollow tiny expanded">
                        {{$child->name}}
                    </a>
                </div>
            @endforeach
        </div>
        <div class="medium-12 large-9 columns">
            <div class="row medium-up-3 large-up-4">
                @foreach($category->products->data as $product)
                    <div class="column">
                            <img class="thumbnail" src="/images{{ $product->small_image }}">

                        <h5>{{$product->name}}
                            <small>$22</small>
                        </h5>
                        <p></p>
                        <a href="{{ url('/product/'.$product->url_key) }}" class="button hollow tiny expanded">Buy
                            Now</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection