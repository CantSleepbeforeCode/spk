<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bobot extends Model
{
    use HasFactory;
    protected $table = 'bobot';
    public $timestamps = false;
    protected $primaryKey = 'bobot_id';
    protected $keyType = 'string';
    protected $fillable = [
        'kategori',
        'sub_kategori',
        'deskripsi',
        'nilai',
    ];

    public function penilaian_min(): HasOne {
        return $this->hasOne(Penilaian::class, 'bobot_id', 'nilai_min');
    }

    public function penilaian_jas(): HasOne {
        return $this->hasOne(Penilaian::class, 'bobot_id', 'nilai_jas');
    }

    public function penilaian_kes(): HasOne {
        return $this->hasOne(Penilaian::class, 'bobot_id', 'nilai_kes');
    }
}
