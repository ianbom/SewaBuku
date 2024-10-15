<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\CoverBuku;
use App\Models\DetailBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(){
        $buku = Buku::all();
        return view('sewa_buku.admin.buku.index_buku', ['buku'=> $buku]);
    }

    public function indexBukuUser(){

        $buku = Buku::with('coverBuku')
                    ->with(['order.rating' => function($query) {
                        $query->select('id_order', 'rating');
                    }])
                    ->get();

        foreach ($buku as $b) {
            $totalRating = 0;
            $totalOrderWithRating = 0;

            foreach ($b->order as $order) {
                if ($order->rating) {
                    $totalRating += $order->rating->rating;
                    $totalOrderWithRating++;
                }
            }

            $b->ratingRerata = $totalOrderWithRating > 0 ? $totalRating / $totalOrderWithRating : null;
        }
        //return response()->json(['data' => $buku]);
        return view('sewa_buku.user.buku.index_buku', ['buku' => $buku]);
    }


    public function create(){
        return view('sewa_buku.admin.buku.create_buku');
    }

    public function store(Request $request)
{
    try {
        // Validate the request data
        $request->validate([
            'nama_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'jumlah_halaman' => 'required|string|max:255',
            'isbn' => 'required|string|max:255',
            'tahun_terbit' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'teaser_audio' => 'required|file|mimes:mp3',
            'sinopsis' => 'required|string',
            'ringkasan_audio' => 'required|file|mimes:mp3',
            'detail_buku.*.bab' => 'required|string|max:255',
            'detail_buku.*.isi' => 'required|string',
            'detail_buku.*.audio' => 'nullable|file|mimes:mp3', // Nullable audio
            'cover_buku.*' => 'required|file|mimes:jpeg,png,jpg',
        ]);

        // Handle teaser audio upload
        if ($request->hasFile('teaser_audio')) {
            $teaserAudioPath = $request->file('teaser_audio')->store('voice/teaser', 'public');
        }

        // Handle ringkasan audio upload
        if ($request->hasFile('ringkasan_audio')) {
            $ringkasanAudioPath = $request->file('ringkasan_audio')->store('voice/ringkasan', 'public');
        }

        // Create a new book
        $buku = Buku::create([
            'judul_buku' => $request->nama_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'jumlah_halaman' => $request->jumlah_halaman,
            'isbn' => $request->isbn,
            'tahun_terbit' => $request->tahun_terbit,
            'harga' => $request->harga,
            'teaser_audio' => $teaserAudioPath,
            'sinopsis' => $request->sinopsis,
            'ringkasan_audio' => $ringkasanAudioPath,
        ]);

        // Handle detail_buku (multiple book details)
        foreach ($request->input('detail_buku') as $key => $detail) {
            $detailAudioPath = null;
            if ($request->hasFile("detail_buku.$key.audio")) {
                $detailAudioPath = $request->file("detail_buku.$key.audio")->store('voice/detail', 'public');
            }

            DetailBuku::create([
                'id_buku' => $buku->id_buku,
                'bab' => $detail['bab'],
                'isi' => $detail['isi'],
                'audio' => $detailAudioPath, // Nullable audio
            ]);
        }

        // Handle cover_buku (multiple covers)
        if ($request->hasFile('cover_buku')) {
            foreach ($request->file('cover_buku') as $cover) {
                $coverPath = $cover->store('cover_buku', 'public');
                CoverBuku::create([
                    'id_buku' => $buku->id_buku,
                    'file_image' => $coverPath,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Buku berhasil diupload');
    } catch (\Throwable $th) {
        // Handle any errors that occur during the process
        return redirect()->back()->withErrors($th->getMessage());
    }
}




    public function edit($id){
        $buku = Buku::findOrFail($id);
        return view('sewa_buku.admin.buku.edit_buku', ['buku'=> $buku]);
    }

    public function updateBuku(Request $request, $id)
{
    try {
        // Validasi data dari request
        $request->validate([
            'nama_buku' => 'nullable|string|max:255',
            'penulis' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'jumlah_halaman' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'teaser_audio' => 'nullable|file|mimes:mp3', // Nullable for update
            'sinopsis' => 'nullable|string',
            'ringkasan_audio' => 'nullable|file|mimes:mp3', // Nullable for update
            'cover_buku.*' => 'nullable|file|mimes:jpeg,png,jpg', // Nullable for update
        ]);

        // Temukan buku yang akan di-update
        $buku = Buku::findOrFail($id);

        // Update teaser audio jika ada file baru yang diupload
        if ($request->hasFile('teaser_audio')) {
            // Hapus teaser audio lama jika ada
            if ($buku->teaser_audio) {
                Storage::disk('public')->delete($buku->teaser_audio);
            }
            $teaserAudioPath = $request->file('teaser_audio')->store('voice/teaser', 'public');
            $buku->teaser_audio = $teaserAudioPath;
        }


        if ($request->hasFile('ringkasan_audio')) {

            if ($buku->ringkasan_audio) {
                Storage::disk('public')->delete($buku->ringkasan_audio);
            }
            $ringkasanAudioPath = $request->file('ringkasan_audio')->store('voice/ringkasan', 'public');
            $buku->ringkasan_audio = $ringkasanAudioPath;
        }

        // Update data buku
        $buku->update([
            'judul_buku' => $request->nama_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'jumlah_halaman' => $request->jumlah_halaman,
            'isbn' => $request->isbn,
            'tahun_terbit' => $request->tahun_terbit,
            'harga' => $request->harga,
            'sinopsis' => $request->sinopsis,
        ]);

        // Update cover buku jika ada file cover baru yang diupload
        if ($request->hasFile('cover_buku')) {

            foreach ($request->file('cover_buku') as $cover) {
                $coverPath = $cover->store('cover_buku', 'public');
                CoverBuku::create([
                    'id_buku' => $buku->id_buku,
                    'file_image' => $coverPath,
                ]);
            }
        }
        return redirect()->back()->with('success', 'Buku berhasil diperbarui');
    } catch (\Throwable $th) {
        return redirect()->back()->withErrors($th->getMessage());
    }
}

    public function editDetailBuku($id){
        $buku = Buku::findOrFail($id);
        $detailBuku = DetailBuku::where('id_buku', $buku->id_buku)->get();
        //return response()->json(['buku' => $detailBuku]);
        return view('sewa_buku.admin.buku.edit_detail_buku', ['detailBuku' => $detailBuku]);
    }

    public function updateDetailBuku(Request $request, $id)
    {
        try {
            $request->validate([
                'detail_buku.*.bab' => 'nullable|string|max:255',
                'detail_buku.*.isi' => 'nullable|string',
                'detail_buku.*.audio' => 'nullable|file|mimes:mp3',
                'detail_buku.*.keep_existing_audio' => 'nullable|boolean',
            ]);

            // Temukan buku berdasarkan ID
            $buku = Buku::findOrFail($id);

            // Hapus semua detail buku terkait buku ini untuk mencegah duplikasi
            $buku->detailBuku()->delete();

            // Simpan kembali semua detail buku baru
            foreach ($request->input('detail_buku') as $key => $detail) {
                $detailAudioPath = null;

                // Cek apakah ada file audio baru yang diunggah
                if ($request->hasFile("detail_buku.$key.audio")) {
                    $detailAudioPath = $request->file("detail_buku.$key.audio")->store('voice/detail', 'public');
                } elseif (isset($detail['keep_existing_audio']) && $detail['keep_existing_audio'] && isset($detail['existing_audio'])) {
                    // Gunakan audio yang sudah ada jika tidak ada yang diunggah
                    $detailAudioPath = $detail['existing_audio'];
                }

                // Buat entri detail buku baru untuk buku ini
                DetailBuku::create([
                    'id_buku' => $buku->id_buku,
                    'bab' => $detail['bab'],
                    'isi' => $detail['isi'],
                    'audio' => $detailAudioPath,
                ]);
            }

            return redirect()->back()->with('success', 'Detail buku berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }





    public function show($id){
        try {
            $buku = Buku::with('coverBuku')->findOrFail($id);
        //return response()->json(['buku' => $buku]);
        return view('sewa_buku.admin.buku.show_buku', ['buku' => $buku]);
        } catch (\Throwable $th) {
            return response()->json(['err' => $th]);
        }

    }

    public function deleteCover($id){
        try {
           $cover = CoverBuku::findOrFail($id);
           $cover->delete();
           return redirect()->back()->with('success', 'cover Buku berhasil hapus.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
