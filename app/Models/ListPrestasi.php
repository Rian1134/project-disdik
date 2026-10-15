<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListPrestasi extends Model
{
    protected $fillable = [
        'jenis',
        'prestasi',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
