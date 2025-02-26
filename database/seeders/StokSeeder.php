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
        $barangIds = DB::table('m_barang')->pluck('barang_id')->toArray(); 

        if (empty($barangIds)) {
            return; // Jangan insert jika tidak ada barang
        }

        $data = [];

        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'barang_id' => $barangIds[array_rand($barangIds)],
                'user_id' => rand(1, 3),
                'supplier_id' => rand(1, 3),
                'stok_jumlah' => rand(10, 100),
                'stok_tanggal' => Carbon::now(),
            ];
        }
        DB::table('t_stok')->insert($data);
    }
}
