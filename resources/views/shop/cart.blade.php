<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop - cart</title>

    <style>
        .products {
            margin-top: 2rem;
        }

        .product {
            border: 1px solid black;
            padding: 1rem;
        }

        .product:not(:first-child) {
            margin-top: 1rem;
        }

        .cart-total {
            margin-top: 2rem;
        }

        .order {
            margin-top: 2rem;
        }
    </style>

</head>
<body>

<h1>Корзина</h1>

<a href="{{ route('products.list') }}">назад к товарам</a>

<div class="products">
    @foreach ($products as $product)
        <div class="product">
            <div class="name">{{ $product->name }}</div>
            <div class="price">цена: {{ $product->price }}</div>
            <div class="count">кол-во:{{ $product->count }} шт.</div>
            <div class="total">сумма: {{ $product->price * $product->count }}</div>
        </div>
    @endforeach
</div>

<div class="cart-total">Общая стоимость: {{ $total }}</div>

<button class="order" onclick="window.location.href = '{{ route('order.create')  }}';">Оформить заказ</button>

</body>
</html>