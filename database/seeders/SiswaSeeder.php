<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Siswa::create([
            'nisn' => '0987654321',
            'nama_siswa' => 'Siti Aminah',
            'alamat'    => 'Jl. Kebangsaan No. 2, Jakarta',
            'jenis_kelamin' => 'wanita',
            'kelas_id' => 1,
            'user_id' => 3,
        ]);
    }
}
