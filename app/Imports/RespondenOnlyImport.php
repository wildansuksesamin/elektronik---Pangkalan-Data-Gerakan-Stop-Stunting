<?php

namespace App\Imports;

use App\Models\Responden;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class RespondenOnlyImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $responden = Responden::where('kartu_keluarga', $row['kartu_keluarga'])->first();
            if (!$responden) {
                Responden::create([
                    'kartu_keluarga' => $row['kartu_keluarga'],
                    'nama_kepala_keluarga' => $row['nama_kepala_keluarga'],
                    'alamat' => $row['alamat'],
                    'provinsi_id' => $row['provinsi'],
                    'kabupaten_kota_id' => $row['kabupaten'],
                    'kecamatan_id' => $row['kecamatan'],
                    'desa_kelurahan_id' => $row['desa'],
                    'kode_unik' => random_int(10000000, 99999999),
                ]);
            }
        }
    }
}
