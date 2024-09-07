<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Models\Mase;
use Auth;
use Illuminate\Support\Facades\Hash;
use Crypt;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response,File;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class KasController extends Controller
{
  var $model;
  public function __construct()
  {   
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function kasditangan(){
    if (Auth::user()->level == '1' || Auth::user()->level == '4') {
      $data['kasditangan'] = DB::table('tb_kas_ditangan as a')
                            ->select("*")
                            ->where("a.status","aktif")
                            ->whereNull("a.exception")
                            ->orderBy("a.id","ASC")
                            ->orderBy("a.tgl_verifikasi","ASC")
                            ->get();
      $data['rekening'] = DB::table('tb_rekening as a')
                            ->select("*")
                            ->where("a.status","aktif")
                            ->get();
      $text_admin = DB::table('users as a')->select("a.*")->get();
      $data['admin'] = array();
      $data['nama_download'] = "Data Kas Ditangan";
      foreach ($text_admin as $value) {
        $data['admin'][$value->id] =$value->name;
      }
      return view('KasDiTangan',$data);
    }
  }

  public function kasditangans(Request $post){
    if (Auth::user()->level == '1' || Auth::user()->level == '4') {
      $data = $post->except('_token');
      if ($data['from'] !="") {
        $from = $data['from'];
      }
      if ($data['to'] !="") {
        $to = $data['to'];
      }
      if ($data['jenis'] != "" && $data['jenis'] != "Semua") {
        $x['jenis'] = $data['jenis'];
      }
      if ($data['nama_jenis'] != "" && $data['nama_jenis'] != "Semua") {
        $x['nama_jenis'] = $data['nama_jenis'];
      }
      $data['rekening'] = DB::table('tb_rekening as a')
                            ->select("*")
                            ->where("a.status","aktif")
                            ->get();
      if (isset($from) && isset($to) && isset($x)) {
        $data['kasditangan'] = DB::table('tb_kas_ditangan as a')
                             ->select("*")
                             ->where("a.status","aktif")
                             ->where($x)
                             ->whereBetween('tgl_transaksi',[$data['from'],$data['to']])
                             ->whereNull("a.exception")
                             ->orderBy("a.id","ASC")
                             ->orderBy("a.tgl_verifikasi","ASC")
                             ->get();
      }else if(isset($from) && isset($to)){
        $data['kasditangan'] = DB::table('tb_kas_ditangan as a')
                             ->select("*")
                             ->where("a.status","aktif")
                             ->whereBetween('tgl_transaksi',[$data['from'],$data['to']])
                             ->whereNull("a.exception")
                             ->orderBy("a.id","ASC")
                             ->orderBy("a.tgl_verifikasi","ASC")
                             ->get();
      }else if(isset($x)){
        $data['kasditangan'] = DB::table('tb_kas_ditangan as a')
                             ->select("*")
                             ->where("a.status","aktif")
                             ->where($x)
                             ->whereNull("a.exception")
                             ->orderBy("a.id","ASC")
                             ->orderBy("a.tgl_verifikasi","ASC")
                             ->get();
      }else{
        $data['kasditangan'] = DB::table('tb_kas_ditangan as a')
                              ->select("*")
                              ->where("a.status","aktif")
                              ->whereNull("a.exception")
                              ->orderBy("a.id","ASC")
                              ->orderBy("a.tgl_verifikasi","ASC")
                              ->get();
      }

     $text_admin = DB::table('users as a')->select("a.*")->get();
     $data['admin'] = array();
     $data['nama_download'] = "Data Laba Rugi";
     foreach ($text_admin as $value) {
       $data['admin'][$value->id] =$value->name;
     }
     return view('KasDiTangan',$data);
    }
  }

  public function proseskasditangan(Request $post){
    if (Auth::user()->level == '1' || Auth::user()->level == '4') {
      $data = $post->except('_token','kode_bank');
      $data['jumlah'] = str_replace(".","",$data['jumlah']);
      $data['old_saldo'] = str_replace(".","",$data['old_saldo']);
      if ($post->kode_bank != "Pilih Rekening") {
        if ($data['nama_jenis'] == "Simpan di Bank") {
          $t['kode_bank'] = $post->kode_bank;
          $y['kode_bank'] = $post->kode_bank;
        }
      }
      if ($data['old_saldo'] < 1) {
        $data['old_saldo'] = 0;
      }
      if ($data['jumlah'] > 0) {
        $t['jumlah'] = $data['jumlah'];
        if ($data['cek'] == "in") {
          $t['saldo_temp'] = $data['old_saldo'] + $data['jumlah'];
        }else{
          $t['saldo_temp'] = $data['old_saldo'] - $data['jumlah'];
        }
        $t['jenis'] = $data['cek'];
        $t['nama_jenis'] = $data['nama_jenis'];
        $t['admin'] = Auth::user()->id;
        $t['tgl_transaksi'] = $data['tgl_transaksi'];
        $t['keterangan'] = $data['keterangan'];
        $q = DB::table('tb_kas_ditangan')->insert($t);

        if ($q) {
          if ($t['nama_jenis'] == "Ambil dari Bank") {
            $y['jumlah'] = $data['jumlah'];
            $y['saldo_temp'] = 0;
            $y['jenis'] = 'out';
            $y['nama_jenis'] = "Penarikan Saldo";
            $y['admin'] = Auth::user()->id;
            $y['tgl_transaksi'] = $data['tgl_transaksi'];
            $y['keterangan'] = $data['keterangan'];
            $q = DB::table('tb_kas_dibank')->insert($y);
          }else if($t['nama_jenis'] == "Simpan di Bank"){
            $y['jumlah'] = $data['jumlah'];
            $y['saldo_temp'] = 0;
            $y['jenis'] = 'in';
            $y['nama_jenis'] = "Deposit Saldo";
            $y['admin'] = Auth::user()->id;
            $y['tgl_transaksi'] = $data['tgl_transaksi'];
            $y['keterangan'] = $data['keterangan'];
            $q = DB::table('tb_kas_dibank')->insert($y);
          }
          
          
          if ($t['nama_jenis'] == "Beban Operasional" || $t['nama_jenis'] == "Pengeluaran Lain - Lain") {
            $sa['jumlah'] = $data['jumlah'];
            $sa['saldo_temp'] = 0;
            $sa['jenis'] = 'out';
            $sa['nama_jenis'] = $t['nama_jenis'];
            $sa['admin'] = Auth::user()->id;
            $sa['keterangan'] = $data['keterangan'];
            $q = DB::table('tb_labarugi')->insert($sa);
          }else if($t['nama_jenis'] == "Pemasukan Lain - Lain"){
            $sa['jumlah'] = $data['jumlah'];
            $sa['saldo_temp'] = 0;
            $sa['jenis'] = 'in';
            $sa['nama_jenis'] = $t['nama_jenis'];
            $sa['admin'] = Auth::user()->id;
            $sa['keterangan'] = $data['keterangan'];
            $q = DB::table('tb_labarugi')->insert($sa);  
          }
          
          
          return redirect()->back()->with('success','Berhasil');
        }else{
          return redirect()->back();
        }


      }else{
        return redirect()->back()->withErrors(['msg', 'The Message']);
      }
    }
  }


  public function kasdibank(){
    if (Auth::user()->level == '1' || Auth::user()->level == '4') {
      $data['kasdibank'] = DB::table('tb_kas_dibank as a')
                            ->select("*")
                            ->where("a.status","aktif")
                            ->orderBy("a.id","ASC")
                            ->orderBy("a.tgl_verifikasi","ASC")
                            ->get();
      $data['rekening'] = DB::table('tb_rekening as a')
                            ->select("*")
                            ->where("a.status","aktif")
                            ->get();
      $text_admin = DB::table('users as a')->select("a.*")->get();
      $data['admin'] = array();
      $data['nama_download'] = "Data Kas Dibank";
      foreach ($text_admin as $value) {
        $data['admin'][$value->id] =$value->name;
      }
      return view('KasDiBank',$data);
    }
  }


  public function kasdibanks(Request $post){
    if (Auth::user()->level == '1' || Auth::user()->level == '4') {
      $data = $post->except('_token');
      if ($data['from'] !="") {
        $from = $data['from'];
      }
      if ($data['to'] !="") {
        $to = $data['to'];
      }
      if ($data['jenis'] != "" && $data['jenis'] != "Semua") {
        $x['jenis'] = $data['jenis'];
      }
      if ($data['kode_bank'] != "" && $data['kode_bank'] != "Semua") {
        $x['kode_bank'] = $data['kode_bank'];
      }
      if ($data['nama_jenis'] != "" && $data['nama_jenis'] != "Semua") {
        $x['nama_jenis'] = $data['nama_jenis'];
      }
      $data['rekening'] = DB::table('tb_rekening as a')
                            ->select("*")
                            ->where("a.status","aktif")
                            ->get();
      if (isset($from) && isset($to) && isset($x)) {
        $data['kasdibank'] = DB::table('tb_kas_dibank as a')
                             ->select("*")
                             ->where("a.status","aktif")
                             ->where($x)
                             ->whereBetween('tgl_transaksi',[$data['from'],$data['to']])
                             ->orderBy("a.id","ASC")
                             ->orderBy("a.tgl_verifikasi","ASC")
                             ->get();
      }else if(isset($from) && isset($to)){
        $data['kasdibank'] = DB::table('tb_kas_dibank as a')
                             ->select("*")
                             ->where("a.status","aktif")
                             ->whereBetween('tgl_transaksi',[$data['from'],$data['to']])
                             ->orderBy("a.id","ASC")
                             ->orderBy("a.tgl_verifikasi","ASC")
                             ->get();
      }else if(isset($x)){
        $data['kasdibank'] = DB::table('tb_kas_dibank as a')
                             ->select("*")
                             ->where("a.status","aktif")
                             ->where($x)
                             ->orderBy("a.id","ASC")
                             ->orderBy("a.tgl_verifikasi","ASC")
                             ->get();
      }else{
        $data['kasdibank'] = DB::table('tb_kas_dibank as a')
                              ->select("*")
                              ->where("a.status","aktif")
                              ->orderBy("a.id","ASC")
                              ->orderBy("a.tgl_verifikasi","ASC")
                              ->get();
      }

     $text_admin = DB::table('users as a')->select("a.*")->get();
     $data['admin'] = array();
     $data['nama_download'] = "Data Laba Rugi";
     foreach ($text_admin as $value) {
       $data['admin'][$value->id] =$value->name;
     }
     return view('KasDiBank',$data);
    }
  }


  public function proseskasdibank(Request $post){
    if (Auth::user()->level == '1' || Auth::user()->level == '4') {
      $data = $post->except('_token');
      $data['jumlah'] = str_replace(".","",$data['jumlah']);
      $data['old_saldo'] = str_replace(".","",$data['old_saldo']);

      if ($data['old_saldo'] < 1) {
        $data['old_saldo'] = 0;
      }

      if ($post->kode_bank != "Pilih Rekening") {
        $t['kode_bank'] = $post->kode_bank;
        $y['kode_bank'] = $post->kode_bank;
      }
      
      if ($post->kode_bank_transfer != "Pilih Rekening") {
        $ab['kode_bank'] = $post->kode_bank_transfer;
      }
      
      if ($data['jumlah'] > 0) {
        $t['jumlah'] = $data['jumlah'];
        if ($data['cek'] == "in") {
          $t['saldo_temp'] = $data['old_saldo'] + $data['jumlah'];
        }else{
          $t['saldo_temp'] = $data['old_saldo'] - $data['jumlah'];
        }
        $t['jenis'] = $data['cek'];
        $t['nama_jenis'] = $data['nama_jenis'];
        $t['admin'] = Auth::user()->id;
        $t['tgl_transaksi'] = $data['tgl_transaksi'];
        $t['keterangan'] = $data['keterangan'];
        $q = DB::table('tb_kas_dibank')->insert($t);
        
        if($post->kode_bank_transfer != "Pilih Rekening" || $post->kode_bank_transfer != ""){
            if($t['nama_jenis'] == "Pindah rekening bank"){
                $ab['jumlah'] = $data['jumlah'];
                $ab['saldo_temp'] = $data['old_saldo'] + $data['jumlah'];
                $ab['jenis'] = 'in';
                $ab['nama_jenis'] = $data['nama_jenis'];
                $ab['admin'] = Auth::user()->id;
                $ab['tgl_transaksi'] = $data['tgl_transaksi'];
                $ab['keterangan'] = $data['keterangan'];
                $q = DB::table('tb_kas_dibank')->insert($ab);
            }
        }

        if ($q) {
          if ($t['nama_jenis'] == "Penarikan Saldo") {
            $y['jumlah'] = $data['jumlah'];
            $y['saldo_temp'] = 0;
            $y['jenis'] = 'in';
            $y['nama_jenis'] = "Penarikan Saldo";
            $y['admin'] = Auth::user()->id;
            $y['tgl_transaksi'] = $data['tgl_transaksi'];
            $y['keterangan'] = $data['keterangan'];
            $q = DB::table('tb_kas_ditangan')->insert($y);
          }else if($t['nama_jenis'] == "Deposit Saldo"){
            $y['jumlah'] = $data['jumlah'];
            $y['saldo_temp'] = 0;
            $y['jenis'] = 'out';
            $y['nama_jenis'] = "Deposit Saldo";
            $y['admin'] = Auth::user()->id;
            $y['tgl_transaksi'] = $data['tgl_transaksi'];
            $y['keterangan'] = $data['keterangan'];
            $q = DB::table('tb_kas_ditangan')->insert($y);
          }
          
          if ($t['nama_jenis'] == "Beban Operasional" || $t['nama_jenis'] == "Pengeluaran Lain - Lain") {
            $sa['jumlah'] = $data['jumlah'];
            $sa['saldo_temp'] = 0;
            $sa['jenis'] = 'out';
            $sa['nama_jenis'] = $t['nama_jenis'];
            $sa['admin'] = Auth::user()->id;
            $sa['keterangan'] = $data['keterangan'];
            $q = DB::table('tb_labarugi')->insert($sa);
          }else if($t['nama_jenis'] == "Pemasukan Lain - Lain"){
            $sa['jumlah'] = $data['jumlah'];
            $sa['saldo_temp'] = 0;
            $sa['jenis'] = 'in';
            $sa['nama_jenis'] = $t['nama_jenis'];
            $sa['admin'] = Auth::user()->id;
            $sa['keterangan'] = $data['keterangan'];
            $q = DB::table('tb_labarugi')->insert($sa);  
          }
          
          
          
          return redirect()->back()->with('success','Berhasil');
        }else{
          return redirect()->back();
        }


      }else{
        return redirect()->back()->withErrors(['msg', 'The Message']);
      }
    }
  }

}
