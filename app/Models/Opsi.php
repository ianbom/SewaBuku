<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opsi extends Model
{
    use HasFactory;

    protected $table = 'opsi';
    protected $primaryKey = 'id_opsi';
    protected $guarded = ['id_opsi'];

    public function soal(){
        return $this->belongsTo(Soal::class, 'id_soal', 'id_soal');
    }

    public function jawaban(){
        return $this->hasOne(Jawaban::class, 'id_opsi', 'id_opsi');
    }
}
