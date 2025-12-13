<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Fasilitas;
use App\Models\Feedback;
use App\Models\Kehadiran;
use App\Models\Kategori;
use App\Models\Enrollment;
use App\Models\Mahasiswa;
use App\Models\Unit;
use App\Models\Indikator;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Periode;
use App\Models\Penilaian;
use App\Models\DetailPenilaian;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// PDF Export (Dompdf)
use Dompdf\Dompdf;



class MahasiswaController extends Controller
{
public function dashboard()
{
    
    $userId = Auth::id();
    $periodeAktif = Periode::max('id');

    // =========================
    // DATA MAHASISWA
    // =========================
    $mahasiswa = Mahasiswa::with('user', 'program_studi')
        ->where('user_id', $userId)
        ->firstOrFail();

    // =========================
    // KELAS YANG DIAMBIL (SAMA DENGAN LAPORAN)
    // =========================
    $kelasSaya = Kelas::with(['mataKuliah', 'dosen.user'])
        ->where('periode_id', $periodeAktif)
        ->whereHas('enrollment', function ($q) use ($mahasiswa) {
            $q->where('mahasiswa_nrp', $mahasiswa->nrp);
        })
        ->get();

    $isBaru = $kelasSaya->count() === 0;

    // =========================
    // DOSEN
    // =========================
    $dosenUsers = $kelasSaya
        ->pluck('dosen')
        ->filter()
        ->unique('id')
        ->values();

    $dosenIds = $dosenUsers->pluck('id'); // 
        
$dosenSudah = Penilaian::where('kategori_id', 1)
    ->where('penilai_id', $userId)
    ->where('dinilai_type', 'App\Models\Dosen')
    ->whereIn('dinilai_id', $dosenIds)
    ->count();
    
        
$totalDosen = $dosenIds->count();
$dosenBelum = max(0, $totalDosen - $dosenSudah);

    // =========================
    // PRAKTIKUM
    // =========================
    $praktikumIds = $kelasSaya
        ->where('has_praktikum', 1)
        ->pluck('id');

    $praktikumSudah = Penilaian::where('kategori_id', 4)
        ->where('penilai_id', $userId)
        ->whereIn('dinilai_id', $praktikumIds)
        ->count();

    $praktikumBelum = max(0, $praktikumIds->count() - $praktikumSudah);

    // =========================
    // UNIT & FASILITAS
    // =========================
    $unitSudah = Penilaian::where('kategori_id', 5)
        ->where('penilai_id', $userId)
        ->count();
    $unitBelum = max(0, Unit::count() - $unitSudah);

    $fasilitasSudah = Penilaian::where('kategori_id', 6)
        ->where('penilai_id', $userId)
        ->count();
    $fasilitasBelum = max(0, Fasilitas::count() - $fasilitasSudah);

    // =========================
    // GRAFIK KEHADIRAN (IDENTIK LAPORAN)
    // =========================
    $all_periode = Periode::orderBy('id')->get();
    $grafik_labels = [];
    $grafik_values = [];

    foreach ($all_periode as $p) {

        $kelasPerPeriode = Kelas::where('periode_id', $p->id)
            ->whereHas('enrollment', function ($q) use ($mahasiswa) {
                $q->where('mahasiswa_nrp', $mahasiswa->nrp);
            })
            ->get();

        if ($kelasPerPeriode->count() === 0) continue;

        $total = 0;
        $count = 0;

        foreach ($kelasPerPeriode as $k) {

            $totalPertemuan = Kehadiran::where('kelas_id', $k->id)
                ->distinct('pertemuan_ke')
                ->count('pertemuan_ke');

            $hadir = Kehadiran::where('kelas_id', $k->id)
                ->where('mahasiswa_nrp', $mahasiswa->nrp)
                ->where('is_present', 1)
                ->distinct('pertemuan_ke')
                ->count('pertemuan_ke');

            if ($totalPertemuan > 0) {
                $total += ($hadir / $totalPertemuan) * 100;
                $count++;
            }
        }

        if ($count > 0) {
            $grafik_labels[] = $p->nama_periode;
            $grafik_values[] = round($total / $count, 1);
        }
    }

    // =========================
    // LIST BELUM DINILAI
    // =========================
    $dosenBelumList = $dosenUsers->filter(function ($d) use ($userId) {
        return !Penilaian::where('kategori_id', 1)
            ->where('penilai_id', $userId)
            ->where('dinilai_id', $d->id)
            ->exists();
    })->take(1);

    $praktikumBelumList = $kelasSaya
        ->where('has_praktikum', 1)
        ->filter(function ($k) use ($userId) {
            return !Penilaian::where('kategori_id', 4)
                ->where('penilai_id', $userId)
                ->where('dinilai_id', $k->id)
                ->exists();
        })->take(1);

    $unitBelumList = Unit::whereNotIn('id',
        Penilaian::where('kategori_id', 5)
            ->where('penilai_id', $userId)
            ->pluck('dinilai_id')
    )->limit(1)->get();

    $fasilitasBelumList = Fasilitas::whereNotIn('id',
        Penilaian::where('kategori_id', 6)
            ->where('penilai_id', $userId)
            ->pluck('dinilai_id')
    )->limit(1)->get();

    // =========================
    // RETURN
    // =========================
    return view('mahasiswa.dashboard', compact(
        'mahasiswa',
        'isBaru',
        'kelasSaya',
        'dosenSudah', 'dosenBelum',
        'praktikumSudah', 'praktikumBelum',
        'unitSudah', 'unitBelum',
        'fasilitasSudah', 'fasilitasBelum',
        'dosenBelumList', 'praktikumBelumList',
        'unitBelumList', 'fasilitasBelumList',
        'grafik_labels', 'grafik_values', 'totalDosen'
    ));
}

