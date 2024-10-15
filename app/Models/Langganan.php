<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langganan extends Model
{
    use HasFactory;

    protected $guarded = ['id_langganan'];
    protected $primaryKey = 'id_langganan';
    protected $table = 'langganan';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function getStatusLanggananAttribute($value)
    {
        if (Carbon::now()->greaterThan($this->akhir_langganan)) {
            $this->status_langganan = false;
            $this->save();
        }
        return $this->attributes['status_langganan'];
    }
}
