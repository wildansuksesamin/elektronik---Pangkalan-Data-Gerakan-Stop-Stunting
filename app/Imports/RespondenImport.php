<?php

namespace App\Imports;

use App\Models\Responden;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


// class RespondenImport implements ToCollection, WithHeadingRow
class RespondenImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $bentrok = array();
    public function model(array $row)
    {
        $responden = Responden::where('kartu_keluarga', $row['kartu_keluarga'])->first();
        if ($responden == null) {
            return new Responden([
                'kartu_keluarga'    => $row['kartu_keluarga'],
                'nama_kepala_keluarga' => $row['nama_kepala_keluarga'],
                'alamat'    => $row['alamat'],
                'provinsi_id'    => $row['provinsi_id'],
                'kabupaten_kota_id'    => $row['kabupaten_kota_id'],
                'kecamatan_id'    => $row['kecamatan_id'],
                'desa_kelurahan_id'    => $row['desa_kelurahan_id'],
                'nomor_hp'    => $row['nomor_hp'],
                'kode_unik'    => $row['kode_unik'],

            ]);
        } else {
            $nomor_kk = $responden->kartu_keluarga;
            $kode_unik_old = $responden->kode_unik;
            $kode_unik_new = $row['kode_unik'];
            $data = [
                'kartu_keluarga' => $nomor_kk,
                'kode_unik_old' => $kode_unik_old,
                'kode_unik_new' => $kode_unik_new,
            ];
            array_push($this->bentrok, $data);
        }
    }

    public function getBentrok()
    {
        return $this->bentrok;
    }
}