   public function profile(){
      $mahasiswa = Mahasiswa::with('program_studi')->where('user_id', Auth::id())->firstOrFail();
      return view('mahasiswa.profile', compact('mahasiswa'));
   }
   public function changePassword(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $mahasiswa = Mahasiswa::findOrFail($id);
         $user = $mahasiswa->user;
         $user->update([
            'password' => Hash::make($validated['password']),
         ]);
        return redirect()
            ->route('mahasiswa.profile')
            ->with('success', 'Password berhasil diubah!');
    }

   public function uploadProfpic(Request $request, $id)
   {
      $request->validate([
         'file' => 'required|file|mimes:jpg,jpeg,png|max:5120',
      ]);
      $mahasiswa = Mahasiswa::where('user_id', $id)->firstOrFail();
      $user = $mahasiswa->user;
      if ($user->photo_profile && Storage::disk('public')->exists($user->photo_profile)) {
         Storage::disk('public')->delete($user->photo_profile);
      }
      $file = $request->file('file');
      $path = $file->store('profiles', 'public');
      $user->update([
         'photo_profile' => $path,
      ]);
      return redirect()
         ->route('mahasiswa.profile')
         ->with('success', 'Foto profil berhasil diperbarui!');
   }


   public function kpi(){
      return view('mahasiswa.kpi');
   }
   public function kelas(){
      return view('mahasiswa.kelas');
   }

public function penilaian_dosen()
{
    $userId = auth()->id();
    $mahasiswa = auth()->user()->mahasiswa;

    $periodeAktif = Periode::max('id');

    // ===========================
    // DOSEN AKTIF DI PERIODE SEKARANG
    // ===========================
    $dosenList = Enrollment::with('kelas.dosen.user')
        ->where('mahasiswa_nrp', $mahasiswa->nrp)
        ->whereHas('kelas', function ($q) use ($periodeAktif) {
            $q->where('periode_id', $periodeAktif);
        })
        ->get()
        ->pluck('kelas.dosen')
        ->filter()
        ->unique('id')
        ->values();

    // ===========================
    // DOSEN YANG SUDAH DINILAI
    // ===========================
    $dosenSudahDinilaiIds = Penilaian::where('kategori_id', 1)
        ->where('penilai_id', $userId)
        ->where('dinilai_type', \App\Models\Dosen::class)
        ->pluck('dinilai_id');

    // ===========================
    // PISAHKAN
    // ===========================
    $dosenSudah = $dosenList->filter(fn ($d) =>
        $dosenSudahDinilaiIds->contains($d->id)
    )->values();

    $dosenBelum = $dosenList->filter(fn ($d) =>
        !$dosenSudahDinilaiIds->contains($d->id)
    )->values();

    return view('mahasiswa.penilaian_dosen', compact(
        'dosenBelum',
        'dosenSudah'
    ));
}

