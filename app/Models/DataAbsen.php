<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAbsen extends Model
{
    use Uuid;
    use HasFactory;

    public $incrementing = false;
    protected $table = 'absen_umat';

    protected $fillable = ['pendaftaran_id', 'user_id'];

    protected $dates = [];

    protected $appends = [
        'wilayah',
        'jadwal',
    ];

    /**
     * Get the pendaftaran that owns the DataAbsen
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id');
    }

    /**
     * Get the user that owns the DataAbsen
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getWilayahAttribute()
    {
        if ($this->pendaftaran->dataUmat) {
            return $this->pendaftaran->dataUmat->wilayah;
        }
        return null;
    }

    public function getJadwalAttribute()
    {
        if ($this->pendaftaran->jadwal) {
            return 'Misa ' . $this->pendaftaran->jadwal->tanggal->isoFormat('dddd, D MMMM Y');
        }
        return null;
    }
}
