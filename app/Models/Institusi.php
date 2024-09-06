<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institusi extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;

    protected $table = 'institusi';
    protected $guarded = ['id'];

    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }
}
