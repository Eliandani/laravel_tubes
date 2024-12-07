<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    use HasFactory;

    protected $table = 'barbers';

    protected $fillable = [
        'nama_barber',    
        'kontak_barber',  
    ];

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'id_barber');
    }
}
