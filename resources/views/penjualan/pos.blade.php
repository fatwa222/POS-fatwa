@extends('layouts.app')

@section('title', 'Halaman Kasir (POS)')

@section('content')
@include('layouts.navbar')

<style>
    :root {
        --primary: #091540;
        --secondary: #1B2CC1;
        --accent: #7692FF;
        --bg-light: #F8FAFC;
        --text-dark: #0F172A;
        --text-muted: #64748B;
        --border-color: #E2E8F0;
    }

    body {
        background-color: var(--bg-light);
        color: var(--text-dark);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .page-title {
        color: var(--primary);
        font-weight: 700;
        font-size: 1.5rem;
        letter-spacing: -0.02em;
    }

    .pos-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .search-input {
        border-radius: 8px !important;
        border: 1px solid var(--border-color);
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }

    .search-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(118, 146, 255, 0.15);
    }

    .product-item {
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin-bottom: 0.75rem;
        background-color: #ffffff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .product-item:hover {
        border-color: var(--accent);
        box-shadow: 0 2px 8px rgba(118, 146, 255, 0.12);
    }

    .cart-table {
        width: 100%;
        margin-bottom: 0;
    }

    .cart-table th {
        background: #F8FAFC;
        color: var(--primary);
        font-weight: 600;
        font-size: 0.8rem;
        border-bottom: 2px solid var(--border-color);
        padding: 0.6rem;
    }

    .cart-table td {
        padding: 0.6rem;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.85rem;
        vertical-align: middle;
    }

    .qty-input {
        border-radius: 6px;
        border: 1px solid var(--border-color);
        text-align: center;
        font-weight: 600;
    }

    .total-box {
        background: #F1F5F9;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .btn-add-item {
        background-color: var(--secondary);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        padding: 0.35rem 0.75rem;
    }

    .btn-add-item:hover {
        background-color: var(--primary);
        color: #ffffff;
    }

    .btn-checkout {
        background-color: #16A34A;
        color: #ffffff;
        border: none;
        font-weight: 600;
        padding: 0.75rem;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    .btn-checkout:hover:not(:disabled) {
        background-color: #15803D;
        color: #ffffff;
    }
</style>

<div class="container py-4">
    {{-- Alert Pesan Flash --}}
    @if(session('errors'))
    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
        {{ session('errors') }}
    </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title m-0">Halaman Kasir</h1>
        <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
            ID Transaksi: <strong>#{{ $sale->id }}</strong>
        </span>
    </div>

    <div class="row g-4">
        <!-- Katalog Produk (Kiri) -->
        <div class="col-lg-7">
            <div class="pos-card p-3">
                <form method="GET" action="{{ route('penjualan.edit', $sale->id) }}" class="mb-3">
                    <div class="input-group">
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control search-input"
                            placeholder="Cari nama produk...">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    </div>
                </form>

                <div style="max-height: 65vh; overflow-y: auto;" class="pe-1">
                    @forelse($products as $item)
                    <div class="product-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold text-dark">{{ $item->nama }}</div>
                            <div class="text-muted small">
                                Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('item-penjualan.store') }}" class="d-flex align-items-center gap-2">
                            @csrf
                            <input type="hidden" name="penjualan_id" value="{{ $sale->id }}">
                            <input type="hidden" name="produk_id" value="{{ $item->id }}">
                            <input type="number"
                                name="kuantitas"
                                value="1"
                                min="1"
                                class="form-control form-control-sm qty-input"
                                style="width: 60px;">
                            <button type="submit" class="btn btn-add-item btn-sm">
                                + Tambah
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        Produk tidak ditemukan.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Rincian Keranjang & Pembayaran (Kanan) -->
        <div class="col-lg-5">
            <div class="pos-card p-3">
                <h5 class="fw-bold mb-3" style="color: var(--primary);">Keranjang Belanja</h5>

                <div class="table-responsive" style="max-height: 35vh; overflow-y: auto;">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center" style="width: 70px;">Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-center" style="width: 40px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sale->itemPenjualan as $item)
                            <tr>
                                <td class="fw-semibold text-dark">{{ $item->produk->nama }}</td>
                                <td class="text-end text-muted">
                                    {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('item-penjualan.update', $item->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="number"
                                            name="kuantitas"
                                            value="{{ $item->kuantitas }}"
                                            min="1"
                                            class="form-control form-control-sm qty-input"
                                            onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="text-end fw-semibold">
                                    {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @can('delete', $item)
                                    <form method="POST" action="{{ route('item-penjualan.destroy', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-link text-danger p-0 border-0"
                                            onclick="return confirm('Hapus produk ini?')"
                                            title="Hapus">
                                            &times;
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Keranjang masih kosong.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="total-box d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-semibold text-muted">Total Bayar:</span>
                    <span class="fs-4 fw-bold" style="color: var(--secondary);">
                        Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                    </span>
                </div>

                <!-- Form Selesaikan Pembayaran -->
                <!-- Form Selesaikan Pembayaran -->
<form action="{{ route('penjualan.update', $sale->id) }}" method="POST" id="form-checkout">
    @csrf
    @method('PUT')

    <input type="hidden" id="total_pembayaran" value="{{ $sale->total_pembayaran }}">

    <div class="mb-3">
        <label class="form-label text-muted small">Metode Pembayaran</label>
        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select">
            <option value="Cash (Tunai)">Cash (Tunai)</option>
            <option value="QRIS">QRIS</option>
            <option value="Transfer">Transfer</option>
        </select>
    </div>

    <!-- Container CASH -->
    <div id="container-cash">
        <div class="mb-3">
            <label class="form-label text-muted small">Uang Diterima (Rp)</label>
            <input type="number"
                name="uang_diterima"
                id="uang_diterima"
                class="form-control form-control-lg"
                placeholder="0"
                min="0">
        </div>

        <div class="p-3 bg-light rounded border mb-3 d-flex justify-content-between align-items-center">
            <span class="text-muted fw-semibold">Kembalian:</span>
            <span class="h5 mb-0 fw-bold text-success" id="text-kembalian">Rp 0</span>
        </div>
    </div>

    <!-- Container QRIS -->
    <div id="container-qris" class="text-center p-3 bg-light rounded border mb-3" style="display: none;">
        <p class="small text-muted mb-2 fw-semibold">Scan QRIS untuk Pembayaran</p>
        <!-- Ganti 'qris.png' dengan path gambar QRIS kamu -->
       <img src="{{ asset('assets/img/qrisfatwa.jpeg') }}" alt="QRIS Code" class="img-fluid rounded border bg-white p-2" style="max-height: 180px;">
    </div>

    <!-- Container TRANSFER -->
    <div id="container-transfer" class="p-3 bg-light rounded border mb-3" style="display: none;">
        <p class="small text-muted mb-1 fw-semibold">Rekening Pembayaran:</p>
        <div class="fw-bold text-dark">BCA: 1234-5678-90</div>
        <div class="small text-muted">a.n. Nama Toko Kamu</div>
    </div>

    <button type="submit" class="btn btn-success w-100 py-2 mb-2 btn-checkout" id="btn-submit-checkout" {{ $sale->itemPenjualan->isEmpty() ? 'disabled' : '' }}>
        Selesaikan Transaksi
    </button>
</form>
                <!-- Form Batal Transaksi -->
                <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100 py-2">
                        Batal Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalPembayaran = parseFloat(document.getElementById('total_pembayaran').value) || 0;
    const inputUangDiterima = document.getElementById('uang_diterima');
    const textKembalian = document.getElementById('text-kembalian');
    const selectMetode = document.getElementById('metode_pembayaran');

    const containerCash = document.getElementById('container-cash');
    const containerQris = document.getElementById('container-qris');
    const containerTransfer = document.getElementById('container-transfer');

    function formatRupiah(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    function calculateChange() {
        const uangDiterima = parseFloat(inputUangDiterima.value) || 0;
        const kembalian = uangDiterima - totalPembayaran;

        if (kembalian >= 0) {
            textKembalian.innerText = formatRupiah(kembalian);
            textKembalian.className = 'h5 mb-0 fw-bold text-success';
        } else {
            textKembalian.innerText = formatRupiah(kembalian);
            textKembalian.className = 'h5 mb-0 fw-bold text-danger';
        }
    }

    function togglePaymentMethod() {
        const value = selectMetode.value.toUpperCase();

        // Sembunyikan semua container dulu
        containerCash.style.display = 'none';
        containerQris.style.display = 'none';
        containerTransfer.style.display = 'none';
        inputUangDiterima.removeAttribute('required');

        if (value.includes('CASH') || value.includes('TUNAI')) {
            containerCash.style.display = 'block';
            inputUangDiterima.value = '';
            inputUangDiterima.setAttribute('required', 'required');
            calculateChange();
        } else if (value.includes('QRIS')) {
            containerQris.style.display = 'block';
            inputUangDiterima.value = totalPembayaran; // Auto-fill agar backend tidak null
        } else if (value.includes('TRANSFER')) {
            containerTransfer.style.display = 'block';
            inputUangDiterima.value = totalPembayaran; // Auto-fill agar backend tidak null
        }
    }

    inputUangDiterima.addEventListener('input', calculateChange);
    selectMetode.addEventListener('change', togglePaymentMethod);

    // Jalankan sekali saat pertama load
    togglePaymentMethod();
});
</script>
@endsection