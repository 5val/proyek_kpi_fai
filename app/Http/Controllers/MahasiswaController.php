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
   

      // Data Mahasiswa
      $mahasiswa = Mahasiswa::where('user_id', $userId)->firstOrFail();

      // Kelas sesuai prodi dan periode aktif
      $kelasSaya = Kelas::where('program_studi_id', $mahasiswa->program_studi_id)
         ->where('periode_id', $periodeAktif)
         ->get();

      $dosenIds = $kelasSaya->pluck('dosen_nidn')->unique();
      $totalDosen = $dosenIds->count();

      $dosenSudah = Penilaian::where('kategori_id', 1)
         ->where('penilai_id', $userId)
         ->whereIn('dinilai_id', $dosenIds)
         ->count();

      $dosenBelum = max(0, $totalDosen - $dosenSudah);

      $praktikumIds = $kelasSaya->where('has_praktikum', 1)->pluck('id');
      $totalPraktikum = $praktikumIds->count();

      $praktikumSudah = Penilaian::where('kategori_id', 4)
         ->where('penilai_id', $userId)
         ->whereIn('dinilai_id', $praktikumIds)
         ->count();

      $praktikumBelum = max(0, $totalPraktikum - $praktikumSudah);

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

      $penilaianSaya = Penilaian::where('kategori_id', 2)
         ->where('dinilai_id', $userId)
         ->where('periode_id', $periodeAktif)
         ->pluck('id');

      $penilaianSemua = Penilaian::where('kategori_id', 2)
         ->where('periode_id', $periodeAktif)
         ->pluck('id');

      $indikatorList = Indikator::where('kategori_id', 2)->get();

      $hasilIndikator = [];
      $totalSaya = 0;
      $jumlahIndikator = count($indikatorList);

      // Feedback (dikeluarkan dari loop!)
      $feedback = Feedback::where('kategori_id', 2)
         ->where('target_id', $userId)
         ->with('pengirim')
         ->get();

      foreach ($indikatorList as $indikator) {

         $nilaiSaya = DetailPenilaian::whereIn('penilaian_id', $penilaianSaya)
               ->where('indikator_id', $indikator->id)
               ->avg('score');

         $rataSemua = DetailPenilaian::whereIn('penilaian_id', $penilaianSemua)
               ->where('indikator_id', $indikator->id)
               ->avg('score');

         if ($nilaiSaya === null) {
               $status = 'Belum dinilai';
         } elseif ($nilaiSaya > $rataSemua) {
               $status = 'Sangat Baik';
         } elseif ($nilaiSaya == $rataSemua) {
               $status = 'Cukup';
         } else {
               $status = 'Perlu Ditingkatkan';
         }

         $totalSaya += ($nilaiSaya ?? 0);

         $hasilIndikator[] = [
               'indikator' => $indikator->name,
               'nilai_saya' => $nilaiSaya ? round($nilaiSaya, 2) : 0,
               'rata_semua' => $rataSemua ? round($rataSemua, 2) : 0,
               'status' => $status
         ];
      }

      $kpiSaya = $jumlahIndikator > 0 ? round($totalSaya / $jumlahIndikator, 2) : 0;

      $dosenBelumList = User::whereHas('dosen', function($q) use ($dosenIds){
            $q->whereIn('nidn', $dosenIds);
         })
         ->whereNotIn('id', Penilaian::where('kategori_id', 1)
            ->where('penilai_id', $userId)
            ->pluck('dinilai_id')
         )
         ->limit(1)
         ->get();

      // 2. Praktikum belum dinilai
      $praktikumBelumList = Kelas::whereIn('id', $praktikumIds)
         ->whereNotIn('id', Penilaian::where('kategori_id', 4)
            ->where('penilai_id', $userId)
            ->pluck('dinilai_id')
         )
         ->limit(1)
         ->get();

      // 3. Unit belum dinilai
      $unitBelumList = Unit::whereNotIn('id', Penilaian::where('kategori_id', 5)
            ->where('penilai_id', $userId)
            ->pluck('dinilai_id')
         )
         ->limit(1)
         ->get();

      // 4. Fasilitas belum dinilai
      $fasilitasBelumList = Fasilitas::whereNotIn('id', Penilaian::where('kategori_id', 6)
            ->where('penilai_id', $userId)
            ->pluck('dinilai_id')
         )
         ->limit(1)
         ->get();

      return view('mahasiswa.dashboard', compact(
         'periodeAktif',

         'totalDosen', 'dosenSudah', 'dosenBelum',
         'totalPraktikum', 'praktikumSudah', 'praktikumBelum',
         'totalUnit', 'unitSudah', 'unitBelum',
         'totalFasilitas', 'fasilitasSudah', 'fasilitasBelum',

         'hasilIndikator', 'kpiSaya', 'feedback', 'mahasiswa', 'dosenBelumList', 'fasilitasBelumList', 'praktikumBelumList', 'unitBelumList', 'kelasSaya'
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
      $mahasiswa = auth()->user()->mahasiswa; 
      $dosenList = Enrollment::with('kelas.dosen.user')
         ->where('mahasiswa_nrp', $mahasiswa->nrp)
         ->get()
         ->pluck('kelas.dosen')      
         ->filter()                  
         ->unique('nidn')            
         ->map(function ($dosen) {   
               return $dosen->user;
         });
      return view('mahasiswa.penilaian_dosen', compact('dosenList'));
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

    // Semua periode
    $all_periode = Periode::orderBy('id', 'desc')->get();
    $periode_id = $request->periode_id ?? Periode::max('id');

    // Ambil kelas yang diikuti mahasiswa pada periode tersebut
    $kelasDiambil = Kelas::with(['mata_kuliah', 'dosen'])
        ->where('periode_id', $periode_id)
        ->whereHas('enrollment.mahasiswa', function ($q) use ($mahasiswa) {
            $q->where('mahasiswa_nrp', $mahasiswa->id);
        })
        ->get();

    $hasil = [];

    foreach ($kelasDiambil as $k) {

        // Total Pertemuan
        $totalPertemuan = Kehadiran::where('kelas_id', $k->id)->count();

        // Kehadiran mahasiswa
        $hadir = Kehadiran::where('kelas_id', $k->id)
            ->where('mahasiswa_nrp', $mahasiswa->id)
            ->where('status', 'hadir')
            ->count();

        $persenHadir = $totalPertemuan > 0
            ? round(($hadir / $totalPertemuan) * 100, 2)
            : 0;

        $hasil[] = [
            'kelas'      => $k->mata_kuliah->nama,
            'dosen'      => $k->dosen->name,
            'sks'        => $k->sks ?? 0,
            'kehadiran'  => $persenHadir
        ];
    }

    // Ambil feedback dosen
    $feedback = Feedback::where('kategori_id', 2)
        ->where('target_id', $userId)
        ->with('pengirim')
        ->get();

    return view('mahasiswa.laporan', [
        'all_periode' => $all_periode,
        'periode_id' => $periode_id,
        'mahasiswa' => $mahasiswa,
        'hasil' => $hasil,
        'feedback' => $feedback
    ]);
}

   public function feedback() {
      $kategori = Kategori::where('id', '!=', 2)->where('id', '!=', 5)->get();
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
