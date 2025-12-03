<?php
namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Kampus;
use App\Models\Penilaian;
use App\Models\DetailPenilaian;
use App\Models\Periode;
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
        } elseif ($tipe === 'manajemen') {
            $kategoriIds = [6];
            $target = Kampus::findOrFail($id);
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
        } elseif ($tipe === 'manajemen') {
            $kategoriIds = [6];
            $target = Kampus::first();
            $targetId = $target->id;
            $dinilaiType = 'App\Models\Kampus';
        } else {
            abort(404, 'Tipe penilaian tidak valid.');
        }
        $periode = Periode::latest()->first();
        $kategoriUtama = $kategoriIds[0];
        $penilaian = Penilaian::create([
            'kategori_id' => $kategoriUtama,
            'penilai_id'  => auth()->id() ?? 1,
            'dinilai_id'  => $targetId,
            'dinilai_type' => $dinilaiType, 
            'periode_id'  => $periode->id,
            'komentar'    => $request->feedback,
            'avg_score'   => collect($request->rating)->avg(),
        ]);
        foreach ($request->rating as $indikator_id => $nilai) {
            DetailPenilaian::create([
                'penilaian_id' => $penilaian->id,
                'indikator_id' => $indikator_id,
                'score'        => $nilai,
            ]);
        }

        $newAvgKpi = Penilaian::where('dinilai_type', $dinilaiType)
            ->where('dinilai_id', $targetId)
            ->avg('avg_score');

        // Update kolom avg_kpi pada model target
        $target->update([
            'avg_kpi' => $newAvgKpi
        ]);

        return back()->with('success', 'Penilaian berhasil disimpan!');
    }

}
