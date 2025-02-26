<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kategori')->insert([
            ['kategori_kode' => 'ELC', 'kategori_nama' => 'Elektronik'],
            ['kategori_kode' => 'FUR', 'kategori_nama' => 'Furniture'],
            ['kategori_kode' => 'FTW', 'kategori_nama' => 'Footwear'],
            ['kategori_kode' => 'CLT', 'kategori_nama' => 'Clothing'],
            ['kategori_kode' => 'FOD', 'kategori_nama' => 'Food & Beverage'],
        ]);
    }
}
