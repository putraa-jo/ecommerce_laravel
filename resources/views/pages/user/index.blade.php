@extends('layouts.user.main')
@section('content')
<!-- start banner Area -->
<section class="banner-area">
    <div class="container">
     <div class="row fullscreen align-items-center justify-content-start">
            <div class="col-lg-12">
                <div class="">
                    <!-- single-slide -->
                    <div class="row">
                        <div class="col-lg-5 col-md-6">
                            <div class="banner-content">
                                <h1>Nike New <br>Collection!</h1>
           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="banner-img">
      <img class="img-fluid" src="{{ asset('assets/templates/user/img/banner/banner-img.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End banner Area -->

<!-- start Flash Sale Area -->
@if($flashSales->count() > 0)
<section class="section_gap" id="flash-sale">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>⚡ Flash Sale</h1>
                    <p>Dapatkan produk dengan harga spesial! Penawaran terbatas, buruan sebelum kehabisan!</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($flashSales as $item)
                <div class="col-lg-3 col-md-6">
                    <div class="single-product" style="border: 2px solid #ff6b6b; border-radius: 8px; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 10px; left: 10px; background: #ff4757; color: #fff; padding: 4px 12px; border-radius: 4px; font-size: 12px; font-weight: bold; z-index: 2;">
                            FLASH SALE
                        </div>
                        <img class="img-fluid" src="{{ asset('images/' . $item->product->image) }}" alt="">
                        <div class="product-details">
                            <h6>{{ $item->product->name }}</h6>
                            <div class="price">
                                <h6 style="text-decoration: line-through; color: #999; font-size: 13px;">{{ $item->product->price }} Points</h6>
                                <h6 style="color: #ff4757; font-weight: bold;">{{ $item->discount_price }} Points</h6>
                            </div>
                            <div style="text-align: center; margin: 8px 0;">
                                <small style="color: #ff4757; font-weight: bold;">Berakhir dalam:</small>
                                <div class="countdown-timer" data-end="{{ $item->end_time->toIso8601String() }}" style="font-size: 14px; font-weight: bold; color: #ff4757; margin-top: 4px;">
                                </div>
                            </div>
                            <div class="prd-bottom">
                                <a class="social-info" href="javascript:void(0);"
                                    onclick="confirmFlashPurchase('{{ $item->id }}', '{{ Auth::user()->id }}')">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">Beli</p>
                                </a>
                                <a href="{{ route('user.detail.product', $item->product->id) }}" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">Detail</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- end Flash Sale Area -->

<!-- start product Area -->
<section class="section_gap">
    <!-- single product slide -->>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Latest Products</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore
                        magna aliqua.</p>
                </div>
            </div>
        </div>
       <div class="row">
                <!-- single product -->
                @forelse ($products as $item)
                    <div class="col-lg-3 col-md-6">
                        <div class="single-product">
                            <img class="img-fluid" src="{{ asset('images/' . $item->image) }}" alt="">
                            <div class="product-details">
                                <h6>{{ $item->name }}</h6>
                                <div class="price">
                                    <h6>Harga: {{ $item->price }} Points</h6>
                                </div>
                                <div class="prd-bottom">
                                    <a class="social-info" href="javascript:void(0);"
                                        onclick="confirmPurchase('{{ $item->id }}', '{{ Auth::user()->id }}')">
                                        <span class="ti-bag"></span>
                                        <p class="hover-text">Beli</p>
                                    </a>
                                    <a href="{{ route('user.detail.product', $item->id) }}" class="social-info">
                                        <span class="lnr lnr-move"></span>
                                        <p class="hover-text">Detail</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12 col-md-12">
                        <div class="single-product">
                            <h3 class="text-center">Tidak ada produk</h3>
                        </div>
                    </div>
                @endforelse
            </div>
    </div>
</section>
<!-- end product Area -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmPurchase(productId, userId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan membeli produk ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Beli!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/product/purchase/' + productId + '/' + userId;
                }
            });
        }

        function confirmFlashPurchase(flashSaleId, userId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan membeli produk Flash Sale ini dengan harga diskon!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Beli!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/product/purchase-flash/' + flashSaleId + '/' + userId;
                }
            });
        }

        // Countdown Timer
        function updateCountdowns() {
            document.querySelectorAll('.countdown-timer').forEach(function(el) {
                var endTime = new Date(el.getAttribute('data-end')).getTime();
                var now = new Date().getTime();
                var distance = endTime - now;

                if (distance < 0) {
                    el.innerHTML = '<span style="color: #999;">Berakhir</span>';
                    return;
                }

                var hours = Math.floor(distance / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                el.innerHTML = hours + 'j ' + minutes + 'm ' + seconds + 'd';
            });
        }

        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    </script>
@endsection

