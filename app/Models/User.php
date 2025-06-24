<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'description',
    'photo',
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function consultationsAsClient()
{
    return $this->hasMany(Consultation::class, 'user_id');
}

public function consultationsAsConsultant()
{
    return $this->hasMany(Consultation::class, 'consultant_id');
}

 public function consultations()
    {
        return $this->hasMany(\App\Models\Consultation::class, 'consultant_id');
    }

    public function consultant()
{
    return $this->belongsTo(User::class, 'consultant_id');
}


    public function topics()
{
    return $this->hasMany(\App\Models\Topic::class, 'consultant_id');
}

public function services()
{
    return $this->belongsToMany(Service::class);
}

public function topic()
{
    return $this->belongsTo(Topic::class, 'topic_id');
}

}
