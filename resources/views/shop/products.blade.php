<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop - catalog</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            padding: 1rem;
        }

        .products {
            margin-top: 2rem;
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: flex-start;
            gap: 1rem;
        }

        .product {
            padding: 1rem;
            border: 1px solid black;
            width: calc(33% - 1rem);
            min-width: 160px;
        }

        [name="count"] {
            width: 50px;
        }
    </style>

</head>

<body>

<h1>Каталог товаров</h1>

<div class="products">
    @foreach($products as $product)
        <div class="product">
            <div class="name">{{ $product->name }}</div>
            <div class="price">цена: {{ $product->price }}</div>
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <label>
                    <input type="number" name="count" value="1">
                </label>
                <button type="submit">в корзину</button>
            </form>
        </div>
    @endforeach
</div>

</body>
</html>