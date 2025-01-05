<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTags extends Model
{
    use HasFactory;

    protected $guarded = ['id_buku_tags'];
    protected $primaryKey = 'id_buku_tags';
    protected $table = 'buku_tags';

    public function buku(){
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function tags(){
        return $this->belongsTo(Tags::class, 'id_tags', 'id_tags');
    }

}
