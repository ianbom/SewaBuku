<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id_order'];
    protected $primaryKey = 'id_order';
    protected $table = 'order';

    public function user(){
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function buku(){
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id_order', 'id_order');
    }

    public function rating(){
        return $this->hasOne(Rating::class, 'id_order', 'id_order');
    }
}
