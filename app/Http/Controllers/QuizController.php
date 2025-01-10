<?php

namespace App\Http\Controllers;

use App\Models\DetailBuku;
use App\Models\Jawaban;
use App\Models\Langganan;
use App\Models\Opsi;
use App\Models\Quiz;
use App\Models\Soal;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class QuizController extends Controller
{
    public function create($id){
        $detailBuku = DetailBuku::findOrFail($id);
        return view('sewa_buku.admin.quiz.create_quiz', ['detailBuku' => $detailBuku]);
    }

    public function edit($id){
        $quiz = Quiz::findOrFail($id);
        return view('sewa_buku.admin.quiz.edit_quiz', ['quiz' => $quiz]);
    }

    public function update(Request $request, $id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            $request->validate([
                'nama_quiz' => 'required',
                'deskripsi' => 'nullable|string',
                'file' => 'nullable|file',
            ]);

            $data = $request->except(['file']);

            if ($request->hasFile('file')) {

                if ($quiz->file) {
                    Storage::disk('public')->delete($quiz->file);
                }

                $path = $request->file('file')->store('quiz', 'public');
                $data['file'] = $path;
            }

            $quiz->update($data);

            return redirect()->back()->with('success', 'Quiz has been updated successfully');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => $th->getMessage()]);
        }

    }

    public function show($id){
        $detailBuku = DetailBuku::findOrFail($id);
        $quiz = Quiz::where('id_detail_buku', $detailBuku->id_detail_buku)->first();
        $soal = Soal::where('id_quiz', $quiz->id_quiz)->get();
       // return response()->json($quiz);
        return view('sewa_buku.admin.quiz.show_quiz', ['quiz' => $quiz, 'soal' => $soal]);
    }

    public function store(Request $request){
        $request->validate([
            'id_detail_buku' => 'required',
            'nama_quiz' => 'required',
            'deskripsi' => 'nullable',
            'file' => 'nullable',
        ]);

        try {
            $data = $request->except('file');
            if($request->hasFile('file')){
                $path = $request->file('file')->store('quiz', 'public');
                $data['file'] = $path;
            }

            $quiz = Quiz::create($data);

            return redirect()->route('soal.create', $quiz->id_quiz)->with('success', 'Quiz created successfully');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function destroy($id){
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return response()->json(['success' => 'Quiz berhasil dihapus']);
    }

    public function kerjakanQuiz($id){
        $detailBuku = DetailBuku::findOrFail($id);
        $quiz = Quiz::where('id_detail_buku', $detailBuku->id_detail_buku)->first();
        $soal = Soal::where('id_quiz', $quiz->id_quiz)->get();
        $user = Auth::user();
        $checkLangganan = Langganan::where('status_langganan', true)->where('id', $user->id)->exists();
        // return response()->json(['idBuku' => $detailBuku->id_buku]);

        return view('sewa_buku.user.buku.quiz.kerjakan_quiz', ['quiz' => $quiz, 'soal' => $soal, 'idBuku' => $detailBuku->id_buku, 'checkLangganan' => $checkLangganan]);
    }

    public function submitQuiz(Request $request, $id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            $jawabanUser = $request->input('jawaban', []);
            $userId = Auth::id();

            $request->validate([
                'jawaban' => 'required|array',
            ]);

            foreach ($jawabanUser as $idSoal => $idOpsi) {
                $opsi = Opsi::where('id_opsi', $idOpsi)->first();


                $jawaban = Jawaban::where('id_quiz', $quiz->id_quiz)
                    ->where('id_soal', $idSoal)
                    ->where('id', $userId)
                    ->first();

                if ($jawaban) {

                    $jawaban->id_opsi = $idOpsi;
                    $jawaban->is_correct = $opsi->is_correct ?? false;
                    $jawaban->save();
                } else {

                    Jawaban::create([
                        'id_quiz' => $quiz->id_quiz,
                        'id_soal' => $idSoal,
                        'id_opsi' => $idOpsi,
                        'id' => $userId,
                        'is_correct' => $opsi->is_correct ?? false,
                    ]);
                }
            }

           return redirect()->route('user.buku.bacaBab', $quiz->id_detail_buku)->with('success', 'Jawaban kamu telah direkam');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }



}
