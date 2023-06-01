<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KurirController extends Controller
{
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;

            return response()->json(['message' => 'Anda berhasil login', 'token' => $success['token']], 200);
        } else {
            return response()->json(['error' => 'Gagal login'], 401);
        }
    }

    public function createDataKurir(Request $request)
    {
        $inputs = $request->all();
        $inputs['password'] = bcrypt($inputs['password']);
        $kurir = User::create($inputs);
        $data = $kurir->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Data Kurir Berhasil ditambahkan.'
        ];

        return response()->json($response, 200);
    }

    public function getDataKurir()
    {
        $kurir = User::whereNotIn('name', ['fritzen faizal'])->get();

        $data = $kurir->toArray();

        $response = [
            'success' => true,
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    public function updateDataKurir($id, Request $request)
    {
        $input = $request->all();
        $kurir = User::findOrFail($id);

        $kurir->name = $input['name'];
        $kurir->email = $input['email'];
        $kurir->password = bcrypt($input['password']);
        $kurir->save();

        $data = $kurir->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Data Kurir berhasil diubah.'
        ];

        return response()->json($response, 200);
    }

    public function deleteDataKurir($id)
    {
        $kurir = User::findOrFail($id);

        $kurir->delete();

        $response = [
            'success' => true,
            'message' => 'Data Kurir berhasil dihapus.'
        ];

        return response()->json($response, 200);
    }
}
