<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function indexTags(){
        $tags = Tags::all();
        return view('sewa_buku.admin.tags.index_tags', ['tags' => $tags]);
    }

    public function storeTags(Request $request){

        $request->validate([
            'nama_tags' => 'required|string'
        ]);

        Tags::create([
            'nama_tags' => $request->nama_tags
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan tags');
    }

    public function editTags($id){
        $tags = Tags::findOrFail($id);
        return view('sewa_buku.admin.tags.edit_tags', ['tags' => $tags]);
    }

    public function updateTags(Request $request, $id){
        $tags = Tags::findOrFail($id);

        $request->validate([
            'nama_tags' => 'required|string'
        ]);

        $tags->nama_tags = $request->nama_tags;
        $tags->save();
        
        return redirect()->route('admin.tags.index')->with('success', 'Berhasil mengupdate tags');
    }
}
