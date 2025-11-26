<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Cell;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;


class DosenController extends Controller
{
    public function dashboard() {
    return view('dosen.dashboard');
    }

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
}
