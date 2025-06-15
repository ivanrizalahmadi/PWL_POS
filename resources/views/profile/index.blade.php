@extends('layouts.template')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Profile Image -->
        <div class="card shadow-lg border-0">
            <div class="card-body text-center">
                <div class="position-relative mb-3">
                    <img src="{{ asset($user->avatar) }}" class="rounded-circle shadow-sm" alt="User profile picture" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <h4 class="text-primary font-weight-bold">{{ $user->nama }}</h4>
                <p class="text-muted mb-2"><i class="fas fa-user-shield mr-1"></i> {{ $user->level->level_nama }}</p>

                <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <div class="custom-file text-left mb-2">
                        <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
                        <label class="custom-file-label" for="avatar">Pilih avatar baru</label>
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary w-100 mt-2">Update Foto Profil</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Edit Profile -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="mb-0"><i class="fas fa-user-edit mr-2 text-primary"></i>Edit Profil Pengguna</h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="username"><i class="fas fa-user-tag mr-1"></i>Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            id="username" name="username" value="{{ old('username', $user->username) }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama"><i class="fas fa-signature mr-1"></i>Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                            id="nama" name="nama" value="{{ old('nama', $user->nama) }}">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="level"><i class="fas fa-user-lock mr-1"></i>Level Pengguna</label>
                        <input type="text" class="form-control" value="{{ $user->level->level_nama }}" disabled>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-3"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
