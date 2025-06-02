<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    protected $fillable = [
        'ktp_id',
        'kredit_id',
        'tanggal_pengajuan',
    ];

    public function ktp(): BelongsTo
    {
        return $this->belongsTo(Ktp::class);
    }

    public function kredit(): BelongsTo
    {
        return $this->belongsTo(Kredit::class);
    }

    public function sliks(): HasMany
    {
        return $this->hasMany(Slik::class);
    }
}
