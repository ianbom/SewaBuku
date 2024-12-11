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
     * @var array<int, string>
     */
    protected $guarded = [
       'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function bukuLangganan()
    {
        return $this->belongsToMany(Buku::class, 'langganan', 'id', 'id_buku')
                    ->withPivot('status_langganan', 'mulai_langganan', 'akhir_langganan')
                    ->withTimestamps();
    }

    public function order(){
        return $this->hasMany(Order::class, 'id', 'id');
    }

    public function favorite(){
        return $this->hasMany(Favorite::class, 'id', 'id');
    }

    public function rating(){
        return $this->hasMany(Rating::class, 'id', 'id');
    }

    public function dibaca(){
        return $this->hasMany(Dibaca::class, 'id', 'id');
    }


}
