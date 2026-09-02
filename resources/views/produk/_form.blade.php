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

    /* Form Card Container */
    .form-container-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        max-width: 800px;
        margin: 0 auto;
    }

    /* Form Label Styling */
    .custom-form-label {
        font-weight: 600;
        font-size: 0.875rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    /* Inputs Focus & Styling */
    .form-control-custom {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        padding: 0.6rem 0.9rem;
        font-size: 0.9rem;
        color: var(--text-dark);
        transition: all 0.2s ease;
    }

    .form-control-custom:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(118, 146, 255, 0.15);
    }

    /* Image Preview Container */
    .image-preview-box {
        border: 2px dashed var(--border-color);
        border-radius: 10px;
        padding: 0.75rem;
        text-align: center;
        background-color: #F8FAFC;
        min-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .preview-img-render {
        max-width: 100%;
        max-height: 120px;
        border-radius: 6px;
        object-fit: cover;
    }

    /* Action Buttons */
    .btn-save-custom {
        background-color: var(--secondary);
        color: #ffffff;
        border: none;
        font-weight: 500;
        padding: 0.625rem 1.5rem;
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
        padding: 0.625rem 1.25rem;
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
    @csrf

    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: var(--primary);">
            {{ isset($produk) ? 'Edit Data Produk' : 'Tambah Produk Baru' }}
        </h4>

    </div>

    <!-- Section Foto Produk -->
    <div class="mb-4">
        <label class="form-label custom-form-label">Gambar Produk</label>
        <div class="row g-3 align-items-center">
            @if (!empty($produk->foto))
            <div class="col-auto text-center">
                <div class="text-muted small mb-1">Foto Saat Ini</div>
                <img src="{{ asset('storage/' . $produk->foto) }}" class="rounded border" width="100" height="100" style="object-fit: cover;">
            </div>
            @endif

            <div class="col">
                <input type="file" name="foto" onchange="previewImage(this)" class="form-control form-control-custom @error('foto') is-invalid @enderror" accept="image/*">
                @error('foto')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <div class="form-text text-muted small mt-1">Format: JPG, PNG, WEBP (Maks. 2MB)</div>
            </div>

            <div class="col-md-4" id="previewContainer" style="display: none;">
                <div class="image-preview-box">
                    <img id="preview" class="preview-img-render" alt="Preview Gambar">
                </div>
            </div>
        </div>
    </div>

    <!-- Nama Produk -->
    <div class="mb-3">
        <label class="form-label custom-form-label">Nama Produk</label>
        <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror" value="{{ old('name', $produk->nama ?? '') }}" placeholder="Contoh: Kopi Susu Aren">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Baris Harga (Beli & Jual) -->
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label custom-form-label">Harga Beli (Rp)</label>
            <input type="number" name="purchase_price" class="form-control form-control-custom @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price', $produk->harga_beli ?? '') }}" placeholder="0">
            @error('purchase_price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label custom-form-label">Harga Jual (Rp)</label>
            <input type="number" name="selling_price" class="form-control form-control-custom @error('selling_price') is-invalid @enderror" value="{{ old('selling_price', $produk->harga_jual ?? '') }}" placeholder="0">
            @error('selling_price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Stok Produk -->
    <div class="mb-4">
        <label class="form-label custom-form-label">Jumlah Stok</label>
        <input type="number" name="stock" class="form-control form-control-custom @error('stock') is-invalid @enderror" value="{{ old('stock', $produk->stok ?? '') }}" placeholder="0">
        @error('stock')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Tombol Aksi -->
    <div class="d-flex align-items-center gap-2 pt-2">
        <button class="btn btn-save-custom" type="submit">Simpan Produk</button>
        <a href="{{ route('produk.index') }}" class="btn btn-cancel-custom">Batal</a>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const container = document.getElementById('previewContainer');
        const file = input.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }
</script>