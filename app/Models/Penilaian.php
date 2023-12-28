<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penilaian extends Model
{
    use HasFactory;
    protected $table = 'penilaian';
    public $timestamps = false;
    protected $primaryKey = 'penilaian_id';
    protected $keyType = 'string';
    protected $fillable = [
        'calon_peserta_id',
        'nilai_min',
        'nilai_kes',
        'nilai_jas',
        'keterangan_min',
        'keterangan_kes',
        'keterangan_jas',
    ];
    
    public function calon_peserta(): BelongsTo
    {
        return $this->belongsTo(CalonPeserta::class, 'id');
    }
    
    public function bobot_min(): BelongsTo
    {
        return $this->belongsTo(Bobot::class, 'nilai_min', 'bobot_id');
    }
    
    public function bobot_kes(): BelongsTo
    {
        return $this->belongsTo(Bobot::class, 'nilai_kes', 'bobot_id');
    }
    
    public function bobot_jas(): BelongsTo
    {
        return $this->belongsTo(Bobot::class, 'nilai_jas', 'bobot_id');
    }
}
