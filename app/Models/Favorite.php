<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Bus;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = ['id_favorite'];
    protected $primaryKey = 'id_favorite';
    protected $table = 'favorite';

    public function user(){
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function buku(){
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}
