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

class LockController extends Controller
{
  var $model;
  public function __construct()
  {     
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function lockinvestasi(){
    if (Auth::user()->level == "1" || Auth::user()->level == "4") {
      $data['lock'] = DB::table('tb_lock_investasi as a')
                              ->select("*")
                              ->whereNotNull("status")
                              ->get();

      date_default_timezone_set('Asia/Jakarta');
      $data['bagi'] = DB::table('tb_lock_investasi')->select("*")
              ->whereDate("next_bagi","<=",date('Y-m-d'))
              ->where("status","lock")->get();

    }else{
      $data['lock'] = DB::table('tb_lock_investasi as a')
                              ->select("*")
                              ->where("id_investor",cekmyid_investor())
                              ->whereNotNull("status")
                              ->get();
    }
    $data['pending_pati'] = DB::table('tb_pengadaan_investasi as a')
                            ->select(DB::raw('SUM(a.jumlah_investasi) as jumlah_investasi'))
                            ->where('a.id_pengambil',Auth::user()->id)
                            ->whereNull('a.status')
                            ->get();
    $data['pending_jkt'] = DB::table('tb_pengadaan_investasi_jkt as a')
                            ->select(DB::raw('SUM(a.jumlah_investasi) as jumlah_investasi'))
                            ->where('a.id_pengambil',Auth::user()->id)
                            ->whereNull('a.status')
                            ->get();
    $data['karyawan'] = DB::table('tb_investor as a')->where("a.status","aktif")->select("*")->get();
    $investor = DB::table('tb_investor as a')->select("*")->get();
    $data['investor'] = array();
    foreach ($investor as $key => $value) {
      $data['investor'][$value->id]['nama'] = $value->nama_investor;
    }
    return view('LockInvestasi',$data);
  }

  public function cektransaksipending($id){
    $user = DB::table('users as a')
                      ->where("a.nik",$id)
                      ->select("*")->get();

    $inv = DB::table('tb_investor as a')
                      ->where("a.nik",$id)
                      ->select("*")->get();


    $lock = DB::table('tb_lock_investasi as a')
                            ->select(DB::raw('SUM(a.jumlah_lock) as jumlah_locking'))
                            ->where('a.id_investor',$inv[0]->id)
                            ->where('a.status','lock')
                            ->get();
    $lock2 = DB::table('tb_lock_investasi_2 as a')
                            ->select(DB::raw('SUM(a.jumlah_lock) as jumlah_locking'))
                            ->where('a.id_investor',$inv[0]->id)
                            ->where('a.status','lock')
                            ->get();

    $lock3 = DB::table('tb_transaksi as a')
                            ->select(DB::raw('SUM(a.jumlah) as jumlah_tarik'))
                            ->where('a.id_investor',$inv[0]->id)
                            ->where('a.status','pending')
                            ->get();

   $cek = 0;
   if (count($lock) > 0) {
     $cek += $lock[0]->jumlah_locking;
   };
   if (count($lock2) > 0) {
     $cek += $lock2[0]->jumlah_locking;
   }
   if (count($lock3) > 0) {
     $cek += $lock3[0]->jumlah_tarik;
   }

    $data['pending'] = $cek;
    echo json_encode($data);

  }

  public function simpanlock(Request $post){
    date_default_timezone_set('Asia/Jakarta');
    $d = $post->except('_token');

    $data['durasi'] = $d['durasi'];
    if ($data['durasi'] == "3") {
      $data['share'] = perseninvestor()[0]->investasiLS3;
    }else if($data['durasi'] == "6"){
      $data['share'] = perseninvestor()[0]->investasiLS6;
    }else if ($data['durasi'] == "12") {
      $data['share'] = perseninvestor()[0]->investasiLS12;
    }
    $data['id_investor'] = $d['id_investor'];
    $data['tgl_lock'] = date('Y-m-d');
    $x = strtotime(date('Y-m-d'));
    $data['next_bagi'] = date("Y-m-d",strtotime("+1 month",$x));
    $data['status'] = "lock";
    $data['jumlah_lock'] = str_replace(".","",$d['saldo']);
    $data['admin_lock'] = Auth::user()->id;

    if ($data['jumlah_lock'] > 0) {
      $query = DB::table('tb_lock_investasi')->insert($data);
      if ($query) {
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back()->withErrors(['msg', 'The Message']);
      }
    }else{
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function simpanlock2(Request $post){
    date_default_timezone_set('Asia/Jakarta');
    $d = $post->except('_token');
    $data['id_investor'] = $d['id_investor'];
    $data['tgl_lock'] = date('Y-m-d');
    $x = strtotime(date('Y-m-d'));
    $data['tgl_open'] = date("Y-m-d",strtotime("+".$d['durasi']." month",$x));
    $data['status'] = "lock";
    $data['durasi'] = $d['durasi'];
    $data['jumlah_lock'] = str_replace(".","",$d['saldo']);
    $data['admin_lock'] = Auth::user()->id;
    if ($data['jumlah_lock'] > 0) {
      $query = DB::table('tb_lock_investasi_2')->insert($data);
      if ($query) {
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back()->withErrors(['msg', 'The Message']);
      }
    }else{
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function unlock($id){
    $data['status'] = "unlock";
    $data['admin_unlock'] = Auth::user()->id;
    DB::table('tb_lock_investasi')->where('id',$id)->update($data);
    echo json_encode($data);
  }

  public function lock($id){
    date_default_timezone_set('Asia/Jakarta');
    $data['status'] = "lock";
    $data['admin_unlock'] = Auth::user()->id;
    $x = strtotime(date('Y-m-d'));
    $data['next_bagi'] = date("Y-m-d",strtotime("+1 month",$x));
    $data['tgl_lock'] = date('Y-m-d');
    DB::table('tb_lock_investasi')->where('id',$id)->update($data);
    echo json_encode($data);
  }

  public function deletelock($id){
    $data['status'] = null;
    $data['admin_delete'] = Auth::user()->id;
    DB::table('tb_lock_investasi')->where('id',$id)->update($data);
    echo json_encode($data);
  }

  public function verifikasi_lock_investasi($id){
    $cek = DB::table('tb_lock_investasi')->where('id',$id)->get();
    $x = strtotime($cek[0]->next_bagi);
    $data['next_bagi'] = date("Y-m-d",strtotime("+1 month",$x));
    $query = DB::table('tb_lock_investasi')->where('id',$id)->update($data);

    $inv = DB::table('tb_investor')->where('id',$cek[0]->id_investor)->get();
    $u['id_investor'] = $cek[0]->id_investor;
    $u['jumlah'] = $cek[0]->share/100*$cek[0]->jumlah_lock;
    $u['saldo_temp'] = $inv[0]->saldo + $u['jumlah'];
    $u['jenis'] = "lock";
    $u['admin'] = Auth::user()->id;
    $u['id_lock'] = $id;

    $dlr = DB::table('tb_labarugi')->select("*")->where('status','aktif')->orderBy("id","DESC")->limit(1)->get();
    $lr['jumlah'] = $cek[0]->share/100*$cek[0]->jumlah_lock;
    $lr['saldo_temp'] = $dlr['0']->saldo_temp + $lr['jumlah'];
    $lr['jenis'] = "out";
    $lr['nama_jenis'] = "Bagi Hasil Lock Investasi";
    $lr['admin'] = Auth::user()->id;
    $lr['keterangan'] = "(".$cek[0]->jumlah_lock.") - ".$inv['0']->nama_investor;
    DB::table('tb_labarugi')->insert($lr);

    if ($query) {
      $input = DB::table('tb_transaksi')->insert($u);
      $c['saldo'] = $u['saldo_temp'];
      $update = DB::table('tb_investor')->where('id',$cek[0]->id_investor)->update($c);

      if ($update) {
        if ($inv[0]->pengembang != "") {
          $inv_pengembang = DB::table('tb_investor')->where('id',$inv[0]->pengembang)->get();
          $up['id_investor'] = $inv[0]->pengembang;
          $up['jumlah'] = perseninvestor()[0]->investasi_P * $u['jumlah'];
          $up['saldo_temp'] = $inv_pengembang[0]->saldo + $up['jumlah'];
          $up['jenis'] = "lockpengembang";
          $up['admin'] = Auth::user()->id;
          $up['keterangan'] = $inv['0']->nama_investor;
          $input_pengembang = DB::table('tb_transaksi')->insert($up);

          if ($input_pengembang) {
            $pi['saldo'] = $up['jumlah'];
            $update_investor_pegembang = DB::table('tb_investor')->where('id',$inv[0]->pengembang)->increment('saldo', $pi['saldo']);
          }

          if ($update_investor_pegembang) {
            $dlr_pengembang = DB::table('tb_labarugi')->select("*")->where('status','aktif')->orderBy("id","DESC")->limit(1)->get();
            $lr_pengembang['jumlah'] = $up['jumlah'];
            $lr_pengembang['saldo_temp'] = $dlr_pengembang['0']->saldo_temp + $lr_pengembang['jumlah'];
            $lr_pengembang['jenis'] = "out";
            $lr_pengembang['nama_jenis'] = "Fee Pengembang Lock Investasi (".$inv['0']->nama_investor.") - ";
            $lr_pengembang['admin'] = Auth::user()->id;
            $lr_pengembang['keterangan'] = $inv_pengembang['0']->nama_investor;
            DB::table('tb_labarugi')->insert($lr_pengembang);
          }
        }

        if ($inv[0]->leader != "") {
          $inv_leader = DB::table('tb_investor')->where('id',$inv[0]->leader)->get();
          $ul['id_investor'] = $inv[0]->leader;
          $ul['jumlah'] = perseninvestor()[0]->investasi_L * $u['jumlah'];
          $ul['saldo_temp'] = $inv_leader[0]->saldo + $ul['jumlah'];
          $ul['jenis'] = "lockleader";
          $ul['admin'] = Auth::user()->id;
          $ul['keterangan'] = $inv['0']->nama_investor;
          $input_leader = DB::table('tb_transaksi')->insert($ul);

          if ($input_leader) {
            $li['saldo'] = $ul['jumlah'];
            $update_investor_leader = DB::table('tb_investor')->where('id',$inv[0]->leader)->increment('saldo', $li['saldo']);
          }

          if ($update_investor_leader) {
            $dlr_leader= DB::table('tb_labarugi')->select("*")->where('status','aktif')->orderBy("id","DESC")->limit(1)->get();
            $lr_leader['jumlah'] = perseninvestor()[0]->investasi_L * $u['jumlah'];
            $lr_leader['saldo_temp'] = $dlr_leader['0']->saldo_temp + $lr_leader['jumlah'];
            $lr_leader['jenis'] = "out";
            $lr_leader['nama_jenis'] = "Fee Leader Lock Investasi (".$inv['0']->nama_investor.") - ";
            $lr_leader['admin'] = Auth::user()->id;
            $lr_leader['keterangan'] = $inv_leader['0']->nama_investor;
            DB::table('tb_labarugi')->insert($lr_leader);
          }
        }

      }

    }
    echo json_encode($data);
  }



  public function lockinvestasinonbagi(){
    if (Auth::user()->level == "1" || Auth::user()->level == "4") {
      $data['lock'] = DB::table('tb_lock_investasi_2 as a')
                              ->select("*")
                              ->whereNotNull("status")
                              ->get();
    }else{
      $data['lock'] = DB::table('tb_lock_investasi_2 as a')
                              ->select("*")
                              ->where("id_investor",cekmyid_investor())
                              ->whereNotNull("status")
                              ->get();
    }
    $data['karyawan'] = DB::table('tb_investor as a')->where("a.status","aktif")->select("*")->get();
    $investor = DB::table('tb_investor as a')->select("*")->get();
    $data['investor'] = array();
    foreach ($investor as $key => $value) {
      $data['investor'][$value->id]['nama'] = $value->nama_investor;
    }
    return view('LockInvestasiNonBagi',$data);
  }

  public function unlock2($id){
    $data['status'] = "unlock";
    $data['admin_unlock'] = Auth::user()->id;
    DB::table('tb_lock_investasi_2')->where('id',$id)->update($data);
    echo json_encode($data);
  }

  public function deletelock2($id){
    $data['status'] = null;
    $data['admin_delete'] = Auth::user()->id;
    DB::table('tb_lock_investasi_2')->where('id',$id)->update($data);
    echo json_encode($data);
  }
}
