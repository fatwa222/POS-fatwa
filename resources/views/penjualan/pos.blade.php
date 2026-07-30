@extends('layouts.app')

@section('title', 'Halaman POS')

@section('content')

@include('layouts.navbar')

<h1>Halaman POS</h1>

<div class="row">
   <div class="col-md-7">
    <div class="card">
        <div class="card-body" style="max-height:70vh; overflow:auto">

            <form method="GET" action="{{ route('penjualan.create') }}" class="mb-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Cari produk..."
                       onkeyup="this.form.submit()">
            </form>

            @foreach($produk as $item)
<div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
    <div>
        <div class="fw-semibold text-primary">{{ $item->nama }}</div>
        <small class="text-muted">{{ number_format($item->harga_jual) }}</small>
    </div>
    <form method="POST" action="{{ route('item-penjualan.store') }}" class="d-flex align-items-center gap-2">
        @csrf
        <input type="hidden" name="penjualan_id" value="{{ $sale->id }}">
        <input type="hidden" name="produk_id" value="{{ $item->id }}">
        <input type="number" name="kuantitas" value="1" min="1"
               class="form-control form-control-sm" style="width:60px">
        <button class="btn btn-primary btn-sm">+</button>
    </form>
</div>
@endforeach

        </div>
    </div>
</div>
    <div class="col-md-5">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Keranjang</h5>

            <table class="table table-sm">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sale->itemPenjualan as $item)
        <tr>
            <td>{{ $item->produk->nama }}</td>
            <td>Rp.{{ number_format($item->harga_satuan) }}</td>
            <td style="width:70px">
                <form method="POST" action="{{ route('item-penjualan.update', $item->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="number" name="kuantitas" value="{{ $item->kuantitas }}"
                           min="1" class="form-control form-control-sm"
                           onchange="this.form.submit()">
                </form>
            </td>
            <td>Rp.{{ number_format($item->subtotal) }}</td>
            <td>
                <form method="POST" action="{{ route('item-penjualan.destroy', $item->id) }}"
                      onsubmit="return confirm('Hapus barang ini dari keranjang?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">Keranjang masih kosong</td></tr>
        @endforelse
    </tbody>
</table>
            <form method="POST" action="{{ route('penjualan.destroy', $sale->id) }}"
      onsubmit="return confirm('Yakin batalkan transaksi ini? Semua item di keranjang akan dihapus.')" class="mb-3">
    @csrf
    @method('DELETE')
</form>
        <h5 class="text-end">Total : Rp{{ number_format($sale->total_pembayaran) }}</h5>

<form method="POST" action="{{ route('penjualan.update', $sale->id) }}" class="mt-3">
    @csrf
    @method('PUT')
    <div class="mb-2">
        <select name="metode_pembayaran" class="form-select" required>
            <option value="">-- Pilih Pembayaran --</option>
            <option value="CASH">Cash</option>
            <option value="QRIS">QRIS</option>
            <option value="TRANSFER">Transfer</option>
        </select>
    </div>
    <button class="btn btn-success w-100" {{ $sale->itemPenjualan->isEmpty() ? 'disabled' : '' }}>
        Checkout
    </button>
</form>

<form method="POST" action="{{ route('penjualan.destroy', $sale->id) }}"
      onsubmit="return confirm('Yakin batalkan transaksi ini? Semua item di keranjang akan dihapus.')" class="mt-2">
    @csrf
    @method('DELETE')
    <button class="btn btn-outline-danger w-100">Batal Transaksi</button>
</form>


        </div>
    </div>
</div>
</div>

@endsection