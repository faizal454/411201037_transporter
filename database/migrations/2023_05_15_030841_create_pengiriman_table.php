<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengirimanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_pengiriman', 15);
            $table->date('tanggal');
            $table->integer('kurir_id')->nullable();
            $table->integer('lokasi_id')->nullable();
            $table->integer('barang_id')->nullable();
            $table->integer('harga_barang')->nullable();
            $table->integer('jumlah_barang');
            $table->boolean('is_approval')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengiriman');
    }
}
