<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function arsips(): HasMany
    {
        return $this->hasMany(Arsip::class);
    }
}
