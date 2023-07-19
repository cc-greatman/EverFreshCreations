@include('partials.head')

@include('partials.header')

<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-3 ltn__breadcrumb-color-white bg-overlay-theme-black-90 bg-image plr--9---" data-bg="user/img/bg/9.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h6 class="section-subtitle ltn__secondary-color">//  Welcome to Everfresh Creations</h6>
                        <h1 class="section-title white-color">Shop</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="{{ route('home.index') }}">Home</a></li>
                            <li>Shop</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- PRODUCT DETAILS AREA START -->
<div class="ltn__product-area ltn__product-gutter mb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="ltn__shop-options">
                    <ul>
                        <li>
                            <div class="ltn__grid-list-tab-menu ">
                                <div class="nav">
                                    <a class="active show" data-toggle="tab" href="#liton_product_grid"><i class="fas fa-th-large"></i></a>
                                    <a data-toggle="tab" href="#liton_product_list"><i class="fas fa-list"></i></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="liton_product_grid">
                        <div class="ltn__product-tab-content-inner ltn__product-grid-view">
                            <div class="row">
                                <!-- ltn__product-item -->
                                @foreach ($product as $food)
                                <div class="col-xl-4 col-sm-6 col-6">
                                    <div class="ltn__product-item ltn__product-item-3 text-center">
                                        <div class="product-img">
                                            <a href="{{ route('food.details', $food->id) }}"><img src="food/{{ $food->image }}" alt="#"></a>
                                            @foreach ($product as $eat => $meals )
                                                <div class="product-hover-action">
                                                    <ul>
                                                        <li>
                                                            <a href="#modal-{{ $meals->id }}" title="Quick View" data-toggle="modal" aria-controls="#modal-{{ $meals->id }}" data-target="#modal-{{ $meals->id }}" role="modal">
                                                                <i class="far fa-eye"></i>
                                                            </a>
                                                        </li>
                                                        <form action="{{ route('cart.update', $meals->id) }}" method="POST">
                                                            @csrf

                                                            <input value="1" name="quantity" min="1" type="hidden">

                                                                <button type="submit" name="submit" class="cart-button" href="#cart-modal-{{ $meals->id }}" title="Add to Cart" data-toggle="modal" data-target="#cart-modal-{{ $meals->id }}" role="modal" aria-controls="#cart-modal-{{ $meals->id }}">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </button>
                                                        </form>
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="product-info">
                                            <div class="product-ratting">
                                                <ul>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                    <li><a href="#"><i class="far fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                            <h2 class="product-title"><a href="{{ route('food.details', $food->id) }}">{{ $food->title }}</a></h2>
                                            <div class="product-price">
                                                <span>₦{{ $food->price }}</span>
                                                @if ($food->discount_price != null)
                                                 <del>₦{{ $food->discount_price }}</del>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="liton_product_list">
                        <div class="ltn__product-tab-content-inner ltn__product-list-view">
                            <div class="row">
                                <!-- ltn__product-item -->
                                @foreach ($product as $food)
                                <div class="col-lg-12">
                                    <div class="ltn__product-item ltn__product-item-3">
                                        <div class="product-img">
                                            <a href="{{ route('food.details', $food->id) }}"><img src="food/{{ $food->image }}" alt="#"></a>
                                        </div>
                                        <div class="product-info">
                                            <h2 class="product-title"><a href="{{ route('food.details', $food->id) }}">{{ $food->title }}s</a></h2>
                                            <div class="product-ratting">
                                                <ul>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                    <li><a href="#"><i class="far fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="product-price">
                                                <span>₦{{ $food->price }}</span>
                                                @if ($food->discount_price != null)
                                                 <del>₦{{ $food->discount_price }}</del>
                                                @endif
                                            </div>
                                            <div class="product-brief">
                                                <p>{{ $food->description }}</p>
                                            </div>
                                            @foreach ($product as $food => $meals )
                                                <div class="product-hover-action">
                                                    <ul>
                                                        <li>
                                                            <a href="#modal-{{ $meals->id }}" title="Quick View" data-toggle="modal" aria-controls="#modal-{{ $meals->id }}" data-target="#modal-{{ $meals->id }}" role="modal">
                                                                <i class="far fa-eye"></i>
                                                            </a>
                                                        </li>
                                                        <form action="{{ route('cart.update', $meals->id) }}" method="POST">
                                                            @csrf

                                                            <input value="1" name="quantity" min="1" type="hidden">

                                                            <button type="submit" name="submit" class="cart-button" href="#cart-modal-{{ $meals->id }}" title="Add to Cart" data-toggle="modal" data-target="#cart-modal-{{ $meals->id }}" role="modal" aria-controls="#cart-modal-{{ $meals->id }}">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                            </button>
                                                        </form>
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ltn__pagination-area text-center">
                    {{ $product->onEachSide(3)->links() }}
                </div>
            </div>
            <div class="col-lg-4">
                <aside class="sidebar ltn__shop-sidebar ltn__right-sidebar">
                    <!-- Category Widget -->
                    <div class="widget ltn__menu-widget">
                        <h4 class="ltn__widget-title ltn__widget-title-border">Meal Categories</h4>
                        <ul>
                           @foreach ($category as $tag)
                           <li><a href="#">{{ $tag->name }} <span><i class="fas fa-long-arrow-alt-right"></i></span></a></li>
                           @endforeach
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- PRODUCT DETAILS AREA END -->

