<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Data User</h1>

        <!-- Notifikasi Berhasil -->
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Tombol Tambah User -->
        <a href="{{ route('user.tambah') }}" class="btn btn-primary mb-3">+ Tambah User</a>

        <!-- Tabel Data User -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>ID Level</th>
                    <td>Kode Level</td>
                    <td>Nama Level</td>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->level_id }}</td>
                    <td>{{$user->level->level_kode}}</td>
                    <td>{{$user->level->level_nama}}</td>
                    <td>
                        <!-- Tombol Ubah -->
                        <a href="{{ route('user.ubah', $user->user_id) }}" class="btn btn-warning btn-sm">Ubah</a>

                        <!-- Tombol Hapus dengan SweetAlert -->
                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $user->user_id }}">Hapus</button>

                        <!-- Form Hapus untuk dikirim setelah SweetAlert dikonfirmasi -->
                        <form id="delete-form-{{ $user->user_id }}" action="{{ route('user.hapus', $user->user_id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- Script SweetAlert -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const form = document.getElementById(`delete-form-${userId}`);

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Form di-submit setelah konfirmasi
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
