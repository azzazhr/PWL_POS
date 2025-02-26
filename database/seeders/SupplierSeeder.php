<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_kode' => 'SUP001', 
                'supplier_nama' => 'PT Sukses Makmur', 
                'supplier_alamat' => 'Jakarta'
            ],

            [
                'supplier_kode' => 'SUP002', 
                'supplier_nama' => 'CV Berkah Jaya', 
                'supplier_alamat' => 'Surabaya'
            ],

            [
                'supplier_kode' => 'SUP003', 
                'supplier_nama' => 'UD Maju Terus', 
                'supplier_alamat' => 'Bandung'
            ],
        ];

        DB::table('m_supplier')->insert($data);
    }
}
