<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKesehatan extends Model
{
    use Uuid;
    use HasFactory;

    public $incrementing = false;

    protected $table = 'status_kesehatan';

    protected $fillable = ['status_kesehatan'];

    protected $dates = [];

    /**
     * Get the pendaftaran that owns the StatusKesehatan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
