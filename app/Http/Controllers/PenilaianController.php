<?php
namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Penilaian;
use App\Models\DetailPenilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{

    public function index($tipe)
    {
        if ($tipe === 'dosen') {
            $kategoriIds = [1, 2, 3];

        } elseif ($tipe === 'mahasiswa') {
            $kategoriIds = [4, 5];

        } elseif ($tipe === 'unit') {
            $kategoriIds = [6, 7, 10];

        } elseif ($tipe === 'fasilitas') {
            $kategoriIds = [8, 9];

        } else {
            abort(404, 'Halaman penilaian tidak ditemukan.');
        }
        $indikator = Indikator::whereIn('kategori_id', $kategoriIds)->get();
        return view('penilaian', [
            'tipe'      => $tipe,
            'indikator' => $indikator
        ]);
    }

    public function store(Request $request, $tipe)
    {
        $request->validate([
            'rating' => 'required|array',
        ]);
        if ($tipe === 'dosen') {
            $kategoriIds = [1, 2, 3];
        } elseif ($tipe === 'mahasiswa') {
            $kategoriIds = [4, 5];
        } elseif ($tipe === 'unit') {
            $kategoriIds = [6, 7, 10];
        } elseif ($tipe === 'fasilitas') {
            $kategoriIds = [8, 9];
        } else {
            abort(404, 'Tipe penilaian tidak valid.');
        }
        $kategoriUtama = $kategoriIds[0];
        $penilaian = Penilaian::create([
            'kategori_id' => $kategoriUtama,
            'penilai_id'  => auth()->id() ?? 1,
            'dinilai_id'  => 1, 
            'periode_id'  => 1,
            'komentar'    => $request->komentar,
            'avg_score'   => collect($request->rating)->avg(),
        ]);
        foreach ($request->rating as $indikator_id => $nilai) {
            DetailPenilaian::create([
                'penilaian_id' => $penilaian->id,
                'indikator_id' => $indikator_id,
                'score'        => $nilai,
            ]);
        }
        return back()->with('success', 'Penilaian berhasil disimpan!');
    }

}
