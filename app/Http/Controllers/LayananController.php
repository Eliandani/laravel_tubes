<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::all();
        return response()->json($layanan);
    }

    public function show($id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json(['message' => 'Layanan not found'], 404);
        }

        return response()->json($layanan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required|string|max:255',
            'tarif' => 'required|numeric',
            'deskripsi_layanan' => 'required|string|max:500',
            'id_barber' => 'required|exists:barbers,id',
        ]);

        $layanan = Layanan::create([
            'jenis_layanan' => $request->jenis_layanan,
            'tarif' => $request->tarif,
            'deskripsi_layanan' => $request->deskripsi_layanan,
            'id_barber' => $request->id_barber,
        ]);

        return response()->json($layanan, 201);
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json(['message' => 'Layanan not found'], 404);
        }

        $request->validate([
            'jenis_layanan' => 'required|string|max:255',
            'tarif' => 'required|numeric',
            'deskripsi_layanan' => 'required|string|max:500',
            'id_barber' => 'required',
        ]);

        $layanan->update($request->all());

        return response()->json($layanan);
    }

    public function destroy($id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json(['message' => 'Layanan not found'], 404);
        }

        $layanan->delete();

        return response()->json(['message' => 'Layanan deleted successfully']);
    }
}
