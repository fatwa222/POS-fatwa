<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(SearchRequest $request)
{
    $search = $request->search;
    $user = auth()->user();

    $sales = Penjualan::when($search, function ($query, $search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        })
        ->when($user->role->name !== 'admin', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('penjualan.index', compact('sales'));
}

    /**
     * Show the form for creating a new resource.
     */

    public function create(SearchRequest $request)
{
    $user = Auth::user();

    $sale = Penjualan::firstOrCreate(
        ['user_id' => $user->id, 'status' => 'OPEN'],
        ['total_pembayaran' => 0, 'metode_pembayaran' => '-']
    );

    $search = $request->search;

    $produk = Produk::when($search, function ($query, $search) {
            $query->where('nama', 'like', "%{$search}%");
        })
        ->latest()
        ->get();

    return view('penjualan.pos', compact('sale', 'produk'));
}
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Penjualan::with('itemPenjualan.produk', 'user')->findOrFail($id);

    return view('penjualan.show', compact('sale'));
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
        'metode_pembayaran' => 'required|in:CASH,QRIS,TRANSFER',
    ]);

    $sale = Penjualan::findOrFail($id);

    if ($sale->itemPenjualan()->count() === 0) {
        return back()->with('error', 'Keranjang masih kosong, tidak bisa checkout.');
    }

    $sale->update([
        'metode_pembayaran' => $request->metode_pembayaran,
        'status' => 'COMPLETED',
    ]);
    return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil, pembayaran diterima.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Penjualan::findOrFail($id);
    $sale->itemPenjualan()->delete(); // hapus semua item keranjangnya dulu
    $sale->delete();                  // baru hapus transaksinya

    return redirect()->route('penjualan.index')->with('success', 'Transaksi dibatalkan.');
    }
}
