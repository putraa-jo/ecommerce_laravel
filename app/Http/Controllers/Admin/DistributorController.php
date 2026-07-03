<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Imports\DistributorImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class DistributorController extends Controller
{
    public function index()
    {
        $distributor = Distributor::all();
        confirmDelete('Hapus data!', 'Apakah anda yakin ingin menghapus data ini?');
        return view('pages.admin.distributor.index', compact('distributor'));
    }

    public function create()
    {
        return view('pages.admin.distributor.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_distributor' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'kontak' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back();
        }

        $distributor = Distributor::create([
            'nama_distributor' => $request->nama_distributor,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kontak' => $request->kontak,
            'email' => $request->email,
        ]);

        if ($distributor) {
            Alert::success('Berhasil!', 'Distributor berhasil ditambahkan!');
            return redirect()->route('admin.distributor');
        } else {
            Alert::error('Gagal!', 'Distributor gagal ditambahkan!');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $distributor = Distributor::findOrFail($id);
        return view('pages.admin.distributor.edit', compact('distributor'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_distributor' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'kontak' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back();
        }

        $distributor = Distributor::findOrFail($id);
        $distributor->update([
            'nama_distributor' => $request->nama_distributor,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kontak' => $request->kontak,
            'email' => $request->email,
        ]);

        if ($distributor) {
            Alert::success('Berhasil!', 'Distributor berhasil diperbarui!');
            return redirect()->route('admin.distributor');
        } else {
            Alert::error('Gagal!', 'Distributor gagal diperbarui!');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $distributor = Distributor::findOrFail($id);
        $distributor->delete();

        if ($distributor) {
            Alert::success('Berhasil!', 'Distributor berhasil dihapus!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Distributor gagal dihapus!');
            return redirect()->back();
        }
    }

    public function import(Request $request)
    {
        try {
            $file = $request->file('file');
            Excel::import(new DistributorImport, $file);
            Alert::success('Berhasil!', 'Data berhasil di import!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = '';
            foreach ($failures as $failure) {
                $messages .= 'Kesalahan pada baris ' . $failure->row() . ': ' . implode(', ', $failure->errors()) . '. ';
            }
            Alert::error('Gagal!', 'Validasi Gagal: ' . $messages);
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Pastikan format dan isi sudah benar! Error: ' . $e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function export()
    {
        $distributors = Distributor::all();
        $pdf = Pdf::loadView('pages.admin.distributor.export', compact('distributors'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('distributor.pdf');
    }
}
