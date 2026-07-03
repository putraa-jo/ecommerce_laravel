<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\User;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $flashSales = FlashSale::with('product')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->get();

        return view('pages.user.index', compact('products', 'flashSales'));
    }

    public function detail_product($id)
    {
        $product = Product::findOrFail($id);

        return view('pages.user.detail', compact('product'));
    }

    public function purchase($productId, $userId)
    {
        $product = Product::findOrFail($productId);
        $user = User::findOrFail($userId);

        if ($user->point >= $product->price) {
            $totalPoints = $user->point - $product->price;

            $user->update([
                'point' => $totalPoints,
            ]);

            History::create([
                'id_user' => $userId,
                'id_product' => $productId,
                'total_harga' => $product->price,
            ]);

            Alert::success('Berhasil!', 'Produk berhasil dibeli!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Point anda tidak cukup!');
            return redirect()->back();
        }
    }

    public function purchase_flash($flashSaleId, $userId)
    {
        $flashSale = FlashSale::with('product')->findOrFail($flashSaleId);
        $user = User::findOrFail($userId);

        // Check if flash sale is still active
        if (now()->lt($flashSale->start_time) || now()->gt($flashSale->end_time)) {
            Alert::error('Gagal!', 'Flash Sale sudah berakhir!');
            return redirect()->back();
        }

        if ($user->point >= $flashSale->discount_price) {
            $totalPoints = $user->point - $flashSale->discount_price;

            $user->update([
                'point' => $totalPoints,
            ]);

            History::create([
                'id_user' => $userId,
                'id_product' => $flashSale->product_id,
                'total_harga' => $flashSale->discount_price,
            ]);

            Alert::success('Berhasil!', 'Produk Flash Sale berhasil dibeli dengan harga diskon!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Point anda tidak cukup!');
            return redirect()->back();
        }
    }

    public function history($id)
    {
        $data = DB::table('histories')
            ->join('products', 'products.id', '=', 'histories.id_product')
            ->where('histories.id_user', '=', $id)
            ->get();

        return view('pages.user.history', compact('data'));
    }

    public function detail_history($id)
    {
        $data = DB::table('histories')
            ->join('products', 'products.id', '=', 'histories.id_product')
            ->where('histories.id', '=', $id)
            ->first();

        return view('pages.user.detail-history', compact('data'));
    }
}
