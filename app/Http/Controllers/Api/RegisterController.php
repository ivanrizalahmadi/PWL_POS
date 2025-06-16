<?php

namespace App\Http\Controllers\Api;

use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
   public function __invoke(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username' => 'required',
        'nama' => 'required',
        'password' => 'required|min:5|confirmed',
        'level_id' => 'required',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $avatarPath = null;

    if ($request->hasFile('avatar')) {
        $avatar = $request->file('avatar');
        $avatar->store('public/avatars'); // simpan ke storage/app/public/avatars
        $avatarPath = $avatar->hashName(); // hanya ambil nama filenya
    }

    // Create User
    $user = UserModel::create([
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => Hash::make($request->password),
        'level_id' => $request->level_id,
        'avatar' => $avatarPath
    ]);

    if ($user) {
        return response()->json([
            'success' => true,
            'user' => $user
        ], 201);
    }

    return response()->json([
        'success' => false,
    ], 409);
}

}