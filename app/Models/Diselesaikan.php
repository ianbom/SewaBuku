<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diselesaikan extends Model
{
    protected $guarded = ['id_diselesaikan'];
    protected $primaryKey = 'id_diselesaikan';
    protected $table = 'diselesaikan';

    public function detailBuku(){
        return $this->belongsTo(DetailBuku::class, 'id_detail_buku', 'id_detail_buku');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function buku(){
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}
