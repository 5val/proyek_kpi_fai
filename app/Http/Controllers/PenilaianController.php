<?php
namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Penilaian;
use App\Models\DetailPenilaian;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Fasilitas;
use App\Models\Feedback;
use App\Models\Kategori;
use App\Models\Praktikum;
use App\Models\Mahasiswa;
use App\Models\Unit;

class PenilaianController extends Controller
{

    public function index($tipe, $id)
    {
        if ($tipe === 'dosen') {
            $kategoriIds = [1];
            $target = Dosen::where('id', $id)->orWhere('user_id', $id)->firstOrFail();
            $targetName = $target->name;
        } elseif ($tipe === 'mahasiswa') {
            $kategoriIds = [2];
            $target = Mahasiswa::where('id', $id)->orWhere('user_id', $id)->firstOrFail();
            $targetName = $target->name;
        } elseif ($tipe === 'unit') {
            $kategoriIds = [4];
            $target = Unit::findOrFail($id);
            $targetName = $target->name;
        } elseif ($tipe === 'fasilitas') {
            $kategoriIds = [3];
            $target = Fasilitas::findOrFail($id);
            $targetName = $target->name;
        } elseif ($tipe === 'praktikum') {
            $kategoriIds = [5];
            $target = Praktikum::findOrFail($id);
            $targetName = '';
        } else {
            abort(404);
        }
        $indikator = Indikator::whereIn('kategori_id', $kategoriIds)->get();
        return view('penilaian', [
            'tipe'        => $tipe,
            'indikator'   => $indikator,
            'id'          => $id,
            'targetName'  => $targetName,
        ]);
    }

    public function store(Request $request, $tipe, $id)
    {
        $request->validate([
            'rating' => 'required|array',
        ]);
        if ($tipe === 'dosen') {
            $kategoriIds = [1];
            $target = Dosen::where('user_id', $id)->firstOrFail();
            $targetId = $target->id;
            $dinilaiType = 'App\Models\Dosen';
        } elseif ($tipe === 'mahasiswa') {
            $kategoriIds = [2];
            $target = Mahasiswa::where('user_id', $id)->firstOrFail();
            $targetId = $target->id;
            $dinilaiType = 'App\Models\Mahasiswa';
        } elseif ($tipe === 'unit') {
            $kategoriIds = [4];
            $target = Unit::where('id', $id)->firstOrFail();
            $targetId = $target->id;
            $dinilaiType = 'App\Models\Unit';
        } elseif ($tipe === 'fasilitas') {
            $kategoriIds = [3];
            $target = Fasilitas::where('id', $id)->firstOrFail();
            $targetId = $target->id;
            $dinilaiType = 'App\Models\Fasilitas';
        } elseif ($tipe === 'praktikum') {
            $kategoriIds = [5];
            $target = Praktikum::where('id', $id)->firstOrFail();
            $targetId = $target->id;
            $dinilaiType = 'App\Models\Praktikum';
        } else {
            abort(404, 'Tipe penilaian tidak valid.');
        }
        $kategoriUtama = $kategoriIds[0];
        $penilaian = Penilaian::create([
            'kategori_id' => $kategoriUtama,
            'penilai_id'  => auth()->id() ?? 1,
            'dinilai_id'  => $targetId,
            'dinilai_type' => $dinilaiType, 
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
