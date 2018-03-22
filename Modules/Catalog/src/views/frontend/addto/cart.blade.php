<form method="post" action="{{url('cart/add')}}">
    {{csrf_field()}}
    <input type="hidden" name="sku" value="{{$product['sku']}}">
    <div class="form-group">
        <input type="number" name="qty" value="1">
        <div class="btn-group-s pull-right">
            <input type="submit" class="btn btn-primary" value="@lang('catalog.add-to-cart')">
        </div>
    </div>
</form>