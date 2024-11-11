<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller {
    /**
     * Display a listing of the products.
     */
    public function index() {
        $products = Product::all();

        return view('products.index', ['products' => $products]);
    }

    /**
     * Create a new product
     */
    public function create() {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
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

        return redirect()->route('products.show', $product->Product_id);
    }

    public function show($id) {
        $product = Product::find($id);
        if (!$product) {
            abort(404);
        }

        return view('products.show', ['product' => $product]);
    }
}
