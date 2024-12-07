<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan'; 
    protected $fillable = ['jenis_layanan', 'tarif', 'deskripsi_layanan', 'id_barber'];

    public function barber()
    {
        return $this->belongsTo(Barber::class, 'id_barber');
    }
}

