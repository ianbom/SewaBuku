<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';
    protected $primaryKey = 'id_soal';
    protected $guarded = ['id_soal'];

    public function quiz(){
        return $this->belongsTo(Quiz::class, 'id_quiz', 'id_quiz');
    }

    public function opsi(){
        return $this->hasMany(Opsi::class, 'id_soal', 'id_soal');
    }
}
