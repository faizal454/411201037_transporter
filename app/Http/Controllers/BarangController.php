<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Helpers\ArrayHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function createDataBarang(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'namaBarang' => 'required',
            'kodeBarang' => 'required',
            'stokBarang' => 'required',
            'hargaBarang' => 'required',
            'deskripsi' => 'nullable'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $arrayHelper = new ArrayHelper();
        $inputs = $arrayHelper->snakeCaseKey($inputs);

        $barang = Barang::create($inputs);
        $data = $barang->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Data Barang Berhasil ditambahkan.'
        ];

        return response()->json($response, 200);
    }

    public function getDataBarang()
    {
        $barang = Barang::all();

        $data = $barang->toArray();

        $response = [
            'success' => true,
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    public function updateDataBarang($id, Request $request)
    {
        $input = $request->all();
        $barang = Barang::findOrFail($id);

        $validator = Validator::make($input, [
            'namaBarang' => 'required',
            'kodeBarang' => 'required',
            'stokBarang' => 'required',
            'hargaBarang' => 'required',
            'deskripsi' => 'nullable'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $barang->kode_barang = $input['kodeBarang'];
        $barang->nama_barang = $input['namaBarang'];
        $barang->deskripsi = $input['deskripsi'];
        $barang->stok_barang = $input['stokBarang'];
        $barang->harga_barang = $input['hargaBarang'];
        $barang->save();

        $data = $barang->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Data Barang berhasil diubah.'
        ];

        return response()->json($response, 200);
    }

    public function deleteDataBarang($id)
    {
        $barang = Barang::findOrFail($id);

        $barang->delete();

        $response = [
            'success' => true,
            'message' => 'Data Barang berhasil dihapus.'
        ];

        return response()->json($response, 200);
    }
}
