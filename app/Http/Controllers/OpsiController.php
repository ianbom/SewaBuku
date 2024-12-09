<?php

namespace App\Http\Controllers;

use App\Models\Opsi;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OpsiController extends Controller
{
    public function create($id){
        $soal = Soal::findOrFail($id);

        return view('sewa_buku.admin.quiz.soal.opsi.create_opsi', ['soal' => $soal]);
    }



    public function edit($id){
        $opsi = Opsi::findOrFail($id);

        //return response()->json(['opsi' => $opsi]);
        return view('sewa_buku.admin.quiz.soal.opsi.edit_opsi', ['opsi' => $opsi]);
    }

    public function update(Request $request, $id){
        try {
            $opsi = Opsi::findOrFail($id);
            $request->validate([
                'opsi' => 'required',
                'image' => 'nullable',
                'is_correct' => 'required|boolean',
            ]);

            $data = $request->all();

                if ($request->hasFile('image')) {
                    if ($opsi->image) {
                        Storage::disk('public')->delete($opsi->image);
                    }
                    $path = $request->file('image')->store('opsi', 'public');
                    $data['image'] = $path;
                }

            $opsi->update($data);

            return response()->json($opsi);
        } catch (\Throwable $th) {
           return response()->json(['error' => $th->getMessage()]);
        }

    }

    public function store(Request $request){
        try {

            $request->validate([
                'id_soal' => 'required',
                'opsi' => 'required',
                'image' => 'nullable',
                'is_correct' => 'required|boolean',
            ]);

            $data = $request->all();
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('opsi', 'public');
                $data['image'] = $path;
            }

            Opsi::create($data);
            return response()->json($data);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function destroy($id){
        $opsi = Opsi::findOrFail($id);
        $opsi->delete();

        return response()->json(['success' => 'Opsi berhasil dihapus']);
    }
}
