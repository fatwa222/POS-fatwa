@extends('layouts.app')

@section('title', 'Manajemen Users')

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

    /* Role Badge Custom */
    .badge-role-admin {
        background-color: rgba(27, 44, 193, 0.1);
        color: var(--secondary);
        font-weight: 600;
        padding: 0.35em 0.75em;
        border-radius: 6px;
        font-size: 0.78rem;
        text-transform: capitalize;
    }

    .badge-role-kasir {
        background-color: #F1F5F9;
        color: var(--text-muted);
        font-weight: 600;
        padding: 0.35em 0.75em;
        border-radius: 6px;
        font-size: 0.78rem;
        text-transform: capitalize;
    }

    /* Action Buttons Custom */
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

    /* Avatar Soft Shadow & Border */
    .user-avatar {
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
    }
</style>

<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Pengguna Sistem</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-custom-primary">
            + Tambah User
        </a>
    </div>

    <!-- Main Container -->
    <div class="table-container">
        <!-- Search Filter -->
        <form action="{{ route('admin.users') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-5 col-lg-4">
                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control search-input"
                            placeholder="Cari nama atau email...">
                        <button class="btn btn-search" type="submit">
                            Cari
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Table Users -->
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 70px;">Profil</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 170px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted">{{ $users->firstItem() + $loop->index }}</td>
                        <td>
                            @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}"
                                alt="Avatar"
                                class="rounded-circle user-avatar"
                                width="38"
                                height="38"
                                style="object-fit: cover;">
                            @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=091540&color=ffffff"
                                alt="Avatar"
                                class="rounded-circle user-avatar"
                                width="38"
                                height="38">
                            @endif
                        </td>
                        <td class="fw-semibold" style="color: var(--primary);">{{ $user->name }}</td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="{{ $user->role->name === 'admin' ? 'badge-role-admin' : 'badge-role-kasir' }}">
                                {{ $user->role->name }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-action-edit">
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action-delete" onclick="return confirm('Yakin hapus user ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Data pengguna tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="d-flex justify-content-end mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

@endsection