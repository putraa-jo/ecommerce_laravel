<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class FlashSaleController extends Controller
{
    public function index()
    {
        $flashSales = FlashSale::with('product')->get();

        confirmDelete('Hapus data!', 'Apakah anda yakin ingin menghapus data ini?');

        return view('pages.admin.flash-sale.index', compact('flashSales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('pages.admin.flash-sale.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'discount_price' => 'required|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back()->withInput();
        }

        $flashSale = FlashSale::create([
            'product_id' => $request->product_id,
            'discount_price' => $request->discount_price,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        if ($flashSale) {
            Alert::success('Berhasil!', 'Flash Sale berhasil ditambahkan!');
            return redirect()->route('admin.flash-sale');
        } else {
            Alert::error('Gagal!', 'Flash Sale gagal ditambahkan!');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $products = Product::all();
        return view('pages.admin.flash-sale.edit', compact('flashSale', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'discount_price' => 'required|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back()->withInput();
        }

        $flashSale = FlashSale::findOrFail($id);

        $flashSale->update([
            'product_id' => $request->product_id,
            'discount_price' => $request->discount_price,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        if ($flashSale) {
            Alert::success('Berhasil!', 'Flash Sale berhasil diperbarui!');
            return redirect()->route('admin.flash-sale');
        } else {
            Alert::error('Gagal!', 'Flash Sale gagal diperbarui!');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->delete();

        if ($flashSale) {
            Alert::success('Berhasil!', 'Flash Sale berhasil dihapus!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Flash Sale gagal dihapus!');
            return redirect()->back();
        }
    }
}
