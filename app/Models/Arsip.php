<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arsip extends Model
{
    protected $fillable = [
        'kategori_id',
        'judul',
        'nomor_arsip',
        'tanggal_arsip',
        'deskripsi',
        'file_path',
        'file_asli',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_arsip' => 'date',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
