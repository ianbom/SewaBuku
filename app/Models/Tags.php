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

    public function buku(){
        return $this->belongsToMany(Buku::class, 'buku_tags', 'id_tags', 'id_buku');
    }

    public function parent()
    {
        return $this->belongsTo(Tags::class, 'id_child', 'id_tags');
    }

    // Relasi untuk child tags
    public function child()
    {
        return $this->hasMany(Tags::class, 'id_child', 'id_tags');
    }
}
