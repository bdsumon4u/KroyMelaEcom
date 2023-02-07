@extends('layouts.yellow.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('strokya/vendor/xzoom/xzoom.css') }}">
    <link rel="stylesheet" href="{{ asset('strokya/vendor/xZoom-master/example/css/demo.css') }}">
    <style>
        #accordion .card-link {
            display: block;
            font-size: 20px;
            padding: 18px 48px;
            border-bottom: 2px solid transparent;
            color: inherit;
            font-weight: 500;
            border-radius: 3px 3px 0 0;
            transition: all .15s;
        }
        #accordion .card-link:not(.collapsed) {
            border-bottom: 2px solid #000;
            color: #000;
        }

        @media (max-width: 768px) {
            .product__option-label {
                display: block;
                text-align: center;
            }
            .product__actions {
                justify-content: center;
            }
            .product__actions-item {
                width: 100%;
            }
        }
        .product__content {
            grid-template-columns: [gallery] calc(40% - 30px) [info] calc(40% - 35px) [sidebar] calc(25% - 10px);
            grid-column-gap: 10px;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush

@section('title', $product->name)

@section('content')

    @include('partials.page-header', [
        'paths' => [
            url('/')                => 'Home',
            route('products.index') => 'Products',
        ],
        'active' => $product->name,
    ])

    <div class="block">
        <div class="container">
            <div class="product product--layout--standard" data-layout="standard">
                <div class="product__content" data-id="{{ $product->id }}" data-max="{{ $product->should_track ? $product->stock_count : -1 }}">
                    <div class="xzoom-container">
                        <img class="xzoom" id="xzoom-default" src="{{ asset($product->base_image->src) }}" xoriginal="{{ asset($product->base_image->src) }}" />
                        <div class="xzoom-thumbs d-flex mt-2">
                            <a href="{{ asset($product->base_image->src) }}"><img class="xzoom-gallery" width="80" src="{{ asset($product->base_image->src) }}"  xpreview="{{ asset($product->base_image->src) }}"></a>
                            @foreach($product->additional_images as $image)
                                <a href="{{ asset($image->src) }}">
                                    <img class="xzoom-gallery" width="80" src="{{ asset($image->src) }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <!-- .product__info -->
                    <div class="product__info">
                        <h1 class="product__name">{{ $product->name }}</h1>
                        <div class="w-100 mb-2 border-top pt-2">Product Code: <strong>{{ $product->sku }}</strong></div>
                        <div class="product__prices {{$product->selling_price == $product->price ? '' : 'has-special'}}">
                            Price:
                            @if($product->selling_price == $product->price)
                                {!!  theMoney($product->price)  !!}
                            @else
                                <span class="product-card__new-price">{!!  theMoney($product->selling_price)  !!}</span>
                                <span class="product-card__old-price">{!!  theMoney($product->price)  !!}</span>
                            @endif
                        </div>
                        <ul class="product__meta">
                            <li class="product__meta-availability w-100 mb-2">
                                <big>
                                    Availability:
                                    @if(! $product->should_track)
                                        <span class="text-success">In Stock</span>
                                    @else
                                        <span class="text-{{ $product->stock_count ? 'success' : 'danger' }}">{{ $product->stock_count }} In Stock</span>
                                    @endif
                                </big>
                            </li>
                        </ul>
                        <!-- .product__sidebar -->
                        <div class="product__sidebar">
                            <!-- .product__options -->
                            <form class="product__options">
                                <div class="form-group product__option">
                                    <label class="product__option-label" for="product-quantity">Quantity</label>
                                    <div class="product__actions">
                                        <div class="product__actions-item d-flex justify-content-center">
                                            <div class="input-number product__quantity">
                                                <input id="product-quantity"
                                                       class="input-number__input form-control form-control-lg"
                                                       type="number" min="1" {{ $product->should_track ? 'max='.$product->stock_count : '' }} value="1">
                                                <div class="input-number__add"></div>
                                                <div class="input-number__sub"></div>
                                            </div>
                                        </div>
                                        @exp($available = !$product->should_track || $product->stock_count > 0)
                                        <div class="product__buttons d-flex flex-wrap">
                                            {{-- <div class="product__actions-item product__actions-item--addtocart">
                                                <button class="btn btn-primary product__addtocart btn-lg btn-block" {{ $available ? '' : 'disabled' }}>Add to cart</button>
                                            </div> --}}
                                            <div class="product__actions-item product__actions-item--ordernow">
                                                <button class="btn btn-primary product__ordernow btn-lg btn-block d-flex justify-content-center align-items-center" {{ $available ? '' : 'disabled' }}>
                                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M7 8V6a5 5 0 1 1 10 0v2h3a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h3zm0 2H5v10h14V10h-2v2h-2v-2H9v2H7v-2zm2-2h6V6a3 3 0 0 0-6 0v2z"/></svg>
                                                    <span class="ml-1">অর্ডার করুন</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="call-for-order text-center">
                                    <img src="{{ asset('call-now-icon-20.jpg') }}" width="135" alt="Call For Order">
                                    <div style="padding: 10px;margin-bottom: 10px;font-weight: bold;color: red;">
                                        {!! implode('<br>', explode(' ', setting('call_for_order'))) !!}
                                    </div>
                                </div>
                            </form><!-- .product__options / end -->
                        </div><!-- .product__end -->

                        <div class="product__footer mt-0">
                            <div class="product__tags tags">
                                @if($product->brand)
                                    <p class="text-secondary mb-2">
                                        Brand: <a href="{{ route('brands.products', $product->brand) }}" class="text-primary badge badge-light"><big>{{ $product->brand->name }}</big></a>
                                    </p>
                                @endif
                                <div class="">
                                    <p class="text-secondary mb-2 d-inline-block mr-2">Categories:</p>
                                    @foreach($product->categories as $category)
                                        <a href="{{ route('categories.products', $category) }}" class="badge badge-primary">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div><!-- .product__info / end -->
                    <div>
                        <div class="block-features__list flex-column d-block">
                            @if($services = setting('services'))
                                @foreach(config('services.services', []) as $num => $icon)
                                    <div class="block-features__item">
                                        <div class="block-features__icon">
                                            <svg width="48px" height="48px">
                                                <use xlink:href="{{ asset($icon) }}"></use>
                                            </svg>
                                        </div>
                                        <div class="block-features__content">
                                            <div class="block-features__title">{{ $services->$num->title }}</div>
                                            <div class="block-features__subtitle">{{ $services->$num->detail }}</div>
                                        </div>
                                    </div>
                                    @if(!$loop->last)
                                        <div class="block-features__divider"></div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div id="accordion" class="mt-3">
                <div class="card">
                    <div class="card-header p-0">
                        <a class="card-link px-4" datatoggle="collapse" href="javascript:void(false)">
                            Product Description
                        </a>
                    </div>
                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                        <div class="card-body p-4">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-0">
                        <a class="card-link px-4" datatoggle="collapse" href="javascript:void(false)">
                            Delivery and Payment
                        </a>
                    </div>
                    <div id="collapseTwo" class="collapse show" data-parent="#accordion">
                        <div class="card-body p-4">
                            {!! setting('delivery_text') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .block-products-carousel -->
    @include('partials.products.pure-grid', [
        'title' => 'Related Products',
        'cols' => $related_products->cols,
        'rows' => $related_products->rows,
    ])
    <!-- .block-products-carousel / end -->
@endsection

@push('scripts')
    <script src="{{ asset('strokya/vendor/xzoom/xzoom.min.js') }}"></script>
    <script src="{{ asset('strokya/vendor/xZoom-master/example/js/vendor/modernizr.js') }}"></script>
    <script src="{{ asset('strokya/vendor/xZoom-master/example/js/setup.js') }}"></script>
    <script>
        $(document).ready(function () {

        });
    </script>
@endpush
