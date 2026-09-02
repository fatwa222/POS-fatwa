@extends('layouts.app')

@section('title', 'Daftar Produk')

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

  /* Header */
  .page-title {
    color: var(--primary);
    font-weight: 700;
    font-size: 1.5rem;
    letter-spacing: -0.02em;
    margin: 0;
  }

  /* Container Card */
  .table-container {
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
  }

  /* Button Primary Custom */
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

  /* Search Input Custom */
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

  /* Custom Table Styling */
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

  /* Thumbnail Styling */
  .product-thumb {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid var(--border-color);
  }

  .product-thumb-placeholder {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    background-color: #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 0.75rem;
    border: 1px dashed var(--border-color);
  }

  /* Stock Badges */
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
  <!-- Header Section -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Daftar Produk</h1>
    @can('create', App\Models\Produk::class)
    <a href="{{ route('produk.create') }}" class="btn btn-custom-primary">
      + Tambah Produk
    </a>
    @endcan
  </div>

  <!-- Main Container Card -->
  <div class="table-container">
    <!-- Search Filter -->
    <form action="{{ route('produk.index') }}" method="GET" class="mb-4">
      <div class="row">
        <div class="col-md-5 col-lg-4">
          <div class="input-group">
            <input
              type="text"
              name="search"
              value="{{ request('search') }}"
              class="form-control search-input"
              placeholder="Cari nama produk...">
            <button class="btn btn-search" type="submit">
              Cari
            </button>
          </div>
        </div>
      </div>
    </form>

    <!-- Table Produk -->
    <div class="table-responsive">
      <table class="custom-table">
        <thead>
          <tr>
            <th style="width: 50px;">No</th>
            <th style="width: 70px;">Foto</th>
            <th>Nama Produk</th>
            <th>Petugas</th>
            <th class="text-end">Harga Beli</th>
            <th class="text-end">Harga Jual</th>
            <th class="text-center">Stok</th>
            <th style="width: 200px;" class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($products as $product)
          <tr>
            <td class="text-muted">{{ $products->firstItem() + $loop->index }}</td>
            <td>
              @if ($product->foto)
              <img src="{{ asset('storage/'.$product->foto) }}" alt="{{ $product->nama }}" class="product-thumb">
              @else
              <div class="product-thumb-placeholder">No Img</div>
              @endif
            </td>
            <td class="fw-semibold" style="color: var(--primary);">{{ $product->nama }}</td>
            <td class="text-muted small">{{ $product->user?->name ?? 'Sistem' }}</td>
            <td class="text-end text-muted">Rp {{ number_format($product->harga_beli) }}</td>
            <td class="text-end fw-bold" style="color: var(--secondary);">Rp {{ number_format($product->harga_jual) }}</td>
            <td class="text-center">
              @if($product->stok <= 0)
                <span class="badge-stock-empty">Habis</span>
                @elseif($product->stok <= 5)
                  <span class="badge-stock-low">{{ $product->stok }}</span>
                  @else
                  <span class="badge-stock-safe">{{ $product->stok }}</span>
                  @endif
            </td>
            <td class="text-end">
              <div class="d-inline-flex gap-1">
                @can('view', $product)
                <a href="{{ route('produk.show', $product->id) }}" class="btn-action-view">
                  Detail
                </a>
                @endcan
                @can('update', $product)
                <a href="{{ route('produk.edit', $product) }}" class="btn-action-edit">
                  Edit
                </a>
                @endcan
                @can('delete', $product)
                <form action="{{ route('produk.destroy', $product) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button class="btn-action-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
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
              Data produk tidak ditemukan.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="d-flex justify-content-end mt-4">
      {{ $products->withQueryString()->links() }}
    </div>
    @endif
  </div>
</div>
@endsection