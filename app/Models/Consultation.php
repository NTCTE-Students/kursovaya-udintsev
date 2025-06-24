<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'user_id',
        'consultant_id',
        'scheduled_at',
        'status',
        'duration',
        'notes',
        'topic_id',
    ];

    protected $dates = ['scheduled_at'];

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function payments()
{
    return $this->hasMany(\App\Models\Payment::class);
}

public function topic()
{
    return $this->belongsTo(Topic::class);
}


}
