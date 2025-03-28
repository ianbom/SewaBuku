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
    protected $fillable = [
        'name',
        'email',
        'password',      // Optional, depending on your approach
        'google_id',     // For storing the Google OAuth ID
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

    public function hasRole($string)
    {
        return false;
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

    public function diselesaikan(){
        return $this->hasMany(Diselesaikan::class, 'id', 'id');
    }

    public function report(){
        return $this->hasMany(Report::class, 'id', 'id');
    }


}
