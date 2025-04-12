<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Menampilkan halaman awal user
  // Menampilkan halaman awal user
public function index()
{
    $breadcrumb = (object) [
        'title' => 'Daftar User',
        'list'  => ['Home', 'User']
    ];

    $page = (object) [
        'title' => 'Daftar user yang terdaftar dalam sistem'
    ];

    $activeMenu = 'user'; // set menu yang sedang aktif

    $level = LevelModel::all(); // ambil data level untuk filter level

    return view('user.index', [
        'breadcrumb'   => $breadcrumb,
        'page'         => $page,
        'level'        => $level,
        'activeMenu'   => $activeMenu
    ]);
}

    // Ambil data user dalam bentuk JSON untuk DataTables
public function list(Request $request)
{
    $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
        ->with('level'); // relasi ke tabel level

    // filter data user berdasarkan level_id
    if ($request->level_id) {
        $users->where('level_id', $request->level_id);
    }
        
    return DataTables::of($users)
        ->addIndexColumn() // menambahkan kolom nomor urut (DT_RowIndex)
        ->addColumn('aksi', function ($user) {
            $btn  = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                 . csrf_field() . method_field('DELETE') . '
                 <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button>
                 </form>';

            return $btn;
        })
        ->rawColumns(['aksi']) // memberi tahu bahwa kolom 'aksi' berisi HTML
        ->make(true);
}

// Menampilkan halaman form tambah user
public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah User',
        'list' => ['Home', 'User', 'Tambah']
    ];

    $page = (object) [
        'title' => 'Tambah user baru'
    ];

    $level = LevelModel::all(); // Ambil semua data level
    $activeMenu = 'user'; // Set menu yang sedang aktif

    return view('user.create', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'level' => $level,
        'activeMenu' => $activeMenu
    ]);
}

// Menyimpan data user baru
public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'username' => 'required|string|min:3|unique:m_user,username',
        'nama'     => 'required|string|max:100',
        'password' => 'required|min:5',
        'level_id' => 'required|integer',
    ]);

    // Simpan data ke database
    UserModel::create([
        'username'  => $request->username,
        'nama'      => $request->nama,
        'password'  => bcrypt($request->password), // enkripsi password
        'level_id'  => $request->level_id,
    ]);

    // Redirect dengan pesan sukses
    return redirect('/user')->with('success', 'Data user berhasil disimpan');
}

// Menampilkan detail user
public function show(string $id)
{
    $user = UserModel::with('level')->find($id);

    $breadcrumb = (object) [
        'title' => 'Detail User',
        'list' => ['Home', 'User', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail user'
    ];

    $activeMenu = 'user';

    return view('user.show', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'user' => $user, // bisa null kalau tidak ditemukan
        'activeMenu' => $activeMenu
    ]);
}
// Menampilkan halaman form edit user
public function edit(string $id)
{
    $user = UserModel::find($id); // Ambil data user berdasarkan ID
    $level = LevelModel::all();   // Ambil semua data level

    $breadcrumb = (object) [
        'title' => 'Edit User',
        'list'  => ['Home', 'User', 'Edit']
    ];

    $page = (object) [
        'title' => 'Edit user'
    ];

    $activeMenu = 'user'; // Set menu yang sedang aktif

    return view('user.edit', [
        'breadcrumb'  => $breadcrumb,
        'page'        => $page,
        'user'        => $user,
        'level'       => $level,
        'activeMenu'  => $activeMenu
    ]);
}
// Menyimpan perubahan data user
public function update(Request $request, string $id)
{
    // Validasi input
    $request->validate([
        'username'  => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
        'nama'      => 'required|string|max:100',
        'password'  => 'nullable|min:5', // boleh kosong, tapi kalau diisi minimal 5 karakter
        'level_id'  => 'required|integer'
    ]);

    // Ambil user berdasarkan ID
    $user = UserModel::find($id);

    // Update data user
    $user->update([
        'username' => $request->username,
        'nama'     => $request->nama,
        'password' => $request->password ? bcrypt($request->password) : $user->password,
        'level_id' => $request->level_id
    ]);

    // Redirect ke halaman user dengan pesan sukses
    return redirect('/user')->with('success', 'Data user berhasil diubah');
}

// Menghapus data user
public function destroy(string $id)
{
    // Cek apakah data user dengan ID tersebut ada
    $user = UserModel::find($id);
    if (!$user) {
        return redirect('/user')->with('error', 'Data user tidak ditemukan');
    }

    try {
        // Hapus data user
        UserModel::destroy($id);
        return redirect('/user')->with('success', 'Data user berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        // Jika gagal menghapus karena ada relasi di tabel lain
        return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terkait dengan data lain di sistem.');
    }
}
public function create_ajax()
{
    $level = LevelModel::select('level_id', 'level_nama')->get();

    return view('user.create_ajax',)
    ->with('level', $level);
}

public function store_ajax(Request $request)
{
    // Cek apakah request berupa AJAX atau JSON
    if ($request->ajax() || $request->wantsJson()) {

        // Aturan validasi
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:6'
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules);

        // Jika validasi gagal, kembalikan response dengan pesan error
        if ($validator->fails()) {
            return response()->json([
                'status' => false, // response status: false berarti gagal
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(), // pesan error validasi
            ]);
        }

        // Menyimpan data user baru
        UserModel::create($request->all());

        // Mengirim response sukses setelah data disimpan
        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan'
        ]);
    }

    // Jika bukan request AJAX atau JSON, redirect ke halaman utama
     redirect('/');
}




}
