<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <!-- Judul Form -->
                <h2 class="text-center mb-4">Tambah User Baru</h2>

                <!-- Card Form -->
                <div class="card shadow-lg rounded-4 p-4">
                    <form action="{{ route('user.tambah_simpan') }}" method="POST">
                        @csrf

                        <!-- Input Username -->
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                        </div>

                        <!-- Input Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                        </div>

                        <!-- Input Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                        </div>

                        <!-- Pilih Level -->
                        <div class="mb-4">
                            <label class="form-label">Level Pengguna</label>
                            <select name="level_id" class="form-control">
                                @foreach ($level as $l)
                                <option value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Simpan -->
                        <button type="submit" class="btn btn-primary w-100">Simpan Data</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
