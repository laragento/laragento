@extends('app')

@section('content')
    <div class="row columns">
        <nav aria-label="You are here:" role="navigation">
            <ul class="breadcrumbs">
                <li><a href="{{ url('/category/2') }}">Shop</a></li>
                <?php /*
                    @foreach($product->categories->data as $category)
                        <li>
                            <a href="{{ url('/category/'.$category->category_id) }}">{{$category->name}}</a>
                        </li>
                    @endforeach */ ?>
                <li>
                    <span class="show-for-sr">Current: </span> {{$product->name}}
                </li>
                <!--
                <li><a href="#">Features</a></li>
                <li class="disabled">Gene Splicing</li>
                <li>
                    <span class="show-for-sr">Current: </span> Cloning
                </li>
                -->
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="medium-6 columns">
            <img class="thumbnail" src="/images{{ $product->image }}">
            <div class="row small-up-4">
                <div class="column">
                    <img class="thumbnail" src="https://placehold.it/250x200">
                </div>
                <div class="column">
                    <img class="thumbnail" src="https://placehold.it/250x200">
                </div>
            </div>
        </div>
        <div class="medium-6 large-5 columns">
            <h1>{{ $product->name }}</h1>
            <small>SKU: {{ $product->sku }}</small><br>
            <small>URL_KEY: {{ $product->url_key }}</small><br>
            <small>ID: {{ $product->id }}</small>
            <p><strong>{!! $product->short_description or '' !!}</strong></p>
            <label>
                <select>
                    @foreach($product->children->data as $child)
                        <option value="{{$child->sku}}">{{$child->name}} - {{$child->price}}</option>
                    @endforeach
                </select>
            </label>
            <div class="row">
                <div class="small-3 columns">
                    <label for="middle-label" class="middle">Quantity</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" id="middle-label" placeholder="Quantity">
                </div>
            </div>
            <a href="#" class="button large expanded">Buy Now</a>
            <div class="small secondary expanded button-group">
                <a class="button">Facebook</a>
                <a class="button">Twitter</a>
                <a class="button">Yo</a>
            </div>
        </div>
    </div>
    <div class="column row">
        <hr>
        <ul class="tabs" data-tabs id="example-tabs">
            <li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Attributes</a></li>
            <li class="tabs-title"><a href="#panel2">Reviews</a></li>
            <li class="tabs-title"><a href="#panel3">Similar Products</a></li>
        </ul>
        <div class="tabs-content" data-tabs-content="example-tabs">
            <div class="tabs-panel is-active" id="panel1">
                <h4>Attributes</h4>
                @foreach($attributes as $attribute)
                    <?php $code = $attribute->attribute_code ?>
                    @if(isset($product->$code))
                        <div class="media-object stack-for-small">
                            <div class="media-object-section">
                                <h5>{{$attribute->frontend_label}} [{{$attribute->attribute_code}}]</h5>
                                <p>{{$product->$code or ''}}</p>
                            </div>
                        </div>
                     @endif
                @endforeach
            </div>
            <div class="tabs-panel" id="panel2">
                <h4>Reviews</h4>
                <div class="media-object stack-for-small">
                    <div class="media-object-section">
                        <img class="thumbnail" src="https://placehold.it/200x200">
                    </div>
                    <div class="media-object-section">
                        <h5>Mike Stevenson</h5>
                        <p>I'm going to improvise. Listen, there's something you should know about me... about inception. An idea is like a virus, resilient, highly contagious. The smallest seed of an idea can grow. It can grow to define or destroy you.</p>
                    </div>
                </div>
                <div class="media-object stack-for-small">
                    <div class="media-object-section">
                        <img class="thumbnail" src="https://placehold.it/200x200">
                    </div>
                    <div class="media-object-section">
                        <h5>Mike Stevenson</h5>
                        <p>I'm going to improvise. Listen, there's something you should know about me... about inception. An idea is like a virus, resilient, highly contagious. The smallest seed of an idea can grow. It can grow to define or destroy you</p>
                    </div>
                </div>
                <div class="media-object stack-for-small">
                    <div class="media-object-section">
                        <img class="thumbnail" src="https://placehold.it/200x200">
                    </div>
                    <div class="media-object-section">
                        <h5>Mike Stevenson</h5>
                        <p>I'm going to improvise. Listen, there's something you should know about me... about inception. An idea is like a virus, resilient, highly contagious. The smallest seed of an idea can grow. It can grow to define or destroy you</p>
                    </div>
                </div>
                <label>
                    My Review
                    <textarea placeholder="None"></textarea>
                </label>
                <button class="button">Submit Review</button>
            </div>
            <div class="tabs-panel" id="panel3">
                <div class="row medium-up-3 large-up-5">
                    <div class="column">
                        <img class="thumbnail" src="https://placehold.it/350x200">
                        <h5>Other Product <small>$22</small></h5>
                        <p>In condimentum facilisis porta. Sed nec diam eu diam mattis viverra. Nulla fringilla, orci ac euismod semper, magna diam.</p>
                        <a href="#" class="button hollow tiny expanded">Buy Now</a>
                    </div>
                    <div class="column">
                        <img class="thumbnail" src="https://placehold.it/350x200">
                        <h5>Other Product <small>$22</small></h5>
                        <p>In condimentum facilisis porta. Sed nec diam eu diam mattis viverra. Nulla fringilla, orci ac euismod semper, magna diam.</p>
                        <a href="#" class="button hollow tiny expanded">Buy Now</a>
                    </div>
                    <div class="column">
                        <img class="thumbnail" src="https://placehold.it/350x200">
                        <h5>Other Product <small>$22</small></h5>
                        <p>In condimentum facilisis porta. Sed nec diam eu diam mattis viverra. Nulla fringilla, orci ac euismod semper, magna diam.</p>
                        <a href="#" class="button hollow tiny expanded">Buy Now</a>
                    </div>
                    <div class="column">
                        <img class="thumbnail" src="https://placehold.it/350x200">
                        <h5>Other Product <small>$22</small></h5>
                        <p>In condimentum facilisis porta. Sed nec diam eu diam mattis viverra. Nulla fringilla, orci ac euismod semper, magna diam.</p>
                        <a href="#" class="button hollow tiny expanded">Buy Now</a>
                    </div>
                    <div class="column">
                        <img class="thumbnail" src="https://placehold.it/350x200">
                        <h5>Other Product <small>$22</small></h5>
                        <p>In condimentum facilisis porta. Sed nec diam eu diam mattis viverra. Nulla fringilla, orci ac euismod semper, magna diam.</p>
                        <a href="#" class="button hollow tiny expanded">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection