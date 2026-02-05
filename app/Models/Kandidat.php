<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kandidat extends Model
{
    protected $table = 'kandidat';
    protected $primaryKey = 'id_kandidat';
    
    protected $fillable = [
        'nama',
        'foto',
    ];

    /**
     * Get all votes for this kandidat
     */
    public function pemilihan(): HasMany
    {
        return $this->hasMany(Pemilihan::class, 'id_kandidat', 'id_kandidat');
    }

    /**
     * Get foto URL attribute
     */
    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto) {
            return asset('storage/kandidat/' . $this->foto);
        }
        return asset('images/default-avatar.png');
    }

    /**
     * Get total votes count
     */
    public function getJumlahSuaraAttribute(): int
    {
        return $this->pemilihan()->count();
    }
}
