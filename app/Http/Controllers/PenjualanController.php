<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
    $sale = Penjualan::findOrFail($id);

    // Pastikan cuma transaksi OPEN yang boleh diedit
    if ($sale->status !== 'OPEN') {
        return redirect()->route('penjualan.index')
            ->with('errors', 'Transaksi ini sudah selesai, tidak bisa diedit.');
    }

    $produk = Produk::latest()->get();

    // Arahkan balik ke halaman pos (kasir) untuk lanjutin transaksi
    return view('penjualan.pos', compact('sale', 'produk'));
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Penjualan $penjualan)
{
    // ❗ Pastikan hanya transaksi OPEN
    if ($penjualan->status !== 'OPEN') {
        return redirect()->route('penjualan.index')->with('errors', 'Transaksi sudah selesai tidak bisa dibatalkan');
    }

    DB::transaction(function () use ($penjualan) {

        foreach ($penjualan->itemPenjualan as $item) {
            // ⏫ kembalikan stok
            $item->produk->increment('stok', $item->kuantitas);
        }

        // ❌ hapus item
        $penjualan->itemPenjualan()->delete();

        // ❌ hapus penjualan
        $penjualan->delete();
    });

    return redirect()
        ->route('penjualan.index')
        ->with('success', 'Transaksi berhasil dibatalkan');
}
}
