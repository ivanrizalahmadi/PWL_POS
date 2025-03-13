<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder untuk m_kategori (5 data)
        $kategori = [
            ['kategori_id' => 1, 'kategori_kode' => 'ELK', 'kategori_nama' => 'Elektronik'],
            ['kategori_id' => 2, 'kategori_kode' => 'FNB', 'kategori_nama' => 'Makanan & Minuman'],
            ['kategori_id' => 3, 'kategori_kode' => 'FAS', 'kategori_nama' => 'Fashion'],
            ['kategori_id' => 4, 'kategori_kode' => 'BKS', 'kategori_nama' => 'Buku & Alat Tulis'],
            ['kategori_id' => 5, 'kategori_kode' => 'KOS', 'kategori_nama' => 'Kosmetik'],
        ];
        DB::table('m_kategori')->insert($kategori);

        // Seeder untuk m_supplier (3 data)
        $supplier = [
            ['supplier_id' => 1, 'supplier_kode' => 'SUP1', 'supplier_nama' => 'Supplier A', 'supplier_alamat' => 'Jakarta'],
            ['supplier_id' => 2, 'supplier_kode' => 'SUP2', 'supplier_nama' => 'Supplier B', 'supplier_alamat' => 'Surabaya'],
            ['supplier_id' => 3, 'supplier_kode' => 'SUP3', 'supplier_nama' => 'Supplier C', 'supplier_alamat' => 'Bandung'],
        ];
        DB::table('m_supplier')->insert($supplier);

        // Seeder untuk m_barang (15 barang, 5 barang per supplier)
        $barang = [];
        $barangId = 1;
        for ($i = 1; $i <= 3; $i++) { // 3 supplier
            for ($j = 1; $j <= 5; $j++) {
                $barang[] = [
                    'barang_id' => $barangId++,
                    'kategori_id' => rand(1, 5),
                    'barang_kode' => 'BRG' . $barangId,
                    'barang_nama' => 'Barang ' . $barangId,
                    'harga_beli' => rand(5000, 50000),
                    'harga_jual' => rand(6000, 60000),
                ];
            }
        }
        DB::table('m_barang')->insert($barang);

        // Seeder untuk t_stok (15 barang)
        $stok = [];
        foreach ($barang as $item) {
            $stok[] = [
                'supplier_id' => rand(1, 3),
                'barang_id' => $item['barang_id'],
                'user_id' => 1, // Asumsi admin yang input stok
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => rand(50, 200),
            ];
        }
        DB::table('t_stok')->insert($stok);

        // Seeder untuk t_penjualan (10 transaksi)
        $penjualan = [];
        for ($i = 1; $i <= 10; $i++) {
            $penjualan[] = [
                'penjualan_id' => $i,
                'user_id' => 1,
                'pembeli' => 'Pembeli ' . $i,
                'penjualan_kode' => 'PNJ' . $i,
                'penjualan_tanggal' => Carbon::now(),
            ];
        }
        DB::table('t_penjualan')->insert($penjualan);

        // Seeder untuk t_penjualan_detail (3 barang per transaksi, total 30 data)
        $penjualanDetail = [];
        foreach ($penjualan as $penjualanItem) {
            $barangIds = array_rand($barang, 3); // Pilih 3 barang secara acak
            foreach ($barangIds as $barangIndex) {
                $penjualanDetail[] = [
                    'penjualan_id' => $penjualanItem['penjualan_id'],
                    'barang_id' => $barang[$barangIndex]['barang_id'],
                    'harga' => $barang[$barangIndex]['harga_jual'],
                    'jumlah' => rand(1, 5),
                ];
            }
        }
        DB::table('t_penjualan_detail')->insert($penjualanDetail);
    }
}
