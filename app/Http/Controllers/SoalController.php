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

    public function update(Request $request, $id)
{
    try {
        $request->validate([
            'soal' => 'required',
            'image' => 'nullable|image',
            'opsi' => 'required|array',
            'is_correct' => 'required',
        ]);

        $soal = Soal::findOrFail($id);

        // Update soal dan gambar
        $data = $request->only(['soal']);
        if ($request->hasFile('image')) {
            if ($soal->image) {
                Storage::disk('public')->delete($soal->image);
            }
            $data['image'] = $request->file('image')->store('soal', 'public');
        }
        $soal->update($data);

        // Update opsi
        $existingOptions = $soal->opsi->pluck('id_opsi')->toArray();
        $updatedOptions = array_keys($request->opsi);

        // Hapus opsi yang tidak ada di input
        foreach (array_diff($existingOptions, $updatedOptions) as $deletedId) {
            $soal->opsi()->where('id_opsi', $deletedId)->delete();
        }

        // Update opsi yang ada
        foreach ($request->opsi as $id => $value) {
            if (is_numeric($id)) {
                $soal->opsi()->where('id_opsi', $id)->update([
                    'opsi' => $value,
                    'is_correct' => $id == $request->is_correct,
                ]);
            }
        }

        // Tambah opsi baru
        if (isset($request->opsi['new'])) {
            foreach ($request->opsi['new'] as $index => $newOption) {
                $soal->opsi()->create([
                    'opsi' => $newOption,
                    'is_correct' => "new_$index" == $request->is_correct,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Opsi is now available');
    } catch (\Throwable $th) {
        return response()->json(['error' => $th->getMessage()]);
    }
}


    public function store(Request $request)
{
    $request->validate([
        // 'id_quiz' => 'required|exists:quizzes,id_quiz',
        'soal' => 'required',
        'image' => 'nullable|image|max:2048',
        'opsi' => 'required|array|min:2', // Minimal dua opsi
        'opsi.*' => 'required|string',
        'is_correct' => 'required|integer|min:0|max:' . (count($request->opsi) - 1),
    ]);

    try {
        $data = $request->except('image', 'opsi', 'is_correct');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('soal', 'public');
            $data['image'] = $path;
        }

        $soal = Soal::create($data);

        foreach ($request->opsi as $index => $opsiJawaban) {
            $soal->opsi()->create([
                'opsi' => $opsiJawaban,
                'is_correct' => $index == $request->is_correct,
            ]);
        }

        return redirect()->route('quiz.show', $soal->quiz->id_detail_buku)->with('success', 'Soal berhasil ditambahkan.');
    } catch (\Throwable $th) {
        return back()->withErrors(['error' => $th->getMessage()]);
    }
}


    public function destroy($id){
        $soal = Soal::findOrFail($id);
        $soal->delete();

        return response()->json(['success' => 'Soal berhasil dihapus']);

    }
}
