@extends('layouts.app')

<!-- Mengirimkan nilai ke title -->
@section('title', 'Profil Saya')

<!-- Batas awal isi konten -->
@section('content')

@include('layouts.navbar')

<style>
  /* Styling Halaman Profil */
  .profile-container {
    max-width: 650px;
  }
  
  .profile-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid rgba(118, 146, 255, 0.2);
    box-shadow: 0 10px 30px rgba(9, 21, 64, 0.08);
    overflow: hidden;
  }

  .profile-header {
    background: linear-gradient(135deg, #091540 0%, #1B2CC1 100%);
    height: 120px;
    position: relative;
  }

  .profile-avatar-wrapper {
    position: relative;
    margin-top: -60px;
    display: inline-block;
  }

  .profile-avatar {
    width: 110px;
    height: 110px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #ffffff;
    box-shadow: 0 4px 15px rgba(9, 21, 64, 0.15);
  }

  .badge-role {
    background-color: rgba(118, 146, 255, 0.15);
    color: #1B2CC1;
    border: 1px solid rgba(27, 44, 193, 0.3);
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 50px;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
  }

  .info-box {
    background-color: #f8faff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 16px;
  }

  .btn-logout {
    background-color: #dc3545;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
  }
  
  .btn-logout:hover {
    background-color: #bb2d3b;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    transform: translateY(-1px);
  }
</style>

<div class="container profile-container my-5">
  <div class="profile-card text-center">
    
    <!-- Banner Atas -->
    <div class="profile-header"></div>

    <!-- Foto Profil & Informasi User -->
    <div class="card-body px-4 pb-4">
      
      <!-- Foto Profil -->
      <div class="profile-avatar-wrapper mb-3">
        @if(Auth::user() && Auth::user()->avatar)
          <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile" class="profile-avatar">
        @else
          <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=1B2CC1&color=fff&size=128" alt="Profile" class="profile-avatar">
        @endif
      </div>

      <!-- Nama & Role -->
      <h3 class="fw-bold mb-1" style="color: #091540;">{{ Auth::user()->name ?? 'Nama User' }}</h3>
      <div class="mb-4">
        <span class="badge-role">
          {{ Auth::user()->role->name ?? 'User' }}
        </span>
      </div>

      <!-- Detail Informasi (Email & Role) -->
      <div class="row g-3 text-start mb-4">
        <div class="col-12">
          <div class="info-box d-flex align-items-center">
            <i data-feather="mail" class="me-3" style="color: #1B2CC1;"></i>
            <div>
              <small class="text-muted d-block fs-7">Alamat Email</small>
              <span class="fw-semibold text-dark">{{ Auth::user()->email ?? 'email@example.com' }}</span>
            </div>
          </div>
        </div>

        <!-- <div class="col-12">
          <div class="info-box d-flex align-items-center">
            <i data-feather="shield" class="me-3" style="color: #1B2CC1;"></i>
            <div>
              <small class="text-muted d-block fs-7">Akses Role</small>
              <span class="fw-semibold text-dark text-capitalize">{{ Auth::user()->role->name ?? 'User' }}</span>
            </div>
          </div>
        </div>
      </div> -->

      <!-- Tombol Logout -->
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger btn-logout d-inline-flex align-items-center">
          <i data-feather="log-out" class="me-2" style="width: 18px; height: 18px;"></i> Logout
        </button>
      </form>

    </div>
  </div>
</div>

@endsection