@extends('layouts.app')


@section('content')
<!-- ***** Product Area Starts ***** -->
<section class="section" id="product">
    <div id="main-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-images">
                        <img class="img-fluid" style="max-height: 500px; width: auto; object-fit: contain;" src="{{ asset($product->PicUrl) }}" alt="{{$product->Description}}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-content">

                        <h4>{{ $product->ProductName }}</h4>
                        <span class="price">${{ $product->ProductPrice }}</span>
                        <ul class="stars">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                        </ul>
                        <span>{{ $product->Description }}.</span>
                        <div class="quote">
                            <i class="fa fa-quote-left"></i>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiuski smod.</p>
                        </div>
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
</section>
<!-- ***** Product Area Ends ***** -->