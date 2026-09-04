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

    .btn-cancel {
        background-color: transparent;
        color: #DC2626;
        border: 1px solid #FCA5A5;
        font-weight: 500;
        padding: 0.5rem;
        border-radius: 8px;
    }

    .btn-cancel:hover {
        background-color: #FEE2E2;
        color: #991B1B;
    }
</style>

<div class="container py-4">
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
        <h1 class="page-title m-0">Halaman Kasir </h1>
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

        <!-- Rincian Keranjang (Kanan) -->
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

                <div class="total-box d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-muted">Total Bayar:</span>
                    <span class="fs-4 fw-bold" style="color: var(--secondary);">
                        Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                    </span>
                </div>

                <form method="POST" action="{{ route('penjualan.update', $sale->id) }}" class="mt-3">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metodePembayaran" class="form-select" required onchange="toggleCashInput()">
                            <option value="">-- Pilih Metode --</option>
                            <option value="CASH">Cash (Tunai)</option>
                            <option value="QRIS">QRIS</option>
                            <option value="TRANSFER">Transfer Bank</option>
                        </select>
                    </div>

                    <div id="cashCalculation" class="d-none mb-3">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold text-muted">Uang Diterima (Rp)</label>
                            <input type="number" id="uangDiterima" class="form-control" placeholder="0" oninput="calculateKembalian()">
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded border">
                            <span class="small fw-semibold text-muted">Kembalian:</span>
                            <span id="uangKembalian" class="fw-bold text-success">Rp 0</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-checkout w-100" {{ $sale->itemPenjualan->isEmpty() ? 'disabled' : '' }}>
                        Selesaikan Transaksi
                    </button>
                </form>

                @can('delete', $sale)
                <form method="POST" action="{{ route('penjualan.destroy', $sale->id) }}"
                    onsubmit="return confirm('Yakin batalkan transaksi ini? Seluruh isi keranjang akan dihapus.')"
                    class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-cancel w-100">
                        Batal Transaksi
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>

<script>
    function toggleCashInput() {
        const metode = document.getElementById('metodePembayaran').value;
        const cashBox = document.getElementById('cashCalculation');
        if (metode === 'CASH') {
            cashBox.classList.remove('d-none');
        } else {
            cashBox.classList.add('d-none');
        }
    }

    function calculateKembalian() {
        // Mengambil angka total langsung dari PHP secara aman
        const totalPembayaran = Number("{{ $sale->total_pembayaran ?? 0 }}") || 0;
        const inputUang = parseFloat(document.getElementById('uangDiterima').value) || 0;
        const kembalian = inputUang - totalPembayaran;
        const elKembalian = document.getElementById('uangKembalian');

        if (kembalian >= 0) {
            elKembalian.className = 'fw-bold text-success';
            elKembalian.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
        } else {
            elKembalian.className = 'fw-bold text-danger';
            elKembalian.innerText = 'Kurang Rp ' + Math.abs(kembalian).toLocaleString('id-ID');
        }
    }
</script>
@endsection