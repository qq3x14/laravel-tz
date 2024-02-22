<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ShopCartsController extends Controller
{
    public function add(Request $request): RedirectResponse
    {
        $product_id = $request->post('id');
        $count = $request->post('count');

        $cart_product = DB::table('carts')
            ->select(['count'])
            ->where('product_id', $product_id)
            ->first();

        if ($cart_product) {

            $new_count = $cart_product->count + $count;

            DB::table('carts')
                ->where('product_id', $product_id)
                ->update(['count' => $new_count]);

        } else {

            $product = DB::table('products')
                ->select(['id', 'price'])
                ->where('id', $product_id)
                ->first();

            DB::table('carts')->insert([
                'session' => Session::getId(),
                'product_id' => $product->id,
                'product_price' => $product->price,
                'count' => $count
            ]);

        }

        return redirect(route('cart.show'));
    }

    public function show(): View|RedirectResponse
    {
        $session_id = Session::getId();

        $products = DB::table('carts')
            ->select(['carts.count as count', 'products.name as name', 'products.price as price'])
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.session', $session_id)
            ->get();

        if ($products->count() === 0) return redirect()->route('products.list');

        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $product->count;
        }

        return view('shop.cart', [
            'products' => $products,
            'total' => $total
        ]);

    }
}
