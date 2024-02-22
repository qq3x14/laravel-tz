<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ShopProductsController extends Controller
{
    public function list(): View
    {
        $products = DB::table('products')
            ->select(['id', 'name', 'price'])
            ->get();

        return view('shop.products', [
            'products' => $products
        ]);
    }
}
