<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $guarded = ['id_buku'];
    protected $primaryKey = 'id_buku';
    protected $table = 'buku';

    public function detailBuku()
    {
        return $this->hasMany(DetailBuku::class, 'id_buku', 'id_buku');
    }


    public function userLangganan()
    {
        return $this->belongsToMany(User::class, 'langganan', 'id_buku', 'id')
            ->withPivot('status_langganan', 'mulai_langganan', 'akhir_langganan')
            ->withTimestamps();
    }

    public function coverBuku()
    {
        return $this->hasMany(CoverBuku::class, 'id_buku', 'id_buku');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'id_buku', 'id_buku');
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class, 'id_buku', 'id_buku');
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'buku_tags', 'id_buku', 'id_tags');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'id_buku', 'id_buku');
    }

    public function dibaca()
    {
        return $this->hasMany(Dibaca::class, 'id_buku', 'id_buku');
    }

    public function diselesaikan()
    {
        return $this->hasMany(Diselesaikan::class, 'id_buku', 'id_buku');
    }

    public function quizzes()
    {
        return $this->hasManyThrough(Quiz::class, DetailBuku::class, 'id_buku', 'id_detail_buku', 'id_buku', 'id_detail_buku');
    }

    public function highlight()
    {
        return $this->hasMany(Highlight::class, 'id_buku', 'id_buku');
    }
}
