<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Barber;
use App\Models\Pelanggan;
use App\Models\Layanan;

class ReviewController extends Controller
{
    public function getReviewsByBarber($barber_id) {
        $reviews = Review::where('id_barber', $barber_id)
            ->with(['pelanggan', 'layanan']) 
            ->get();
    
        if ($reviews->isEmpty()) {
            return response()->json([], 200); 
        }
    
        return response()->json($reviews, 200);
    }
    
}

