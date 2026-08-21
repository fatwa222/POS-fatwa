<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Role</label>
    <select name="role_id" class="form-select @error('role_id') is-invalid @enderror">
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

<!-- INPUT FOTO PROFIL TAMBAHAN DI SINI -->
<div class="mb-3">
    <label class="form-label">Foto Profil</label>
    @if(isset($user) && $user->avatar)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
        </div>
    @endif
    <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
    @error('avatar')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button class="btn btn-success">Simpan</button>
<a href="{{ route('admin.users') }}" class="btn btn-secondary">Kembali</a>