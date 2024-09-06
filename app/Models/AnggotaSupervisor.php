<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaSupervisor extends Model
{
    use HasFactory;
    use TraitUuid;
    use SoftDeletes;

    protected $table = 'anggota_supervisor';

    public function profileSurveyor()
    {
        return $this->belongsTo(Profile::class, 'profile_surveyor', 'id');
    }

    public function profileSupervisor()
    {
        return $this->belongsTo(Profile::class, 'profile_dpl', 'id');
    }

    public function lokasiSurveySupervisor()
    {
        return $this->belongsTo(LokasiSurveySupervisor::class, 'lokasi_survey_supervisor_id', 'id');
    }
}
