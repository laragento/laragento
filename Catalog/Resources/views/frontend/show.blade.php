<!DOCTYPE html>
<html>
<head>
    <title>Laravel Timezones</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">

        <p>{{ $product->sku }}</p>
        @foreach($product->entities as $entity)
            {{ $entity->attribute->attribute_code }}: {{ $entity->value }}<br>
        @endforeach

        <p>children</p>
        @foreach($product->children as $child)
            <p>child</p>
            @foreach($child->entities as $entity)
                {{ $entity->attribute->attribute_code }}: {{ $entity->value }}<br>
            @endforeach
        @endforeach
    </div>
</div>
</body>
</html>