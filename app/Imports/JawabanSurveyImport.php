<?php

namespace App\Imports;

use App\Models\JawabanSurvey;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;



class JawabanSurveyImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            $jawaban_survey = JawabanSurvey::where('kode_unik_survey', $row['kode_unik_survey'])
            ->where('soal_id', $row['soal_id'])
            ->where('kategori_soal_id', $row['kategori_soal_id'])
            ->first();
            if($jawaban_survey){
                $jawaban_survey->delete();
            } 
            JawabanSurvey::create([
                'soal_id'  => $row['soal_id'],
                'kode_unik_survey'  => $row['kode_unik_survey'],
                'kategori_soal_id'  => $row['kategori_soal_id'],
                'jawaban_soal_id'  => $row['jawaban_soal_id'],
                'jawaban_lainnya'  => $row['jawaban_lainnya'],
            ]);
        }
       
    }
}
