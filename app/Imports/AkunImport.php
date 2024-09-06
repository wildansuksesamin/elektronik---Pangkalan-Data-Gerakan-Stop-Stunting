<?php

namespace App\Imports;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AkunImport implements ToCollection, WithHeadingRow
{
    public function __construct($role, $institusi_id)
    {
        $this->role = $role;
        $this->institusi_id = $institusi_id;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $role = $this->role;
        $institusi_id = $this->institusi_id;

        foreach ($rows as $row) {
            $cekUsername = User::where('username', $row['username'])->first();

            if (!$cekUsername) {
                $user = new User();
                $user->username = $row['username'];
                $user->password = bcrypt($row['username']);
                $user->role = $role;
                $user->status = 1;
                $user->save();

                $profil = new Profile();
                $profil->user_id = $user->id;
                $profil->institusi_id = $institusi_id;
                $profil->nama_lengkap = $row['nama_lengkap'];
                $profil->jenis_kelamin = 'Laki-laki';
                $profil->tempat_lahir = 'Palu';
                $profil->tanggal_lahir = '1999-01-01';
                $profil->alamat = 'Palu';
                $profil->provinsi = 72;
                $profil->kabupaten_kota = 7271;
                $profil->kecamatan = 7271031;
                $profil->desa_kelurahan = 7271031006;
                $profil->nomor_hp = $row['no_hp'];
                $profil->save();
            }
        }
    }
}
