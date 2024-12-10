<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanans = Pesanan::with(['pelanggan', 'barber'])->get(); // Eager load relationships if defined
        return response()->json($pesanans, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'id_barber' => 'required|exists:barbers,id',
            'tanggal_pesanan' => 'required|date',
            'nama_pemesan' => 'required|string',
            'total_harga' => 'required|int',
            'layanan_ambil' => 'required|string',
            'kode_booking' => 'required|string|unique:pesanans,kode_booking',
        ]);

        try {
            $pesanan = Pesanan::create([
                'id_pelanggan' => $request->id_pelanggan,
                'id_barber' => $request->id_barber,
                'tanggal_pesanan' => $request->tanggal_pesanan,
                'nama_pemesan' => $request->nama_pemesan,
                'total_harga' => $request->total_harga,
                'layanan_ambil' => $request->layanan_ambil,
                'kode_booking' => $request->kode_booking,
            ]);

            return response()->json([
                'message' => 'Pesanan berhasil dibuat',
                'data' => $pesanan,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat pesanan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'barber'])->findOrFail($id); // Eager load relationships
        return response()->json($pesanan, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $validated = $request->validate([
            'id_pelanggan' => 'nullable|integer|exists:pelanggans,id', // Optional updates
            'id_barber' => 'nullable|integer|exists:barbers,id',
            'tanggal_pesanan' => 'nullable|date',
            'status' => 'nullable|string|max:255',
        ]);

        $pesanan->update($validated);

        return response()->json([
            'message' => 'Pesanan updated successfully',
            'data' => $pesanan
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return response()->json(['message' => 'Pesanan deleted successfully'], 200);
    }

    public function transactionHistory()
    {
        $user = Auth::user(); // Ambil user yang sedang login

        $transactions = DB::table('pesanans')
            ->where('id_pelanggan', $user->id)
            ->select('tanggal_pesanan as date', 'layanan_ambil as service', 'total_harga as price')
            ->orderBy('tanggal_pesanan', 'desc')
            ->get();

        return response()->json(['transactions' => $transactions], 200);
    }


}