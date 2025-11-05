<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Fasilitas;
use App\Models\Mahasiswa;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
   public function dashboard() {
      return view('mahasiswa.dashboard');
   }

   public function profile(){
      return view('mahasiswa.profile');
   }
   public function kpi(){
      return view('mahasiswa.kpi');
   }
   public function kelas(){
      return view('mahasiswa.kelas');
   }

   public function penilaian_dosen() {
      return view('mahasiswa.penilaian_dosen');
   }
   public function penilaian_fasilitas() {
      return view('mahasiswa.penilaian_fasilitas');
   }
   public function penilaian_unit() {
      return view('mahasiswa.penilaian_unit');
   }
   public function penilaian_praktikum() {
      return view('mahasiswa.penilaian_praktikum');
   }

   public function laporan() {
      return view('mahasiswa.laporan');
   }

   public function feedback() {
      return view('mahasiswa.feedback');
   }
}
