<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <!-- Judul Form -->
                <h2 class="text-center mb-4">Edit Data User</h2>

                <!-- Card Form -->
                <div class="card p-4 shadow-lg rounded-4">
                    <form action="{{ route('user.ubah_simpan', $data->user_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Input Username -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $data->username }}" required>
                        </div>

                        <!-- Input Nama -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" required>
                        </div>

                        <!-- Input Password -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password (Opsional)</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah">
                        </div>

                        <!-- Pilih Level -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Level Pengguna</label>
                            <select name="level_id" class="form-control">
                                @foreach ($level as $l)
                                <option value="{{ $l->level_id }}" {{ $data->level_id == $l->level_id ? 'selected' : '' }}>
                                    {{ $l->level_nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Simpan -->
                        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
