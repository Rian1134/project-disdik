<?php

namespace App\Models;

use App\Models\Concerns\MemerlukanPersetujuan;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use MemerlukanPersetujuan;

    public const STATUS_MENUNGGU = 'menunggu';

    public const STATUS_DISETUJUI = 'disetujui';

    public const SUMBER_MANUAL = 'manual';

    public const SUMBER_IMPORT = 'import';

    // Pilihan dropdown (sama dengan dropdown di template Excel)
    public const AGAMA = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];

    public const JABATAN = ['Tenaga Pendidik', 'Tenaga Kependidikan'];

    public const TUGAS = ['Kepala Sekolah', 'Wakil Kepala Sekolah', 'Bendahara', 'Guru Mapel', 'Bimbingan Konseling', 'Tata Usaha', 'Laboran', 'Pustakawan', 'Kebersihan', 'Security', 'Lainnya'];

    public const STATUS_KEPEGAWAIAN = ['PNS', 'PPPK', 'PPPK Paruh Waktu', 'Non-ASN', 'Honorer', 'Lainnya'];

    // Golongan PNS (I/a - IV/e) dan golongan PPPK (I - XVII)
    public const GOLONGAN = [
        'I/a', 'I/b', 'I/c', 'I/d',
        'II/a', 'II/b', 'II/c', 'II/d',
        'III/a', 'III/b', 'III/c', 'III/d',
        'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e',
        'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII',
    ];

    // Mata pelajaran guru jenjang SMP
    public const MATA_PELAJARAN = [
        'Pendidikan Agama dan Budi Pekerti',
        'Pendidikan Pancasila',
        'Bahasa Indonesia',
        'Matematika',
        'Ilmu Pengetahuan Alam (IPA)',
        'Ilmu Pengetahuan Sosial (IPS)',
        'Bahasa Inggris',
        'PJOK',
        'Informatika',
        'Seni dan Budaya',
        'Prakarya',
        'Bahasa Daerah',
        'Muatan Lokal',
        'Lainnya',
    ];

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
        'mata_pelajaran',
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
