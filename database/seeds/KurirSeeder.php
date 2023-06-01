<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KurirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();
        DB::table('users')->insert([
            'email' => 'fritzenfaizal66@gmail.com',
            'name' => 'fritzen faizal',
            'password' => bcrypt('faisal123'),
            'created_at' => $dateNow,
            'updated_at' => $dateNow
        ]);
    }
}
