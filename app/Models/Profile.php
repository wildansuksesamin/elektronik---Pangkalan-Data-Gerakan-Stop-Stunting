<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;

class Profile extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institusi()
    {
        return $this->belongsTo(Institusi::class);
    }

    public function lokasiSurveySupervisor()
    {
        return $this->hasMany(LokasiSurveySupervisor::class, 'profile_id', 'id');
    }

    public function anggotaSupervisor()
    {
        return $this->belongsTo(AnggotaSupervisor::class, 'id', 'profile_surveyor');
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
