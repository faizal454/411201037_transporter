<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Helpers\ArrayHelper;
use App\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengirimanController extends Controller
{
    public function createDataPengiriman(Request $request)
    {
        $input = $request->all();
        $arrayHelper = new ArrayHelper();
        
        $validator = Validator::make($input, [
            'noPengiriman' => 'required',
            'lokasiId' => 'required|exists:lokasi,id',
            'barangId' => 'required|exists:barang,id',
            'jumlahBarang' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $input = $arrayHelper->snakeCaseKey($input);
        $input['kurir_id'] = Auth::user()->id;
        $input['is_approval'] = false;
        
        $barang = Barang::find($input['barang_id']);
        
        if ($barang->stok_barang <= 0) {
            return response()->json(['message' => 'Stok habis'], 401);
        }

        $barang->update(['stok_barang' => $barang->stok_barang - $input['jumlah_barang']]);

        $input['harga_barang'] = $barang->harga_barang;
        $pengiriman = Pengiriman::create($input);

        $response = [
            'success' => true,
            'data' => ['id' => $pengiriman->id],
            'message' => 'Transaksi pengiriman telah dibuat'
        ];

        return response()->json($response, 200);
    }

    public function getDataPengiriman()
    {
        $data = Pengiriman::all();

        $barang = [];
        foreach ($data as $row) {
            $barang = [
                'id' => $row->id,
                'noPengiriman' => $row->no_pengiriman,
                'namaBarang' => $row->barang->nama_barang,
                'namaLokasi' => $row->lokasi->nama_lokasi,
                'namaKurir' => $row->kurir->name,
                'jumlahBarang' => $row->jumlah_barang,
                'harga' => $row->harga_barang,
                'tanggalPengiriman' => $row->tanggal,
                'statusPersetujuan' => ($row->is_approval == 1) ? 'Approved' : 'Pending approval'
            ];
        }

        $response = [
            'success' => true,
            'data' => $barang
        ];

        return response()->json($response, 200);
    }

    public function approval($id, Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'isApproval' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }
        
        $data = Pengiriman::findOrFail($id);
        $data->is_approval = $input['isApproval'];
        $data->save();

        $response = [
            'success' => true,
            'data' => ['nomorPengiriman' => $data->no_pengiriman],
            'message' => 'Berhasil merubah status'
        ];

        return response()->json($response, 200);
    }
}
