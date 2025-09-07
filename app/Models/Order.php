<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    protected $guarded = [];

        public function host()
    {
        return $this->belongsTo(Karyawan::class, 'host_id');
    }

    // Relasi ke Karyawan (co-host)
    public function coHost()
    {
        return $this->belongsTo(Karyawan::class, 'co_host_id');
    }

    // Relasi ke Admin (CS)
    public function cs()
    {
        return $this->belongsTo(Karyawan::class, 'cs_id');
    }

    // Relasi ke detail order

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
