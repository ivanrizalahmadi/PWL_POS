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
            'avatar' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $avatar = $request->avatar;

        // Create User
        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id,
            'avatar' => $avatar->hashName()
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