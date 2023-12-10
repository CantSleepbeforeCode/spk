<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonPeserta extends Model
{
    use HasFactory;
    protected $table = 'calon_peserta';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'nomor_peserta',
        'kodim',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'kode_panda',
        'tinggi_badan',
        'berat_badan',
        'agama',
        'suku',
        'pendidikan',
        'tahun_kelulusan',
        'alamat',
        'nomor_telepon',
        'nama_ortu',
        'alamat_ortu',
        'nama_wali',
        'sumber_info',
        'pekerjaan_ortu',
        'jurusan_dikum',
        'nama_sekolah',
        'nilai_uan',
        'nilai_jas',
        'status_jas',
        'keterangan_jas',
        'nilai_kes',
        'status_kes',
        'keterangan_kes',
        'nilai_min',
        'status_min',
        'keterangan_min',
        'status_kelulusan',
        'tanggal_daftar',
    ];
}
