<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemilihan extends Model
{
    protected $table = 'pemilihan';
    
    protected $fillable = [
        'id_kandidat',
        'nisn',
    ];

    /**
     * Get the kandidat that was voted for
     */
    public function kandidat(): BelongsTo
    {
        return $this->belongsTo(Kandidat::class, 'id_kandidat', 'id_kandidat');
    }

    /**
     * Get the siswa who voted
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'nisn', 'nisn');
    }
}
