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

    // Ambil data mahasiswa
    $mahasiswa = Mahasiswa::where('user_id', $userId)->firstOrFail();
   
    // 1. KELAS YANG DIAMBIL MAHASISWA
    $enrollment = Enrollment::with('kelas.dosen.user')
        ->where('mahasiswa_nrp', $mahasiswa->nrp)
        ->get();

    $kelasSaya = $enrollment->pluck('kelas');

    // *** TANDAKAN MAHASISWA BARU ***
    $isBaru = $kelasSaya->count() === 0;


    // 2. DOSEN PENGAJAR
    $dosenUsers = $kelasSaya
        ->pluck('dosen.user')
        ->filter()
        ->unique('id')
        ->values();

    $dosenIds = $dosenUsers->pluck('id');
    $totalDosen = $dosenIds->count();

    $dosenSudah = Penilaian::where('kategori_id', 1)
        ->where('penilai_id', $userId)
        ->whereIn('dinilai_id', $dosenIds)
        ->count();

    $dosenBelum = max(0, $totalDosen - $dosenSudah);


    // 3. PRAKTIKUM
    $praktikumIds = $kelasSaya
        ->where('has_praktikum', 1)
        ->pluck('id');

    $totalPraktikum = $praktikumIds->count();

    $praktikumSudah = Penilaian::where('kategori_id', 4)
        ->where('penilai_id', $userId)
        ->whereIn('dinilai_id', $praktikumIds)
        ->count();

    $praktikumBelum = max(0, $totalPraktikum - $praktikumSudah);


    // 4. UNIT & FASILITAS
    $totalUnit = Unit::count();
    $unitSudah = Penilaian::where('kategori_id', 5)
        ->where('penilai_id', $userId)
        ->count();
    $unitBelum = max(0, $totalUnit - $unitSudah);

    $totalFasilitas = Fasilitas::count();
    $fasilitasSudah = Penilaian::where('kategori_id', 6)
        ->where('penilai_id', $userId)
        ->count();
    $fasilitasBelum = max(0, $totalFasilitas - $fasilitasSudah);


    // 5. GRAFIK KEHADIRAN
    $all_periode = Periode::orderBy('id')->get();

    $grafik_labels = [];
    $grafik_values = [];

    foreach ($all_periode as $p) {

        $kelasPerPeriode = Enrollment::with('kelas')
            ->where('mahasiswa_nrp', $mahasiswa->nrp)
            ->whereHas('kelas', function($q) use ($p) {
                $q->where('periode_id', $p->id);
            })
            ->get()
            ->pluck('kelas');

        if ($kelasPerPeriode->count() == 0) continue;

        $total = 0;
        $count = 0;

        foreach ($kelasPerPeriode as $k) {

            $totalPertemuan = Kehadiran::where('kelas_id', $k->id)->count();

            $hadir = Kehadiran::where('kelas_id', $k->id)
                ->where('mahasiswa_nrp', $mahasiswa->nrp)
                ->where('is_present', 1)
                ->count();

            $persen = ($totalPertemuan > 0) 
                ? round(($hadir / $totalPertemuan) * 100, 1)
                : 0;

            $total += $persen;
            $count++;
        }

        $grafik_labels[] = $p->nama_periode;
        $grafik_values[] = $count > 0 ? round($total / $count, 1) : 0;
    }


    // 6. LIST BELUM DINILAI
    $dosenBelumList = $dosenUsers->filter(function($d) use ($userId) {
        return !Penilaian::where('kategori_id', 1)
            ->where('penilai_id', $userId)
            ->where('dinilai_id', $d->id)
            ->exists();
    })->take(1);

    $praktikumBelumList = $kelasSaya
        ->where('has_praktikum', 1)
        ->filter(function($k) use ($userId) {
            return !Penilaian::where('kategori_id', 4)
                ->where('penilai_id', $userId)
                ->where('dinilai_id', $k->id)
                ->exists();
        })
        ->take(1);

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


    // RETURN VIEW
    return view('mahasiswa.dashboard', compact(
        'mahasiswa',
        'isBaru',
        'dosenSudah','dosenBelum',
        'praktikumSudah','praktikumBelum',
        'unitSudah','unitBelum',
        'fasilitasSudah','fasilitasBelum',
        'dosenBelumList','praktikumBelumList','unitBelumList','fasilitasBelumList',
        'kelasSaya',
        'grafik_labels','grafik_values'
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

      // Ambil mahasiswa
      $mahasiswa = auth()->user()->mahasiswa;

      // Dosen dari kelas yang diambil mahasiswa
      $dosenList = Enrollment::with('kelas.dosen.user')
         ->where('mahasiswa_nrp', $mahasiswa->nrp)
         ->get()
         ->pluck('kelas.dosen')
         ->filter()
         ->unique('nidn')
         ->map(function ($dosen) {
               return $dosen; // user = model User dosen
         })
         ->values(); // reset index

      // ===========================
      // AMBIL DATA PENILAIAN
      // ===========================
      $penilaian = Penilaian::where('kategori_id', 1) // kategori dosen
         ->where('penilai_id', $userId)
         ->get();

      // ===========================
      // PISAHKAN DOSEN SUDAH & BELUM DINILAI
      // ===========================

      $dosenSudah = [];
      $dosenBelum = [];

      foreach ($dosenList as $d) {

         $sudah = false;

         // Cek manual satu per satu
         foreach ($penilaian as $p) {
               if ($p->dinilai_id == $d->id) { 
                  $sudah = true;
                  break;
               }
         }

         if ($sudah) {
               $dosenSudah[] = $d;
         } else {
               $dosenBelum[] = $d;
         }
      }

      return view('mahasiswa.penilaian_dosen', [
         'dosenBelum' => $dosenBelum,
         'dosenSudah' => $dosenSudah,
      ]);
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
        $totalPertemuan = Kehadiran::where('kelas_id', $k->id)->count();

        $hadir = Kehadiran::where('kelas_id', $k->id)
            ->where('mahasiswa_nrp', $mahasiswa->nrp)
            ->where('is_present', 1)
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

    foreach ($all_periode as $p) {

        $kelas = Kelas::where('periode_id', $p->id)
            ->whereHas('enrollment', function ($q) use ($mahasiswa) {
                $q->where('mahasiswa_nrp', $mahasiswa->nrp);
            })
            ->get();

        if ($kelas->count() == 0) continue;

        $total = 0;
        $count = 0;

        foreach ($kelas as $k) {
            $totalPertemuan = Kehadiran::where('kelas_id', $k->id)->count();

            $hadir = Kehadiran::where('kelas_id', $k->id)
                ->where('mahasiswa_nrp', $mahasiswa->nrp)
                ->where('is_present', 1)
                ->count();

            $persen = $totalPertemuan > 0 ? ($hadir / $totalPertemuan) * 100 : 0;

            $total += $persen;
            $count++;
        }

        $grafik_labels[] = $p->nama_periode;
        $grafik_values[] = round($total / $count, 1);
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

  public function laporan_export_pdf(Request $request)
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
                'dosen'  => $k->dosen->name ?? '-',
                'sks'    => $k->sks ?? '-',
                'hadir'  => $persenHadir
            ];
        }

        $feedback = Feedback::where('kategori_id', 2)
            ->where('target_id', $userId)
            ->with('pengirim')
            ->get();

        // Render HTML
        $html = view('mahasiswa.laporan_pdf', [
            'hasil' => $hasil,
            'feedback' => $feedback,
            'mahasiswa' => $mahasiswa
        ])->render();

        // PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("laporan_mahasiswa.pdf");
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
