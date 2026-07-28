<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirinkan nilai ke tittle untuk ditampilkan -->
@section('title', 'Dashboard')

<!-- batas awal isi konten -->
@section('content')

@include('layouts.navbar')

    <div class="text-center">
    <div class="row">
        <div class="col-md-12">
            <h1>Today's Sales</h1>
        </div>
        <div class="col-md-6">
            <h3>Total Nilai Penjualan Hari ini</h3>
        </div>
        <div class="col-md-6">
            <h3>Jumlah Transaksi Hari ini</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h1>Cash & Payment Status</h1>
        </div>
        <div class="col-md-6">
            <h3>Total pembayaran tunai</h3>
        </div>
        <div class="col-md-6">
            <h3>Total pembayaran non-tunai</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h1>Critical Inventory Status</h1>
        </div>
        <div class="col-md-6">
            <h3>Daftar produk stok rendah</h3>
        </div>
        <div class="col-md-6">
            <h3>Produk habis stok</h3>
        </div>
    </div>
</div>

<!-- batas akhir isi konten -->
@endsection