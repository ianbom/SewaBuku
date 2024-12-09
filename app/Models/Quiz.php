<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';
    protected $primaryKey = 'id_quiz';
    protected $guarded = ['id_quiz'];

    public function detailBuku(){
        return $this->belongsTo(DetailBuku::class, 'id_detail_buku', 'id_detail_buku');
    }

    public function soal(){
        return $this->hasMany(Soal::class, 'id_quiz', 'id_quiz');
    }
}
