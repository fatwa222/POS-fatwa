@extends('layouts.app')

@section('title', 'Daftar Penjualan')

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
        margin: 0;
    }

    .table-container {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .btn-custom-primary {
        background-color: var(--secondary);
        color: #ffffff;
        border: none;
        font-weight: 500;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        transition: background-color 0.2s ease;
        text-decoration: none;
    }

    .btn-custom-primary:hover {
        background-color: var(--primary);
        color: #ffffff;
    }

    .search-input {
        border-radius: 8px 0 0 8px !important;
        border: 1px solid var(--border-color);
        padding: 0.55rem 1rem;
        font-size: 0.9rem;
    }

    .search-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(118, 146, 255, 0.15);
    }

    .btn-search {
        border-radius: 0 8px 8px 0 !important;
        border: 1px solid var(--border-color);
        border-left: none;
        background-color: #F8FAFC;
        color: var(--text-muted);
        font-weight: 500;
        padding: 0 1.25rem;
    }

    .btn-search:hover {
        background-color: #F1F5F9;
        color: var(--primary);
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .custom-table th {
        background: #F8FAFC;
        color: var(--primary);
        font-weight: 600;
        font-size: 0.85rem;
        border-bottom: 2px solid var(--border-color);
        padding: 0.85rem 1rem;
        text-align: left;
    }

    .custom-table td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.9rem;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    .avatar-img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }

    /* Status Badges */
    .badge-status-open {
        background-color: #FEF3C7;
        color: #92400E;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.75rem;
    }

    .badge-status-completed {
        background-color: #DCFCE7;
        color: #166534;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.75rem;
    }

    .badge-status-cancelled {
        background-color: #FEE2E2;
        color: #991B1B;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.75rem;
    }

    .btn-action-view {
        background-color: #E0E7FF;
        color: var(--secondary);
        border: none;
        font-weight: 500;
        font-size: 0.8rem;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-action-view:hover {
        background-color: #C7D2FE;
        color: var(--primary);
    }

    .btn-action-edit {
        background-color: #FEF3C7;
        color: #92400E;
        border: none;
        font-weight: 500;
        font-size: 0.8rem;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-action-edit:hover {
        background-color: #FDE68A;
        color: #78350F;
    }

    .btn-action-delete {
        background-color: #FEE2E2;
        color: #991B1B;
        border: none;
        font-weight: 500;
        font-size: 0.8rem;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-action-delete:hover {
        background-color: #FCA5A5;
        color: #7F1D1D;
    }
</style>

<div class="container py-4">
    @if(session('errors'))
    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
        {{ session('errors') }}
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Daftar Transaksi Penjualan</h1>
        <a href="{{ route('penjualan.create') }}" class="btn btn-custom-primary">
            + Transaksi Baru
        </a>
    </div>

    <div class="table-container">
        <form action="{{ route('penjualan.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-5 col-lg-4">
                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control search-input"
                            placeholder="Cari transaksi...">
                        <button class="btn btn-search" type="submit">
                            Cari
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Tanggal Transaksi</th>
                        <th style="width: 60px;">Foto Kasir</th>
                        <th>Nama Kasir</th>
                        <th class="text-end">Total Pembayaran</th>
                        <th class="text-center">Metode</th>
                        <th class="text-center">Status</th>
                        <th style="width: 180px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td class="text-muted">{{ $sales->firstItem() + $loop->index }}</td>
                        <td class="fw-medium">{{ $sale->created_at->translatedFormat('d M Y, H:i') }}</td>
                        <td>
                            @if ($sale->user && $sale->user->avatar)
                            <img src="{{ asset('storage/' . $sale->user->avatar) }}" alt="Avatar" class="avatar-img">
                            @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($sale->user->name ?? 'Kasir') }}&background=091540&color=fff" alt="Avatar" class="avatar-img">
                            @endif
                        </td>
                        <td class="fw-semibold" style="color: var(--primary);">{{ $sale->user->name ?? 'Sistem' }}</td>
                        <td class="text-end fw-bold" style="color: var(--secondary);">
                            Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-2 py-1 uppercase" style="font-size: 0.75rem;">
                                {{ $sale->metode_pembayaran }}
                            </span>
                        </td>
                        <td class="text-center">
                            @php
                            $status = strtoupper($sale->status);
                            @endphp

                            @if(in_array($status, ['PAID', 'COMPLETE', 'COMPLETED', 'SELESAI', 'CLOSED']))
                            <span class="badge-status-completed">{{ $status }}</span>
                            @elseif(in_array($status, ['CANCEL', 'CANCELLED', 'BATAL']))
                            <span class="badge-status-cancelled">{{ $status }}</span>
                            @else
                            <span class="badge-status-open">{{ $status }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('penjualan.show', $sale->id) }}" class="btn-action-view">
                                    Detail
                                </a>

                                @can('view', $sale)
                                @if(strtoupper($sale->status) === 'OPEN')
                                <a href="{{ route('penjualan.edit', $sale) }}" class="btn-action-edit">
                                    Edit
                                </a>
                                @endif
                                @endcan

                                @can('delete', $sale)
                                <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini?')">
                                        Hapus
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            Data transaksi penjualan tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sales->hasPages())
        <div class="d-flex justify-content-end mt-4">
            {{ $sales->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection