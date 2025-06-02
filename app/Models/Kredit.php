<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kredit extends Model
{
    protected $fillable = [
        'nama_ao',
        'jenis_kredit',
    ];

    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }
}
