<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nik',
        'nisn',
        'nama_siswa',
        'kelas',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'status_tempat_tinggal',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'kisaran_penghasilan_ayah',
        'kisaran_penghasilan_ibu',
        'jumlah_saudara',
        'bantuan_pendidikan',
        'status_pelajar',
    ];
}
