<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NamaSurvey extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'nama_survey';

    public function kategoriSoal()
    {
        return $this->hasMany(KategoriSoal::class);
    }
}
