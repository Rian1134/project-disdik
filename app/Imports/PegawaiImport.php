<?php

namespace App\Imports;

use App\Imports\Concerns\MembacaTanggal;
use App\Models\Pegawai;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Import template-pegawai.xlsx (sheet "Data Pegawai").
 * - Sekolah dipilih di form upload (dikirim lewat constructor), bukan dari isi file.
 * - Header ada di baris 1, data pegawai dibaca mulai baris ke-2.
 * Semua baris divalidasi dulu; kalau ada yang salah, tidak ada data yang tersimpan.
 */
class PegawaiImport implements ToCollection, WithMultipleSheets, SkipsUnknownSheets
{
    use MembacaTanggal;

    private const BARIS_DATA = 2;

    public function __construct(private int $sekolahId)
    {
    }

    /**
     * Hanya baca sheet "Data Pegawai". Tanpa ini Laravel Excel ikut membaca sheet
     * "Referensi" dan isinya dianggap data pegawai.
     */
    public function sheets(): array
    {
        return ['Data Pegawai' => $this];
    }

    public function onUnknownSheet($sheetName): void
    {
        // Sheet lain (mis. "Referensi") diabaikan.
    }

    public function collection(Collection $rows): void
    {
        $rows = $rows->values();

        $simpan = [];
        $error = [];

        foreach ($rows->slice(self::BARIS_DATA - 1)->values() as $i => $row) {
            $v = fn (int $k) => $this->teks($row[$k] ?? null);

            // Baris kosong (hanya berisi nomor urut)
            if ($v(1) === '' && $v(6) === '') {
                continue;
            }

            [$tempat, $tanggal] = array_pad(explode(',', $v(5), 2), 2, '');

            $data = [
                'nama' => $v(1),
                'nip' => $v(2) ?: null,
                'jenis_kelamin' => ['laki-laki' => 'L', 'perempuan' => 'P', 'l' => 'L', 'p' => 'P'][strtolower($v(3))] ?? '',
                'agama' => $v(4),
                'tempat_lahir' => trim($tempat),
                'tanggal_lahir' => $this->tanggal($tanggal),
                'nik' => $v(6),
                'alamat' => $v(7),
                'golongan' => $v(8) ?: null,
                'pangkat' => $v(9) ?: null,
                'terhitung_mulai_tanggal' => $this->tanggal($v(10)),
                'jabatan' => $v(11),
                'tugas' => $v(12),
                'status_kepegawaian' => $v(13),
                'pendidikan_terakhir' => $v(14),
                'unit_satuan_pendidikan_terakhir' => $v(15),
            ];

            $validator = Validator::make($data, self::rules(), self::pesan(), self::labels());

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $pesan) {
                    $error[] = 'Baris ' . ($i + self::BARIS_DATA) . ': ' . $pesan;
                }
                continue;
            }

            $simpan[] = $data + [
                'sekolah_id' => $this->sekolahId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($error) {
            $tampil = array_slice($error, 0, 10);
            if (count($error) > 10) {
                $tampil[] = 'Dan ' . (count($error) - 10) . ' kesalahan lainnya.';
            }
            throw ValidationException::withMessages(['file' => $tampil]);
        }

        if (! $simpan) {
            throw ValidationException::withMessages(['file' => ['Tidak ada data pegawai di file. Isi data mulai baris ke-2 pada sheet "Data Pegawai".']]);
        }

        Pegawai::insert($simpan);
    }

    /**
     * Sel Excel -> teks. Angka (mis. NIK yang tersimpan sebagai angka) ditulis
     * penuh tanpa notasi ilmiah seperti 1.06E+7.
     */
    private function teks(mixed $nilai): string
    {
        if ($nilai === null) {
            return '';
        }

        if (is_int($nilai) || is_float($nilai)) {
            $angka = (float) $nilai;

            return floor($angka) === $angka
                ? number_format($angka, 0, '', '')
                : rtrim(rtrim(number_format($angka, 6, '.', ''), '0'), '.');
        }

        return trim((string) $nilai);
    }

    /**
     * Aturan validasi (dipakai juga oleh form manual di PegawaiController).
     */
    public static function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:30'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'agama' => ['required', Rule::in(Pegawai::AGAMA)],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'nik' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:255'],
            'golongan' => ['nullable', 'string', 'max:50'],
            'pangkat' => ['nullable', 'string', 'max:100'],
            'terhitung_mulai_tanggal' => ['required', 'date'],
            'jabatan' => ['required', Rule::in(Pegawai::JABATAN)],
            'tugas' => ['required', Rule::in(Pegawai::TUGAS)],
            'status_kepegawaian' => ['required', Rule::in(Pegawai::STATUS_KEPEGAWAIAN)],
            'pendidikan_terakhir' => ['required', Rule::in(Pegawai::PENDIDIKAN)],
            'unit_satuan_pendidikan_terakhir' => ['required', 'string', 'max:255'],
        ];
    }

    public static function labels(): array
    {
        return [
            'nama' => 'Nama Lengkap',
            'nip' => 'NIP/NIPPPK/NIPPPKPW',
            'jenis_kelamin' => 'Jenis Kelamin',
            'agama' => 'Agama',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'nik' => 'NIK',
            'alamat' => 'Alamat Tempat Tinggal',
            'golongan' => 'Golongan',
            'pangkat' => 'Pangkat',
            'terhitung_mulai_tanggal' => 'TMT di Sekolah Ini',
            'jabatan' => 'Jabatan',
            'tugas' => 'Tugas',
            'status_kepegawaian' => 'Status Kepegawaian',
            'pendidikan_terakhir' => 'Pendidikan Terakhir',
            'unit_satuan_pendidikan_terakhir' => 'Unit Satuan Pendidikan Terakhir',
        ];
    }

    public static function pesan(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'in' => ':attribute tidak sesuai pilihan di template.',
            'max' => ':attribute terlalu panjang.',
            'tanggal_lahir.required' => 'Tempat, Tanggal Lahir harus diisi, contoh: Lahat, 12 Mei 1985.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak dikenali.',
            'terhitung_mulai_tanggal.required' => 'TMT di Sekolah Ini wajib diisi dengan tanggal yang valid.',
            'terhitung_mulai_tanggal.date' => 'Format TMT di Sekolah Ini tidak dikenali.',
        ];
    }
}