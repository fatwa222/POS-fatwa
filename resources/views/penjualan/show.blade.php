@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')

@include('layouts.navbar')

<h1 class="mb-3">Detail Penjualan #{{ $sale->id }}</h1>

<a href="{{ route('penjualan.index') }}" class="btn btn-secondary mb-3">Kembali</a>

<table class="table table-bordered w-auto mb-4">
    <tr>
        <th>Kasir</th>
        <td>{{ $sale->user->name }}</td>
    </tr>
    <tr>
        <th>Tanggal Transaksi</th>
        <td>{{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</td>
    </tr>
    <tr>
        <th>Metode Pembayaran</th>
        <td>{{ $sale->metode_pembayaran }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ $sale->status }}</td>
    </tr>
    <tr>
        <th>Total Pembayaran</th>
        <td>Rp {{ number_format($sale->total_pembayaran) }}</td>
    </tr>
</table>

<h4 class="mb-3">Daftar Barang</h4>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Produk</th>
            <th>Harga Satuan</th>
            <th>Kuantitas</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sale->itemPenjualan as $item)
        <tr>
            <th>{{ $loop->iteration }}</th>
            <td>{{ $item->produk->nama }}</td>
            <td>Rp {{ number_format($item->harga_satuan) }}</td>
            <td>{{ $item->kuantitas }}</td>
            <td>Rp {{ number_format($item->subtotal) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5">Tidak ada barang</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection