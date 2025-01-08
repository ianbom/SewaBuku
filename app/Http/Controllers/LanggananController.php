<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailBuku;
use App\Models\Dibaca;
use App\Models\Diselesaikan;
use App\Models\Highlight;
use App\Models\Jawaban;
use App\Models\Langganan;
use App\Models\Quiz;
use App\Models\Soal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LanggananController extends Controller
{
    public function indexUser(){
        $user = Auth::user();
        $langganan = Langganan::where('id', $user->id)->get();
        foreach ($langganan as $lang) {
            if (Carbon::now()->greaterThan($lang->akhir_langganan)) {
                $lang->status_langganan = false;
                $lang->save();
            }
        }
        return view('sewa_buku.user.langganan.index_langganan', ['langganan' => $langganan, 'user'=> $user]);
    }

    public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Validasi input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Update nama dan email
    $user->name = $validated['name'];
    $user->email = $validated['email'];

    // Update password jika diisi
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    // Update foto jika ada file baru
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($user->foto) {
            Storage::delete('public/' . $user->foto);
        }

        // Simpan foto baru
        $path = $request->file('foto')->store('user_photos', 'public');
        $user->foto = $path;
    }

    // Simpan perubahan pada user
    $user->save();

    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
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
        $userId = Auth::id();
        $checkLangganan = Langganan::where('status_langganan', true)->where('id', $userId)->first();

        $terakhirDibaca = Dibaca::where('id', $userId)
        ->where('id_buku', $buku->id_buku)
        ->where('is_read', true)
        ->latest('updated_at')
        ->first();

        $diselesaikan = Diselesaikan::where('id', $userId)->pluck('id_detail_buku')->toArray();

        $babTerakhirDibaca = $terakhirDibaca ? $terakhirDibaca->id_detail_buku : null;

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

            if ($detailBuku->is_free_detail || $checkLangganan) {

                $detailBuku->can_read = true;
            } else {

                $detailBuku->can_read = false;
            }

        }

        return view('sewa_buku.user.buku.baca_buku', [
            'buku' => $buku,
            'quizStatus' => $quizStatus,
            'quizScores' => $quizScores,
            'checkLangganan' => $checkLangganan,
            'babTerakhirDibaca' => $babTerakhirDibaca,
            'diselesaikan' => $diselesaikan,
            'idBuku' => $buku->id_buku,
        ]);

    } catch (\Throwable $th) {
        return response()->json(['err' => $th->getMessage()]);
    }
}

public function bacaBabBuku($id)
{
    try {
        $user = Auth::user();
        $detailBuku = DetailBuku::findOrFail($id);

        Dibaca::where('id', $user->id)
            ->where('id_buku', $detailBuku->id_buku)
            ->update(['is_read' => false]);

        $dibaca = Dibaca::where('id', $user->id)
            ->where('id_detail_buku', $detailBuku->id_detail_buku)
            ->where('id_buku', $detailBuku->id_buku)
            ->first();

        if ($dibaca) {
            $dibaca->is_read = true;
            $dibaca->save();
        } else {
            Dibaca::create([
                'id' => $user->id,
                'id_detail_buku' => $detailBuku->id_detail_buku,
                'id_buku' => $detailBuku->id_buku,
                'is_read' => true,
            ]);
        }

        $diselesaikanCheck = Diselesaikan::where('id_buku', $detailBuku->id_buku)->where('id_detail_buku', $detailBuku->id_detail_buku)->first();
        // return response()->json(['status' => $diselesaikanCheck]);



        $quiz = Quiz::where('id_detail_buku', $detailBuku->id_detail_buku)->first();
        $quizStatus = null;
        $quizScore = null;

        if ($quiz) {
            $isAttempted = Jawaban::where('id_quiz', $quiz->id_quiz)
                ->where('id', $user->id)
                ->exists();

            if ($isAttempted) {
                $totalSoal = Soal::where('id_quiz', $quiz->id_quiz)->count();
                $benar = Jawaban::where('id_quiz', $quiz->id_quiz)
                    ->where('id', $user->id)
                    ->where('is_correct', true)
                    ->count();
                $quizScore = "{$benar}/{$totalSoal}";
            } else {
                $quizStatus = 'Quiz belum dikerjakan';
            }
        } else {
            $quizStatus = 'Quiz belum tersedia';
        }

        return view('sewa_buku.user.buku.baca_bab_buku', [
            'detailBuku' => $detailBuku,
            'quiz' => $quiz,
            'quizStatus' => $quizStatus,
            'quizScore' => $quizScore,
            'idBuku' => $detailBuku->id_buku,
            'diselesaikanCheck' => $diselesaikanCheck,
        ]);
    } catch (\Throwable $th) {
        return response()->json(['err' => $th->getMessage()]);
    }
}



    public function tandaiBabDiselesaikan($id){
        $userId = Auth::id();

        $detailBuku = DetailBuku::findOrFail($id);
        $buku = Buku::where('id_buku', $detailBuku->id_buku)->first();

            Diselesaikan::create([
                'id' => $userId,
                'id_buku' => $buku->id_buku,
                'id_detail_buku' => $detailBuku->id_detail_buku,
                'is_finished' => true
            ]);

        return redirect()->back()->with('success', 'Chapter mark as finished');
    }

    public function hapusTandaBabDiselesaikan($id){
        $userId = Auth::id();

        $detailBuku = DetailBuku::findOrFail($id);
        $diselesaikanCheck = Diselesaikan::where('id', $userId)->where('id_detail_buku', $detailBuku->id_detail_buku)->first();
        $diselesaikanCheck->delete();


        return redirect()->back()->with('success', 'Chapter mark as unfinished');
    }

    public function tandaiBukuDiselesaikan($id){
        $userId = Auth::id();

        $buku = Buku::findOrFail($id);

            Diselesaikan::create([
                'id' => $userId,
                'id_buku' => $buku->id_buku,
                'id_detail_buku' => null,
                'is_finished' => true
            ]);

        return redirect()->back()->with('success', 'Book mark as finished');
    }

    public function hapusTandaBukuDiselesaikan($id){
        $userId = Auth::id();

        $buku = Buku::findOrFail($id);
        $diselesaikanCheck = Diselesaikan::where('id', $userId)->where('id_buku', $buku->id_buku)->first();
        $diselesaikanCheck->delete();


        return redirect()->back()->with('success', 'Book mark as unfinished');
    }


    public function highlightText(Request $request){
        $userId = Auth::id();

        $highlight = Highlight::create([
            'id' => $userId,
            'id_buku' => $request->id_buku,
            'id_detail_buku' => $request->id_detail_buku,
            'highlight' => $request->highlight
        ]);

        return response()->json([
            'success' => true,
            'highlight' => $highlight
        ]);
    }





}
