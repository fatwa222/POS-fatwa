@extends('layouts.app')

@section('title', 'Dashboard')

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

    /* Header Styling */
    .dashboard-header {
        margin-bottom: 2rem;
    }

    .dashboard-title {
        color: var(--primary);
        font-weight: 700;
        font-size: 1.75rem;
        letter-spacing: -0.02em;
        margin: 0;
    }

    .dashboard-subtitle {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin-top: 0.25rem;
    }

    /* Section Label */
    .section-label {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--secondary);
        margin-bottom: 0.75rem;
    }

    /* Cards */
    .stat-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(9, 21, 64, 0.05);
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0;
    }

    /* Content Cards / Tables */
    .content-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        height: 100%;
    }

    .content-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1.25rem;
    }

    /* Custom Table */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th {
        background: #F8FAFC;
        color: var(--primary);
        font-weight: 600;
        font-size: 0.85rem;
        border-bottom: 2px solid var(--border-color);
        padding: 0.75rem 1rem;
        text-align: left;
    }

    .custom-table td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.9rem;
        color: var(--text-dark);
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Pagination Adjustment */
    .pagination {
        margin-top: 1rem;
        margin-bottom: 0;
    }

    .page-item.active .page-link {
        background-color: var(--secondary);
        border-color: var(--secondary);
    }

    .page-link {
        color: var(--secondary);
    }
</style>

<div class="container py-4">
    <div class="dashboard-header text-center">
        <h1 class="dashboard-title">Ringkasan Penjualan Yuuma GameShop
    
        </h1>
        <div class="dashboard-subtitle">
            {{ $tanggalHariIni->translatedFormat('l, d F Y') }}
        </div>
    </div>

    @can('viewAny', App\Models\User::class)
    <div class="mb-5">
        <div class="section-label">Performa Penjualan</div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-label">Total Nilai Penjualan</div>
                    <div class="stat-value">Rp {{ number_format($ringkasan['total_penjualan']) }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-label">Jumlah Transaksi</div>
                    <div class="stat-value">{{ number_format($ringkasan['total_transaksi']) }}</div>
                </div>
            </div>
        </div>

        <div class="section-label">Metode Pembayaran</div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-label">Pembayaran Tunai (Cash)</div>
                    <div class="stat-value">Rp {{ number_format($ringkasan['total_cash']) }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-label">Pembayaran Non-Tunai</div>
                    <div class="stat-value">Rp {{ number_format($ringkasan['total_non_tunai']) }}</div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <div class="mb-5">
        <div class="section-label">Status Inventaris</div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="content-card">
                    <div class="content-card-title">Stok Rendah</div>
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Nama Produk</th>
                                    <th style="width: 80px;" class="text-end">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkStokRendah as $index => $produk)
                                <tr>
                                    <td>{{ $produkStokRendah->firstItem() + $index }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td class="text-end fw-bold" style="color: var(--secondary);">{{ $produk->stok }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        Seluruh produk berada dalam kondisi stok aman
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $produkStokRendah->withQueryString()->links() }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="content-card">
                    <div class="content-card-title">Stok Habis</div>
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Nama Produk</th>
                                    <th style="width: 80px;" class="text-end">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkStokHabis as $index => $produk)
                                <tr>
                                    <td>{{ $produkStokHabis->firstItem() + $index }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td class="text-end fw-bold text-danger">{{ $produk->stok }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        Tidak ada produk yang habis
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $produkStokHabis->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="section-label">Performa Produk</div>
        <div class="content-card">
            <div class="content-card-title">Produk Terlaris</div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th style="width: 120px;" class="text-center">Sisa Stok</th>
                            <th style="width: 140px;" class="text-end">Unit Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produkTerlaris as $produk)
                        <tr>
                            <td class="fw-semibold">{{ $produk->nama }}</td>
                            <td class="text-center">{{ $produk->stok }}</td>
                            <td class="text-end fw-bold" style="color: var(--secondary);">{{ $produk->total_terjual }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">
                                Belum ada data penjualan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection