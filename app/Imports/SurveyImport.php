<?php

namespace App\Imports;

use App\Models\Survey;
use App\Models\JawabanSurvey;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;


class SurveyImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function  __construct($bentrok)
    {
        // $this->kode_unik_old = $bentrok['kode_unik_old'];
        // $this->kode_unik_new = $bentrok['kode_unik_new'];
        $this->bentrok = $bentrok;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $survey = Survey::where('kode_unik', $row['kode_unik'])->first();
            if ($survey == null) {
                $bentrok = $this->bentrok;
                for ($i = 0; $i < count($bentrok); $i++) {
                    if ($bentrok[$i]['kode_unik_new'] == $row['kode_unik_responden']) {
                        $kode_unik_responden = $bentrok[$i]['kode_unik_old'];
                    } else {
                        $kode_unik_responden = $row['kode_unik_responden'];
                    }
                }
                // $kode_unik_responden = $row['kode_unik_responden'];

                Survey::create([
                    'kode_unik_responden'  => $kode_unik_responden,
                    'nama_survey_id' => $row['nama_survey_id'],
                    'profile_id' => $row['profile_id'],
                    'kategori_selanjutnya' => $row['kategori_selanjutnya'],
                    'is_selesai' => $row['is_selesai'],
                    'kode_unik' => $row['kode_unik'],
                ]);
            }
        }
    }
}
