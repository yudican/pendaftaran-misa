<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use Uuid;
    use HasFactory;

    public $incrementing = false;

    protected $table = 'pendaftaran';

    protected $fillable = ['status', 'alasan', 'jadwal_id', 'user_id', 'status_kesehatan_id', 'parent_id'];

    protected $dates = [];

    /**
     * Get the user that owns the Pendaftaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the jadwal that owns the Pendaftaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id');
    }

    /**
     * Get the statusKesehatan associated with the Pendaftaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function statusKesehatan()
    {
        return $this->hasOne(StatusKesehatan::class);
    }

    /**
     * Get the dataUmat that owns the Pendaftaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataUmat()
    {
        return $this->belongsTo(DataUmat::class, 'user_id', 'id');
    }

    /**
     * Get all of the dataAbsens for the Pendaftaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataAbsens()
    {
        return $this->hasMany(DataAbsen::class);
    }
}