   public function penilaian_fasilitas() {
      $fasilitas = Fasilitas::paginate(10);
      return view('mahasiswa.penilaian_fasilitas', ['fasilitas' => $fasilitas]);
   }
   public function penilaian_unit() {
      $units = Unit::with('penanggungJawab')->paginate(10);
      return view('mahasiswa.penilaian_unit', ['units' => $units]);
   }
   public function penilaian_praktikum() {
      $mahasiswa = auth()->user()->mahasiswa;
      $praktikumList = Enrollment::with('kelas.mataKuliah')
         ->where('mahasiswa_nrp', $mahasiswa->nrp)
         ->whereHas('kelas', function ($query) {
               $query->where('has_praktikum', 1);
         })
         ->get()
         ->map(function ($enrollment) {
               return $enrollment->kelas; 
         });

      return view('mahasiswa.penilaian_praktikum', compact('praktikumList'));
   }

public function laporan(Request $request)
{
    $userId = auth()->id();

    // Ambil data mahasiswa
    $mahasiswa = Mahasiswa::with('user', 'program_studi')
        ->where('user_id', $userId)
        ->firstOrFail();

    // Cek apakah mahasiswa baru (belum punya enrollment)
    $isBaru = Enrollment::where('mahasiswa_nrp', $mahasiswa->nrp)->count() == 0;

    // Semua periode
    $all_periode = Periode::orderBy('id', 'desc')->get();
    $periode_id = $request->periode_id ?? Periode::max('id');

    // Jika mahasiswa baru → langsung kirim view (tidak hitung apa-apa)
    if ($isBaru) {
        return view('mahasiswa.laporan', [
            'isBaru'        => true,
            'all_periode'   => $all_periode,
            'periode_id'    => $periode_id,
            'mahasiswa'     => $mahasiswa,
            'hasil'         => [],
            'feedback'      => [],
            'grafik_labels' => [],
            'grafik_values' => []
        ]);
    }

    // ===========================
    // MAHASISWA LAMA (ADA DATA)
    // ===========================

    // Ambil kelas yang diikuti
    $kelasDiambil = Kelas::with(['mataKuliah', 'dosen'])
        ->where('periode_id', $periode_id)
        ->whereHas('enrollment', function ($q) use ($mahasiswa) {
            $q->where('mahasiswa_nrp', $mahasiswa->nrp);
        })
        ->get();

    $hasil = [];

    foreach ($kelasDiambil as $k) {
        $totalPertemuan = Kehadiran::where('kelas_id', $k->id)
            ->where('mahasiswa_nrp', $mahasiswa->nrp)
            ->select('pertemuan_ke')
            ->distinct()
            ->count();

        $hadir = Kehadiran::where('kelas_id', $k->id)
            ->where('mahasiswa_nrp', $mahasiswa->nrp)
            ->where('is_present', 1)
            ->select('pertemuan_ke')
            ->distinct()
            ->count();

        $persenHadir = $totalPertemuan > 0
            ? round(($hadir / $totalPertemuan) * 100, 2)
            : 0;

        $hasil[] = [
            'kelas'     => $k->mataKuliah->name ?? '-',
            'dosen'     => $k->dosen->user->name ?? '-',
            'sks'       => $k->sks ?? 0,
            'kehadiran' => $persenHadir
        ];
    }

    // Feedback dosen
    $feedback = Feedback::where('kategori_id', 2)
        ->where('target_id', $userId)
        ->with('pengirim')
        ->get();

    // =============================
    // GRAFIK RATA-RATA PER PERIODE
    // =============================
   $grafik_labels = [];
$grafik_values = [];

$all_periode_grafik = Periode::orderBy('id')->get();

foreach ($all_periode_grafik as $p) {

    $kelasPerPeriode = Kelas::where('periode_id', $p->id)
        ->whereHas('enrollment', function ($q) use ($mahasiswa) {
            $q->where('mahasiswa_nrp', $mahasiswa->nrp);
        })
        ->get();

    if ($kelasPerPeriode->count() === 0) continue;

    $total = 0;
    $count = 0;

    foreach ($kelasPerPeriode as $k) {

        $totalPertemuan = Kehadiran::where('kelas_id', $k->id)
            ->distinct()
            ->count('pertemuan_ke');

        $hadir = Kehadiran::where('kelas_id', $k->id)
            ->where('mahasiswa_nrp', $mahasiswa->nrp)
            ->where('is_present', 1)
            ->distinct()
            ->count('pertemuan_ke');

        if ($totalPertemuan > 0) {
            $total += ($hadir / $totalPertemuan) * 100;
            $count++;
        }
    }

    if ($count > 0) {
        $grafik_labels[] = $p->nama_periode;
        $grafik_values[] = round($total / $count, 1);
    }
}

    return view('mahasiswa.laporan', [
        'isBaru'        => false,
        'all_periode'   => $all_periode,
        'periode_id'    => $periode_id,
        'mahasiswa'     => $mahasiswa,
        'hasil'         => $hasil,
        'feedback'      => $feedback,
        'grafik_labels' => $grafik_labels,
        'grafik_values' => $grafik_values
    ]);
}

