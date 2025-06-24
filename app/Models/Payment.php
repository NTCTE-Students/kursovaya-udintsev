<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'consultation_id',
        'amount',
        'method',
        'status',
        'paid_at',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
