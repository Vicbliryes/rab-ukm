<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Budget Codes
        DB::table('budget_codes')->insert([
            ['Kode_Anggaran' => 1, 'Nama_Anggaran' => 'Barang'],
            ['Kode_Anggaran' => 2, 'Nama_Anggaran' => 'Upah'],
            ['Kode_Anggaran' => 3, 'Nama_Anggaran' => 'Alat'],
            ['Kode_Anggaran' => 4, 'Nama_Anggaran' => 'Lain-Lain'],
        ]);

        // RAB
        DB::table('rab')->insert([
            ['NOMOR_RAB' => 'RAB001', 'Kegiatan' => 'UKM_Badminton', 'TANGGAL_RAP' => '2025-05-11'],
            ['NOMOR_RAB' => 'RAB002', 'Kegiatan' => 'UKM_Futsal', 'TANGGAL_RAP' => '2025-05-14'],
        ]);

        // RAB Details (Badminton)
        DB::table('rab_details')->insert([
            ['NOMOR_RAB' => 'RAB001', 'Kode_Anggaran' => 1, 'Nama' => 'Cock', 'Jumlah' => 10, 'Satuan' => 'Slop', 'Harga_Satuan' => 60000.00],
            ['NOMOR_RAB' => 'RAB001', 'Kode_Anggaran' => 4, 'Nama' => 'Sewa Lapangan', 'Jumlah' => 2, 'Satuan' => 'Hari', 'Harga_Satuan' => 100000.00],
            ['NOMOR_RAB' => 'RAB001', 'Kode_Anggaran' => 2, 'Nama' => 'Upah Pelatih', 'Jumlah' => 2, 'Satuan' => 'Hari', 'Harga_Satuan' => 80000.00],
            ['NOMOR_RAB' => 'RAB001', 'Kode_Anggaran' => 4, 'Nama' => 'Aqua Gelas', 'Jumlah' => 4, 'Satuan' => 'dos', 'Harga_Satuan' => 20000.00],
            ['NOMOR_RAB' => 'RAB001', 'Kode_Anggaran' => 1, 'Nama' => 'Raket', 'Jumlah' => 1, 'Satuan' => 'Pcs', 'Harga_Satuan' => 300000.00],
            ['NOMOR_RAB' => 'RAB001', 'Kode_Anggaran' => 4, 'Nama' => 'Lain-Lain', 'Jumlah' => 1, 'Satuan' => 'Is', 'Harga_Satuan' => 500000.00],
            ['NOMOR_RAB' => 'RAB002', 'Kode_Anggaran' => 1, 'Nama' => 'Bola', 'Jumlah' => 1, 'Satuan' => 'Pcs', 'Harga_Satuan' => 100000.00],
            ['NOMOR_RAB' => 'RAB002', 'Kode_Anggaran' => 4, 'Nama' => 'Sewa Lapangan', 'Jumlah' => 2, 'Satuan' => 'Hari', 'Harga_Satuan' => 150000.00],
            ['NOMOR_RAB' => 'RAB002', 'Kode_Anggaran' => 2, 'Nama' => 'Upah Pelatih', 'Jumlah' => 2, 'Satuan' => 'Hari', 'Harga_Satuan' => 100000.00],
            ['NOMOR_RAB' => 'RAB002', 'Kode_Anggaran' => 4, 'Nama' => 'Aqua Gelas', 'Jumlah' => 4, 'Satuan' => 'dos', 'Harga_Satuan' => 20000.00],
            ['NOMOR_RAB' => 'RAB002', 'Kode_Anggaran' => 4, 'Nama' => 'Lain-Lain', 'Jumlah' => 1, 'Satuan' => 'Is', 'Harga_Satuan' => 500000.00],
        ]);

        // Realization
        DB::table('realization')->insert([
            ['NOMOR_RAB' => 'RAB001', 'Tanggal' => '2025-06-01', 'Kode_Anggaran' => 1, 'Nama' => 'Cock', 'Jumlah' => 4, 'Satuan' => 'Slop', 'Harga_Satuan' => 52000.00],
            ['NOMOR_RAB' => 'RAB001', 'Tanggal' => '2025-06-01', 'Kode_Anggaran' => 4, 'Nama' => 'Sewa Lapangan', 'Jumlah' => 1, 'Satuan' => 'Hari', 'Harga_Satuan' => 100000.00],
            ['NOMOR_RAB' => 'RAB001', 'Tanggal' => '2025-06-01', 'Kode_Anggaran' => 2, 'Nama' => 'Upah Pelatih', 'Jumlah' => 1, 'Satuan' => 'Hari', 'Harga_Satuan' => 80000.00],
            ['NOMOR_RAB' => 'RAB001', 'Tanggal' => '2025-06-01', 'Kode_Anggaran' => 4, 'Nama' => 'Aqua Gelas', 'Jumlah' => 2, 'Satuan' => 'dos', 'Harga_Satuan' => 20000.00],
            ['NOMOR_RAB' => 'RAB001', 'Tanggal' => '2025-06-02', 'Kode_Anggaran' => 1, 'Nama' => 'Cock', 'Jumlah' => 5, 'Satuan' => 'Slop', 'Harga_Satuan' => 60000.00],
            ['NOMOR_RAB' => 'RAB001', 'Tanggal' => '2025-06-02', 'Kode_Anggaran' => 4, 'Nama' => 'Sewa Lapangan', 'Jumlah' => 1, 'Satuan' => 'Hari', 'Harga_Satuan' => 100000.00],
            ['NOMOR_RAB' => 'RAB001', 'Tanggal' => '2025-06-02', 'Kode_Anggaran' => 2, 'Nama' => 'Upah Pelatih', 'Jumlah' => 1, 'Satuan' => 'Hari', 'Harga_Satuan' => 80000.00],
            ['NOMOR_RAB' => 'RAB001', 'Tanggal' => '2025-06-02', 'Kode_Anggaran' => 4, 'Nama' => 'Aqua Gelas', 'Jumlah' => 1, 'Satuan' => 'dos', 'Harga_Satuan' => 20000.00],
            ['NOMOR_RAB' => 'RAB002', 'Tanggal' => '2025-06-01', 'Kode_Anggaran' => 1, 'Nama' => 'Bola', 'Jumlah' => 1, 'Satuan' => 'Pcs', 'Harga_Satuan' => 90000.00],
            ['NOMOR_RAB' => 'RAB002', 'Tanggal' => '2025-06-01', 'Kode_Anggaran' => 4, 'Nama' => 'Sewa Lapangan', 'Jumlah' => 1, 'Satuan' => 'Hari', 'Harga_Satuan' => 150000.00],
            ['NOMOR_RAB' => 'RAB002', 'Tanggal' => '2025-06-01', 'Kode_Anggaran' => 2, 'Nama' => 'Upah Pelatih', 'Jumlah' => 1, 'Satuan' => 'Hari', 'Harga_Satuan' => 100000.00],
            ['NOMOR_RAB' => 'RAB002', 'Tanggal' => '2025-06-01', 'Kode_Anggaran' => 4, 'Nama' => 'Aqua Gelas', 'Jumlah' => 4, 'Satuan' => 'dos', 'Harga_Satuan' => 20000.00],
            ['NOMOR_RAB' => 'RAB002', 'Tanggal' => '2025-06-01', 'Kode_Anggaran' => 4, 'Nama' => 'Sewa Lapangan', 'Jumlah' => 1, 'Satuan' => 'Hari', 'Harga_Satuan' => 150000.00],
            ['NOMOR_RAB' => 'RAB002', 'Tanggal' => '2025-06-02', 'Kode_Anggaran' => 2, 'Nama' => 'Upah Pelatih', 'Jumlah' => 1, 'Satuan' => 'Hari', 'Harga_Satuan' => 100000.00],
            ['NOMOR_RAB' => 'RAB002', 'Tanggal' => '2025-06-02', 'Kode_Anggaran' => 4, 'Nama' => 'Aqua Gelas', 'Jumlah' => 1, 'Satuan' => 'vari', 'Harga_Satuan' => 10000.00],
            ['NOMOR_RAB' => 'RAB002', 'Tanggal' => '2025-06-02', 'Kode_Anggaran' => 4, 'Nama' => 'Jasa Pempa Bola', 'Jumlah' => 1, 'Satuan' => 'unit', 'Harga_Satuan' => 10000.00],
            ['NOMOR_RAB' => 'RAB002', 'Tanggal' => '2025-06-02', 'Kode_Anggaran' => 4, 'Nama' => 'P3K', 'Jumlah' => 1, 'Satuan' => 'Is', 'Harga_Satuan' => 50000.00],
        ]);
    }
}