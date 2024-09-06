<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LokasiSurveySupervisor extends Model
{
    use HasFactory;
    use TraitUuid;
    use SoftDeletes;

    protected $table = "lokasi_survey_supervisor";

    public function lokasiSurvey()
    {
        return $this->belongsTo(LokasiSurvey::class);
    }

    public function anggotaSupervisor()
    {
        return $this->hasMany(AnggotaSupervisor::class, 'lokasi_survey_supervisor_id', 'id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
