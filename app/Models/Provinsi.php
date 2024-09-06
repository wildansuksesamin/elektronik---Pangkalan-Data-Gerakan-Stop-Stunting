<?php

namespace App\Models;

use App\Models\Kabupaten_kota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Provinsi extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'provinsi';


    public function kabupatenKota()
    {
        return $this->hasMany(Kabupaten_kota::class, 'provinsi_id');
    }
}
