<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use Illuminate\Http\Request;

class BarberController extends Controller
{
    public function index()
    {
        $barbers = Barber::all();
        return response()->json($barbers);
    }

    public function show($id)
    {
        $barber = Barber::find($id);

        if (!$barber) {
            return response()->json(['message' => 'Barber not found'], 404);
        }

        return response()->json($barber);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barber' => 'required|string|max:255',
            'kontak_barber' => 'required|string|max:15',
        ]);

        $barber = Barber::create($request->all());

        return response()->json($barber, 201);
    }

    public function update(Request $request, $id)
    {
        $barber = Barber::find($id);

        if (!$barber) {
            return response()->json(['message' => 'Barber not found'], 404);
        }

        $request->validate([
            'nama_barber' => 'required|string|max:255',
            'kontak_barber' => 'required|string|max:15',
        ]);

        $barber->update($request->all());

        return response()->json($barber);
    }

    public function destroy($id)
    {
        $barber = Barber::find($id);

        if (!$barber) {
            return response()->json(['message' => 'Barber not found'], 404);
        }

        $barber->delete();

        return response()->json(['message' => 'Barber deleted successfully']);
    }
}
