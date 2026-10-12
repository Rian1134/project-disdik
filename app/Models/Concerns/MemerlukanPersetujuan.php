<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Persetujuan admin untuk siswa hasil import (tambah & hapus).
 *
 * Model yang memakai trait ini wajib punya konstanta:
 *   STATUS_MENUNGGU, STATUS_DISETUJUI, SUMBER_MANUAL, SUMBER_IMPORT
 */
trait MemerlukanPersetujuan
{
    /** Otomatis ikut mass-assignment & casting tanpa mengubah $fillable/$casts model. */
    public function initializeMemerlukanPersetujuan(): void
    {
        $this->mergeFillable(['status_persetujuan', 'sumber', 'hapus_diajukan_pada']);
        $this->mergeCasts(['hapus_diajukan_pada' => 'datetime']);
    }

    /** Siswa yang sudah masuk daftar. */
    #[Scope]
    protected function disetujui(Builder $query): void
    {
        $query->where('status_persetujuan', static::STATUS_DISETUJUI);
    }

    /** Siswa import yang menunggu persetujuan masuk daftar. */
    #[Scope]
    protected function menungguTambah(Builder $query): void
    {
        $query->where('status_persetujuan', static::STATUS_MENUNGGU);
    }

    /** Siswa di daftar yang pengajuan hapusnya menunggu admin. */
    #[Scope]
    protected function menungguHapus(Builder $query): void
    {
        $query->where('status_persetujuan', static::STATUS_DISETUJUI)
            ->whereNotNull('hapus_diajukan_pada');
    }

    public function isDariImport(): bool
    {
        return $this->sumber === static::SUMBER_IMPORT;
    }

    public function isMenungguTambah(): bool
    {
        return $this->status_persetujuan === static::STATUS_MENUNGGU;
    }

    public function isMenungguHapus(): bool
    {
        return $this->status_persetujuan === static::STATUS_DISETUJUI
            && $this->hapus_diajukan_pada !== null;
    }
}
