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
}
