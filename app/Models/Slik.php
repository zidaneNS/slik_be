<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slik extends Model
{
    protected $fillable = [
        'form_id',
        'category_id'
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
