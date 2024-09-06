<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Soal extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'soal';

    public function jawabanSoal()
    {
        return $this->hasMany(JawabanSoal::class);
    }

    public function kategoriSoal()
    {
        return $this->belongsTo(KategoriSoal::class);
    }

    public function jawabanSurvey()
    {
        return $this->hasMany(JawabanSurvey::class);
    }
}
