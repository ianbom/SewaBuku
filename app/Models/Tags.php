<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    protected $guarded = ['id_tags'];
    protected $primaryKey = 'id_tags';
    protected $table = 'tags';

    public function bukuTags(){
        return $this->belongsToMany(Buku::class, 'buku_tags', 'id_tags', 'id_buku');
    }
}
