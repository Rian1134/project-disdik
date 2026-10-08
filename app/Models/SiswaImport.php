<?php

namespace App\Imports;

use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * Import Template_Data_Siswa_web.xlsx (sheet "Data Siswa", data mulai baris ke-3).
 * Semua baris divalidasi dulu; kalau ada yang salah, tidak ada data yang tersimpan.
 */
class SiswaImport implements ToCollection, WithStartRow
{
    public function __construct(private int $sekolahId)
    {
    }

    public function startRow(): int
    {
        return 3;
    }

    public function collection(Collection $rows)
    {
        $simpan = [];
        $error = [];

        foreach ($rows->values() as $i => $row) {
            $v = fn (int $k) => trim((string) ($row[$k] ?? ''));

            // Baris kosong (hanya berisi nomor urut)
            if ($v(1) === '' && $v(3) === '') {
                continue;
            }

            [$tempat, $tanggal] = array_pad(explode(',', $v(6), 2), 2, '');

            $data = [
                'nik' => $v(1),
                'nisn' => $v(2),
                'nama_siswa' => $v(3),
                'kelas' => $v(4),
                'jenis_kelamin' => strtoupper($v(5)),
                'tempat_lahir' => trim($tempat),
                'tanggal_lahir' => $this->tanggal($tanggal),
                'alamat' => $v(7),
                'status_tempat_tinggal' => $v(8),
                'nama_ayah' => $v(9),
                'nama_ibu' => $v(10),
                'pekerjaan_ayah' => $v(11),
                'pekerjaan_ibu' => $v(12),
                'kisaran_penghasilan_ayah' => $v(13),
                'kisaran_penghasilan_ibu' => $v(14),
                'jumlah_saudara' => $v(15),
                'bantuan_pendidikan' => $v(16),
                'status_pelajar' => $v(17),
            ];

            $validator = Validator::make($data, self::rules(), self::pesan(), self::labels());

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $pesan) {
                    $error[] = 'Baris ' . ($i + $this->startRow()) . ': ' . $pesan;
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
            throw ValidationException::withMessages(['file' => ['Tidak ada data siswa di file. Isi data mulai baris ke-3 pada sheet "Data Siswa".']]);
        }

        Siswa::insert($simpan);
    }

    /**
     * Ubah teks tanggal jadi Y-m-d. Mendukung: 12-05-2010, 12/05/2010, 2010-05-12,
     * 12 Mei 2010, dan angka tanggal Excel.
     */
    private function tanggal(string $teks): ?string
    {
        $teks = trim($teks);

        if ($teks === '') {
            return null;
        }

        if (is_numeric($teks)) {
            return Date::excelToDateTimeObject((float) $teks)->format('Y-m-d');
        }

        foreach (['d-m-Y', 'd/m/Y', 'Y-m-d', 'd.m.Y'] as $format) {
            if (Carbon::hasFormat($teks, $format)) {
                return Carbon::createFromFormat($format, $teks)->format('Y-m-d');
            }
        }

        try {
            return Carbon::parseFromLocale($teks, 'id')->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Aturan validasi (dipakai juga oleh form manual di SiswaController).
     */
    public static function rules(): array
    {
        return [
            'nik' => ['required', 'string', 'max:20'],
            'nisn' => ['required', 'string', 'max:20'],
            'nama_siswa' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'status_tempat_tinggal' => ['required', Rule::in(Siswa::STATUS_TEMPAT_TINGGAL)],
            'nama_ayah' => ['required', 'string', 'max:255'],
            'nama_ibu' => ['required', 'string', 'max:255'],
            'pekerjaan_ayah' => ['required', Rule::in(Siswa::PEKERJAAN)],
            'pekerjaan_ibu' => ['required', Rule::in(Siswa::PEKERJAAN)],
            'kisaran_penghasilan_ayah' => ['required', Rule::in(Siswa::PENGHASILAN)],
            'kisaran_penghasilan_ibu' => ['required', Rule::in(Siswa::PENGHASILAN)],
            'jumlah_saudara' => ['required', 'integer', 'min:0'],
            'bantuan_pendidikan' => ['required', Rule::in(Siswa::BANTUAN)],
            'status_pelajar' => ['required', Rule::in(Siswa::STATUS_PELAJAR)],
        ];
    }

    public static function labels(): array
    {
        return [
            'nik' => 'NIK',
            'nisn' => 'NISN',
            'nama_siswa' => 'Nama Siswa',
            'kelas' => 'Kelas',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat' => 'Alamat',
            'status_tempat_tinggal' => 'Status Tempat Tinggal',
            'nama_ayah' => 'Nama Ayah',
            'nama_ibu' => 'Nama Ibu',
            'pekerjaan_ayah' => 'Pekerjaan Ayah',
            'pekerjaan_ibu' => 'Pekerjaan Ibu',
            'kisaran_penghasilan_ayah' => 'Penghasilan Ayah',
            'kisaran_penghasilan_ibu' => 'Penghasilan Ibu',
            'jumlah_saudara' => 'Jumlah Saudara',
            'bantuan_pendidikan' => 'Bantuan Pendidikan',
            'status_pelajar' => 'Status Pelajar',
        ];
    }

    public static function pesan(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'in' => ':attribute tidak sesuai pilihan di template.',
            'integer' => ':attribute harus berupa angka.',
            'max' => ':attribute terlalu panjang.',
            'tanggal_lahir.required' => 'Tempat, Tanggal Lahir harus diisi, contoh: Lahat, 12 Mei 2010.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak dikenali.',
        ];
    }
}