<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Enrollment;
use App\Models\Fasilitas;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Periode;
use App\Models\Unit;
use App\Models\User;
use App\Models\Indikator;
use App\Models\Penilaian;
use App\Models\DetailPenilaian;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Cell;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Controllers\DB;


class DosenController extends Controller
{
    // DASHBOARD

    public function dashboard() {
    return view('dosen.dashboard');
    }

//     public function dashboard()
// {
//     $user = Auth::user();

//     // Ambil data dosen berdasarkan user_id
//     $dosen = Dosen::where('user_id', $user->id)->first();

//     if (!$dosen) {
//         return back()->with('error', 'Data dosen tidak ditemukan.');
//     }

//     /*
//     |--------------------------------------------------------------------------
//     | 1. SKOR KINERJA DOSEN (Kategori: dosen)
//     |--------------------------------------------------------------------------
//     | dari tabel: penilaian + detail_penilaian
//     */
//     $kategoriDosen = Kategori::where('name', 'dosen')->first();

//     $skorKinerja = DetailPenilaian::whereHas('penilaian', function ($q) use ($dosen, $kategoriDosen) {
//         $q->where('dinilai_id', $dosen->nidn)
//           ->where('kategori_id', $kategoriDosen->id); 
//     })->avg('score') ?? 0;


//     /*
//     |--------------------------------------------------------------------------
//     | 2. MAHASISWA BIMBINGAN
//     |--------------------------------------------------------------------------
//     | dari tabel mahasiswa (FK: mahasiswa.dosen_nidn)
//     */
//     $bimbingan = Mahasiswa::where('dosen_nidn', $dosen->nidn)->get();
//     $jumlahBimbingan = $bimbingan->count();


//     /*
//     |--------------------------------------------------------------------------
//     | 3. MAHASISWA BELUM DINILAI (Kategori: mahasiswa)
//     |--------------------------------------------------------------------------
//     | dinilai_id = mahasiswa.nrp
//     */
//     $kategoriMhs = Kategori::where('name', 'mahasiswa')->first();

//     $pendingMahasiswa = Mahasiswa::where('dosen_nidn', $dosen->nidn)
//         ->whereDoesntHave('penilaian', function ($q) use ($kategoriMhs, $dosen) {
//             $q->where('kategori_id', $kategoriMhs->id)
//               ->where('penilai_id', $dosen->nidn);
//         })
//         ->get();


//     /*
//     |--------------------------------------------------------------------------
//     | 4. TREND SKOR KINERJA PER PERIODE / SEMESTER
//     |--------------------------------------------------------------------------
//     | ambil rata-rata score dari detail_penilaian grouped by periode
//     */
//     $trend = DetailPenilaian::select(
//             'penilaian.periode_id',
//             DB::raw('AVG(detail_penilaian.score) as avg_skor')
//         )
//         ->join('penilaian', 'penilaian.id', '=', 'detail_penilaian.penilaian_id')
//         ->where('penilaian.dinilai_id', $dosen->nidn)
//         ->where('penilaian.kategori_id', $kategoriDosen->id)
//         ->groupBy('penilaian.periode_id')
//         ->join('periode', 'periode.id', '=', 'penilaian.periode_id')
//         ->orderBy('periode.tahun')
//         ->orderBy('periode.semester')
//         ->get();


//     /*
//     |--------------------------------------------------------------------------
//     | 5. RATING PER INDIKATOR (Kategori: dosen)
//     |--------------------------------------------------------------------------
//     */
//     $ratingIndikator = DetailPenilaian::select(
//             'indikator_id',
//             DB::raw('AVG(score) as avg_score')
//         )
//         ->whereHas('penilaian', function ($q) use ($dosen, $kategoriDosen) {
//             $q->where('dinilai_id', $dosen->nidn)
//               ->where('kategori_id', $kategoriDosen->id);
//         })
//         ->with('indikator')
//         ->groupBy('indikator_id')
//         ->get();


//     /*
//     |--------------------------------------------------------------------------
//     | RETURN KE DASHBOARD VIEW
//     |--------------------------------------------------------------------------
//     */
//     return view('dosen.dashboard', [
//         'user'              => $user,
//         'dosen'             => $dosen,
//         'skorKinerja'       => $skorKinerja,
//         'jumlahBimbingan'   => $jumlahBimbingan,
//         'pendingMahasiswa'  => $pendingMahasiswa,
//         'trend'             => $trend,
//         'ratingIndikator'   => $ratingIndikator,
//     ]);
// }


