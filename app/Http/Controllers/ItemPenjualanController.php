<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemPenjualan;
use App\Models\Produk;
use App\Models\Penjualan; 
use Illuminate\Support\Facades\DB;

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
        'produk_id'    => 'required|exists:produk,id',
        'kuantitas'    => 'nullable|integer|min:1',
    ]);

    $jumlah = $request->kuantitas ?? 1;

    try {
        DB::transaction(function () use ($request, $jumlah) {
            $produk = Produk::where('id', $request->produk_id)->lockForUpdate()->firstOrFail();

            if ($produk->stok < $jumlah) {
                throw new \RuntimeException('Stok produk "' . $produk->nama . '" tidak mencukupi.');
            }

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
                    'produk_id'    => $request->produk_id,
                    'kuantitas'    => $jumlah,
                    'harga_satuan' => $produk->harga_jual,
                    'subtotal'     => $jumlah * $produk->harga_jual,
                ]);
            }

            $produk->decrement('stok', $jumlah);

            $total = ItemPenjualan::where('penjualan_id', $request->penjualan_id)->sum('subtotal');
            Penjualan::where('id', $request->penjualan_id)->update(['total_pembayaran' => $total]);
        });
    } catch (\RuntimeException $e) {
        return back()->with('error', $e->getMessage());
    }

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

    try {
        DB::transaction(function () use ($request, $id) {
            $item = ItemPenjualan::findOrFail($id);
            $produk = Produk::where('id', $item->produk_id)->lockForUpdate()->firstOrFail();

            $qtyLama = $item->kuantitas;
            $qtyBaru = $request->kuantitas;
            $selisih = $qtyBaru - $qtyLama;

            if ($selisih > 0 && $produk->stok < $selisih) {
                throw new \RuntimeException('Stok produk "' . $produk->nama . '" tidak mencukupi.');
            }

            $item->kuantitas = $qtyBaru;
            $item->subtotal = $item->kuantitas * $item->harga_satuan;
            $item->save();

            $produk->decrement('stok', $selisih);

            $total = ItemPenjualan::where('penjualan_id', $item->penjualan_id)->sum('subtotal');
            Penjualan::where('id', $item->penjualan_id)->update(['total_pembayaran' => $total]);
        });
    } catch (\RuntimeException $e) {
        return back()->with('error', $e->getMessage());
    }

    return back();
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil data berdasarkan ID agar aman dari mismatch Route Model Binding
        $itempenjualan = ItemPenjualan::findOrFail($id);

        $this->authorize('delete', $itempenjualan);

        DB::transaction(function () use ($itempenjualan) {
            $produk = $itempenjualan->produk;
            $sale   = $itempenjualan->penjualan;

            // Kembalikan stok hanya jika produknya masih ada
            if ($produk) {
                $produk->increment('stok', $itempenjualan->kuantitas);
            }

            // Hapus item
            $itempenjualan->delete();

            // Update total penjualan jika relasinya ada
            if ($sale) {
                $sale->update([
                    'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
                ]);
            }
        });

        return back();
    }
}