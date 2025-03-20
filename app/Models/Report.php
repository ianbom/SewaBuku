<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = ['id_report'];
    protected $primaryKey = 'id_report';
    protected $table = 'report';

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
