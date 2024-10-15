<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverBuku extends Model
{
    use HasFactory;

    protected $guarded = ['id_cover_buku'];
    protected $primaryKey = 'id_cover_buku';
    protected $table = 'cover_buku';

    public function buku(){
        return $this->belongsTo(CoverBuku::class, 'id_buku', 'id_buku');
    }
}
