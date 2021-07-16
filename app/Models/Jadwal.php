<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use Uuid;
    use HasFactory;

    public $incrementing = false;

    protected $table = 'jadwal';

    protected $fillable = ['tanggal', 'waktu', 'kuota_tersedia'];

    protected $dates = ['tanggal'];

    /**
     * Get all of the pendaftarans for the Jadwal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'jadwal_id', 'id');
    }
}
