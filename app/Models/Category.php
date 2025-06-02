<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'category_name'
    ];

    public function sliks(): HasMany
    {
        return $this->hasMany(Slik::class);
    }
}
