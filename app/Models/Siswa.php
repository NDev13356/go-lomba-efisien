<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'nisn';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'nisn',
        'nama',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the vote record for this siswa
     */
    public function pemilihan(): HasOne
    {
        return $this->hasOne(Pemilihan::class, 'nisn', 'nisn');
    }

    /**
     * Check if siswa has voted
     */
    public function hasVoted(): bool
    {
        return $this->pemilihan()->exists();
    }
}
