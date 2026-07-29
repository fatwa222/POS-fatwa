<?php

namespace App\Service;
use App\Models\Produk;

class MonitoringStokService
{
    /**
     * Create a new class instance.
     */
    public function produkStokRendah(int $batas = 5, int $perPage = 5)
    {
        return Produk::where('stok', '>', 0)
            ->where('stok', '<=', $batas)
            ->orderBy('stok', 'asc')
            ->paginate(5, ['*'], 'stok_rendah_page');
    }

    public function produkStokHabis(int $perPage = 5)
    {
        return Produk::where('stok', 0)
            ->orderBy('nama')
            ->paginate(5, ['*'], 'stok_habis_page');
    }

}
