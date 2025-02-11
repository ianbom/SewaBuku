<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function indexTags(){
        $tags = Tags::with('parent', 'child')->get();
        $parent = Tags::where('id_child', null)->get();
        return view('sewa_buku.admin.tags.index_tags', ['tags' => $tags, 'parent' => $parent]);
    }

    public function storeTags(Request $request){

        try {
            $request->validate([
                'id_child' => 'nullable',
                'nama_tags' => 'required|string'
            ]);

            $tag = Tags::create([
                'id_child' => $request->id_child,
                'nama_tags' => $request->nama_tags
            ]);

            return redirect()->back()->with('success', 'Berhasil menambahkan tags');
        } catch (\Throwable $th) {
            return response()->json(['err' => $th->getMessage()]);
        }

    }

    public function editTags($id){
        $tags = Tags::findOrFail($id);
        $parent = Tags::where('id_child', null)->get();
        return view('sewa_buku.admin.tags.edit_tags', ['tags' => $tags, 'parent' => $parent]);
    }

    public function updateTags(Request $request, $id){
        $tags = Tags::findOrFail($id);

        $request->validate([
            'nama_tags' => 'required|string',
            'id_child' => 'nullable',
        ]);

        $tags->nama_tags = $request->nama_tags;
        $tags->id_child = $request->id_child;
        $tags->save();

        return redirect()->route('admin.tags.index')->with('success', 'Berhasil mengupdate tags');
    }

    public function deleteTags($id){
        $tags = Tags::findOrFail($id);
        $tags->delete();
        return redirect()->back()->with('success', 'Tags berhasil dihapus');
    }
}
