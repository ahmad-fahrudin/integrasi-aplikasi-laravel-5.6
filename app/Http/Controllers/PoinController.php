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

class PoinController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function datapoin(){
    $data['konsumen'] = DB::table('tb_konsumen as a')
                      ->where("a.status","aktif")
                      ->select("*")->get();
    if (Auth::user()->level == "4" || Auth::user()->level == "1") {
      $data['poin'] = DB::table('tb_poin as a')
                              ->select("*")
                              ->where("a.status","aktif")
                              ->get();
    }else{
      $p = DB::table('tb_konsumen as a')->select("*")->where("a.nik",Auth::user()->nik)->get();
      $data['poin'] = DB::table('tb_poin as a')
                              ->select("*")
                              ->where("a.id_konsumen",$p[0]->id)
                              ->where("a.status","aktif")
                              ->get();
    }
    $text_admin = DB::table('users as a')->select("a.*")->get();
    $data['admin'] = array();
    foreach ($text_admin as $value) {
      $data['admin'][$value->id] =$value->name;
    }
    $data['rekening'] = DB::table('tb_rekening as a')
              ->select("*")
              ->where("a.status","aktif")
              ->get();
    return view('DataPoin',$data);
  }

  public function uppoin($id){
    $insentif = DB::table('tb_poin as a')
                            ->select("*")
                            ->where("a.id_konsumen",$id)
                            ->where("a.status","aktif")
                            ->get();
    $poin = 0;
    foreach ($insentif as $key => $value) {
      if ($value->jenis == "in"){
          $poin += $value->jumlah;
      }
      if ($value->jenis == "out"){
          $poin -= $value->jumlah;
      }
    }
    $data['poin'] = $poin;
    DB::table('tb_konsumen as a')->where("id",$id)->update($data);
  }

  public function prosespoin(Request $post){
    $data = $post->except('_token');

    $data['old_saldo'] = str_replace(".","",$data['old_saldo']);
    $data['jumlah'] = str_replace(".","",$data['jumlah']);

    $u['id_konsumen'] = $data['id_konsumen'];
    $u['nama_konsumen'] = $data['nama_konsumen'];
    $u['jumlah'] = $data['jumlah'];
    if ($data['jenis'] == "out") {
      $last = $data['old_saldo'] - $data['jumlah'];
    }else{
      $last = $data['old_saldo'] + $data['jumlah'];
    }
    $u['jenis'] = $data['jenis'];
    $u['nama_jenis'] = $data['nama_jenis'];
    $u['admin'] = Auth::user()->id;
    DB::table('tb_poin')->insert($u);

    $x['poin'] = $last;
    DB::table('tb_konsumen')->where('id',$data['id_konsumen'])->update($x);
    return redirect()->back()->with('success','Berhasil');
  }

  public function createkode(){
    if (getKodeReferal() == null) {
      $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789');
      shuffle($seed);
      $rand = '';
      $status = false;
      for ($i=0; $i < 100; $i++) {
        foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
        $karyawan = DB::table('tb_karyawan as a')->select("*")->where("kode_referal",$rand)->get();
        $konsumen = DB::table('tb_konsumen as a')->select("*")->where("kode_referal",$rand)->get();
        if (count($karyawan) < 1 && count($konsumen) < 1) {
          $u['kode_referal'] = $rand;
          DB::table('tb_konsumen')->where('nik','=',Auth::user()->nik)->update($u);
          DB::table('tb_karyawan')->where('nik','=',Auth::user()->nik)->update($u);
          return redirect()->back()->with('success','Berhasil');
        }
      }
    }else{
      return redirect()->back();
    }
  }

  public function hadiah(){
    $data['hadiah'] = DB::table('tb_hadiah')->where('status','<>','delete')->get();
    return view('Hadiah',$data);
  }

  public function simpan_hadiah(Request $post){
    $data = $post->except('_token','gbr');
    if (isset($post->gbr)) {
      if ($post->hasFile('gbr')) {
        $target_dir = "gambar/hadiah/";
        $passname = str_replace(" ","-",$post->file('gbr')->getClientOriginalName());
        $target_file = $target_dir . $passname;
        move_uploaded_file($_FILES['gbr']["tmp_name"], $target_file);
        $data['gbr'] = $passname;
      }
      $q = DB::table('tb_hadiah')->insert($data);
      if ($q) {
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back();
      }
    }
  }

  public function updatehadiah(Request $post){
    $data = $post->except('_token','gbr');
    if (isset($post->gbr)) {
      if ($post->hasFile('gbr')) {
        $target_dir = "gambar/hadiah/";
        $passname = str_replace(" ","-",$post->file('gbr')->getClientOriginalName());
        $target_file = $target_dir . $passname;
        move_uploaded_file($_FILES['gbr']["tmp_name"], $target_file);
        $data['gbr'] = $passname;
      }
    }
    $q = DB::table('tb_hadiah')->where('id',$data['id'])->update($data);
    if ($q) {
      return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back();
    }
  }

  public function hapushadiah($id){
    $data['status'] = "delete";
    $q = DB::table('tb_hadiah')->where('id',$id)->update($data);
    if ($q) {
      return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back();
    }
  }

  public function penukaranpoin(){
    $data['penukaranpoin'] = DB::table('tb_hadiah_konsumen')->where('status',"pending")->get();
    $data['selesai'] = DB::table('tb_hadiah_konsumen')->where('status',"selesai")->get();
    $data['batal'] = DB::table('tb_hadiah_konsumen')->where('status',"batal")->get();

    $konsumen = DB::table('tb_konsumen')->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id] = $value;
    }
    $hadiah = DB::table('tb_hadiah')->get();
    $data['hadiah'] = array();
    foreach ($hadiah as $key => $value) {
      $data['hadiah'][$value->id] = $value;
    }
    $provinsi =  DB::table('provinces')->get();
    $kabupaten =  DB::table('regencies')->get();
    $kecamatan =  DB::table('districts')->get();

    foreach ($provinsi as $key => $value) {
      $data['data_provinsi'][$value->id] = $value->name;
    }
    foreach ($kabupaten as $key => $value) {
      $data['data_kabupaten'][$value->id] = $value->name;
    }
    foreach ($kecamatan as $key => $value) {
      $data['data_kecamatan'][$value->id] = $value->name;
    }

    return view('PenukaranPoin',$data);
  }

  public function verifikasihadiah($id){
    $data['status'] = "selesai";
    $q = DB::table('tb_hadiah_konsumen')->where('id',$id)->update($data);
    if ($q) {
      return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back();
    }
  }

  public function batalhadiah($id){
    $q = DB::table('tb_hadiah_konsumen')->where('id',$id)->get();
    foreach ($q as $key => $value) {
      $konsumen = DB::table('tb_konsumen')->where('id',$value->id_konsumen)->get();
      $hadiah = DB::table('tb_hadiah')->where('id',$value->id_hadiah)->get();
      $u['id_konsumen'] = $konsumen[0]->id;
      $u['nama_konsumen'] = $konsumen[0]->nama_pemilik;
      $u['jumlah'] = $value->jumlah_poin;
      $u['jenis'] = 'in';
      $u['nama_jenis'] = "Gagal Penukran Poin dengan ".$hadiah[0]->nama;
      $u['admin'] = Auth::user()->id;
      $a = DB::table('tb_poin')->insert($u);

      if ($a) {
          $b = DB::table('tb_konsumen')->where('id',$konsumen[0]->id)->increment('poin',$value->jumlah_poin);
          if ($b) {
            $hk['status'] = "batal";
            DB::table('tb_hadiah_konsumen')->where('id',$id)->update($hk);
            return redirect()->back()->with('success','Berhasil');
          }
        }
    }
  }

}
