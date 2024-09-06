<?php

namespace App\Models;

use App\Models\Desa_kelurahan;
use App\Models\Kabupaten_kota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Kecamatan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'kecamatan';

    public function kabupatenKota()
    {
        return $this->belongsTo(Kabupaten_kota::class, 'kabupaten_kota_id');
    }

    public function desaKelurahan()
    {
        return $this->hasMany(Desa_kelurahan::class, 'kecamatan_id');
    }
}
