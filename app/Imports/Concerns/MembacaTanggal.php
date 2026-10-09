<?php

namespace App\Imports\Concerns;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

trait MembacaTanggal
{
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
}