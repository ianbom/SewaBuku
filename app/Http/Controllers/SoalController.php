<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SoalController extends Controller
{
    public function create($id){
        $quiz = Quiz::findOrFail($id);
        return view('sewa_buku.admin.quiz.soal.create_soal', ['quiz' => $quiz]);
    }

    public function edit($id){
        $soal = Soal::findOrFail($id);
        return view('sewa_buku.admin.quiz.soal.edit_soal', ['soal' => $soal]);
    }

    public function update(Request $request, $id){
        try {
            $request->validate([
                'soal' => 'required',
                'image' => 'nullable',
            ]);
            $soal = Soal::findOrFail($id);

            $data = $request->all();

                if ($request->hasFile('image')) {
                    if ($soal->image) {
                        Storage::disk('public')->delete($soal->image);
                    }
                    $path = $request->file('image')->store('soal', 'public');
                    $data['image'] = $path;
                }


            $soal->update($data);
            return response()->json(['success' => $data]);
        } catch (\Throwable $th) {
           return response()->json(['error' => $th->getMessage()]);
        }


    }

    public function store(Request $request){


        $request->validate([
            'id_quiz' => 'required',
            'soal' => 'required',
            'image' => 'nullable',
        ]);

        try {

            $data = $request->except('image');
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('soal', 'public');
                $data['image'] = $path;
            }

            Soal::create($data);

            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['err' => $th->getMessage()]);
        }
    }

    public function destroy($id){
        $soal = Soal::findOrFail($id);
        $soal->delete();

        return response()->json(['success' => 'Soal berhasil dihapus']);

    }
}
