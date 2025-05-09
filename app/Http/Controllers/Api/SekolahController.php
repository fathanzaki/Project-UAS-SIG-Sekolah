<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Sekolah::all()
        ]);
    }

    public function store(Request $request)
    {
        $sekolah = Sekolah::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'jenis_sekolah' => $request->jenis_sekolah,
            'status_sekolah' => $request->status_sekolah,
            'akreditasi' => $request->akreditasi,
            'website' => $request->website,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return response()->json([
            'message' => 'Sekolah berhasil ditambahkan',
            'data' => $sekolah
        ], 201);
    }

    public function show(Sekolah $sekolah)
    {
        return response()->json([
            'data' => $sekolah
        ]);
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string|max:20',
            'jenis_sekolah' => 'required|string',
            'status_sekolah' => 'nullable|string',
            'akreditasi' => 'nullable|string',
            'website' => 'nullable|url',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);
    
        $sekolah->update($validated);
    
        return response()->json([
            'message' => 'Sekolah berhasil diupdate',
            'data' => $sekolah
        ]);
    }
    

    public function destroy(Sekolah $sekolah)
    {
        $sekolah->delete();

        return response()->json([
            'message' => 'Sekolah deleted'
        ], 204);
    }
}
