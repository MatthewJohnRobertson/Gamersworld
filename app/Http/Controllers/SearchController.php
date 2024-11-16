<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller {
    public function search(Request $request) {
        Log::error('Search request received', ['searchTerm' => $request->searchBar]);

        try {
            $searchTerm = $request->searchBar;

            if (empty($searchTerm)) {
                return response('Please enter a search term');
            }

            $products = Product::query()
                ->where('ProductName', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('ItemType', 'LIKE', '%' . $searchTerm . '%')
                ->limit(5)
                ->get();

            Log::error('Search results', ['count' => $products->count()]);

            if ($products->isEmpty()) {
                return response('No products found');
            }

            $output = '';
            foreach ($products as $product) {
                $output .= '<div class="search-result-item">';
                $output .= '<a href="/products/show/' . $product->id . '">';
                $output .= htmlspecialchars($product->ProductName);
                $output .= '</a>';
                $output .= '</div>';
            }

            return response($output);
        } catch (\Exception $e) {
            Log::error('Search error', ['error' => $e->getMessage()]);
            return response('Error performing search', 500);
        }
    }
}