<!-- MODAL AREA START (Quick View Modal) -->
@foreach ($product as $food => $meals)
    <div class="ltn__modal-area ltn__quick-view-modal-area">
        <div class="modal fade" id="modal-{{ $meals->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <!-- <i class="fas fa-times"></i> -->
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="modal-product-img">
                                            <img src="food/{{ $meals->image }}" alt="#">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="modal-product-info">
                                            <div class="product-ratting">
                                                <ul>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                    <li><a href="#"><i class="far fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                            <h3>{{ $meals->title }}</h3>
                                            <div class="product-price">
                                                <span>₦{{ $meals->price }}</span>
                                                <del>₦{{ $meals->discount_price }}</del>
                                            </div>
                                            <div class="ltn__product-details-menu-2">
                                                <ul>
                                                    <form action="{{ route('cart.update', $meals->id) }}" method="POST">
                                                        @csrf
                                                        <li>
                                                            <div class="cart-plus-minus">
                                                                <input type="number" value="1" name="quantity" min="1" class="cart-plus-minus-box">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <button type="submit" name="submit" href="#modal-{{ $meals->id }}" class="theme-btn-1 btn btn-effect-1" title="Add to Cart" data-toggle="modal" data-target="#modal-{{ $meals->id }}">
                                                                <i class="fas fa-shopping-cart"></i>
                                                                <span>ADD TO CART</span>
                                                            </button>
                                                        </li>
                                                    </form>
                                                </ul>
                                            </div>
                                            <hr>
                                            <div class="ltn__social-media">
                                                <ul>
                                                    <li>Share:</li>
                                                    <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                                    <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                                    <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                                    <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!-- MODAL AREA END -->

<!-- MODAL AREA START (Add To Cart Modal) -->
@auth
@foreach ($product as $food => $meals)
<div class="ltn__modal-area ltn__add-to-cart-modal-area">
    <div class="modal fade" id="cart-modal-{{ $meals->id }}" tabindex="-1">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <div class="ltn__quick-view-modal-inner">
                         <div class="modal-product-item">
                            <div class="row">
                                <div class="col-12">
                                    <div class="modal-product-img">
                                        <img src="food/{{ $meals->image }}" alt="#">
                                    </div>
                                     <div class="modal-product-info">
                                        <h5><a href="{{ route('food.details', $meals->id) }}">{{ $meals->title }}</a></h5>
                                        <p class="added-cart"><i class="fa fa-check-circle"></i>  Successfully added to your Cart</p>
                                        <div class="btn-wrapper">
                                            <a href="cart.html" class="theme-btn-1 btn btn-effect-1">View Cart</a>
                                            <a href="checkout.html" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                                        </div>
                                     </div>
                                </div>
                            </div>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endauth
<!-- MODAL AREA END -->

@include('partials.footer')
