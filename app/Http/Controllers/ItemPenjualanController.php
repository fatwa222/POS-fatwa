<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemPenjualan;
use App\Models\Produk;
use App\Models\Penjualan; 

class ItemPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
{
    $request->validate([
        'penjualan_id' => 'required|exists:penjualan,id',
        'produk_id' => 'required|exists:produk,id',
        'kuantitas' => 'nullable|integer|min:1',
    ]);

    $jumlah = $request->kuantitas ?? 1;
    $produk = Produk::findOrFail($request->produk_id);

    $item = ItemPenjualan::where('penjualan_id', $request->penjualan_id)
        ->where('produk_id', $request->produk_id)
        ->first();

    if ($item) {
        $item->kuantitas += $jumlah;
        $item->subtotal = $item->kuantitas * $item->harga_satuan;
        $item->save();
    } else {
        $item = ItemPenjualan::create([
            'penjualan_id' => $request->penjualan_id,
            'produk_id' => $request->produk_id,
            'kuantitas' => $jumlah,
            'harga_satuan' => $produk->harga_jual,
            'subtotal' => $jumlah * $produk->harga_jual,
        ]);
    }

    $total = ItemPenjualan::where('penjualan_id', $request->penjualan_id)->sum('subtotal');
    Penjualan::where('id', $request->penjualan_id)->update(['total_pembayaran' => $total]);

    return back();
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'kuantitas' => 'required|integer|min:1',
    ]);

    $item = ItemPenjualan::findOrFail($id);
    $item->kuantitas = $request->kuantitas;
    $item->subtotal = $item->kuantitas * $item->harga_satuan;
    $item->save();

    $total = ItemPenjualan::where('penjualan_id', $item->penjualan_id)->sum('subtotal');
    Penjualan::where('id', $item->penjualan_id)->update(['total_pembayaran' => $total]);

    return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Itempenjualan);

        $item = ItemPenjualan::findOrFail($id);
    $penjualanId = $item->penjualan_id;
    $item->delete();

    $total = ItemPenjualan::where('penjualan_id', $penjualanId)->sum('subtotal');
    Penjualan::where('id', $penjualanId)->update(['total_pembayaran' => $total]);

    return back();
    }
}
