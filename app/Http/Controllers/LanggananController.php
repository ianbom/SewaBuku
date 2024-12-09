<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailBuku;
use App\Models\Jawaban;
use App\Models\Langganan;
use App\Models\Quiz;
use App\Models\Soal;
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

    public function bacaBuku($id)
{
    try {
        $buku = Buku::with('detailBuku')->findOrFail($id);

        $quizStatus = [];
        $quizScores = [];
        $userId = Auth::id();
        foreach ($buku->detailBuku as $detailBuku) {
            $quiz = Quiz::where('id_detail_buku', $detailBuku->id_detail_buku)->first();

            if ($quiz) {
                
                $isAttempted = Jawaban::where('id_quiz', $quiz->id_quiz)
                    ->where('id', $userId)
                    ->exists();

                $quizStatus[$detailBuku->id_detail_buku] = $isAttempted;

                if ($isAttempted) {
                    $totalSoal = Soal::where('id_quiz', $quiz->id_quiz)->count();
                    $benar = Jawaban::where('id_quiz', $quiz->id_quiz)
                        ->where('id', $userId)
                        ->where('is_correct', true)
                        ->count();
                    $quizScores[$detailBuku->id_detail_buku] = "{$benar}/{$totalSoal}";
                } else {
                    $quizScores[$detailBuku->id_detail_buku] = null;
                }
            } else {
                $quizStatus[$detailBuku->id_detail_buku] = false;
                $quizScores[$detailBuku->id_detail_buku] = null;
            }
        }

        return view('sewa_buku.user.buku.baca_buku', [
            'buku' => $buku,
            'quizStatus' => $quizStatus,
            'quizScores' => $quizScores,
        ]);

    } catch (\Throwable $th) {
        return response()->json(['err' => $th->getMessage()]);
    }
}



}
