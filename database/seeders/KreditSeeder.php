<?php

namespace Database\Seeders;

use App\Models\Kredit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KreditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kredits = [
            [
                "nama_ao" => "Yunita",
                "jenis_kredit" => 'KMG'
            ],
            [
                "nama_ao" => "Wika",
                "jenis_kredit" => 'RITEL'
            ],
            [
                "nama_ao" => "Ruli",
                "jenis_kredit" => 'KUR'
            ]
        ];

        foreach ($kredits as $kredit) {
            Kredit::create([
                'nama_ao' => $kredit['nama_ao'],
                'jenis_kredit' => $kredit['jenis_kredit']
            ]);
        }
    }
}
