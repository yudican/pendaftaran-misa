<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUmat extends Model
{
    use Uuid;
    use HasFactory;

    public $incrementing = false;
    protected $table = 'data_umat';

    protected $fillable = ['nama_lengkap', 'tanggal_lahir', 'alamat', 'linkungan', 'wilayah', 'telepon', 'user_id'];

    protected $dates = ['tanggal_lahir'];

    /**
     * Get the user that owns the DataUmat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
