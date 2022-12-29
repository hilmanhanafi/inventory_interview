<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = DB::table('products')->get();
        return view('produk.index',compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|unique:products,nama_barang',
            'jenis_barang' => 'required',
            'stok' => 'required|numeric'
        ]);
        DB::table('products')->insert([
            'nama_barang' => $request->nama_barang,
            'jenis_barang' =>$request->jenis_barang,
            'stok' => $request->stok,
            'user_id' => auth()->user()->id
        ]);

        return redirect('/produk')->with('status','Data Produk Berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = DB::table('products')->where('id',$id)->first();
        return view('produk.edit',compact('produk'));
    }

    public function update(Request $request,$id)
    {
        $produk = DB::table('products')->where('id',$id)->first();


                /* Rules validasi */
                $rules = [
                    'jenis_barang' => 'required',
                    'stok' => 'required|numeric'
                ];

                /* cek Jika kode_product tidak sama dengan kode_product awal */
                if ($request->nama_barang != $produk->nama_barang) {
                    $rules['nama_barang'] = 'required|unique:products,nama_barang';
                }
                /* Jalankan Validasi */
                $request->validate($rules);
        DB::table('products')->where('id',$id)->update([
            'nama_barang' => $request->nama_barang,
            'jenis_barang' =>$request->jenis_barang,
            'stok' => $request->stok
        ]);

        return redirect('/produk')->with('status','Data Produk Berhasil ditambahkan');
    }

    public function delete($id)
    {
        DB::table('products')->where('id',$id)->delete();
        return redirect('/produk')->with('status','Data Produk Berhasil dihapus');
    }

    function apiDataProduct(){
        $produk = DB::table('products')->get();
        return response()->json(['message' =>'Data Produk','data' => $produk]);
    }
}
