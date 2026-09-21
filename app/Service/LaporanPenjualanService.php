<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanPenjualanService
{
    public function ringkasanHariIni(): array
    {
        $data = DB::table('penjualan')
            ->whereDate('created_at', Carbon::today())
            ->where('status', 'COMPLETED')
            ->selectRaw('
                COUNT(*) as total_transaksi,
                SUM(total_pembayaran) as total_penjualan,
                SUM(CASE WHEN metode_pembayaran = "CASH" THEN total_pembayaran ELSE 0 END) as total_cash,
                SUM(CASE WHEN metode_pembayaran != "CASH" THEN total_pembayaran ELSE 0 END) as total_non_tunai')
            ->first();

        return [
            'total_transaksi' => $data->total_transaksi ?? 0,
            'total_penjualan' => $data->total_penjualan ?? 0,
            'total_cash' => $data->total_cash ?? 0,
            'total_non_tunai' => $data->total_non_tunai ?? 0,
        ];
    }

    public function produkTerlarisHariIni($limit = 5)
{
    return DB::table('item_penjualan')
        ->join('penjualan', 'penjualan.id', '=', 'item_penjualan.penjualan_id')
        ->join('produk', 'produk.id', '=', 'item_penjualan.produk_id')
        ->whereDate('penjualan.created_at', now()->today())
        ->where('penjualan.status', 'COMPLETED')
        ->select(
            'produk.nama',
            'produk.stok',
            DB::raw('SUM(item_penjualan.kuantitas) as total_terjual')
        )
        ->groupBy('produk.id', 'produk.nama', 'produk.stok') // <--- Tambahkan produk.stok di sini
        ->orderByDesc('total_terjual')
        ->limit($limit)
        ->get();
}

}
