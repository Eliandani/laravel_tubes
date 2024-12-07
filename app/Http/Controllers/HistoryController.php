<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::all();
        return response()->json($histories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ID_pengguna' => 'required|exists:users,id',
            'ID_pesanan' => 'required|exists:pesanans,ID_pesanan',
        ]);

        $history = History::create($validated);

        return response()->json($history, 201);
    }

    public function show($id)
    {
        $history = History::findOrFail($id);
        return response()->json($history);
    }

    public function update(Request $request, $id)
    {
        $history = History::findOrFail($id);

        $validated = $request->validate([
            'ID_pengguna' => 'required|exists:users,id',
            'ID_pesanan' => 'required|exists:pesanans,ID_pesanan',
        ]);

        $history->update($validated);

        return response()->json($history);
    }

    public function destroy($id)
    {
        $history = History::findOrFail($id);
        $history->delete();

        return response()->json(['message' => 'History deleted successfully']);
    }
}
