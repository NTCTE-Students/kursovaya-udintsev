<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['consultant_id', 'title'];

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }
}
