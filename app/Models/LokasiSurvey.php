<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LokasiSurvey extends Model
{
    use HasFactory, TraitUuid, SoftDeletes;
    protected $table = 'lokasi_survey';
    protected $guarded = ['id'];

    public function desa_kelurahan(){
        return $this->belongsTo(Desa_kelurahan::class, 'desa_kelurahan_id');
    }
}
