@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')

@include('layouts.navbar')

<style>
  /* Styling Card Utama sesuai Tema Navbar */
  .card-detail {
    background-color: #ffffff;
    border: 1px solid rgba(118, 146, 255, 0.25);
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(9, 21, 64, 0.08);
  }
  
  .card-header-custom {
    background-color: #091540;
    color: #ffffff;
    border-top-left-radius: 12px !important;
    border-top-right-radius: 12px !important;
    padding: 1.25rem;
  }

  /* Avatar Kasir */
  .kasir-avatar-lg {
    border: 3px solid #7692FF;
    box-shadow: 0 4px 12px rgba(27, 44, 193, 0.25);
  }

  /* Styling Tabel Informasi & Produk */
  .table-custom-info th {
    background-color: #f8f9fa;
    color: #091540;
    width: 35%;
  }

  .table-produk standard thead {
    background-color: #091540;
    color: #ffffff;
  }

  .badge-status-open {
    background-color: #ffc107;
    color: #000;
  }

  .badge-status-completed {
    background-color: #198754;
    color: #fff;
  }
</style>

<div class="container py-4">
    <!-- Tombol Kembali & Judul -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0" style="color: #091540;">Detail Penjualan #{{ $sale->id }}</h2>
        <a href="{{ route('penjualan.index') }}" class="btn text-white" style="background-color: #091540; border-radius: 8px;">
            <i data-feather="arrow-left" class="me-1" style="width: 18px;"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        <!-- Kartu Foto & Info Kasir (Di Tengah) -->
        <div class="col-md-4">
            <div class="card card-detail text-center h-100 p-4 d-flex flex-column align-items-center justify-content-center">
                <div class="mb-3">
                    @if ($sale->user && $sale->user->avatar)
                        <img src="{{ asset('storage/' . $sale->user->avatar) }}" 
                             alt="Avatar {{ $sale->user->name }}" 
                             class="rounded-circle kasir-avatar-lg" 
                             width="110" 
                             height="110" 
                             style="object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($sale->user->name ?? 'Kasir') }}&background=1B2CC1&color=fff&size=128" 
                             alt="Avatar {{ $sale->user->name ?? 'Kasir' }}" 
                             class="rounded-circle kasir-avatar-lg" 
                             width="110" 
                             height="110" 
                             style="object-fit: cover;">
                    @endif
                </div>
                <h5 class="fw-bold mb-1" style="color: #091540;">{{ $sale->user->name ?? 'Kasir Tidak Ditemukan' }}</h5>
                <span class="badge bg-secondary mb-2" style="font-weight: 500;">Kasir Penanggung Jawab</span>
                <p class="text-muted small mb-0">{{ $sale->user->email ?? '' }}</p>
            </div>
        </div>

        <!-- Kartu Metadata Transaksi -->
        <div class="col-md-8">
            <div class="card card-detail h-100">
                <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold"><i data-feather="file-text" class="me-2"></i>Informasi Transaksi</h5>
                    <span class="badge {{ $sale->status === 'COMPLETED' ? 'badge-status-completed' : 'badge-status-open' }} px-3 py-2">
                        {{ $sale->status }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-custom-info mb-0 align-middle">
                        <tbody>
                            <tr>
                                <th class="ps-3"><i data-feather="calendar" class="me-2 text-primary" style="width: 16px;"></i>Tanggal Transaksi</th>
                                <td>{{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th class="ps-3"><i data-feather="credit-card" class="me-2 text-primary" style="width: 16px;"></i>Metode Pembayaran</th>
                                <td><span class="fw-medium text-uppercase">{{ $sale->metode_pembayaran }}</span></td>
                            </tr>
                            <tr>
                                <th class="ps-3"><i data-feather="dollar-sign" class="me-2 text-primary" style="width: 16px;"></i>Total Pembayaran</th>
                                <td class="fw-bold fs-5" style="color: #1B2CC1;">Rp {{ number_format($sale->total_pembayaran) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Barang -->
    <div class="card card-detail mt-4">
        <div class="card-header card-header-custom">
            <h5 class="mb-0 fw-semibold"><i data-feather="shopping-bag" class="me-2"></i>Daftar Barang</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #091540; color: #ffffff;">
                        <tr>
                            <th class="ps-3">No</th>
                            <th>Produk</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-center">Kuantitas</th>
                            <th class="text-end pe-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sale->itemPenjualan as $item)
                        <tr>
                            <th class="ps-3">{{ $loop->iteration }}</th>
                            <td class="fw-medium" style="color: #091540;">{{ $item->produk->nama }}</td>
                            <td class="text-end">Rp {{ number_format($item->harga_satuan) }}</td>
                            <td class="text-center"><span class="badge bg-light text-dark border px-3 py-1">{{ $item->kuantitas }}</span></td>
                            <td class="text-end pe-3 fw-bold" style="color: #1B2CC1;">Rp {{ number_format($item->subtotal) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Tidak ada barang dalam transaksi ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection