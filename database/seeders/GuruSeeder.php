<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guru::create([
            'nip' => '1234567890',
            'nama_guru' => 'Budi Santoso',
            'alamat'    => 'Jl. Merdeka No. 1, Jakarta',
            'no_telp' => '081234567890',
            'jenis_kelamin' => 'pria',
            'user_id' => 2,
        ]);
    }
}
