@include('partials.head')

@include('partials.header')

<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-overlay-theme-black-90 bg-image" data-bg="user/img/bg/9.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h6 class="section-subtitle ltn__secondary-color">//  Welcome to EverFresh Creations</h6>
                        <h1 class="section-title white-color">Cart</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="{{ route('home.index') }}">Home</a></li>
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- SHOPPING CART AREA START -->
<div class="liton__shoping-cart-area mb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping-cart-inner">
                    <div class="shoping-cart-table table-responsive">
                        <table class="table">
                            <!-- <thead>
                                <th class="cart-product-remove">Remove</th>
                                <th class="cart-product-image">Image</th>
                                <th class="cart-product-info">Product</th>
                                <th class="cart-product-price">Price</th>
                                <th class="cart-product-quantity">Quantity</th>
                                <th class="cart-product-subtotal">Subtotal</th>
                            </thead> -->
                            <tbody>
                                <?php
                                    $totalPrice = 0;
                                    $totalQuantity = 0;
                                ?>
                                @foreach ($cart as $item)
                                <tr>
                                    <td class="cart-product-remove"><a href="{{ route('cart.remove', $item->id) }}" onclick="return confirm('Are you sure you want to remove this meal from your cart')">x</a></td>
                                    <td class="cart-product-image">
                                        <a href="{{ route('food.details', $item->product_id) }}"><img src="food/{{ $item->image }}" alt="{{ $item->product_title }}"></a>
                                    </td>
                                    <td class="cart-product-info">
                                        <h4><a href="{{ route('food.details', $item->product_id) }}">{{ $item->product_title }}</a></h4>
                                    </td>
                                    <td class="cart-product-info">
                                            <p >x{{ $item->quantity }}</p>
                                    </td>
                                    <td class="cart-product-subtotal">₦{{ $item->price }}</td>
                                </tr>

                                <?php
                                    $totalPrice = $totalPrice + $item->price;
                                    $totalQuantity = $totalQuantity + $item->quantity;
                                ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="shoping-cart-total mt-50">
                        @if(session()->has('msg'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Holy guacamole!</strong> {{ session()->get('msg') }}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
                        <h4>Cart Total</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Cart Subtotal</td>
                                    <td>₦{{ $totalPrice }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="btn-wrapper text-right">
                            <form action="{{ route('pay.now') }}" method="POST">
                                @csrf
                                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                <input type="hidden" name="orderID" value="345">
                                <input type="hidden" name="amount" value="{{ $totalPrice * 100 }}"> {{-- required in kobo --}}
                                <input type="hidden" name="quantity" value="{{ $totalQuantity }}">
                                <input type="hidden" name="currency" value="NGN">
                                <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value',]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
                                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">


                                <button type="submit" value="submit" class="theme-btn-2 btn btn-effect-1">Proceed to checkout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- SHOPPING CART AREA END -->

@include('partials.footer')
