<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'supplier_id' => 1, 'barang_nama' => 'Laptop Asus', 'harga_beli' => 7000000, 'harga_jual' => 8000000],
            ['kategori_id' => 1, 'supplier_id' => 1, 'barang_nama' => 'Smartphone Samsung', 'harga_beli' => 5000000, 'harga_jual' => 6000000],
            ['kategori_id' => 2, 'supplier_id' => 1, 'barang_nama' => 'Meja Kayu', 'harga_beli' => 500000, 'harga_jual' => 700000],
            ['kategori_id' => 2, 'supplier_id' => 1, 'barang_nama' => 'Kursi Kantor', 'harga_beli' => 400000, 'harga_jual' => 600000],
            ['kategori_id' => 3, 'supplier_id' => 1, 'barang_nama' => 'Sepatu Adidas', 'harga_beli' => 600000, 'harga_jual' => 750000],

            ['kategori_id' => 3, 'supplier_id' => 2, 'barang_nama' => 'Sandal Eiger', 'harga_beli' => 200000, 'harga_jual' => 300000],
            ['kategori_id' => 4, 'supplier_id' => 2, 'barang_nama' => 'Jaket Jeans', 'harga_beli' => 350000, 'harga_jual' => 500000],
            ['kategori_id' => 4, 'supplier_id' => 2, 'barang_nama' => 'Kaos Polo', 'harga_beli' => 150000, 'harga_jual' => 250000],
            ['kategori_id' => 5, 'supplier_id' => 2, 'barang_nama' => 'Kopi Arabica', 'harga_beli' => 80000, 'harga_jual' => 120000],
            ['kategori_id' => 5, 'supplier_id' => 2, 'barang_nama' => 'Susu UHT', 'harga_beli' => 10000, 'harga_jual' => 15000],

            ['kategori_id' => 5, 'supplier_id' => 3, 'barang_nama' => 'Mie Instan', 'harga_beli' => 3000, 'harga_jual' => 5000],
            ['kategori_id' => 5, 'supplier_id' => 3, 'barang_nama' => 'Beras Premium 5kg', 'harga_beli' => 60000, 'harga_jual' => 75000],
            ['kategori_id' => 5, 'supplier_id' => 3, 'barang_nama' => 'Minyak Goreng 1L', 'harga_beli' => 20000, 'harga_jual' => 25000],
            ['kategori_id' => 1, 'supplier_id' => 3, 'barang_nama' => 'Headset Gaming', 'harga_beli' => 250000, 'harga_jual' => 350000],
            ['kategori_id' => 2, 'supplier_id' => 3, 'barang_nama' => 'Lemari Pakaian', 'harga_beli' => 1000000, 'harga_jual' => 1200000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
