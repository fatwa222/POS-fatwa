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

    /* Container Card */
    .form-container-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        max-width: 650px;
        margin: 0 auto;
    }

    /* Label Styling */
    .custom-form-label {
        font-weight: 600;
        font-size: 0.875rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    /* Input Custom Focus */
    .form-control-custom,
    .form-select-custom {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        padding: 0.6rem 0.9rem;
        font-size: 0.9rem;
        color: var(--text-dark);
        transition: all 0.2s ease;
    }

    .form-control-custom:focus,
    .form-select-custom:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(118, 146, 255, 0.15);
    }

    /* Avatar Preview Box */
    .avatar-preview-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .avatar-preview-img {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 8px rgba(9, 21, 64, 0.12);
    }

    /* Custom Buttons */
    .btn-save-custom {
        background-color: var(--secondary);
        color: #ffffff;
        border: none;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    .btn-save-custom:hover {
        background-color: var(--primary);
        color: #ffffff;
    }

    .btn-cancel-custom {
        background-color: #F1F5F9;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
        font-weight: 500;
        padding: 0.6rem 1.25rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-cancel-custom:hover {
        background-color: #E2E8F0;
        color: var(--text-dark);
    }
</style>

<div class="form-container-card">
    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: var(--primary);">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h4>
    </div>

    <!-- Foto Profil -->
    <div class="mb-4">
        <label class="form-label custom-form-label">Foto Profil</label>
        @if(isset($user) && $user->avatar)
        <div class="avatar-preview-wrapper">
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile" class="avatar-preview-img">
            <span class="text-muted small">Foto profil saat ini</span>
        </div>
        @endif
        <input type="file" name="avatar" class="form-control form-control-custom @error('avatar') is-invalid @enderror" accept="image/*">
        @error('avatar')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Nama -->
    <div class="mb-3">
        <label class="form-label custom-form-label">Nama Lengkap</label>
        <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" placeholder="Masukkan nama lengkap">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label class="form-label custom-form-label">Alamat Email</label>
        <input type="email" name="email" class="form-control form-control-custom @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" placeholder="nama@email.com">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label class="form-label custom-form-label">Password {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '' }}</label>
        <input type="password" name="password" class="form-control form-control-custom @error('password') is-invalid @enderror" placeholder="••••••••">
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Role -->
    <div class="mb-4">
        <label class="form-label custom-form-label">Role Akses</label>
        <select name="role_id" class="form-select form-select-custom @error('role_id') is-invalid @enderror">
            <option value="">-- Pilih Role --</option>
            @foreach($roles as $role)
            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                {{ ucfirst($role->name) }}
            </option>
            @endforeach
        </select>
        @error('role_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Tombol Aksi -->
    <div class="d-flex align-items-center gap-2 pt-2">
        <button type="submit" class="btn btn-save-custom">Simpan Data</button>
        <a href="{{ route('admin.users') }}" class="btn btn-cancel-custom">Batal</a>
    </div>
</div>