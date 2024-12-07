<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::all();
        return response()->json($transaksis);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'total_harga' => 'required|numeric',
        ]);

        $transaksi = Transaksi::create($validated);

        return response()->json($transaksi, 201);
    }

    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return response()->json($transaksi);
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $validated = $request->validate([
            'total_harga' => 'required|numeric',
        ]);

        $transaksi->update($validated);

        return response()->json($transaksi);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return response()->json(['message' => 'Transaksi deleted successfully']);
    }
}
