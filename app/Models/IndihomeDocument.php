<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndihomeDocument extends Model
{
    protected $fillable = [
        'nama_dokumen',
        'lokasi',
        'latitude',
        'longitude',
        'file_path',
        'keterangan',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 