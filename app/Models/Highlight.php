<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasFactory;

    protected $guarded = ['id_highlight'];
    protected $primaryKey = 'id_highlight';
    protected $table = 'highlight';
}
