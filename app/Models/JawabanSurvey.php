<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class JawabanSurvey extends Model
{
    use HasFactory;
    protected $table = 'jawaban_survey';
    protected $guarded = [];

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    public function jawabanSoal()
    {
        return $this->belongsTo(JawabanSoal::class);
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
