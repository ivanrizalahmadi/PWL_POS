<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use App\Models\LevelModel;


    class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::with('level')->get();
        return view('user', ['data' => $user]);
    }

    public function tambah()
    {
        $level = LevelModel::all();
        return view('user_tambah', ['level' => $level]);
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect()->route('user.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();
        return view('user_ubah', ['data' => $user, 'level' => $level]);
    }

    public function ubah_simpan(Request $request, $id)
    {
        $user = UserModel::find($id);
        $user->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect()->route('user.index')->with('success', 'Data berhasil diubah');
    }

    public function hapus($id)
    {
        UserModel::find($id)->delete();
        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus');
    }
}
