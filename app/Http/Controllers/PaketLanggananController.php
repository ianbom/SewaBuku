<?php

namespace App\Http\Controllers;

use App\Models\PaketLangganan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaketLanggananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $paketLangganan = PaketLangganan::get();
            return view('sewa_buku.admin.paket_langganan.index_paket_langganan', ['paketLangganan' => $paketLangganan]);
    }

    public function indexUser(){
        $paketLangganan = PaketLangganan::where('is_active', true)->get();
        return view('sewa_buku.user.paket_langganan.index_paket_langganan', ['paketLangganan' => $paketLangganan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sewa_buku.admin.paket_langganan.create_paket_langganan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_paket' => 'required|string',
                'harga' => 'required|numeric',
                'masa_waktu' => 'required|integer',
                'deskripsi' => 'required|string',
                'is_active' => 'nullable|boolean'
            ]);

            $data = $request->all();

            PaketLangganan::create($data);
            return response()->json(['data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paketLangganan = PaketLangganan::findOrFail($id);
        return view('sewa_buku.user.paket_langganan.show_paket_langganan', ['paketLangganan' => $paketLangganan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paketLangganan = PaketLangganan::findOrFail($id);
        return view('sewa_buku.admin.paket_langganan.edit_paket_langganan', ['paketLangganan' => $paketLangganan]);
    }

    public function update(Request $request, string $id)
    {
        $paketLangganan = PaketLangganan::findOrFail($id);
        try {
            $request->validate([
                'nama_paket' => 'nullable|string',
                'harga' => 'nullable|numeric',
                'masa_waktu' => 'nullable|integer',
                'deskripsi' => 'nullable|string',
                'is_active' => 'nullable|boolean'
            ]);

            $data = $request->all();

            $paketLangganan->update($data);

            return response()->json(['data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paketLangganan = PaketLangganan::findOrFail($id);
        $paketLangganan->delete();
        return response()->json(['success' => 'Paket Langganan berhasil dihapus']);
    }
}
