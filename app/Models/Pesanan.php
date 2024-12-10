<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Pesanan extends Model
{
    use HasFactory;

    // Specify the associated table name
    protected $table = 'pesanans'; 

    // Specify the fields that can be mass-assigned
    protected $fillable = [
        'id_pelanggan',
        'id_barber',
        'tanggal_pesanan',
        'nama_pemesan',
        'total_harga',
        'layanan_ambil',
        'kode_booking',
    ];    

    // Specify the fields that should be cast to specific types
    protected $casts = [
        'tanggal_pesanan' => 'datetime', // Automatically cast to a Carbon instance
    ];

    // Add relationships if needed
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class, 'id_barber');
    }
}