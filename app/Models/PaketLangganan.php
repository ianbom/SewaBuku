<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketLangganan extends Model
{
    use HasFactory;

    protected $guarded = ['id_paket_langganan'];
    protected $primaryKey = 'id_paket_langganan';
    protected $table = 'paket_langganan';

    public function langganan(){
        return $this->hasMany(Langganan::class, 'id_paket_langganan', 'id_paket_langganan');
    }

    public function order(){
        return $this->hasMany(Order::class, 'id_paket_langganan', 'id_paket_langganan');
    }
}
