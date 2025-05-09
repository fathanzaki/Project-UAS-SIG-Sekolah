<?php
namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahWebController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'jenis_sekolah' => 'required|string',
            'status_sekolah' => 'required|string',
            'akreditasi' => 'nullable|string',
            'website' => 'nullable|url',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Sekolah::create($validated);

        return redirect()->back()->with('message', 'Data sekolah berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

        $request->validate([
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

        $sekolah->update($request->all());

        return redirect()->route('master')->with('message', 'Sekolah berhasil diupdate');
    }

}
