<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Langganan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanggananController extends Controller
{
    public function indexUser(){
        $userId = Auth::id();
        $langganan = Langganan::where('id', $userId)->get();
        foreach ($langganan as $lang) {
            if (Carbon::now()->greaterThan($lang->akhir_langganan)) {
                $lang->status_langganan = false;
                $lang->save();
            }
        }
        return view('sewa_buku.user.langganan.index_langganan', ['langganan' => $langganan]);
    }

    public function showUser($id){
        $userId = Auth::id();
        $langganan = Langganan::where('id', $userId)->findOrFail($id);
        return view('sewa_buku.user.langganan.show_langganan', ['langganan' => $langganan]);
    }

    public function bacaBuku($id){
        try {
        $buku = Buku::with('detailBuku')->findOrFail($id);
        //return response()->json(['buku' => $buku]);
        return view('sewa_buku.user.buku.baca_buku', ['buku' => $buku]);
        } catch (\Throwable $th) {
           return response()->json(['err' => $th->getMessage()]);
        }

    }
}