    public function laporan_export_excel(Request $request)
    {
        $userId = auth()->id();
        $mahasiswa = Mahasiswa::where('user_id', $userId)->firstOrFail();

        $periode_id = $request->periode_id ?? Periode::max('id');

        $kelasDiambil = Kelas::with(['mata_kuliah', 'dosen'])
            ->where('periode_id', $periode_id)
            ->whereHas('enrollment', function ($q) use ($mahasiswa) {
                $q->where('mahasiswa_nrp', $mahasiswa->nrp);
            })
            ->get();

        $hasil = [];

        foreach ($kelasDiambil as $k) {

            $totalPertemuan = Kehadiran::where('kelas_id', $k->id)->count();

            $hadir = Kehadiran::where('kelas_id', $k->id)
                ->where('mahasiswa_nrp', $mahasiswa->nrp)
                ->where('status', 'hadir')
                ->count();

            $persenHadir = $totalPertemuan > 0
                ? round(($hadir / $totalPertemuan) * 100, 2)
                : 0;

            $hasil[] = [
                'matkul' => $k->mata_kuliah->nama ?? '-',
                'dosen'  => $k->dosen->user->name ?? '-',
                'sks'    => $k->sks ?? '-',
                'hadir'  => $persenHadir
            ];
        }

        // EXCEL
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Mata Kuliah');
        $sheet->setCellValue('B1', 'Dosen');
        $sheet->setCellValue('C1', 'SKS');
        $sheet->setCellValue('D1', 'Kehadiran (%)');

        $row = 2;
        foreach ($hasil as $h) {
            $sheet->setCellValue("A{$row}", $h['matkul']);
            $sheet->setCellValue("B{$row}", $h['dosen']);
            $sheet->setCellValue("C{$row}", $h['sks']);
            $sheet->setCellValue("D{$row}", $h['hadir']);
            $row++;
        }

        $filename = "laporan_mahasiswa_kehadiran.xlsx";
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename);
    }

  public function laporan_export_pdf($periode_id)
{

    $userId = auth()->id();

    $mahasiswa = Mahasiswa::with('user', 'program_studi')
        ->where('user_id', $userId)
        ->firstOrFail();

    $kelasDiambil = Kelas::with(['mataKuliah', 'dosen.user'])
        ->where('periode_id', $periode_id)
        ->whereHas('enrollment', function ($q) use ($mahasiswa) {
            $q->where('mahasiswa_nrp', $mahasiswa->nrp);
        })
        ->get();

    $hasil = [];

    foreach ($kelasDiambil as $k) {

        $totalPertemuan = Kehadiran::where('kelas_id', $k->id)
            ->distinct('pertemuan_ke')
            ->count('pertemuan_ke');

        $hadir = Kehadiran::where('kelas_id', $k->id)
            ->where('mahasiswa_nrp', $mahasiswa->nrp)
            ->where('is_present', 1)
            ->distinct('pertemuan_ke')
            ->count('pertemuan_ke');

        $persen = $totalPertemuan > 0
            ? round(($hadir / $totalPertemuan) * 100, 2)
            : 0;

        $hasil[] = [
            'matkul' => $k->mataKuliah->name ?? '-',
            'dosen'  => $k->dosen->user->name ?? '-',
            'sks'    => $k->sks ?? '-',
            'hadir'  => $persen
        ];
    }

    $feedback = Feedback::where('kategori_id', 2)
        ->where('target_id', $userId)
        ->with('pengirim')
        ->get();

    $html = view('mahasiswa.laporan_pdf', compact(
        'mahasiswa',
        'hasil',
        'feedback'
    ))->render();

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return $dompdf->stream(
        "laporan_kehadiran_{$mahasiswa->nrp}.pdf",
        ["Attachment" => true]
    );
}


   public function feedback() {
      $kategori = Kategori::all();
      return view('mahasiswa.feedback', ['kategori' => $kategori]);
   }

   public function get_targets(Request $request) {
      $kategoriId = $request->kategori_id;
        
      // Cari detail kategori untuk mengetahui target_role nya
      $kategori = Kategori::find($kategoriId);
      
      if (!$kategori) {
         return response()->json([]);
      }

      $data = [];

      // Switch case berdasarkan kolom 'target_role' di database kategori_kpi
      // Asumsi value target_role: 'dosen', 'fasilitas', 'unit', 'akademik'
      switch ($kategori->target_role) {
         case 'dosen':
               // Ambil data dosen + nama user
               $data = Dosen::with('user')->get()->map(function($dosen) {
                  return [
                     'id' => $dosen->user_id, // ID Dosen (bukan User ID) untuk disimpan di target_id
                     'name' => $dosen->user->name ?? 'Nama Tidak Ditemukan'
                  ];
               });
               break;

         case 'fasilitas':
               $data = Fasilitas::all();
               break;

         case 'unit':
               $data = Unit::all();
               break;

         default:
               // Jika kategori umum/lainnya, mungkin tidak butuh target spesifik
               $data = []; 
               break;
      }

      return response()->json($data);
   }

   public function insertFeedback(Request $request) 
   {
      $validated = $request->validate([
         'kategori' => 'required|exists:kategori,id',
         'target' => 'required',
         'deskripsi' => 'required|string|max:255',
         'file' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
      ]);
      $isAnonim = $request->has('anonim') ? 1 : 0;
      $path = null;
      if ($request->hasFile('file')) {
         $path = $request->file('file')->store('foto', 'public');
      }
      $user = auth()->user();
      if($request->kategori == 1) {
         $target_type = 'App\Models\Dosen';
      } elseif($request->kategori == 3) {
         $target_type = 'App\Models\Fasilitas';
      } else {
         $target_type = 'App\Models\Unit';
      }
      $mahasiswa = Mahasiswa::where('user_id', $user->id)->firstOrFail();
      Feedback::create([
         'pengirim_id' => $user->id, 
         'kategori_id' => $validated['kategori'],
         'target_id' => $validated['target'],
         'target_type' => $target_type,
         'isi' => $validated['deskripsi'],
         'foto' => $path,
         'is_anonymous' => $isAnonim,
      ]);
      return redirect()
         ->route('mahasiswa.feedback')
         ->with('success', 'Feedback berhasil dikirim!');
   }

}
