<?php

namespace App\Http\Controllers;

use App\Helpers\ArrayHelper;
use App\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LokasiController extends Controller
{
    public function createDataLokasi(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'namaLokasi' => 'required',
            'kodeLokasi' => 'required'
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

        $lokasi = Lokasi::create($inputs);
        $data = $lokasi->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Data Lokasi Berhasil ditambahkan.'
        ];

        return response()->json($response, 200);
    }

    public function getDataLokasi()
    {
        $lokasi = Lokasi::all();

        $data = $lokasi->toArray();

        $response = [
            'success' => true,
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    public function updateDataLokasi($id, Request $request)
    {
        $input = $request->all();
        $lokasi = Lokasi::findOrFail($id);

        $validator = Validator::make($input, [
            'namaLokasi' => 'required',
            'kodeLokasi' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $lokasi->nama_lokasi = $input['namaLokasi'];
        $lokasi->kode_lokasi = $input['kodeLokasi'];
        $lokasi->save();

        $data = $lokasi->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Data Lokasi berhasil diubah.'
        ];

        return response()->json($response, 200);
    }

    public function deleteDataLokasi($id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $lokasi->delete();

        $response = [
            'success' => true,
            'message' => 'Data Lokasi berhasil dihapus.'
        ];

        return response()->json($response, 200);
    }
}
