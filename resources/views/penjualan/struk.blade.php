<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian #{{ $penjualan->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 58mm;
            margin: 0 auto;
            padding: 8px;
            font-size: 11px;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .line { border-bottom: 1px dashed #000; margin: 6px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; padding: 2px 0; }
        
        .action-buttons {
            margin-bottom: 12px;
            text-align: center;
            display: flex;
            gap: 6px;
            justify-content: center;
        }
        .btn {
            padding: 5px 12px;
            font-size: 11px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }
        /* Menggunakan warna tema Bootstrap */
        .btn-primary { background-color: #0d6efd; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }

        @media print {
            .no-print { display: none !important; }
            body { width: 100%; margin: 0; padding: 0; }
        }
    </style>
</head>
<body>

    <!-- Tombol Navigasi dengan tema aplikasi -->
    <div class="action-buttons no-print">
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">← Kembali</a>
        <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak</button>
    </div>

    <div class="text-center">
        <h3 style="margin: 0;">Yuuma GameShop</h3>
        <p style="margin: 2px 0;">Struk Pembelian</p>
    </div>

    <div class="line"></div>

    <table>
        <tr>
            <td>No TRX: #{{ $penjualan->id }}</td>
            <td class="text-right">{{ $penjualan->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td colspan="2">Kasir: {{ $penjualan->user->name ?? 'Admin' }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        @foreach($penjualan->itemPenjualan as $item)
        <tr>
            <td colspan="2"><strong>{{ $item->produk->nama ?? $item->nama }}</strong></td>
        </tr>
        <tr>
            <td>{{ $item->kuantitas }} x {{ number_format($item->harga_satuan ?? ($item->subtotal / ($item->kuantitas ?: 1)), 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>

    @php
        $metode = strtoupper($penjualan->metode_pembayaran);
        // Memeriksa apakah metode pembayaran mengandung kata CASH atau TUNAI
        $isCash = str_contains($metode, 'CASH') || str_contains($metode, 'TUNAI');
        
        $bayar = $penjualan->bayar ?? $penjualan->total_pembayaran;
        $kembali = $penjualan->kembali ?? max(0, $bayar - $penjualan->total_pembayaran);
    @endphp

    <table>
        <tr>
            <td>Metode Bayar</td>
            <td class="text-right">{{ $metode }}</td>
        </tr>
        <tr>
            <td><strong>Total</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}</strong></td>
        </tr>

        {{-- Tampilkan detail Nominal Bayar & Kembali jika Metode Pembayaran Tunai/Cash --}}
        @if($isCash)
        <tr>
            <td>Bayar</td>
            <td class="text-right">Rp {{ number_format($bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">Rp {{ number_format($kembali, 0, ',', '.') }}</td>
        </tr>
        @endif
    </table>

    <div class="line"></div>

    <div class="text-center" style="margin-top: 10px;">
        <p style="margin: 2px 0;">Terima Kasih!</p>
        <p style="margin: 2px 0;">Selamat Belanja Kembali</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>