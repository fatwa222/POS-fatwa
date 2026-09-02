@extends('layouts.app')

@section('title', 'Detail Produk - ' . $produk->nama)

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

    /* Card Container */
    .detail-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        max-width: 850px;
        margin: 0 auto;
    }

    /* Thumbnail Box */
    .product-image-box {
        background-color: #F8FAFC;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 220px;
    }

    .product-image-box img {
        max-height: 240px;
        width: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    /* Product Titles */
    .product-title {
        color: var(--primary);
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    /* Detail Table Custom */
    .table-detail-custom {
        width: 100%;
        margin-bottom: 0;
    }

    .table-detail-custom th {
        color: var(--text-muted);
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.6rem 0;
        width: 35%;
    }

    .table-detail-custom td {
        color: var(--text-dark);
        font-size: 0.95rem;
        padding: 0.6rem 0;
    }

    /* Badges */
    .badge-stock-safe {
        background-color: #DCFCE7;
        color: #166534;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.8rem;
    }

    .badge-stock-low {
        background-color: #FEF3C7;
        color: #92400E;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.8rem;
    }

    .badge-stock-empty {
        background-color: #FEE2E2;
        color: #991B1B;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.8rem;
    }

    /* Action Buttons */
    .btn-edit-custom {
        background-color: var(--secondary);
        color: #ffffff;
        border: none;
        font-weight: 500;
        padding: 0.55rem 1.25rem;
        border-radius: 8px;
        transition: background-color 0.2s ease;
        text-decoration: none;
    }

    .btn-edit-custom:hover {
        background-color: var(--primary);
        color: #ffffff;
    }

    .btn-back-custom {
        background-color: #F1F5F9;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
        font-weight: 500;
        padding: 0.55rem 1.25rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-back-custom:hover {
        background-color: #E2E8F0;
        color: var(--text-dark);
    }
</style>

<div class="container py-4">
    <div class="detail-card">
        <!-- Top Navigation / Title -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <div>
                <h4 class="product-title">{{ $produk->nama }}</h4>
                <span class="text-muted small">Ditambahkan oleh: <strong>{{ $produk->user?->name ?? 'Sistem' }}</strong></span>
            </div>
            <a href="{{ route('produk.index') }}" class="btn-back-custom">
                ← Kembali
            </a>
        </div>

        <div class="row g-4 align-items-center">
            <!-- Foto Produk -->
            <div class="col-md-5">
                <div class="product-image-box">
                    @if (!empty($produk->foto))
                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}">
                    @else
                    <div class="text-center text-muted py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-image text-secondary mb-2" viewBox="0 0 16 16">
                            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                            <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                        </svg>
                        <p class="mb-0 small">Foto tidak tersedia</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Detail Data Produk -->
            <div class="col-md-7">
                <table class="table-detail-custom">
                    <tbody>
                        <tr>
                            <th>Harga Beli</th>
                            <td>: <span class="text-muted">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</span></td>
                        </tr>
                        <tr>
                            <th>Harga Jual</th>
                            <td>: <strong class="fs-5" style="color: var(--secondary);">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <th>Margin Keuntungan</th>
                            <td>: <span class="text-success fw-medium">+Rp {{ number_format($produk->harga_jual - $produk->harga_beli, 0, ',', '.') }}</span></td>
                        </tr>
                        <tr>
                            <th>Sisa Stok</th>
                            <td>:
                                @if($produk->stok <= 0)
                                    <span class="badge-stock-empty">Stok Habis (0)</span>
                                    @elseif($produk->stok <= 5)
                                        <span class="badge-stock-low">{{ $produk->stok }} Unit (Menipis)</span>
                                        @else
                                        <span class="badge-stock-safe">{{ $produk->stok }} Unit</span>
                                        @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Action Button -->
                <div class="pt-4 border-top mt-3 d-flex gap-2">
                    @can('update', $produk)
                    <a href="{{ route('produk.edit', $produk->id) }}" class="btn-edit-custom">
                        Edit Produk Ini
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection