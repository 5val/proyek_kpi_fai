<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function dashboard() {
      return view('admin.dashboard');
   }

   public function user() {
      return view('admin.user');
   }

   public function form_user() {
      return view('admin.form_user');
   }

   public function fasilitas() {
      return view('admin.fasilitas');
   }

   public function form_fasilitas() {
      return view('admin.form_fasilitas');
   }

   public function unit() {
      return view('admin.unit');
   }

   public function form_unit() {
      return view('admin.form_unit');
   }

   public function periode() {
      return view('admin.periode');
   }

   public function mata_kuliah() {
      return view('admin.mata_kuliah');
   }

   public function form_mata_kuliah() {
      return view('admin.form_mata_kuliah');
   }

   public function kelas() {
      return view('admin.kelas');
   }

   public function form_kelas() {
      return view('admin.form_kelas');
   }

   public function enrollment() {
      return view('admin.enrollment');
   }

   public function form_enrollment() {
      return view('admin.form_enrollment');
   }

   public function kategori_kpi() {
      return view('admin.kategori_kpi');
   }

   public function list_indikator() {
      return view('admin.list_indikator');
   }

   public function form_indikator() {
      return view('admin.form_indikator');
   }

   public function penilaian() {
      return view('admin.penilaian');
   }

   public function detail_penilaian() {
      return view('admin.detail_penilaian');
   }

   public function laporan() {
      return view('admin.laporan');
   }

   public function feedback() {
      return view('admin.feedback');
   }
}
