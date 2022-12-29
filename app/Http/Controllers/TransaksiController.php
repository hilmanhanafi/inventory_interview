<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {

        $produk = DB::table('products')->get();

        if(isset(request()->start_date) && isset(request()->end_date)){
            $transaksi = DB::table('transactions')
            ->select('transactions.id','products.nama_barang','transactions.tanggal_transaksi','transactions.jumlah_terjual','products.jenis_barang')
            ->join('products','transactions.product_id','=','products.id')
            ->whereBetween('tanggal_transaksi',[request()->start_date,request()->end_date])
            ->get();
            return view('transaksi.index',compact('transaksi','produk'));

        }else{

            $transaksi = DB::table('transactions')
            ->select('transactions.id','products.nama_barang','transactions.tanggal_transaksi','transactions.jumlah_terjual','products.jenis_barang')
            ->join('products','transactions.product_id','=','products.id')
            ->get();
            return view('transaksi.index',compact('transaksi','produk'));
        }
    }

    public function terbanyak()
    {
        $transaksi = DB::table('transactions')
        ->select('products.nama_barang',DB::raw('SUM(transactions.jumlah_terjual) AS totalTerjual'))
        ->join('products','transactions.product_id','=','products.id')
        ->groupBy('products.nama_barang')
        ->orderBy('totalTerjual','DESC')
        ->get();
        return view('transaksi.terbanyak',compact('transaksi'));
    }

    public function terendah()
    {
        $transaksi = DB::table('transactions')
        ->select('products.nama_barang',DB::raw('SUM(transactions.jumlah_terjual) AS totalTerjual'))
        ->join('products','transactions.product_id','=','products.id')
        ->groupBy('products.nama_barang')
        ->orderBy('totalTerjual','ASC')
        ->get();
        return view('transaksi.terendah',compact('transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required',
            'tanggal' => 'required'
        ]);

        DB::table('transactions')->insert([
            'product_id' => $request->nama_barang,
            'jumlah_terjual' => $request->jumlah,
            'tanggal_transaksi' => $request->tanggal
        ]);

        $produk = DB::table('products')->where('id',$request->nama_barang)->first();

        DB::table('products')->where('id',$produk->id)->update([
            'stok' => $produk->stok - $request->jumlah
        ]);

        return redirect('/transaksi')->with('status','Data berhasil ditambahkan');
    }

    function getApiDataTransaksi()
    {
        $transaksi = DB::table('transactions')
        ->select('transactions.id','products.nama_barang','transactions.tanggal_transaksi','transactions.jumlah_terjual','products.jenis_barang')
        ->join('products','transactions.product_id','=','products.id')
        ->get();

        return response()->json(['message' => 'Data Transaksi','data'  => $transaksi]);
    }

    function getApiDataTransaksiFilter(){
        if(isset(request()->start_date) && isset(request()->end_date)){
            $transaksi = DB::table('transactions')
            ->select('transactions.id','products.nama_barang','transactions.tanggal_transaksi','transactions.jumlah_terjual','products.jenis_barang')
            ->join('products','transactions.product_id','=','products.id')
            ->whereBetween('tanggal_transaksi',[request()->start_date,request()->end_date])
            ->get();
            return response()->json(['message' => 'Data Transaksi Menggunakan Filter','data'  => $transaksi]);

        }else{

            $transaksi = DB::table('transactions')
            ->select('transactions.id','products.nama_barang','transactions.tanggal_transaksi','transactions.jumlah_terjual','products.jenis_barang')
            ->join('products','transactions.product_id','=','products.id')
            ->get();
            return response()->json(['message' => 'Data Transaksi','data'  => $transaksi]);
        }
    }
}
