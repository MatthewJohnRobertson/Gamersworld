<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'Title' => 'required|max:255',
            'Description' => 'required',
            'stars' => 'required|in:0,1,2,3,4,5',
        ]);

        Review::create([
            'customer_id' => auth('customer')->id(),
            'product_id' => $request->product_id,
            'Title' => $request->Title,
            'Description' => $request->Description,
            'stars' => $request->stars,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
