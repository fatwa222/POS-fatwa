@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Produk</h5>
                    <a href="{{ route('produk.index') }}" class="btn btn-light btn-sm">Kembali</a>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom Foto Produk -->
                        <div class="col-md-4 text-center mb-3">
                            @if (!empty($produk->foto))
                                <img src="{{ asset('storage/' . $produk->foto) }}" 
                                     alt="{{ $produk->nama }}" 
                                     class="img-fluid rounded img-thumbnail"
                                     style="max-height: 250px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded border" style="height: 200px;">
                                    <span class="text-muted">Tidak ada foto</span>
                                </div>
                            @endif
                        </div>

                        <!-- Kolom Detail Data -->
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="35%">Nama Produk</th>
                                    <td width="5%">:</td>
                                    <td><strong>{{ $produk->nama }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Harga Beli</th>
                                    <td>:</td>
                                    <td>Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Jual</th>
                                    <td>:</td>
                                    <td><span class="badge bg-success">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</span></td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td>:</td>
                                    <td>
                                        <span class="badge {{ $produk->stok > 0 ? 'bg-info' : 'bg-danger' }}">
                                            {{ $produk->stok }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    @can('update', $produk)
                        <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning">
                            Edit Produk
                        </a>
                    @endcan
                </div>
            </div>

        </div>
    </div>
</div>
@endsection