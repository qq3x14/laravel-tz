<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop - orders</title>

    <style>
        .orders {
            margin-top: 2rem;
        }

        .order {
            border: 1px solid black;
            padding: 1rem;
        }

        .order:not(:first-child) {
            margin-top: 1rem;
        }
    </style>
</head>
<body>

<h1>Заказы</h1>

@if ($orders)

    <div class="orders">
        @foreach($orders as $order)
            <div class="order">
                <div class="number">номер: {{ $order->id }}</div>
                <div class="date">дата: {{ $order->created_at }}</div>
                <div class="products">товары: {{ $order->products }}</div>
                <div class="total">сумма: {{ $order->total }}</div>
                <div><a href="{{ route('order.delete', ['id' => $order->id]) }}">удалить</a></div>
            </div>
        @endforeach
    </div>

@else

    <p>Заказов пока нет.</p>
    <p><a href="{{ route('products.list') }}">к товарам</a></p>

@endif

</body>
</html>