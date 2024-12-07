<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return response()->json($pelanggans);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:pelanggans,username|max:255',
            'email' => 'required|email|unique:pelanggans,email|max:255',
            'telepon' => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'Pelanggan berhasil dibuat', 'data' => $pelanggan], 201);
    }

    public function show(Pelanggan $pelanggan)
    {
        return response()->json($pelanggan);
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|unique:pelanggans,username,' . $pelanggan->id . '|max:255',
            'email' => 'sometimes|required|email|unique:pelanggans,email,' . $pelanggan->id . '|max:255',
            'telepon' => 'sometimes|required|string|max:15',
            'password' => 'sometimes|required|string|min:6',
        ]);

        $pelanggan->update([
            'nama' => $request->nama ?? $pelanggan->nama,
            'username' => $request->username ?? $pelanggan->username,
            'email' => $request->email ?? $pelanggan->email,
            'telepon' => $request->telepon ?? $pelanggan->telepon,
            'password' => $request->password ? bcrypt($request->password) : $pelanggan->password,
        ]);

        return response()->json(['message' => 'Pelanggan berhasil diperbarui', 'data' => $pelanggan]);
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return response()->json(['message' => 'Pelanggan berhasil dihapus']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $pelanggan = Pelanggan::where('username', $request->username)->first();

        if (!$pelanggan || !Hash::check($request->password, $pelanggan->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $pelanggan->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'detail' => $pelanggan,
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            $user->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['message' => 'Not logged in'], 401);
    }
}
