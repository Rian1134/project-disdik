<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // Pilihan dropdown (sama dengan dropdown di template Excel)
    public const STATUS_TEMPAT_TINGGAL = ['Rumah sendiri', 'Rumah orang tua', 'Wali', 'Kost', 'Kontrak', 'Asrama', 'Lainnya'];
    public const PEKERJAAN = ['PNS', 'TNI', 'Polri', 'Karyawan Swasta', 'Wiraswasta', 'Petani', 'Buruh', 'Nelayan', 'Pedagang', 'Tidak bekerja', 'Lainnya'];
    public const PENGHASILAN = ['Rp 0', '< Rp1 juta', 'Rp1–3 juta', 'Rp3–5 juta', 'Rp5–10 juta', '> Rp10 juta'];
    public const BANTUAN = ['PIP', 'KIP', 'KJP', 'PKH', 'Beasiswa Sekolah', 'Beasiswa Prestasi', 'Tidak Ada', 'Lainnya'];
    public const STATUS_PELAJAR = ['Aktif', 'Pindah', 'Berhenti', 'Meninggal'];

    protected $fillable = [
        'sekolah_id',
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

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}