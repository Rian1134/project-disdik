<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $fillable = [
        'user_id',
        'nss',
        'npsn',
        'nama_sekolah',
        'nama_kepala_sekolah',
        'akreditasi',
        'status_sekolah',
        'tanggal_sk_pendirian',
        'tanggal_sk_izin_oprasional',
        'implementasi_kurikulum',

        'alamat',
        'rt_rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',

        'laus_tanah',
        'laus_bangunan',
        'tipe_internet',
        'internet_provider',
        'bandwith_internet',
        'sumber_listrik',
        'daya_listrik',
        'sumber_air',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
}
