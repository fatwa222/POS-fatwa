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

    .form-container-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        max-width: 600px;
        margin: 0 auto;
    }

    .custom-form-label {
        font-weight: 600;
        font-size: 0.875rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .form-control-custom {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        padding: 0.6rem 0.9rem;
        font-size: 0.9rem;
        color: var(--text-dark);
    }

    .btn-save-custom {
        background-color: var(--secondary);
        color: #ffffff;
        border: none;
        font-weight: 500;
        padding: 0.625rem 1.5rem;
        border-radius: 8px;
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
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        text-decoration: none;
    }
</style>

<div class="container py-4">
<div class="form-container-card">
    @csrf

    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: var(--primary);">
            {{ isset($jenis) ? 'Edit Jenis Produk' : 'Tambah Jenis Produk' }}
        </h4>
    </div>

    <div class="mb-4">
        <label class="form-label custom-form-label">Nama Jenis</label>
        <input type="text" name="nama" class="form-control form-control-custom @error('nama') is-invalid @enderror" value="{{ old('nama', $jenis->nama ?? '') }}" placeholder="Contoh: Elektronik">
        @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-2 pt-2">
        <button class="btn btn-save-custom" type="submit">Simpan</button>
        <a href="{{ route('jenis.index') }}" class="btn btn-cancel-custom">Batal</a>
    </div>
</div>
</div>