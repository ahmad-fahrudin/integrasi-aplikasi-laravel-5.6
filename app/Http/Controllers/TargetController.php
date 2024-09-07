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

class TargetController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function targethpp(){
    $data['target'] = DB::table('tb_target_karyawan')->select("*")->get();
    return view('DataTargetHPP',$data);
  }

  public function targeting($id){
    if (Auth::user()->level == '1' || Auth::user()->level == '4') {
      $cek =  DB::table('tb_target_karyawan')->select("*")->where('id',$id)->get();
      if (count($cek)>0) {
        if (($cek[0]->target + $cek[0]->tambahan_target) <= $cek[0]->pencapaian_target) {
          $kr = DB::table('tb_karyawan')->select("*")->where('nama',$cek[0]->id_karyawan)->get();
          if ($kr) {
            $u['id_karyawan'] = $kr[0]->id;
            $u['nama_karyawan'] = $cek[0]->id_karyawan;
            $u['jumlah'] = $cek[0]->bonus - $cek[0]->tambahan_target;
            $u['saldo_temp'] = $u['jumlah'] ;
            $u['jenis'] = "Operasional Target";
            $u['admin'] = Auth::user()->id;
            $ut = DB::table('tb_insentif')->insert($u);
            if ($ut) {
              $up['bonus'] = '0';
              $up['pencapaian_target'] = '0';
              DB::table('tb_target_karyawan')->where('id',$cek[0]->id)->update($up);
              return redirect()->back()->with('success','Berhasil');
            }else{
              return redirect()->back();
            }
          }else{
            return redirect()->back();
          }
        }else{
          $laba = DB::table('tb_labarugi as a')->select("*")->where("a.status","aktif")->orderBy('id', 'desc')->limit(1)->get();
          $data['labarugi'] = str_replace(".","",$cek[0]->bonus);
          if (count($laba) > 0) {
            $l['saldo_temp'] = $laba[0]->saldo_temp + $data['labarugi'];
          }else{
            $l['saldo_temp'] = $data['labarugi'];
          }
          $l['jumlah'] = $data['labarugi'];
          $l['jenis'] = "in";
          $l['nama_jenis'] = "Operasional Target";
          $l['admin'] = Auth::user()->id;
          $l['no_trip'] = $cek[0]->id_karyawan;
          $input = DB::table('tb_labarugi')->insert($l);
          if ($input) {
            $up['bonus'] = '0';
            $up['pencapaian_target'] = '0';
            DB::table('tb_target_karyawan')->where('id',$cek[0]->id)->update($up);
            return redirect()->back()->with('success','Berhasil');
          }else{
            return redirect()->back();
          }
        }
      }else{
        return redirect()->back();
      }
    }else{
      return redirect()->back();
    }
  }

  public function simpantambahantarget(Request $post){
    $data = $post->except('_token');
    $cek =  DB::table('tb_target_karyawan')->select("*")->where('id',$data['id'])->get();
    if (count($cek)>0) {
      $u['tambahan_target'] = str_replace(".","",$data['nominal']) + $cek[0]->tambahan_target;
      DB::table('tb_target_karyawan')->where('id','=',$data['id'])->update($u);
    }
    return redirect()->back()->with('success','Berhasil');
  }

}
