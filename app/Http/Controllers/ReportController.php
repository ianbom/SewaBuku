<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $report = Report::all();
        return view('sewa_buku.admin.report.index_report', ['report' => $report]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        $buku = Buku::findOrFail($id);

        try {
            Report::create([
                'id' => $user->id,
                'id_buku' => $buku->id_buku,
                'alasan' => $request->alasan
            ]);
            return redirect()->back()->with('success', 'Report Issue berhasil dikirimkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return view('sewa_buku.admin.report.detail_report', ['report' => $report]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->back()->with('success', 'Sukses hapus report');
    }
}
