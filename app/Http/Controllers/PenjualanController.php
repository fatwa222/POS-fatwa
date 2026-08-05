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

    $products = Produk::when($search, function ($query, $search) {
            $query->where('nama', 'like', "%{$search}%");
        })
        ->latest()
        ->get();

    return view('penjualan.pos', compact('sale', 'products'));
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
  public function edit(Penjualan $penjualan)
{
    $sale = $penjualan;

    abort_if($sale->status === 'COMPLETED', 403);

    $sale->load('itemPenjualan');
    $products = Produk::orderBy('nama')->get();
    $mode = 'edit';

    return view('penjualan.pos', compact('sale', 'products', 'mode'));
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Penjualan $penjualan)
{
        $this->authorize('delete', $penjualan);
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

public function update(Request $request, Penjualan $penjualan)
{
    // Validasi input
    $request->validate([
        'metode_pembayaran' => 'required|string',
    ]);

    // Update data penjualan
    $penjualan->update([
        'metode_pembayaran' => $request->metode_pembayaran,
        'status' => 'COMPLETED', // Sesuaikan logika status jika perlu
    ]);

    return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil diperbarui!');
}



}
