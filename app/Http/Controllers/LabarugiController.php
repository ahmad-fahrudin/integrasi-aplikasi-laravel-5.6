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

class LabarugiController extends Controller
{
  var $model;
  public function __construct()
  {     
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function labarugi(){
    if (role()) {
     $data['labarugi'] = DB::table('tb_labarugi as a')
                           ->select("*")
                           ->where("a.status","aktif")
                           ->orderBy("a.id","ASC")
                           ->orderBy("a.tgl_verifikasi","ASC")
                           ->get();
     $text_admin = DB::table('users as a')->select("a.*")->get();
     $data['admin'] = array();
     $data['nama_download'] = "Data Laba Rugi";
     foreach ($text_admin as $value) {
       $data['admin'][$value->id] =$value->name;
     }
      return view('LabaRugi',$data);
    }else{
      return view('Denied');
    }
  }

  public function labarugis(Request $post){
    if (role()) {
      $data = $post->except('_token');

      $data['labarugi'] = DB::table('tb_labarugi as a')
                           ->select("*")
                           ->where("a.status","aktif")
                           ->whereBetween('tgl_transaksi',[$data['from'],$data['to']])
                           ->orderBy("a.id","ASC")
                           ->orderBy("a.tgl_verifikasi","ASC")
                           ->get();
     $text_admin = DB::table('users as a')->select("a.*")->get();
     $data['admin'] = array();
     $data['nama_download'] = "Data Laba Rugi";
     foreach ($text_admin as $value) {
       $data['admin'][$value->id] =$value->name;
     }
      return view('LabaRugi',$data);
    }else{
      return view('Denied');
    }
  }

  public function proseslabarugi(Request $post){
    if (role()) {
      $data = $post->except('_token');
      $data['jumlah'] = str_replace(".","",$data['jumlah']);
      $data['old_saldo'] = str_replace(".","",$data['old_saldo']);
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
        DB::table('tb_labarugi')->insert($t);

        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back()->withErrors(['msg', 'The Message']);
      }
    }
  }

  public function pendingkwitansi($id){
    if (role()) {
      $data = DB::table('tb_detail_trip as a')
              ->join('tb_trip as b','b.no_trip','=','a.no_trip')
              ->select("*")->where("a.id",$id)->get();
      $n['no_trip'] = $data[0]->no_trip."P";
      $que = DB::table('tb_detail_trip')->where('id',$id)->update($n);
      if ($que) {
        $cek = DB::table('tb_trip as a')
                ->select("*")->where("a.no_trip",$n['no_trip'])->get();
        if(count($cek) < 1){
          $i['no_trip'] = $n['no_trip'];
          $i['tanggal_input'] = $data[0]->tanggal_input;
          $i['kategori'] = $data[0]->kategori;
          $i['id_gudang'] = $data[0]->id_gudang;
          $i['driver'] = $data[0]->driver;
          $i['qc'] = $data[0]->qc;
          $i['admin'] = $data[0]->admin;
          DB::table('tb_trip')->insert($i);
        }
      }
      echo json_encode($data);
    }
  }

}
?>
