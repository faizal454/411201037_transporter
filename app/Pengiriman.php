<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    //
    protected $table = 'pengiriman';

    protected $fillable = [
        'no_pengiriman',
        'tanggal',
        'kurir_id',
        'barang_id',
        'lokasi_id',
        'harga_barang',
        'jumlah_barang',
        'is_approval'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function kurir()
    {
        return $this->belongsTo(User::class);
    }
}
