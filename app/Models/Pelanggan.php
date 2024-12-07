<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; 
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelanggan extends Authenticatable
{
    use HasFactory, HasApiTokens;  
    public $timestamps = false;
    protected $table = "pelanggans";
    protected $primaryKey = "id";

    protected $fillable = ['nama', 'username', 'email', 'telepon', 'password'];
}

