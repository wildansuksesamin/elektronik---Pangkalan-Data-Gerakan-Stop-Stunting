<?php

namespace App\Models;

use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Desa_kelurahan;
use App\Models\Kabupaten_kota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;

class Responden extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'responden';
    protected $guarded = ['id'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kabupaten_kota()
    {
        return $this->belongsTo(Kabupaten_kota::class, 'kabupaten_kota_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function desa_kelurahan()
    {
        return $this->belongsTo(Desa_kelurahan::class, 'desa_kelurahan_id');
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
