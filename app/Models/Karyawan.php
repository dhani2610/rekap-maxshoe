<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Karyawan extends Model
{
    protected $fillable = [
        'nama','nomor_hp','posisi','status_karyawan',
        'lama_kontrak','status','foto'
    ];

    public function getSisaKontrakAttribute()
    {
        $start = $this->created_at ?? now();
        $end = match($this->lama_kontrak) {
            '2 Minggu' => $start->copy()->addWeeks(2),
            '6 Bulan' => $start->copy()->addMonths(6),
            '12 Bulan' => $start->copy()->addMonths(12),
            default => $start
        };

        if (now()->greaterThan($end)) {
            return 'Habis';
        }

        return $end->diff(now())->format('%m bulan - %d hari');
    }
}
