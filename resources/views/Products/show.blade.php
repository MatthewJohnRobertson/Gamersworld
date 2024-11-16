@extends('layouts.app')
@section('content')
<!-- ***** Product Area Starts ***** -->
<section class="section" id="product">
    <div id="main-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-images">
                        <img class="img-fluid" style="max-height: 500px; width: auto; object-fit: contain;"
                            src="{{ asset($product->PicUrl) }}" alt="{{$product->Description}}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-content">
                        <h4>{{ $product->ProductName }}</h4>
                        <span class="price">${{ $product->ProductPrice }}</span>

                        @php
                        $reviews = $product->reviews()->orderBy('created_at', 'desc')->get();
                        $averageRating = $reviews->avg('stars') ?? 0;
                        $filledStars = floor($averageRating);
                        $hasHalfStar = ($averageRating - $filledStars) >= 0.5;
                        $reviewCount = $reviews->count();
                        @endphp

                        <ul class="stars">
                            @for($i = 0; $i < 5; $i++)
                                @if($i < $filledStars)
                                <li><i class="fa fa-star text-warning"></i></li>
                                @elseif($i == $filledStars && $hasHalfStar)
                                <li><i class="fa fa-star-half-o text-warning"></i></li>
                                @else
                                <li><i class="fa fa-star text-secondary"></i></li>
                                @endif
                                @endfor
                                @if($reviewCount > 0)
                                <li><span class="ml-2">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span></li>
                                @endif
                        </ul>

                        <span>{{ $product->Description }}.</span>

                        <!-- Display latest review in quote -->
                        @if($reviewCount > 0)
                        @php
                        $latestReview = $reviews->first();
                        @endphp
                        <div class="quote">
                            <i class="fa fa-quote-left"></i>
                            <p>{{ Str::limit($latestReview->Description, 100) }}</p>
                            <small class="text-muted">- {{ $latestReview->customer->name }}</small>
                        </div>
                        @else
                        <div class="quote">
                            <i class="fa fa-quote-left"></i>
                            <p>No reviews yet. Be the first to review this product!</p>
                        </div>
                        @endif

                        <div class="quantity-content">
                            <div class="quantity-content">
                                <div class="left-content">
                                    <h6>Quantity</h6>
                                </div>
                                <div class="right-content">
                                    <div class="quantity buttons_added">
                                        <input type="number"
                                            step="1"
                                            min="1"
                                            max="100"
                                            name="quantity"
                                            value="1"
                                            title="Qty"
                                            class="input-text qty text"
                                            style="width: 80px;">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-dark add-to-cart" data-product-id="{{ $product->id }}">
                                    Add To Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Product Reviews</h4>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif

                            @auth('customer')
                            <!-- Review Form -->
                            <form action="{{ route('reviews.store') }}" method="POST" class="mb-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="form-group mb-3">
                                    <label for="Title">Title</label>
                                    <input type="text" class="form-control @error('Title') is-invalid @enderror"
                                        id="Title" name="Title" required>
                                    @error('Title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="stars">Rating</label>
                                    <select class="form-control @error('stars') is-invalid @enderror"
                                        id="stars" name="stars" required>
                                        <option value="">Select Rating</option>
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                        <option value="0">0 Stars</option>
                                    </select>
                                    @error('stars')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="Description">Review</label>
                                    <textarea class="form-control @error('Description') is-invalid @enderror"
                                        id="Description" name="Description" rows="3" required></textarea>
                                    @error('Description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </form>
                            @else
                            <p>Please <a href="{{ route('customer.login') }}">login</a> to leave a review.</p>
                            @endauth

                            <!-- Display Reviews -->
                            <div class="reviews-section mt-4">
                                <h5>Customer Reviews</h5>
                                @if($reviewCount > 0)
                                <p>Total reviews: {{ $reviewCount }}</p>
                                @endif

                                @forelse($reviews as $review)
                                <div class="review-item border-bottom py-3">
                                    <div class="d-flex justify-content-between">
                                        <h6>{{ $review->Title }}</h6>
                                        <div class="stars">
                                            @for($i = 0; $i < $review->stars; $i++)
                                                <i class="fa fa-star text-warning"></i>
                                                @endfor
                                                @for($i = $review->stars; $i < 5; $i++)
                                                    <i class="fa fa-star text-secondary"></i>
                                                    @endfor
                                        </div>
                                    </div>
                                    <p class="mb-1">{{ $review->Description }}</p>
                                    <small class="text-muted">Created on: {{ $review->created_at->format('M d, Y') }}</small>
                                </div>
                                @empty
                                <p>No reviews yet. Be the first to review this product!</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Product Area Ends ***** -->
@endsection