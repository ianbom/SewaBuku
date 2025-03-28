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
    public function index()
    {
        $buku = Buku::all();

        return view('sewa_buku.admin.buku.index_buku', ['buku' => $buku]);
    }

    public function create()
    {
        return view('sewa_buku.admin.buku.create_buku');
    }

    public function store2(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'judul_buku' => 'required|string|max:255',
                'sub_judul' => 'required|string|max:255',
                'penulis' => 'required|string|max:255',
                'penerbit' => 'required|string|max:255',
                'tentang_penulis' => 'required|string',
                'rating_amazon' => 'required|numeric|min:0|max:5',
                'link_pembelian' => 'required|string',
                'isbn' => 'required|string|max:255',
                'tahun_terbit' => 'required|string|max:255',
                'teaser_audio' => 'required|file|mimes:mp3',
                'sinopsis' => 'required|string',
                'ringkasan_audio' => 'required|file|mimes:mp3',
                'cover_buku.*' => 'required|file|mimes:jpeg,png,jpg',
                'is_free' => 'nullable|boolean',
                'detail_buku' => 'required|array',
                'detail_buku.*.bab' => 'required|string|max:255',
                'detail_buku.*.isi' => 'required|string',
                'detail_buku.*.audio' => 'nullable|file|mimes:mp3',
                'detail_buku.*.is_free_detail' => 'required|in:0,1',
            ]);

            // Start DB transaction to ensure all related records are created or none
            DB::beginTransaction();

            // Handle file uploads
            $teaserAudioPath = $request->file('teaser_audio')->store('voice/teaser', 'public');
            $ringkasanAudioPath = $request->file('ringkasan_audio')->store('voice/ringkasan', 'public');

            // Create the book
            $buku = Buku::create([
                'judul_buku' => $request->judul_buku,
                'sub_judul' => $request->sub_judul,
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
                'is_free' => $request->has('is_free') ? 1 : 0,
            ]);

            // Handle covers
            if ($request->hasFile('cover_buku')) {
                foreach ($request->file('cover_buku') as $cover) {
                    $coverPath = $cover->store('cover_buku', 'public');
                    CoverBuku::create([
                        'id_buku' => $buku->id_buku,
                        'file_image' => $coverPath,
                    ]);
                }
            }

            // Handle book details
            if ($request->has('detail_buku')) {
                foreach ($request->detail_buku as $key => $detail) {
                    $detailAudioPath = null;

                    // Check if audio file exists for this detail
                    if ($request->hasFile("detail_buku.$key.audio")) {
                        $detailAudioPath = $request->file("detail_buku.$key.audio")->store('voice/detail', 'public');
                    }

                    DetailBuku::create([
                        'id_buku' => $buku->id_buku,
                        'bab' => $detail['bab'],
                        'isi' => $detail['isi'],
                        'audio' => $detailAudioPath,
                        'is_free_detail' => isset($detail['is_free_detail']) ? (bool)$detail['is_free_detail'] : false,
                    ]);
                }
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('admin.buku.index')->with('success', 'Buku dan detail berhasil disimpan');

        } catch (\Throwable $th) {
            // Roll back the transaction if any step fails
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->withErrors($th->getMessage());
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'judul_buku' => 'required|string|max:255',
                'sub_judul' => 'required|string|max:255',
                'penulis' => 'required|string|max:255',
                'penerbit' => 'required|string|max:255',
                'tentang_penulis' => 'nullable|string',
                'rating_amazon' => 'nullable|numeric',
                'link_pembelian' => 'nullable|string',
                'isbn' => 'nullable|string|max:255',
                'tahun_terbit' => 'nullable|string|max:255',
                'teaser_audio' => 'nullable|file|mimes:mp3',
                'sinopsis' => 'nullable|string',
                'ringkasan_audio' => 'nullable|file|mimes:mp3',
                'detail_buku' => 'nullable|array',
                'detail_buku.*.bab' => 'nullable|string|max:255',
                'detail_buku.*.isi' => 'nullable|string',
                'detail_buku.*.audio' => 'nullable|file|mimes:mp3',
                'cover_buku.*' => 'nullable|file|mimes:jpeg,png,jpg',
                'is_free' => 'nullable|boolean',
            ]);

            // Handle teaser audio upload
            $teaserAudioPath = $request->file('teaser_audio')->store('voice/teaser', 'public');

            // Handle ringkasan audio upload
            $ringkasanAudioPath = $request->file('ringkasan_audio')->store('voice/ringkasan', 'public');

            // Create a new book
            $buku = Buku::create([
                'judul_buku' => $request->judul_buku,
                'sub_judul' => $request->sub_judul,
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

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $quiz = Quiz::pluck('id_detail_buku');
        $checkQuiz = DetailBuku::wherein('id_detail_buku', $quiz)->first();
        $detailBuku = $buku->detailBuku->first();
        return view('sewa_buku.admin.buku.edit_buku', ['buku' => $buku, 'checkQuiz' => $checkQuiz, 'detailBuku' => $detailBuku]);
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
                'is_free' => 'nullable'
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
                'is_free' => $request->is_free,
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

        // $existQuiz = Buku::findOrFail($id)->whereHas('detailBuku', function ($query) use ($quizDetailIds){
        //     $query->whereIn('id_detail_buku', $quizDetailIds);
        // })->first();

        // dd($existQuiz);

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
            'detailNoQuiz' => $detailNoQuiz,
        ]);
    }


    public function createNewQuiz($id)
    {
        // Find the book
        $buku = Buku::with('detailBuku')->findOrFail($id);

        // Make sure the book has at least one detail
        if ($buku->detailBuku->isEmpty()) {
            return redirect()->back()->with('error', 'Buku tidak memiliki detail. Tambahkan detail buku terlebih dahulu.');
        }

        // Get the first detail - assuming this is what you want to create a quiz for
        $detailBuku = $buku->detailBuku->first();

        // Pass both variables to the view
        return view('sewa_buku.admin.buku.create_quiz', compact('buku', 'detailBuku'));
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

            foreach ($request->input('detail_buku') as $key => $detail) {
                $detailAudioPath = null;


                $existingDetail = DetailBuku::where('id_buku', $buku->id_buku)
                    ->where('bab', $detail['bab'])
                    ->first();


                if ($request->hasFile("detail_buku.$key.audio")) {

                    if ($existingDetail && $existingDetail->audio) {
                        Storage::disk('public')->delete($existingDetail->audio);
                    }
                    $detailAudioPath = $request->file("detail_buku.$key.audio")->store('voice/detail', 'public');
                }

                elseif (isset($detail['keep_existing_audio']) && $detail['keep_existing_audio'] && $existingDetail) {
                    $detailAudioPath = $existingDetail->audio;
                }


                DetailBuku::updateOrCreate(
                    [
                        'id_buku' => $buku->id_buku,
                        'bab' => $detail['bab']
                    ],
                    [
                        'isi' => $detail['isi'] ?? null,
                        'audio' => $detailAudioPath,
                        'is_free_detail' => isset($detail['is_free_detail']) ? (bool)$detail['is_free_detail'] : false,
                    ]
                );
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


    public function show($id)
    {
        try {
            $buku = Buku::findOrFail($id);

            //return response()->json(['buku' => $buku]);
            return view('sewa_buku.admin.buku.show_buku', ['buku' => $buku]);
        } catch (\Throwable $th) {
            return response()->json(['err' => $th]);
        }
    }

    public function deleteCover($id)
    {
        try {
            $cover = CoverBuku::findOrFail($id);
            $cover->delete();
            return redirect()->back()->with('success', 'cover Buku berhasil hapus.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    //Search ini ga kepake kayae
    public function searchJudulBuku(Request $request)
    {
        $query = $request->input('query');
        $userId = Auth::id();
        $buku = Buku::with('coverBuku')
            ->where('judul_buku', 'like', "%{$query}%")
            ->with(['order.rating' => function ($query) {
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

    public function searchBukuIndex(Request $request)
    {
        $userId = Auth::id();
        $tagId = $request->input('tag_id');

        $checkLangganan = Langganan::where('status_langganan', true)
            ->where('id', $userId)
            ->first();

        // Ambil semua tags
        $tag = Tags::whereNull('id_child')->get();

        // Query dasar untuk buku
        $query = Buku::with(['coverBuku', 'rating', 'detailBuku', 'tags'])
            ->withCount(['rating as ratingRerata' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)'));
            }]);

        // Filter berdasarkan tag jika ada
        if ($tagId) {
            $query->where(function ($q) use ($tagId) {
                // Cek apakah tag yang dipilih adalah child
                $selectedTag = Tags::find($tagId);

                if ($selectedTag->id_child) {
                    // Jika child tag, ambil buku dengan tag tersebut dan parent tagnya
                    $q->whereHas('tags', function ($query) use ($tagId) {
                        $query->where('tags.id_tags', $tagId);
                    })->orWhereHas('tags', function ($query) use ($selectedTag) {
                        $query->where('tags.id_tags', $selectedTag->id_child);
                    });
                } else {
                    // Jika parent tag, ambil buku dengan tag tersebut dan semua child tagnya
                    $childTagIds = Tags::where('id_child', $tagId)->pluck('id_tags');
                    $q->whereHas('tags', function ($query) use ($tagId, $childTagIds) {
                        $query->where('tags.id_tags', $tagId)
                            ->orWhereIn('tags.id_tags', $childTagIds);
                    });
                }
            });
        }

        $buku = $query->get();

        // Ambil daftar favorit user
        $favorites = Favorite::where('id', $userId)->pluck('id_buku')->toArray();

        // Proses durasi audio
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

            // Format waktu
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $seconds = $totalSeconds % 60;

            $b->formatted_total_waktu = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            $b->totalWaktu = $totalSeconds;

            // Set flag can_read
            $b->can_read = $b->is_free || $checkLangganan ? true : false;
        }

        return view('sewa_buku.user.buku.search_buku', [
            'buku' => $buku,
            'favorites' => $favorites,
            'checkLangganan' => $checkLangganan,
            'tag' => $tag,
            'tagId' => $tagId
        ]);
    }


    public function searchBuku(Request $request)
    {
        $search = $request->input('search');

        $buku = Buku::where('judul_buku', 'like', "%$search%")
            ->orWhere('penulis', 'like', "%$search%")
            ->withCount(['rating as ratingRerata' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)'));
            }])
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
        }

        $html = view('sewa_buku.user.buku.grid_search_buku', compact('buku'))->render();

        return response()->json(['html' => $html]);
    }

    public function myCollection()
    {
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

    public function highlightUser(Request $request)
    {
        $userId = Auth::id();
        $tagId = $request->input('tag_id');

        // Periksa status langganan
        $checkLangganan = Langganan::where('status_langganan', true)
            ->where('id', $userId)
            ->first();

        $highlight = Highlight::where('id', $userId)->pluck('id_buku');

        // Ambil semua tags
        $tag = Tags::whereNull('id_child')->get();

        // Query dasar untuk buku yang di-highlight
        $query = Buku::with(['coverBuku', 'rating', 'detailBuku', 'tags'])
            ->whereIn('id_buku', $highlight)
            ->withCount(['rating as ratingRerata' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)'));
            }])
            ->withCount(['highlight as total_highlight' => function ($query) use ($userId) {
                $query->where('id', $userId);
            }]);

        // Filter berdasarkan tag jika ada
        if ($tagId) {
            $query->where(function ($q) use ($tagId) {
                // Cek apakah tag yang dipilih adalah child
                $selectedTag = Tags::find($tagId);

                if ($selectedTag->id_child) {
                    // Jika child tag, ambil buku dengan tag tersebut dan parent tagnya
                    $q->whereHas('tags', function ($query) use ($tagId) {
                        $query->where('tags.id_tags', $tagId);
                    })->orWhereHas('tags', function ($query) use ($selectedTag) {
                        $query->where('tags.id_tags', $selectedTag->id_child);
                    });
                } else {
                    // Jika parent tag, ambil buku dengan tag tersebut dan semua child tagnya
                    $childTagIds = Tags::where('id_child', $tagId)->pluck('id_tags');
                    $q->whereHas('tags', function ($query) use ($tagId, $childTagIds) {
                        $query->where('tags.id_tags', $tagId)
                            ->orWhereIn('tags.id_tags', $childTagIds);
                    });
                }
            });
        }

        $buku = $query->get();

        // Ambil daftar favorit user
        $favorites = Favorite::where('id', $userId)->pluck('id_buku')->toArray();

        // Proses durasi audio
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

            // Format waktu
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $seconds = $totalSeconds % 60;

            $b->formatted_total_waktu = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            $b->totalWaktu = $totalSeconds;

            // Tentukan apakah buku dapat dibaca
            $b->can_read = $b->is_free || $checkLangganan ? true : false;
        }

        return view('sewa_buku.user.buku.highlight.index_highlight', [
            'buku' => $buku,
            'favorites' => $favorites,
            'checkLangganan' => $checkLangganan,
            'tag' => $tag,
            'tagId' => $tagId,
        ]);
    }


    public function detailHighlight($id)
    {
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

        return view('sewa_buku.user.buku.highlight.detail_highlight', [
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

    public function hapusHighlight($id)
    {
        $highlight = Highlight::findOrFail($id);
        $highlight->delete();
        return redirect()->back()->with('success', 'highlight berhasil dihapus');
    }

    public function searchBukuHighlight(Request $request)
    {
        $userId = Auth::id();

        // Ambil daftar id_buku dari tabel Highlight untuk user tertentu
        $highlight = Highlight::where('id', $userId)->pluck('id_buku');

        $search = $request->input('search');

        // Query buku hanya jika id_buku terdapat pada $highlight
        $buku = Buku::whereIn('id_buku', $highlight) // Filter buku berdasarkan highlight
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('judul_buku', 'like', "%$search%")
                        ->orWhere('penulis', 'like', "%$search%");
                });
            })->withCount(['highlight as total_highlight' => function ($query) use ($userId) {
                $query->where('id', $userId);
            }])
            ->get();

        // Render view dengan data buku yang difilter
        $html = view('sewa_buku.user.buku.highlight.list_highlight', compact('buku'))->render();

        return response()->json(['html' => $html]);
    }


    public function filterTagsBuku(Request $request)
    {
        try {
            $tags = $request->input('tags');
            $search = $request->input('search', '');

            $query = Buku::with(['tags', 'detailBuku'])->withCount([
                'rating as ratingRerata' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(rating), 0)'));
                }
            ]);

            // Filter berdasarkan tags jika dipilih
            if ($tags && $tags !== 'all') {
                $query->whereHas('tags', function ($tagQuery) use ($tags) {
                    $tagQuery->where('id_tags', $tags);
                });
            }

            // Filter berdasarkan pencarian jika ada
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_buku', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('penerbit', 'like', "%{$search}%");
                });
            }

            $buku = $query->get();

            // Proses durasi audio
            $getID3 = new getID3();
            foreach ($buku as $b) {
                $totalSeconds = 0;

                if ($b->detailBuku) {
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
                }

                $hours = floor($totalSeconds / 3600);
                $minutes = floor(($totalSeconds % 3600) / 60);
                $seconds = $totalSeconds % 60;

                $b->formatted_total_waktu = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                $b->totalWaktu = $totalSeconds;
            }

            $html = view('sewa_buku.user.buku.grid_search_buku', compact('buku'))->render();

            return response()->json([
                'html' => $html,
                'count' => $buku->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function indexBukuUser()
    {
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
            'terakhirDibaca' => $terakhirDibaca ?? null
        ]);
    }



    public function detailBukuUser($id)
    {
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
        // dd($buku->detailBuku);
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
}
