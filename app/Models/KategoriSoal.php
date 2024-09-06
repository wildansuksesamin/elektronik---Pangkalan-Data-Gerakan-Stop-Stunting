<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriSoal extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'kategori_soal';

    public function soal()
    {
        return $this->hasMany(Soal::class)->orderBy('urutan', 'asc');
    }

    public function jawabanSurvey()
    {
        return $this->hasMany(JawabanSurvey::class);
    }
}
