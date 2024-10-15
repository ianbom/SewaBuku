<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = ['id_payment'];
    protected $primaryKey = 'id_payment';
    protected $table = 'payment';

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }


}
