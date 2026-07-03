@extends('layouts.admin.main')
@section('title', 'Admin Edit Flash Sale')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Flash Sale</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.flash-sale') }}">Flash Sale</a></div>
                <div class="breadcrumb-item">Edit Flash Sale</div>
            </div>
        </div>

        <a href="{{ route('admin.flash-sale') }}" class="btn btn-icon icon-left btn-warning"> Kembali</a>

        <div class="card mt-4">
            <form action="{{ route('flash-sale.update', $flashSale->id) }}" class="needs-validation" novalidate="" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="product_id">Pilih Produk</label>
                                <select id="product_id" class="form-control" name="product_id" required="">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $flashSale->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} ({{ $product->price }} Points)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Kolom ini harus di isi!
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="discount_price">Harga Diskon (Point)</label>
                                <input id="discount_price" type="number" class="form-control" name="discount_price" value="{{ $flashSale->discount_price }}" required="">
                                <div class="invalid-feedback">
                                    Kolom ini harus di isi!
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="start_time">Waktu Mulai</label>
                                <input id="start_time" type="datetime-local" class="form-control" name="start_time" value="{{ $flashSale->start_time->format('Y-m-d\TH:i') }}" required="">
                                <div class="invalid-feedback">
                                    Kolom ini harus di isi!
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="end_time">Waktu Berakhir</label>
                                <input id="end_time" type="datetime-local" class="form-control" name="end_time" value="{{ $flashSale->end_time->format('Y-m-d\TH:i') }}" required="">
                                <div class="invalid-feedback">
                                    Kolom ini harus di isi!
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
