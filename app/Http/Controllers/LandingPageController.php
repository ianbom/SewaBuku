<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\PaketLangganan;
use App\Models\Tags;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function landingPage(){
        $parentTags = Tags::with('child')->where('id_child', null)->take(3)->get();
        $paketLangganan = PaketLangganan::all();

        $buku = Buku::with('coverBuku', 'rating', 'detailBuku')
            ->withCount(['rating as ratingRerata' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)'));
            }])->take(5)
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

        // return response()->json(['tags' => $parentTags]);
        return view('sewa_buku.user.landing', ['parentTags' => $parentTags, 'paketLangganan' => $paketLangganan, 'buku' => $buku]);
    }
}
