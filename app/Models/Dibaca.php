<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dibaca extends Model
{
    use HasFactory;

    protected $guarded = ['id_dibaca'];
    protected $primaryKey = 'id_dibaca';
    protected $table = 'dibaca';

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
