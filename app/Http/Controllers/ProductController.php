<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller {
    public function index() {
        $products = Product::all();

        return view('products.index', ['products' => $products]);
    }

    public function create() {
        return view('products.create');
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'ProductName' => 'required',
            'Description' => 'required',
            'ItemType' => 'required',
            'QtyRemaining' => 'required',
            'ProductPrice' => 'required',
            'PicUrl' => 'required',
        ]);



        $product = Product::create($validated);

        return redirect()->route('products.show', $product->id);
    }

    public function show($id) {
        $product = Product::with(['reviews' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        return view('products.show', compact('product'));
    }
}