    // PROFILE 

    public function profile()
    {
        $user = Auth::user();

        $dosen = Dosen::where('user_id', $user->id)->first();

        return view('dosen.profile', [
            'user' => $user,
            'dosen' => $dosen,
        ]);
    }
    
     public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,'. $user->id,
            'phone' => 'required|string|max:13|unique:users,phone_number,'. $user->id,
        ]);

        $user->update([
            'email' => $request->email,
            'phone_number' => $request->phone,
        ]);

        return redirect()->route('dosen.profile')->with('success', 'Profil berhasil diperbarui.');
    }   
    
    public function changePassword(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
    
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama yang Anda masukkan salah.');
        }
    
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
    
        return back()->with('success', 'Password berhasil diubah.');
    }

    // KPI SAYA
    
    public function kpi()
    {

        $user = Auth::user();

        $dosen = Dosen::where('user_id', $user->id)->first();
        
        return view('dosen.kpi', [
            'user' => $user,
            'dosen' => $dosen,
        ]);
    }

    // KELAS 
    public function uploadProfpic(Request $request, $id)
    {
      $request->validate([
         'file' => 'required|file|mimes:jpg,jpeg,png|max:5120',
      ]);
      $dosen = Dosen::where('user_id', $id)->firstOrFail();
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
         ->route('dosen.profile')
         ->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function kelas()
    {
        $user = Auth::user();

        $dosen = Dosen::where('user_id', $user->id)->first();

        // Ambil semua kelas yang diajar oleh dosen ini (via relasi)
        $kelasList = Kelas::with('mataKuliah', 'program_studi', 'periode')->withCount('enrollment')->where('dosen_nidn', $dosen->nidn)->where('is_active', 1)->get();

        return view('dosen.kelas', [
            'user' => $user,
            'kelasList' => $kelasList,
        ]);
    }

    public function insert_kehadiran($id) {
      $kelas = Kelas::with('mataKuliah', 'program_studi', 'periode', 'dosen.user')->findOrFail($id);
      return view('dosen.form_kehadiran', ['kelas' => $kelas]);
    }

    public function download_kehadiran($id) {
      $kelas = Kelas::with('mataKuliah', 'dosen.user', 'periode')->where('id', $id)->first();
      $filePath = storage_path('app/template_excel/template_kehadiran.xlsx');

      if (!file_exists($filePath)) {
         abort(404, 'Template file not found.');
      }

      // Load Excel template
      $spreadsheet = IOFactory::load($filePath);
      $sheet = $spreadsheet->getActiveSheet();

      $mahasiswas = Enrollment::where('kelas_id', $id)->pluck('mahasiswa_nrp')->toArray() ?? []; // adjust relation name

      $row = 2;
      foreach ($mahasiswas as $mhs) {
         $sheet->setCellValue("A{$row}", $mhs);
         $sheet->setCellValue("B{$row}", 1);
         $row++;
      }

      /*
      |-----------------------------------------------------------
      | Return the modified XLSX file as a download
    |-----------------------------------------------------------
    */
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $tempFile = tempnam(sys_get_temp_dir(), 'excel_');
    $writer->save($tempFile);

    return response()->download($tempFile, 'template_enrollment_filled.xlsx');
   }

   public function upload_kehadiran(Request $request, $id) {
      $request->validate([
            'pertemuan' => 'required',
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Skip header row (row 0)
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];

            // Skip completely empty rows
            if (empty(array_filter($row))) {
               continue;
            }

            Kehadiran::create([
               'kelas_id' => $id,
               'pertemuan_ke' => $request->pertemuan,
               'mahasiswa_nrp' => $row[0] ?? null,
               'is_present' => $row[1] ?? null,
            ]);
         }

        return redirect()->route('dosen.kelas')->with('success', 'Kehadiran uploaded successfully.');
   }

    // PENILAIAN MAHASISWA 

    public function penilaianMahasiswa()
    {
        $user = Auth::user();

        $dosen = Dosen::where('user_id', $user->id)->first();
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        // eager-load user dan penilaian
        $mahasiswaList = Mahasiswa::with(['user', 'penilaian'])
            ->get();

        return view('dosen.penilaian_mahasiswa', [
            'user' => $user,
            'dosen' => $dosen,
            'mahasiswaList' => $mahasiswaList,
        ]);
    }

    public function penilaianManajemen() {
      return redirect()->route('penilaian.form', ['tipe' => 'manajemen', 'id' => 1]);
    }

// public function penilaianMahasiswa()
// {
//     $user = Auth::user();
//     $dosen = Dosen::where('user_id', $user->id)->first();

//     // Ambil mahasiswa melalui relasi: Dosen → Kelas → Enrollment → Mahasiswa → User
//     $mahasiswaList = Mahasiswa::whereHas('enrollments.kelas', function ($q) use ($dosen) {
//         $q->where('dosen_nidn', $dosen->nidn);
//     })
//     ->with(['user', 'enrollments.kelas'])
//     ->get();

//     return view('dosen.penilaian_mahasiswa', [
//         'user' => $user,
//         'dosen' => $dosen,
//         'mahasiswaList' => $mahasiswaList,
//     ]);
// }
    // PENILAIAN FASILITAS

       public function penilaianFasilitas() {
      $fasilitas = Fasilitas::paginate(10);
      return view('dosen.penilaian_fasilitas', ['fasilitas' => $fasilitas]);
   }

    // PENILAIAN UNIT 
       public function penilaianUnit() {
      $units = Unit::with('penanggungJawab')->paginate(10);
      return view('dosen.penilaian_unit', ['units' => $units]);
   }

    // LAPORAN KERJA 
//     public function laporanKinerja()
//     {
//         $user = Auth::user();
    
//         // CEGAH ERROR: Jika user belum punya data dosen
//         $dosen = Dosen::where('user_id', $user->id)->first();
    
//         // Ambil semua indikator
//         $indikator = Indikator::all();
    
//         // Ambil nilai KPI untuk dosen ini
//         $nilai = Penilaian::where('dosen_id', $dosen->id)
//             ->select('indikator_id', DB::raw('AVG(skor) as skor'))
//             ->groupBy('indikator_id')
//             ->get()
//             ->keyBy('indikator_id');
    
//         // Hitung skor akhir
//         $skorAkhir = $nilai->avg('skor') ?? 0;
    
//         // Tentukan kategori
//         $kategori = 'Buruk';
//         if ($skorAkhir >= 3.5) $kategori = 'Sangat Baik';
//         elseif ($skorAkhir >= 3.0) $kategori = 'Baik';
//         elseif ($skorAkhir >= 2.0) $kategori = 'Cukup';
    
//     return view('dosen.laporan', [
//         'user' => $user,
//         'dosen' => $dosen,
//         'indikator' => $indikator,
//         'nilai' => $nilai,
//         'skorAkhir' => $skorAkhir,
//         'kategori' => $kategori
//     ]);
// }

   
    public function laporanKinerja()
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        $indikator = Indikator::where('kategori_id', 1)->get();
        return view('dosen.laporan', compact('user', 'dosen', 'indikator'));
    }

    public function feedback() {
      $kategori = Kategori::where('id', '!=', 1)->get();
      return view('dosen.feedback', ['kategori' => $kategori]);
    }
}
