<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ktp extends Model
{
    protected $fillable = [
        'nama',
        'NIK',
        'TTL',
        'alamat',
    ];

    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }
}
