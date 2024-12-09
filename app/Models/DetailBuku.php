<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBuku extends Model
{
    use HasFactory;

    protected $guarded = ['id_detail_buku'];
    protected $primaryKey = 'id_detail_buku';
    protected $table = 'detail_buku';

    public function buku(){
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function quiz(){
        return $this->hasMany(Quiz::class, 'id_detail_buku', 'id_detail_buku');
    }
}
