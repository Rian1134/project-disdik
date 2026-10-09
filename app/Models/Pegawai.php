<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    // Pilihan dropdown (sama dengan dropdown di template Excel)
    public const AGAMA = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    public const JABATAN = ['Tenaga Pendidik', 'Tenaga Kependidikan'];
    public const TUGAS = ['Kepala Sekolah', 'Wakil Kepala Sekolah', 'Bendahara', 'Guru Mapel', 'Bimbingan Konseling', 'Tata Usaha', 'Laboran', 'Pustakawan', 'Kebersihan', 'Security', 'Lainnya'];
    public const STATUS_KEPEGAWAIAN = ['PNS', 'PPPK', 'PPPK Paruh Waktu', 'Non-ASN', 'Honorer', 'Lainnya'];
    public const PENDIDIKAN = ['S3', 'S2', 'S1', 'SMA Sederajat', 'SMP Sederajat', 'SD Sederajat', 'Lainnya'];

    protected $fillable = [
        'sekolah_id',
        'nama',
        'nip',
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'alamat',
        'golongan',
        'pangkat',
        'terhitung_mulai_tanggal',
        'jabatan',
        'tugas',
        'status_kepegawaian',
        'pendidikan_terakhir',
        'unit_satuan_pendidikan_terakhir',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'terhitung_mulai_tanggal' => 'date',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}