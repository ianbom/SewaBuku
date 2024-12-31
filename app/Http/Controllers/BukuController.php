<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\BukuTags;
use App\Models\CoverBuku;
use App\Models\DetailBuku;
use App\Models\Dibaca;
use App\Models\Diselesaikan;
use App\Models\Favorite;
use App\Models\Highlight;
use App\Models\Langganan;
use App\Models\Quiz;
use App\Models\Rating;
use App\Models\Tags;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(){
        $buku = Buku::all();

        return view('sewa_buku.admin.buku.index_buku', ['buku'=> $buku]);
    }

    public function indexBukuUser() {
        $userId = Auth::id();

        // Periksa status langganan
        $checkLangganan = Langganan::where('status_langganan', true)->where('id', $userId)->first();

        $parentTags = Tags::where('id_child', null)->get();
        $childTags = Tags::whereNotNull('id_child')->get();

        $buku = Buku::with('coverBuku', 'rating', 'detailBuku')
            ->withCount(['rating as ratingRerata' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)'));
            }])
            ->get();

        $favorites = Favorite::where('id', $userId)->pluck('id_buku')->toArray();

        $getID3 = new getID3();

        foreach ($buku as $b) {
            $totalSeconds = 0;

            foreach ($b->detailBuku as $detail) {
                if ($detail->audio) {
                    $filePath = storage_path('app/public/' . $detail->audio);
                    if (file_exists($filePath)) {
                        $audioInfo = $getID3->analyze($filePath);
                        if (isset($audioInfo['playtime_seconds'])) {
                            $totalSeconds += $audioInfo['playtime_seconds'];
                        }
                    }
                }
            }

            // Simpan total waktu dalam format jam, menit, detik
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $seconds = $totalSeconds % 60;

            $b->formatted_total_waktu = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            $b->totalWaktu = $totalSeconds;

            // Tentukan apakah buku dapat dibaca
            $b->can_read = $b->is_free || $checkLangganan ? true : false;

            $terakhirDibaca = Dibaca::where('id', $userId)
                                        ->orderBy('updated_at', 'desc')
                                        ->first();

        }

        return view('sewa_buku.user.buku.index_buku', [
            'buku' => $buku,
            'favorites' => $favorites,
            'checkLangganan' => $checkLangganan,
            'parentTags' => $parentTags,
            'childTags' => $childTags,
            'terakhirDibaca' => $terakhirDibaca
        ]);
    }



    public function detailBukuUser($id) {
        $userId = Auth::id();

        $buku = Buku::with('detailBuku', 'detailBuku.quiz')
        ->withCount(['detailBuku as jumlahChapter' => function ($query) {
            $query->select(DB::raw('coalesce(count(id_detail_buku))'));
        }])
        ->findOrFail($id);

        $jumlahQuiz = Quiz::whereIn('id_detail_buku', function ($query) use ($buku) {
            $query->select('id_detail_buku')
                ->from('detail_buku')
                ->where('id_buku', $buku->id_buku);
        })
        ->count();


        $favorites = Favorite::where('id', $userId)->pluck('id_buku')->toArray();

        $rating = Rating::where('id_buku', $buku->id_buku)->get();

        $ratingCheck = Rating::where('id', $userId)
        ->where('id_buku', $buku->id_buku)
        ->first();

        $checkLanggananAktif = Langganan::where('id', $userId)
            ->where('status_langganan', true)
            ->exists();

        $averageRating = $rating->isNotEmpty() ? $rating->avg('rating') : null;

        $getID3 = new getID3();

        $totalSeconds = 0;


        foreach ($buku->detailBuku as $detail) {
            if ($detail->audio) {
                $filePath = storage_path('app/public/' . $detail->audio);
                if (file_exists($filePath)) {
                    $audioInfo = $getID3->analyze($filePath);
                    if (isset($audioInfo['playtime_seconds'])) {
                        $totalSeconds += $audioInfo['playtime_seconds'];
                    }
                }
            }
        }

        // Simpan total waktu dalam format jam, menit, detik
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        $buku->formatted_total_waktu = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        $buku->totalWaktu = $totalSeconds;

        $diselesaikanCheck = Diselesaikan::where('id', $userId)->where('id_buku', $buku->id_buku)->first();

        $highlight = Highlight::where('id', $userId)->where('id_buku', $buku->id_buku)->get();

        return view('sewa_buku.user.buku.detail_buku', [
            'buku' => $buku,
            'favorites' => $favorites,
            'averageRating' => $averageRating,
            'ratingCheck' => $ratingCheck,
            'rating' => $rating,
            'checkLanggananAktif' => $checkLanggananAktif,
            'jumlahQuiz' => $jumlahQuiz,
            'diselesaikanCheck' => $diselesaikanCheck,
            'highlight' => $highlight
        ]);
    }



    public function create(){
        return view('sewa_buku.admin.buku.create_buku');
    }

    public function store2(Request $request){
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tentang_penulis' => 'required|string',
            'rating_amazon' => 'required|numeric',
            'link_pembelian' => 'required|string',
            'isbn' => 'required|string|max:255',
            'tahun_terbit' => 'required|string|max:255',
            'teaser_audio' => 'required|file|mimes:mp3',
            'sinopsis' => 'required|string',
            'ringkasan_audio' => 'required|file|mimes:mp3',
            'cover_buku.*' => 'required|file|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('teaser_audio')) {
            $teaserAudioPath = $request->file('teaser_audio')->store('voice/teaser', 'public');
        }

        if ($request->hasFile('ringkasan_audio')) {
            $ringkasanAudioPath = $request->file('ringkasan_audio')->store('voice/ringkasan', 'public');
        }

        $buku = Buku::create([
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tentang_penulis' => $request->tentang_penulis,
            'rating_amazon' => $request->rating_amazon,
            'link_pembelian' => $request->link_pembelian,
            'isbn' => $request->isbn,
            'tahun_terbit' => $request->tahun_terbit,
            'teaser_audio' => $teaserAudioPath,
            'sinopsis' => $request->sinopsis,
            'ringkasan_audio' => $ringkasanAudioPath,
            'is_free' => $request->has('is_free'),
        ]);

        if ($request->hasFile('cover_buku')) {
            foreach ($request->file('cover_buku') as $cover) {
                $coverPath = $cover->store('cover_buku', 'public');
                CoverBuku::create([
                    'id_buku' => $buku->id_buku,
                    'file_image' => $coverPath,
                ]);
            }
        }

        return redirect()->route('admin.detailBuku.edit', $buku->id_buku);
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tentang_penulis' => 'required|string',
            'rating_amazon' => 'required|numeric',
            'link_pembelian' => 'required|string',
            'isbn' => 'required|string|max:255',
            'tahun_terbit' => 'required|string|max:255',
            'teaser_audio' => 'required|file|mimes:mp3',
            'sinopsis' => 'required|string',
            'ringkasan_audio' => 'required|file|mimes:mp3',
            'detail_buku' => 'nullable|array',
            'detail_buku.*.bab' => 'nullable|string|max:255',
            'detail_buku.*.isi' => 'nullable|string',
            'detail_buku.*.audio' => 'nullable|file|mimes:mp3',
            'cover_buku.*' => 'required|file|mimes:jpeg,png,jpg',
            'is_free' => 'nullable|boolean',
        ]);

        // Handle teaser audio upload
        $teaserAudioPath = $request->file('teaser_audio')->store('voice/teaser', 'public');

        // Handle ringkasan audio upload
        $ringkasanAudioPath = $request->file('ringkasan_audio')->store('voice/ringkasan', 'public');

        // Create a new book
        $buku = Buku::create([
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tentang_penulis' => $request->tentang_penulis,
            'rating_amazon' => $request->rating_amazon,
            'link_pembelian' => $request->link_pembelian,
            'isbn' => $request->isbn,
            'tahun_terbit' => $request->tahun_terbit,
            'teaser_audio' => $teaserAudioPath,
            'sinopsis' => $request->sinopsis,
            'ringkasan_audio' => $ringkasanAudioPath,
            'is_free' => $request->has('is_free'),
        ]);

        // Handle book details (optional)
        if ($request->has('detail_buku')) {
            foreach ($request->input('detail_buku') as $key => $detail) {
                // Only create detail if bab and isi are provided
                if (!empty($detail['bab']) && !empty($detail['isi'])) {
                    $detailAudioPath = null;
                    if ($request->hasFile("detail_buku.$key.audio")) {
                        $detailAudioPath = $request->file("detail_buku.$key.audio")->store('voice/detail', 'public');
                    }

                    DetailBuku::create([
                        'id_buku' => $buku->id_buku,
                        'bab' => $detail['bab'],
                        'isi' => $detail['isi'],
                        'audio' => $detailAudioPath,
                        'is_free_detail' => isset($detail['is_free_detail']) ? true : false,
                    ]);
                }
            }
        }

        // Handle cover uploads
        if ($request->hasFile('cover_buku')) {
            foreach ($request->file('cover_buku') as $cover) {
                $coverPath = $cover->store('cover_buku', 'public');
                CoverBuku::create([
                    'id_buku' => $buku->id_buku,
                    'file_image' => $coverPath,
                ]);
            }
        }

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diupload');
    } catch (\Throwable $th) {
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
            'tentang_penulis' => 'nullable|string',
            'rating_amazon' => 'nullable|numeric',
            'link_pembelian' => 'nullable|string',
            'isbn' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|string|max:255',
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
            'tentang_penulis' => $request->tentang_penulis,
            'rating_amazon' => $request->rating_amazon,
            'link_pembelian' => $request->link_pembelian,
            'isbn' => $request->isbn,
            'tahun_terbit' => $request->tahun_terbit,
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

    public function editDetailBuku($id)
    {
        $buku = Buku::with('detailBuku.quiz')->findOrFail($id);

        $detailBuku = DetailBuku::where('id_buku', $buku->id_buku)->get();

        if ($detailBuku->isEmpty()) {
            $detailBuku = collect([new DetailBuku(['id_buku' => $buku->id_buku])]);
        }

        $quiz = Quiz::all();
        $quizDetailIds = $quiz->pluck('id_detail_buku');


        $detailWithQuiz = DetailBuku::where('id_buku', $buku->id_buku)
            ->whereIn('id_detail_buku', $quizDetailIds)
            ->get();

        $detailNoQuiz = DetailBuku::where('id_buku', $buku->id_buku)
            ->whereNotIn('id_detail_buku', $quizDetailIds)
            ->get();


        return view('sewa_buku.admin.buku.edit_detail_buku', [
            'detailBuku' => $detailBuku,
            'buku' => $buku,
            'detailWithQuiz' => $detailWithQuiz,
            'detailNoQuiz' => $detailNoQuiz
        ]);
    }




public function updateDetailBuku(Request $request, $id)
{
    try {
        $request->validate([
            'detail_buku.*.bab' => 'nullable|string|max:255',
            'detail_buku.*.isi' => 'nullable|string',
            'detail_buku.*.audio' => 'nullable|file|mimes:mp3',
            'detail_buku.*.is_free_detail' => 'nullable|boolean',
            'detail_buku.*.keep_existing_audio' => 'nullable|boolean',
        ]);

        $buku = Buku::findOrFail($id);

        // Hapus detail buku lama
        $buku->detailBuku()->delete();

        // Tambahkan detail buku baru
        foreach ($request->input('detail_buku') as $key => $detail) {
            $detailAudioPath = null;

            if ($request->hasFile("detail_buku.$key.audio")) {
                $detailAudioPath = $request->file("detail_buku.$key.audio")->store('voice/detail', 'public');
            } elseif (isset($detail['keep_existing_audio']) && $detail['keep_existing_audio'] && isset($detail['existing_audio'])) {
                $detailAudioPath = $detail['existing_audio'];
            }

            DetailBuku::create([
                'id_buku' => $buku->id_buku,
                'bab' => $detail['bab'] ?? null,
                'isi' => $detail['isi'] ?? null,
                'audio' => $detailAudioPath,
                'is_free_detail' => isset($detail['is_free_detail']) ? (bool)$detail['is_free_detail'] : false,
            ]);
        }

        return redirect()->back()->with('success', 'Detail buku berhasil diperbarui');
    } catch (\Throwable $th) {
        return redirect()->back()->withErrors($th->getMessage());
    }
}


    public function editTagsBuku($id)
{
    $buku = Buku::findOrFail($id);
    $tags = Tags::all();
    $selectedTags = $buku->tags->pluck('id_tags')->toArray();

    return view('sewa_buku.admin.buku.create_tags_buku', [
        'buku' => $buku,
        'tags' => $tags,
        'selectedTags' => $selectedTags
    ]);
}


    public function updateTagsBuku(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'id_tags' => 'nullable|array',
            'id_tags.*' => 'exists:tags,id_tags'
        ]);


        $buku->tags()->sync($request->id_tags ?? []);

        return redirect()->back()->with('success', 'Tags berhasil diperbarui!');
    }


    public function show($id){
        try {
            $buku = Buku::findOrFail($id);
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


    public function searchJudulBuku(Request $request)
    {
        $query = $request->input('query');
        $userId = Auth::id();
        $buku = Buku::with('coverBuku')
                    ->where('judul_buku', 'like', "%{$query}%")
                    ->with(['order.rating' => function($query) {
                        $query->select('id_order', 'rating');
                    }])
                    ->get();

        $favorites = Favorite::where('id', $userId)->pluck('id_buku')->toArray();

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
        return view('sewa_buku.user.buku.index_buku', ['buku' => $buku, 'favorites' => $favorites]);
    }

    public function searchBukuIndex(){
        $userId = Auth::id();

        // Periksa status langganan
        $checkLangganan = Langganan::where('status_langganan', true)->where('id', $userId)->first();

        $parentTags = Tags::where('id_child', null)->get();
        $childTags = Tags::whereNotNull('id_child')->get();

        $buku = Buku::with('coverBuku', 'rating', 'detailBuku')
            ->withCount(['rating as ratingRerata' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)'));
            }])
            ->get();

        $favorites = Favorite::where('id', $userId)->pluck('id_buku')->toArray();

        $getID3 = new getID3(); // Inisialisasi library getID3

        foreach ($buku as $b) {
            $totalSeconds = 0;

            // Hitung total durasi audio dari detailBuku
            foreach ($b->detailBuku as $detail) {
                if ($detail->audio) {
                    $filePath = storage_path('app/public/' . $detail->audio);
                    if (file_exists($filePath)) {
                        $audioInfo = $getID3->analyze($filePath);
                        if (isset($audioInfo['playtime_seconds'])) {
                            $totalSeconds += $audioInfo['playtime_seconds'];
                        }
                    }
                }
            }

            // Simpan total waktu dalam format jam, menit, detik
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $seconds = $totalSeconds % 60;

            $b->formatted_total_waktu = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            $b->totalWaktu = $totalSeconds;

            // Tentukan apakah buku dapat dibaca
            $b->can_read = $b->is_free || $checkLangganan ? true : false;
        }

        return view('sewa_buku.user.buku.search_buku', [
            'buku' => $buku,
            'favorites' => $favorites,
            'checkLangganan' => $checkLangganan,
            'parentTags' => $parentTags,
            'childTags' => $childTags
        ]);
    }

    public function searchBuku(Request $request)
    {
        $search = $request->input('search');

        $buku = Buku::where('judul_buku', 'like', "%$search%")
                    ->orWhere('penulis', 'like', "%$search%")
                    ->get();

        $html = view('sewa_buku.user.buku.grid_search_buku', compact('buku'))->render();

        return response()->json(['html' => $html]);
    }

    public function myCollection(){
        $userId = Auth::id();

        // Periksa status langganan
        $checkLangganan = Langganan::where('status_langganan', true)->where('id', $userId)->first();




        $favorites = Favorite::where('id', $userId)->pluck('id_buku')->toArray();

        $buku = Buku::with('coverBuku', 'rating', 'detailBuku')
        ->withCount(['rating as ratingRerata' => function ($query) {
            $query->select(DB::raw('coalesce(avg(rating), 0)'));
        }])
        ->whereIn('id_buku', $favorites)
        ->get();



        $getID3 = new getID3();

        foreach ($buku as $b) {
            $totalSeconds = 0;

            foreach ($b->detailBuku as $detail) {
                if ($detail->audio) {
                    $filePath = storage_path('app/public/' . $detail->audio);
                    if (file_exists($filePath)) {
                        $audioInfo = $getID3->analyze($filePath);
                        if (isset($audioInfo['playtime_seconds'])) {
                            $totalSeconds += $audioInfo['playtime_seconds'];
                        }
                    }
                }
            }

            // Simpan total waktu dalam format jam, menit, detik
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $seconds = $totalSeconds % 60;

            $b->formatted_total_waktu = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            $b->totalWaktu = $totalSeconds;

            // Tentukan apakah buku dapat dibaca
            $b->can_read = $b->is_free || $checkLangganan ? true : false;

        }

        $diselesaikan = Diselesaikan::where('id', $userId)->pluck('id_buku');

        $bukuDiselesaikan = Buku::with('coverBuku', 'rating', 'detailBuku')
        ->withCount(['rating as ratingRerata' => function ($query) {
            $query->select(DB::raw('coalesce(avg(rating), 0)'));
        }])
        ->whereIn('id_buku', $diselesaikan)
        ->get();



        $getID3 = new getID3();

        foreach ($bukuDiselesaikan as $b) {
            $totalSeconds = 0;

            foreach ($b->detailBuku as $detail) {
                if ($detail->audio) {
                    $filePath = storage_path('app/public/' . $detail->audio);
                    if (file_exists($filePath)) {
                        $audioInfo = $getID3->analyze($filePath);
                        if (isset($audioInfo['playtime_seconds'])) {
                            $totalSeconds += $audioInfo['playtime_seconds'];
                        }
                    }
                }
            }

            // Simpan total waktu dalam format jam, menit, detik
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $seconds = $totalSeconds % 60;

            $b->formatted_total_waktu = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            $b->totalWaktu = $totalSeconds;

            // Tentukan apakah buku dapat dibaca
            $b->can_read = $b->is_free || $checkLangganan ? true : false;

        }


        $terakhirDibaca = Dibaca::where('id', $userId)
                                        ->orderBy('updated_at', 'desc')
                                        ->first();

        // return response()->json(['disimpan' => $disimpan]);

        return view('sewa_buku.user.buku.my_collection.index_collection', [
            'terakhirDibaca' => $terakhirDibaca,
            'buku' => $buku,
            'favorites' => $favorites,
            'checkLangganan' => $checkLangganan,
            'bukuDiselesaikan' => $bukuDiselesaikan


        ]);
    }

}
