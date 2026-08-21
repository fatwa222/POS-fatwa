<style>
  /* Styling Navbar Dasar */
  .custom-navbar {
    background-color: #091540 !important;
    box-shadow: 0 4px 20px rgba(9, 21, 64, 0.25);
    padding: 0.75rem 0;
  }

  /* User Profile Left (Brand) */
  .brand-profile {
    padding: 4px 14px 4px 5px;
    border-radius: 50px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(118, 146, 255, 0.2);
    transition: all 0.3s ease;
  }
  .brand-profile:hover {
    background: rgba(27, 44, 193, 0.3);
    border-color: #7692FF;
  }
  .avatar-img {
    border: 2px solid #7692FF;
  }

  /* Nav Links Tengah */
  .custom-nav-link {
    color: rgba(255, 255, 255, 0.75) !important;
    font-weight: 500;
    padding: 8px 18px !important;
    border-radius: 8px;
    transition: all 0.25s ease;
    margin: 0 3px;
  }
  .custom-nav-link:hover {
    color: #ffffff !important;
    background-color: rgba(118, 146, 255, 0.15);
  }
  .custom-nav-link.active {
    color: #ffffff !important;
    background-color: #1B2CC1 !important;
    box-shadow: 0 2px 10px rgba(27, 44, 193, 0.5);
  }

  /* Icon User Kanan */
  .icon-btn-profile {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    color: #ffffff !important;
    background-color: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(118, 146, 255, 0.25);
    transition: all 0.3s ease;
  }
  .icon-btn-profile:hover, 
  .icon-btn-profile.active {
    background-color: #1B2CC1;
    border-color: #7692FF;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(27, 44, 193, 0.4);
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
  <div class="container">

    <!-- Profil User di Ujung Kiri -->
    <a class="navbar-brand d-flex align-items-center brand-profile text-decoration-none" href="#">
      @if(Auth::user() && Auth::user()->avatar)
        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile" class="rounded-circle avatar-img me-2" width="38" height="38" style="object-fit: cover;">
      @else
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=1B2CC1&color=fff" alt="Profile" class="rounded-circle avatar-img me-2" width="38" height="38">
      @endif
      <span class="fw-semibold fs-6 text-white pe-1">{{ Auth::user()->name ?? 'Nama User' }}</span>
    </a>

    <!-- Toggle Mobile -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <!-- Navigasi Tengah -->
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link custom-nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-nav-link {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">Produk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-nav-link {{ Request::is('penjualan*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">Penjualan</a>
        </li>
      </ul>

      <!-- Ikon Profil di Ujung Kanan -->
      <div class="d-flex align-items-center ms-auto">
        <a class="icon-btn-profile {{ Request::is('profil*') ? 'active' : '' }}" href="{{ route('profil.index') }}" title="Halaman Profil">
          <i data-feather="user" style="width: 20px; height: 20px;"></i>
        </a>
      </div>

    </div>
  </div>
</nav>