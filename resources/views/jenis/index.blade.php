@extends('layouts.app')

@section('title', 'Jenis Produk')

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
    color: #fff;
    border: none;
    font-weight: 500;
    padding: 0.55rem 1.1rem;
    border-radius: 8px;
    text-decoration: none;
  }

  .btn-custom-primary:hover {
    background-color: var(--primary);
    color: #fff;
  }
</style>

<div class="container py-4">
    <!-- @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
        {{ session('success') }}
    </div>
    @endif -->
    @if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
        {{ session('error') }}
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Jenis Produk</h1>
        <a href="{{ route('jenis.create') }}" class="btn btn-custom-primary">
            + Tambah Jenis
        </a>
    </div>

    <div class="table-container">
        <form method="GET" action="{{ route('jenis.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari jenis produk...">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Jenis</th>
                    <th class="text-center">Jumlah Produk</th>
                    <th style="width: 180px;" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jenis as $item)
                <tr>
                    <td class="text-muted">{{ $jenis->firstItem() + $loop->index }}</td>
                    <td class="fw-semibold" style="color: var(--primary);">{{ $item->nama }}</td>
                    <td class="text-center">{{ $item->produk_count ?? $item->produk()->count() }}</td>
                    <td class="text-end">
                        <a href="{{ route('jenis.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('jenis.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jenis ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">Belum ada data jenis produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $jenis->links() }}
    </div>
</div>
@endsection