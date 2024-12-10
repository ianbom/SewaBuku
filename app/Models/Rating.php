<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $guarded = ['id_rating'];
    protected $primaryKey = 'id_rating';
    protected $table = 'rating';

    public function order(){
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function buku(){
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id', 'id'); 
    }
}
