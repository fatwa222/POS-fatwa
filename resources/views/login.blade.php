@extends('layouts.app')

@section('title', 'Login - Yuuma GameShop')

@section('favicon')
    <link rel="icon" type="image/png" href="{{ asset('Console.png') }}">
@endsection

@section('content')
<style>
  /* Background halaman full screen: Terang di kanan, gelap di kiri */
  body {
    background: radial-gradient(circle at top right, #1B2CC1 0%, #091540 55%, #050b21 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    margin: 0;
    padding: 1.5rem;
  }

  /* Container Split Screen */
  .login-wrapper {
    width: 100%;
    max-width: 950px;
    background: rgba(255, 255, 255, 0.97);
    border: 1px solid rgba(118, 146, 255, 0.3);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    overflow: hidden;
  }

  /* Sisi Kiri (Branding & Info) */
  .brand-section {
    background: linear-gradient(135deg, #091540 0%, #112260 100%);
    color: #ffffff;
    padding: 3rem 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
  }

  .brand-logo-wrapper {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(118, 146, 255, 0.3);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
  }

  .brand-logo {
    width: 48px;
    height: 48px;
    object-fit: contain;
  }

  .feature-list {
    list-style: none;
    padding: 0;
    margin-top: 1.5rem;
  }

  .feature-list li {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
  }

  .feature-icon {
    width: 22px;
    height: 22px;
    background: rgba(118, 146, 255, 0.2);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #7692FF;
    font-size: 12px;
    margin-right: 10px;
  }

  /* Sisi Kanan (Form Login) */
  .form-section {
    padding: 3rem 2.5rem;
    background-color: #ffffff;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .form-control-custom {
    border: 1.5px solid #dcdfe6;
    border-radius: 8px;
    padding: 0.7rem 0.9rem;
    transition: all 0.25s ease;
  }

  .form-control-custom:focus {
    border-color: #1B2CC1;
    box-shadow: 0 0 0 0.2rem rgba(27, 44, 193, 0.15);
  }

  .btn-login {
    background-color: #1B2CC1;
    border: none;
    color: #ffffff;
    font-weight: 600;
    padding: 0.75rem;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .btn-login:hover {
    background-color: #091540;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(9, 21, 64, 0.3);
  }
</style>

<div class="login-wrapper">
    <div class="row g-0">
        
        <!-- Sisi Kiri: Branding & Informasi -->
        <div class="col-lg-6 brand-section d-none d-lg-flex">
            <div>
                <div class="brand-logo-wrapper">
                    <img src="{{ asset('console.png') }}" alt="Logo" class="brand-logo">
                </div>
                
                <h2 class="fw-bold text-white mb-2">Yuuma GameShop</h2>
                
                
                <hr style="border-color: rgba(255,255,255,0.15);">

                <ul class="feature-list">
                    <li><span class="feature-icon">✓</span> Transaksi Cepat & Akurat</li>
                    <li><span class="feature-icon">✓</span> Manajemen Inventaris Produk Real-time</li>
                    <li><span class="feature-icon">✓</span> Laporan Penjualan Otomatis</li>
                </ul>
            </div>
            
            <div class="mt-auto pt-4 border-top border-white-10">
                <small class="text-white-50">&copy; {{ date('Y') }} Yuuma GameShop. All rights reserved.</small>
            </div>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="col-lg-6 col-md-12 form-section">
            <!-- Logo Mobile (Hanya muncul di layar kecil) -->
            <div class="text-center d-lg-none mb-4">
                <img src="{{ asset('mebius.png') }}" alt="Logo" width="50" class="mb-2">
                <h4 class="fw-bold text-dark mb-0">Yuuma GameShop</h4>
            </div>

            <div class="mb-4">
                <h3 class="fw-bold text-dark mb-1">Selamat Datang!</h3>
                <p class="text-muted small">Silakan masuk menggunakan akun kasir/admin Anda.</p>
            </div>

            <form action="{{ route('auth') }}" method="POST">
                @csrf 

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label fw-medium text-secondary small">Email Address</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="form-control form-control-custom @error('email') is-invalid @enderror" 
                           id="exampleInputEmail1" 
                           placeholder="nama@email.com" 
                           required autofocus>
                    @error('email')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label fw-medium text-secondary small">Password</label>
                    <input type="password" 
                           name="password" 
                           class="form-control form-control-custom @error('password') is-invalid @enderror" 
                           id="exampleInputPassword1" 
                           placeholder="••••••••" 
                           required>
                    @error('password')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-login w-100 mb-2">
                    Sign In
                </button>
            </form>
        </div>

    </div>
</div>
@endsection