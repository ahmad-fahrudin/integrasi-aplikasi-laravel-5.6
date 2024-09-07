<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Models\Mase;
use Auth;
use Hash;
use Crypt;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response,File;
use DateTime;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class RijectController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function inputriject(){
    $d['bm'] = DB::table('tb_reject as a')->select("*")->where("a.status","=","aktif")->where("a.tanggal_input","=",date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
    if(count($d['bm']) > 0){
      $var = substr($d['bm'][0]->no_reject,9,3);
      $data['number'] = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
    }else{
      $data['number'] = "001";
    }
    if (Auth::user()->level == "1") {
      $data['suplayer'] = DB::table('tb_suplayer as a')->select("*")->where("a.status","=","aktif")->get();
      $data['gudang'] = $this->model->getGudang();
    }else{
      $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.id","=",Auth::user()->gudang)->get();
      if (Auth::user()->gudang != "1") {
        $data['suplayer'] = DB::table('tb_suplayer as a')->select("*")->where("a.status","=","aktif")->get();
      }else{
        $data['suplayer'] = DB::table('tb_suplayer as a')->select("*")->where("a.status","=","aktif")->where("a.id","=","7")->get();
      }
    }
    $data['karyawan'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();
    $data['barang'] = DB::table('tb_barang as a')->join('tb_harga as b','b.id_barang','=','a.id')->select("a.*","harga")->where("a.status","=","aktif")->get();
    return view('Riject',$data);
  }

  public function cekstok($gudang,$id){
    $data = DB::table('tb_gudang_barang as a')->select("*")->where("id_gudang","=",$gudang)->where("id_barang","=",$id)->get();
    echo json_encode($data);
  }

  public function postbarangriject(Request $post){
    $data = $post->except('_token','no_reject');

    $da['bm'] = DB::table('tb_reject as a')->select("*")->where("a.tanggal_input","=",date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
    if(count($da['bm']) > 0){
      $var = substr($da['bm'][0]->no_reject,9,3);
      $number = str_pad($var + 1, 3, '0', STR_PAD_LEFT);;
    }else{
      $number = "001";
    }
    $data['no_reject'] = 'RJ-'.date('ymd').$number;
    $data['admin_g'] = Auth::user()->id;
    $data['status'] = "aktif";
    DB::table('tb_reject')->insert($data);

    echo $data['no_reject'];
  }

  public function postdetailbarangriject(Request $post){
    $data = $post->except('_token','id_gudang','id_barang','jumlah');
    $str_idbarang = explode(',',$post->only('id_barang')['id_barang']);
    $str_jumlah = explode(',',$post->only('jumlah')['jumlah']);

    for ($i=1; $i < count($str_jumlah); $i++) {
      if ($str_jumlah[$i] != "" && $str_jumlah[$i] > 0) {
        $data['id_barang'] = $str_idbarang[$i];
        $data['jumlah'] = $str_jumlah[$i];
        $data['status'] = "pending";
        /*DB::table('tb_gudang_barang')
        ->where('id_barang','=',$data['id_barang'])
        ->where('id_gudang','=', $post->only('id_gudang')['id_gudang'])
        ->decrement('jumlah',  $data['jumlah']);*/

        DB::table('tb_detail_reject')->insert($data);
      }
    }
  }

  public function daftariject(){
    if (role()) {

      if (Auth::user()->level == "1") {
        $data['reject'] = DB::table('tb_reject as a')
                          ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                          ->join('tb_barang as e','e.id','=','b.id_barang')
                          ->select("*","b.id as id_val")->where("b.status","=","pending")->get();
      }elseif(Auth::user()->level == "4"){
        $data['reject'] = DB::table('tb_reject as a')
                          ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                          ->join('tb_barang as e','e.id','=','b.id_barang')
                          ->select("*","b.id as id_val")->where("b.status","=","pending")
                          ->where("a.id_gudang","=","1")->get();
      }else{
        $data['reject'] = DB::table('tb_reject as a')
                          ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                          ->join('tb_barang as e','e.id','=','b.id_barang')
                          ->select("*","b.id as id_val")->where("b.status","=","pending")
                          ->where("a.id_gudang","<>","1")->get();
      }
      $d = DB::table('tb_karyawan as a')->select("*")->get();
      foreach ($d as $key => $value) {
        $data['karyawan'][$value->id] = $value->nama;
      }
      $e = DB::table('users as a')->select("*")->get();
      foreach ($e as $key => $value) {
        $data['admin'][$value->id] = $value->name;
      }
      return view('DaftarRiject',$data);
    }else{
      return view('Denied');
    }
  }

  public function validasiriject($id){
    $x['admin_validasi'] = Auth::user()->id;
    $x['status'] = "aktif";

    $ava =  DB::table('tb_detail_reject as a')->join('tb_reject as b','b.no_reject','=','a.no_reject')->select("*")->where("a.id","=",$id)->get();

    $q1 = DB::table('tb_detail_reject')->where('id','=',$id)->update($x);
    //echo $ava[0]->id_barang." ".$ava[0]->id_gudang." ".$ava[0]->jumlah;
    if ($q1) {
      if ($ava[0]->id_gudang == "1") {
          $trc1 = DB::table('tb_gudang_barang')
          ->where('id_barang','=',$ava[0]->id_barang)
          ->where('id_gudang','=', $ava[0]->id_gudang)
          ->decrement('jumlah',  $ava[0]->jumlah);

          //tracking data
          if ($trc1) {
            $tracking['jenis_transaksi'] = "validasiriject".$id;
            $tracking['nomor'] = "trc1";
            $tracking['gudang'] = $ava[0]->id_gudang;
            $tracking['barang'] = $ava[0]->id_barang;
            $tracking['jumlah'] = $ava[0]->jumlah;
            $tracking['stok'] = "out";
            DB::table('tracking')->insert($tracking);
          }

      }else{
        $q2 = DB::table('tb_gudang_barang')
        ->where('id_barang','=',$ava[0]->id_barang)
        ->where('id_gudang','=', "1")
        ->increment('jumlah',  $ava[0]->jumlah);

        //tracking data
        if ($q2) {
          $tracking['jenis_transaksi'] = "validasiriject".$id;
          $tracking['nomor'] = "q2";
          $tracking['gudang'] = "1";
          $tracking['barang'] = $ava[0]->id_barang;
          $tracking['jumlah'] = $ava[0]->jumlah;
          $tracking['stok'] = "in";
          DB::table('tracking')->insert($tracking);
        }

        if ($q2) {
          $trc2 = DB::table('tb_gudang_barang')
          ->where('id_barang','=',$ava[0]->id_barang)
          ->where('id_gudang','=', $ava[0]->id_gudang)
          ->decrement('jumlah',  $ava[0]->jumlah);

          //tracking data
          if ($trc2) {
            $tracking['jenis_transaksi'] = "validasiriject".$id;
            $tracking['nomor'] = "trc2";
            $tracking['gudang'] = $ava[0]->id_gudang;
            $tracking['barang'] = $ava[0]->id_barang;
            $tracking['jumlah'] = $ava[0]->jumlah;
            $tracking['stok'] = "out";
            DB::table('tracking')->insert($tracking);
          }

        }
      }
    }
    return redirect()->back()->with('success','Berhasil');
  }

  public function batalriject($id){
    $x['admin_validasi'] = Auth::user()->id;
    $x['status'] = "cancel";

    $ava =  DB::table('tb_detail_reject as a')->join('tb_reject as b','b.no_reject','=','a.no_reject')->select("*")->where("a.id","=",$id)->get();

    DB::table('tb_detail_reject')->where('id','=',$id)->update($x);

    return redirect()->back()->with('success','Berhasil');
  }

  public function datareject(){
    if (Auth::user()->level == "1" || Auth::user()->level =="4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")) {
      $data['gudang'] = $this->model->getGudang();
    }else{
      $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
    }
    if (Auth::user()->level == "1" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")) {
      $data['reject'] = DB::table('tb_reject as a')
                        ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                        ->join('tb_gudang as c','c.id','=','a.id_gudang')
                        ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                        ->join('tb_barang as e','e.id','=','b.id_barang')
                        ->select("*","b.status as status")
                        ->where("a.status","=","aktif")
                        ->where("b.status","<>","pending")
                        ->get();
    }else{
      $data['reject'] = DB::table('tb_reject as a')
                        ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                        ->join('tb_gudang as c','c.id','=','a.id_gudang')
                        ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                        ->join('tb_barang as e','e.id','=','b.id_barang')
                        ->select("*","b.status as status")->where("a.status","=","aktif")
                        ->where("b.status","<>","pending")
                        ->where("a.id_gudang","=",Auth::user()->gudang)
                        ->get();
    }
    $d = DB::table('tb_karyawan as a')->select("*")->get();
    foreach ($d as $key => $value) {
      $data['karyawan'][$value->id] = $value->nama;
    }
    $e = DB::table('users as a')->select("*")->get();
    foreach ($e as $key => $value) {
      $data['admin'][$value->id] = $value->name;
    }
    $data['nama_download'] = "Data Reject";
    return view('DataReject',$data);
  }

  public function datarejects(Request $post){
    $data = $post->except('_token');

    if ($data['nama_barang'] != null ||$data['nama_barang'] != "" ) {
      $nm = $data['nama_barang'];
    }

    if ($data['id_gudang'] != "" && $data['id_gudang'] != null) {
       $x['id_gudang'] = $data['id_gudang'];
    }

    if (isset($x)) {

        if (isset($data['from']) && isset($data['to']) && isset($nm)) {
          $from = $data['from'];
          $to = $data['to'];

          if (Auth::user()->level == "1"|| Auth::user()->level =="4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")) {
            $data['reject'] = DB::table('tb_reject as a')
                              ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                              ->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                              ->join('tb_barang as e','e.id','=','b.id_barang')
                              ->select("*","b.status as status")->where("a.status","=","aktif")->where("b.status","<>","pending")
                              ->where($x)
                              ->where('nama_barang','like',"%$nm%")
                              ->whereBetween('a.tanggal_input',[$from,$to])->get();
          }else{
            $data['reject'] = DB::table('tb_reject as a')
                              ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                              ->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                              ->join('tb_barang as e','e.id','=','b.id_barang')
                              ->select("*","b.status as status")->where("a.status","=","aktif")->where("b.status","<>","pending")
                              ->where($x)
                              ->where('nama_barang','like',"%$nm%")
                              ->whereBetween('a.tanggal_input',[$from,$to])
                              ->where("a.id_gudang","=",Auth::user()->gudang)->get();
          }


        }else if (isset($nm)) {
          if (Auth::user()->level == "1"|| Auth::user()->level =="4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")) {
            $data['reject'] = DB::table('tb_reject as a')
                              ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                              ->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                              ->join('tb_barang as e','e.id','=','b.id_barang')
                              ->select("*","b.status as status")->where("a.status","=","aktif")->where("b.status","<>","pending")
                              ->where($x)
                              ->where('nama_barang','like',"%$nm%")->get();
          }else{
            $data['reject'] = DB::table('tb_reject as a')
                              ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                              ->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                              ->join('tb_barang as e','e.id','=','b.id_barang')
                              ->select("*","b.status as status")->where("a.status","=","aktif")->where("b.status","<>","pending")
                              ->where($x)
                              ->where("a.id_gudang","=",Auth::user()->gudang)->get();
          }
        }else{
          if (Auth::user()->level == "1"|| Auth::user()->level =="4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")) {
            $data['reject'] = DB::table('tb_reject as a')
                              ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                              ->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                              ->join('tb_barang as e','e.id','=','b.id_barang')
                              ->select("*","b.status as status")->where("a.status","=","aktif")->where("b.status","<>","pending")->where($x)->get();
          }else{
            $data['reject'] = DB::table('tb_reject as a')
                              ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                              ->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                              ->join('tb_barang as e','e.id','=','b.id_barang')
                              ->select("*","b.status as status")->where("a.status","=","aktif")->where($x)
                              ->where("a.id_gudang","=",Auth::user()->gudang)->where("b.status","<>","pending")->get();
          }
        }

  }else{

    if (isset($data['from']) && isset($data['to']) && isset($nm)) {
      $from = $data['from'];
      $to = $data['to'];

      if (Auth::user()->level == "1"|| Auth::user()->level =="4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")) {
        $data['reject'] = DB::table('tb_reject as a')
                          ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                          ->join('tb_barang as e','e.id','=','b.id_barang')
                          ->select("*","b.status as status")->where("a.status","=","aktif")->where("b.status","<>","pending")
                          ->where('nama_barang','like',"%$nm%")
                          ->whereBetween('a.tanggal_input',[$from,$to])->get();
      }else{
        $data['reject'] = DB::table('tb_reject as a')
                          ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                          ->join('tb_barang as e','e.id','=','b.id_barang')
                          ->select("*","b.status as status")->where("a.status","=","aktif")->where("b.status","<>","pending")
                          ->where('nama_barang','like',"%$nm%")
                          ->whereBetween('a.tanggal_input',[$from,$to])
                          ->where("a.id_gudang","=",Auth::user()->gudang)->get();
      }


    }else if (isset($nm)) {
      if (Auth::user()->level == "1"|| Auth::user()->level =="4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")) {
        $data['reject'] = DB::table('tb_reject as a')
                          ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                          ->join('tb_barang as e','e.id','=','b.id_barang')
                          ->select("*","b.status as status")->where("a.status","=","aktif")->where("b.status","<>","pending")
                          ->where('nama_barang','like',"%$nm%")->get();
      }else{
        $data['reject'] = DB::table('tb_reject as a')
                          ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                          ->join('tb_barang as e','e.id','=','b.id_barang')
                          ->select("*","b.status as status")->where("a.status","=","aktif")->where("b.status","<>","pending")
                          ->where("a.id_gudang","=",Auth::user()->gudang)->get();
      }
    }else{
      if (Auth::user()->level == "1"|| Auth::user()->level =="4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")) {
        $data['reject'] = DB::table('tb_reject as a')
                          ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                          ->join('tb_barang as e','e.id','=','b.id_barang')
                          ->select("*","b.status as status")->where("a.status","=","aktif")->where("b.status","<>","pending")->get();
      }else{
        $data['reject'] = DB::table('tb_reject as a')
                          ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_suplayer as d','d.id','=','a.id_suplayer')
                          ->join('tb_barang as e','e.id','=','b.id_barang')
                          ->select("*","b.status as status")->where("a.status","=","aktif")
                          ->where("a.id_gudang","=",Auth::user()->gudang)->where("b.status","<>","pending")->get();
      }
    }

  }


    if (Auth::user()->level == "1" || Auth::user()->level =="4" || (Auth::user()->level == "3" && Auth::user()->gudang == "1")) {
      $data['gudang'] = $this->model->getGudang();
    }else{
      $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
    }
    $d = DB::table('tb_karyawan as a')->select("*")->get();
    foreach ($d as $key => $value) {
      $data['karyawan'][$value->id] = $value->nama;
    }
    $e = DB::table('users as a')->select("*")->get();
    foreach ($e as $key => $value) {
      $data['admin'][$value->id] = $value->name;
    }
    $data['nama_download'] = "Data Reject";
    return view('DataReject',$data);
  }

} ?>
