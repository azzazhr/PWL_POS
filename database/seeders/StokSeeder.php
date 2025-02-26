<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'barang_id' => $i,
                'user_id' => rand(1, 3),
                'stok_jumlah' => rand(10, 100),
                'stok_tanggal' => Carbon::now(),
            ];
        }

        DB::table('t_stok')->insert($data);
    }
}
