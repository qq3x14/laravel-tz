<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ShopOrdersController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $session_id = Session::getId();

        $products = DB::table('carts')
            ->select(['carts.count as count', 'products.id as id', 'products.name as name', 'products.price as price'])
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.session', $session_id)
            ->get();

        if ($products->count() === 0) return redirect()->route('products.list');

        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $product->count;
        }

        $order_id = DB::table('orders')
            ->insertGetId([
                'total' => $total,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

        foreach ($products as $product) {

            DB::table('orders_products')->insert([
                'order_id' => $order_id,
                'product_id' => $product->id,
                'product_price' => $product->price,
                'count' => $product->count,
                'total' => $product->price * $product->count
            ]);

        }

        DB::table('carts')
            ->where('session', $session_id)
            ->delete();

        return view('shop.order_created', [
            'number' => $order_id
        ]);
    }

    public function list(): View
    {
        $orders = DB::table('orders')
            ->select(['id', 'created_at', 'total'])
            ->get()
            ->toArray();

        $orders = array_map(function ($order) {

            $order->products = [];

            $order_products = DB::table('orders_products')
                ->select(['product_id', 'product_price', 'count'])
                ->where('order_id', $order->id)
                ->get();

            foreach ($order_products as $order_product) {

                $product = DB::table('products')
                    ->select(['name'])
                    ->where('id', $order_product->product_id)
                    ->first();

                $order->products[] = $product->name;

            }

            $order->products = implode(', ', $order->products);


            return $order;

        }, $orders);

        return view('shop.orders', [
            'orders' => $orders
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        DB::table('orders_products')
            ->where('order_id', $id)
            ->delete();

        DB::table('orders')
            ->where('id', $id)
            ->delete();

        return redirect()->route('orders.list');
    }
}
