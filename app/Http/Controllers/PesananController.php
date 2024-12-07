<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::all();
        return response()->json($pesanans);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_pesanan' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $pesanan = Pesanan::create($validated);

        return response()->json($pesanan, 201);
    }

    public function show($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return response()->json($pesanan);
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $validated = $request->validate([
            'tanggal_pesanan' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $pesanan->update($validated);

        return response()->json($pesanan);
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return response()->json(['message' => 'Pesanan deleted successfully']);
    }
}
