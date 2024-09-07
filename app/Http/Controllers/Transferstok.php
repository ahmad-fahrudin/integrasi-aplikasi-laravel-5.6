<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Models\Mase;
use App\Models\m_bahan_baku;
use App\Models\Universe;
use Auth;
use Hash;
use Crypt;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response,File;
use DateTime;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class Transferstok extends Controller
{
  public function __construct()
  {
      $this->model = new Mase;
      $this->bahanbaku = new m_bahan_baku;
      $this->universe = new Universe;
  }

  public function inputorderstok(){
    $d['bm'] = DB::table('tb_transfer_stok as a')->select("*")->where("a.tanggal_order","=",date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();

    if(count($d['bm']) > 0){
      $var = substr($d['bm'][0]->no_transfer,9,3);
      $data['number'] = str_pad($var + 1, 3, '0', STR_PAD_LEFT);;
    }else{
      $data['number'] = "001";
    }

    $data['barang'] = DB::table('tb_barang as a')->select("*")->where("a.status","=","aktif")->get();
    $id = Auth::user()->gudang;
    $data['gudang'] = $this->model->getGudangby($id);
    $data['kepada'] = DB::table('tb_gudang as a')->select("a.*")->where("a.status","=","aktif")->where('id','!=',$id)->get();
    $data['gudang_full'] = DB::table('tb_gudang as a')->select("a.*")->where("a.status","=","aktif")->get();
    return view('Distribusi.inputorderstok',$data);
}
public function detailBarang($to,$from){
  if ($from == '1') {
    $data = DB::table('tb_gudang_barang as a')
                          ->join('tb_barang as b','b.id','=','a.id_barang')
                          ->select("b.*","a.jumlah")
                          ->where("b.status","=","aktif")
                          ->where("a.id_gudang","=",$to)
                          ->where("a.jumlah",">","0")
                          ->get();
  }else{
    $data = DB::table('tb_gudang_barang as a')
                          ->join('tb_barang as b','b.id','=','a.id_barang')
                          ->select("b.*","a.jumlah")
                          ->where("b.status","=","aktif")
                          ->where("a.id_gudang","=",$to)
                          ->get();
  }
  echo json_encode($data);
}

public function posttransferstok(Request $post){
    $data = $post->except('_token');
    date_default_timezone_set('Asia/Jakarta');
    $d['no_transfer'] = $data['no_transfer'];
    $d['tanggal_order'] = $data['tanggal_order'];
    $d['status_transfer'] = $data['status_transfer'];
    $d['dari'] = $data['dari'];
    $d['kepada'] = $data['kepada'];
    $d['admin'] = Auth::user()->id;

    $cek = DB::table('tb_transfer_stok as a')->select("*")
           ->where("a.tanggal_order","=",date('Y-m-d'))
           ->where("a.dari","=",$d['dari'])
           ->where("a.kepada","=",$d['kepada'])
           ->where("a.admin","=",$d['admin'])
           ->where("a.status_transfer","order")
           ->orderBy('id', 'DESC')->limit(1)->get();

    if (count($cek) < 1) {
      $da['bm'] = DB::table('tb_transfer_stok as a')->select("*")->where("a.tanggal_order","=",date('Y-m-d'))->orderBy('id', 'DESC')->get();
      $status = true;
      if(count($da['bm']) > 0){
        foreach ($da['bm'] as $key => $value):
          $split = explode("P",$value->no_transfer);
          if(count($split) < 2 && $status){
            $var = substr($value->no_transfer,9,3);
            $number = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
            $status = false;
          }
        endforeach;
      }else{
        $number = "001";
      }
      $d['no_transfer'] = 'TRF'.date('ymd').$number;
      $this->model->inserttransferstok($d);
      echo $d['no_transfer'];
    }else{
      echo $cek[0]->no_transfer;
    }
  }

  public function postdetailtransferstok(Request $post){
    $data = $post->except('_token','id_barang','jumlah');
    $d['no_transfer'] = $data['no_transfer'];
    $d['tanggal_order'] = $data['tanggal_order'];
    $d['status_transfer'] = $data['status_transfer'];
    $d['dari'] = $data['dari'];
    $d['kepada'] = $data['kepada'];
    $d['admin'] = Auth::user()->id;
    $s['no_transfer'] = $data['no_transfer'];
    $s['time'] = date("h:i");
    //$s['id_barang'] = $data['id_barang'];
    //$s['jumlah'] = $data['jumlah'];

    $id_barang = explode(',',$post->only('id_barang')['id_barang']);
    $jumlah = explode(',',$post->only('jumlah')['jumlah']);

    for ($i=0; $i < count($id_barang); $i++) {
      if ($id_barang[$i] > 0) {
        $s['id_barang'] = $id_barang[$i];
        $s['jumlah'] = $jumlah[$i];

        $available = DB::table('tb_detail_transfer as a')->select("*")->where($s)->get();
        if (count($available) < 1) {
          $cek = DB::table('tb_detail_transfer as a')->select("*")->where('no_transfer',$s['no_transfer'])->where('id_barang',$s['id_barang'])->get();
          if (count($cek) < 1) {
            $this->model->insertdetailtransferstok($s);
          }else{
            $trc = DB::table('tb_detail_transfer')->where('no_transfer',$s['no_transfer'])->where('id_barang',$s['id_barang'])->increment('jumlah', $jumlah[$i]);
          }
        }
      }
    }
  }

  public function daftarorderstok(){
      $del =  date("Y-m-d",strtotime("-2 Months"));

      $cekdel = DB::table('tb_transfer_stok as a')->where('tanggal_order','<',$del)->where('status_transfer','order')->get();
      foreach ($cekdel as $key => $value) {
         DB::table('tb_transfer_stok')->where('no_transfer',$value->no_transfer)->delete();
         DB::table('tb_detail_transfer')->where('no_transfer',$value->no_transfer)->delete();
      }


      $data['gudang'] = $this->model->getGudang();
      if (Auth::user()->level == "1") {
        $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                                ->join('tb_gudang as b','b.id','=','a.dari')
                                ->join('tb_gudang as c','c.id','=','a.kepada')
                                ->select("a.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                                ->where("a.status_transfer","order")
                                ->get();
      }elseif (Auth::user()->gudang == "1") {
        $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                                ->join('tb_gudang as b','b.id','=','a.dari')
                                ->join('tb_gudang as c','c.id','=','a.kepada')
                                ->select("a.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                                ->where("a.status_transfer","order")
                                ->get();
      }else{
        $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                                ->join('tb_gudang as b','b.id','=','a.dari')
                                ->join('tb_gudang as c','c.id','=','a.kepada')
                                ->select("a.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                                ->where("a.dari",Auth::user()->gudang)
                                ->where("a.status_transfer","order")
                                ->orWhere("a.kepada",Auth::user()->gudang)
                                ->where("a.status_transfer","order")
                                ->get();
      }
      return view('Distribusi.daftarorderstok',$data);
  }

  public function daftarorderstoks(Request $post){
      $data = $post->except('_token');
      $data['gudang'] = $this->model->getGudang();

      if ($data['from'] != null) { $from = $data['from']; }
      if ($data['to'] != null) { $to = $data['to']; }
      if ($data['dari'] != null) { $x['kepada'] = $data['dari']; $dari=$data['dari']; }
      if (Auth::user()->gudang == "3" || Auth::user()->gudang == "4" || Auth::user()->level == "5" || Auth::user()->level == "6") {
        $x['dari'] = Auth::user()->gudang;
      }

      if (isset($from) && isset($x)) {
        $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                                ->join('tb_gudang as b','b.id','=','a.dari')
                                ->join('tb_gudang as c','c.id','=','a.kepada')
                                ->select("a.*","b.nama_gudang as dari","c.nama_gudang as kepada")
                                ->where($x)
                                ->whereBetween('tanggal_order',[$from,$to])
                                ->where("a.status_transfer","order")
                                ->get();
      }else if(isset($from)){
        $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                                ->join('tb_gudang as b','b.id','=','a.dari')
                                ->join('tb_gudang as c','c.id','=','a.kepada')
                                ->select("a.*","b.nama_gudang as dari","c.nama_gudang as kepada")
                                ->whereBetween('tanggal_order',[$from,$to])
                                ->where("a.status_transfer","order")
                                ->get();
      }else if(isset($x)){
        $data['transfer_stok'] = DB::table('tb_transfer_stok as a')
                                ->join('tb_gudang as b','b.id','=','a.dari')
                                ->join('tb_gudang as c','c.id','=','a.kepada')
                                ->select("a.*","b.nama_gudang as dari","c.nama_gudang as kepada")
                                ->where("a.status_transfer","order")
                                ->where($x)
                                ->get();
      }
      //dd($data);
      return view('Distribusi.daftarorderstok',$data);
  }

  public function detailTransferStok($id){
    $data = $this->model->detailTransferStokby($id);
    echo json_encode($data);
  }
  public function deleteitemtransfer($id){
    DB::table('tb_detail_transfer')->where('id', '=', $id)->delete();
    return redirect()->back()->with('success','Berhasil');
  }
  public function printdetailbarang($id){
    $data['barang'] = DB::table('tb_detail_transfer as a')
                      ->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select("a.jumlah","b.*")
                      ->where("a.no_transfer",$id)
                      ->get();
    $data['header'] = DB::table('tb_transfer_stok as a')
                      ->join('tb_gudang as b','b.id','=','a.dari')
                      ->select("*")
                      ->where("a.no_transfer",$id)
                      ->get();
    return view('Surat.DetailBarang',$data);
  }
  public function deleteOrderStok($id){
    DB::table('tb_transfer_stok')->where('no_transfer', '=', $id)->delete();
    DB::table('tb_detail_transfer')->where('no_transfer', '=', $id)->delete();
    return redirect()->back()->with('success','Berhasil');
  }

  public function printdetailorderstok($from,$to,$dari){
    if ($from != "null") { $fr = $from; }
    if ($to != "null") { $tp = $to; }
    if ($dari != "null") { $dr = $dari; }
    if (isset($fr) && isset($tp) && isset($dr)) {
      $data['data'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_gudang as b','b.id','=','a.dari')
                              ->join('tb_gudang as c','c.id','=','a.kepada')
                              ->join('tb_detail_transfer as d','d.no_transfer','=','a.no_transfer')
                              ->join('tb_barang as e','e.id','=','d.id_barang')
                              ->select("a.*","d.*","e.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                              ->where("a.status_transfer","order")
                              ->whereBetween('tanggal_order',[$fr,$tp])
                              ->where("kepada",$dr)
                              ->get();
    }elseif(isset($fr) && isset($tp)){
      $data['data'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_gudang as b','b.id','=','a.dari')
                              ->join('tb_gudang as c','c.id','=','a.kepada')
                              ->join('tb_detail_transfer as d','d.no_transfer','=','a.no_transfer')
                              ->join('tb_barang as e','e.id','=','d.id_barang')
                              ->select("a.*","d.*","e.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                              ->where("a.status_transfer","order")
                              ->whereBetween('tanggal_order',[$fr,$tp])
                              ->get();
    }elseif(isset($dr)) {
      $data['data'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_gudang as b','b.id','=','a.dari')
                              ->join('tb_gudang as c','c.id','=','a.kepada')
                              ->join('tb_detail_transfer as d','d.no_transfer','=','a.no_transfer')
                              ->join('tb_barang as e','e.id','=','d.id_barang')
                              ->select("a.*","d.*","e.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                              ->where("a.status_transfer","order")
                              ->where("kepada",$dr)
                              ->get();
    }else{
      $data['data'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_gudang as b','b.id','=','a.dari')
                              ->join('tb_gudang as c','c.id','=','a.kepada')
                              ->join('tb_detail_transfer as d','d.no_transfer','=','a.no_transfer')
                              ->join('tb_barang as e','e.id','=','d.id_barang')
                              ->select("a.*","d.*","e.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                              ->where("a.status_transfer","order")
                              ->get();
    }
    $data['nama_download'] = "Daftar Order Stok";
    return view("Surat.printdetailorderstok",$data);
  }

  public function pengiriman(){

    if (Auth::user()->level == "1") {
      $data['transfer'] = DB::table('tb_transfer_stok as a')
                          ->join('tb_gudang as b','b.id','=','a.dari')
                          ->join('tb_gudang as c','c.id','=','a.kepada')
                          ->join('users as d','d.id','=','a.admin')
                          ->select("a.*","b.nama_gudang as dari","c.nama_gudang as kepada","b.alamat as alamat_dari","c.alamat as alamat_kepada","d.name as adminp","d.id as idp")
                          ->where("a.status_transfer","=","order")->get();
    }else{
      $data['transfer'] = DB::table('tb_transfer_stok as a')
                          ->join('tb_gudang as b','b.id','=','a.dari')
                          ->join('tb_gudang as c','c.id','=','a.kepada')
                          ->join('users as d','d.id','=','a.admin')
                          ->select("a.*","b.nama_gudang as dari","c.nama_gudang as kepada","b.alamat as alamat_dari","c.alamat as alamat_kepada","d.name as adminp","d.id as idp")
                          ->where("a.kepada","=",Auth::user()->gudang)->where("a.status_transfer","=","order")->get();
    }

    //dd($data);

    $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
    $data['driver'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();

    $id = Auth::user()->gudang;
    $data['gudang'] = $this->model->getGudangby($id);
    $data['kepada'] = DB::table('tb_gudang as a')->select("a.*")->where("a.status","=","aktif")->where('id','!=',$id)->get();
    return view('Distribusi.pengiriman',$data);
}

public function pilihtransfer($id){
  $data = DB::table('tb_detail_transfer as a')
          ->join('tb_barang as b','b.id','=','a.id_barang')
          ->join('tb_transfer_stok as d','d.no_transfer','=','a.no_transfer')
          ->join('tb_gudang_barang as c',function($join){
                      $join->on("c.id_barang","=","b.id")
                           ->on("c.id_gudang","=","d.kepada");
                  })
          ->select("a.*","b.nama_barang","b.no_sku","c.jumlah as stok","d.kepada","d.dari","d.tanggal_kirim")
          ->where("a.no_transfer","=",$id)
          ->get();
  echo json_encode($data);
}

public function updateproses($id,$ids,$order){
  $data['proses'] = $id;
  $data['pending'] = $order - $id;
  DB::table('tb_detail_transfer')->where('id','=',$ids)->update($data);
  echo json_encode($data);
}


public function updatetransferstok($no_transfer,$driver,$qc){
    $data['driver'] = $driver;
    $data['qc'] = $qc;
    $data['status_transfer'] = "proses";
    $data['tanggal_kirim'] = date('Y-m-d');
    $data['admin_g'] = Auth::user()->id;
    $upd_data = DB::table('tb_transfer_stok')->where('id','=',$no_transfer)->update($data);

    $x = DB::table('tb_transfer_stok as a')->join('tb_detail_transfer as b','a.no_transfer','=','b.no_transfer')
         ->where('a.id','=',$no_transfer)->get();

    $kondisi = false;
    $a = array();
    foreach ($x as $value) {
      $pend = $value->jumlah - $value->proses;
      if($pend > 0){
        $s['no_transfer'] = $value->no_transfer."P";
        $s['id_barang'] = $value->id_barang;
        $s['jumlah'] = $pend;
        $kondisi = true;
        $cek_detail_transfer_stok = DB::table('tb_detail_transfer')->where($s)->get();
        if (count($cek_detail_transfer_stok) < 1) {
          DB::table('tb_detail_transfer')->insert($s);
        }
        $a['no_transfer'] = $value->no_transfer."P";
        $a['tanggal_order'] = $value->tanggal_order;
        $a['status_transfer'] = "order";
        $a['dari'] = $value->dari;
        $a['kepada'] = $value->kepada;
        $a['admin'] = $value->admin;
      }
    }

    if($kondisi){
      $cek_transfer_stok = DB::table('tb_transfer_stok')->where($a)->get();
      if (count($cek_transfer_stok) < 1) {
        DB::table('tb_transfer_stok')->insert($a);
      }
    }

    if($upd_data){
        echo json_encode($data);
    }

  }

  public function updatedetailtransferstok($id_barang,$id_gudang,$value){
    $loop_id_barang = explode(",",$id_barang);
    $loop_id_gudang = explode(",",$id_gudang);
    $loop_value = explode(",",$value);

    $loop = count($loop_id_barang) - 1;
    for ($i=0; $i < $loop; $i++) {
      if ($loop_value[$i] > 0) {
        $data['jumlah'] = $loop_value[$i];
        $q = DB::table('tb_gudang_barang')->where('id_barang','=',$loop_id_barang[$i])->where('id_gudang','=',$loop_id_gudang[$i])->decrement('jumlah', $loop_value[$i]);
      }
    }
    if($q){
       echo json_encode($loop_id_gudang);
    }
  }

  public function penerimaan(){
    //proses update terkirim otomatis
    $del =  date("Y-m-d",strtotime("-7 day"));
    $pending= DB::table('tb_transfer_stok as a')->select("a.*")->where("a.status_transfer","proses")->where('a.tanggal_kirim','<',$del)->get();

    foreach ($pending as $key => $value) {
      $a['status_transfer'] = "terkirim";
      date_default_timezone_set('Asia/Jakarta');
      $a['tanggal_terkirim'] = date('Y-m-d');
      $a['admin_v'] = '23';
      $que = DB::table('tb_transfer_stok')->where('no_transfer','=',$value->no_transfer)->update($a);
      if ($que) {
        $barang_pending= DB::table('tb_detail_transfer as a')->select("*")->where("a.no_transfer",$value->no_transfer)->where('a.proses','<>','0')->get();
        foreach ($barang_pending as $k => $v) {
          $b['retur'] = '0';
          $b['terkirim'] = $v->proses;
          $que1 = DB::table('tb_detail_transfer')->where('id','=',$v->id)->update($b);
          if ($que1) {
            $trc = DB::table('tb_gudang_barang')->where('id_barang','=',$v->id_barang)->where('id_gudang','=',$value->dari)->increment('jumlah', $v->proses);

          }
        }
      }
    }
    //end proses

    if (Auth::user()->level == "1") {
    $data['transfer'] = DB::table('tb_transfer_stok as a')
                          ->join('tb_gudang as b','b.id','=','a.dari')
                          ->join('tb_gudang as c','c.id','=','a.kepada')
                          ->join('users as d','d.id','=','a.admin')
                          ->join('users as e','e.id','=','a.admin_g')
                          ->join('tb_karyawan as f','f.id','=','a.qc')
                          ->join('tb_karyawan as g','g.id','=','a.driver')
                          ->select("a.*","b.nama_gudang as dari","c.nama_gudang as kepada","b.alamat as alamat_dari","c.alamat as alamat_kepada"
                                    ,"d.name as adminp","e.name as adming","f.nama as qc","g.nama as driver")
                          ->where("a.status_transfer","=","proses")
                          ->orWhere("a.status_transfer","=", 'kirim ulang')->get();
    }else{
    $data['transfer'] = DB::table('tb_transfer_stok as a')
                        ->join('tb_gudang as b','b.id','=','a.dari')
                        ->join('tb_gudang as c','c.id','=','a.kepada')->join('users as d','d.id','=','a.admin')
                        ->join('users as e','e.id','=','a.admin_g')
                        ->join('tb_karyawan as f','f.id','=','a.qc')
                        ->join('tb_karyawan as g','g.id','=','a.driver')
                        ->select("a.*","b.nama_gudang as dari","c.nama_gudang as kepada","b.alamat as alamat_dari","c.alamat as alamat_kepada"
                                  ,"d.name as adminp","e.name as adming","f.nama as qc","g.nama as driver")
                        ->where("a.dari","=",Auth::user()->gudang)
                        ->where("a.status_transfer","=","proses")
                        ->orWhere("a.status_transfer","=", 'kirim ulang')->get();
    }
    $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.jabatan","=","2")->where("a.status","=","aktif")->get();
    $data['driver'] = DB::table('tb_karyawan as a')->select("*")->where("a.jabatan","=","1")->where("a.status","=","aktif")->get();

    $id = Auth::user()->gudang;
    $data['gudang'] = $this->model->getGudangby($id);
    $data['kepada'] = DB::table('tb_gudang as a')->select("a.*")->where("a.status","=","aktif")->where('id','!=',$id)->get();
    return view('Distribusi.penerimaan',$data);
}


public function postdetailtransferpenerimaan(Request $post){
    $d= $post->except('_token');
    $barang = explode(",",$post->only('barang')['barang']);
    $pengorder = explode(",",$post->only('gudang')['gudang']);
    $terkirim = explode(",",$post->only('terkirim')['terkirim']);
    $retur = explode(",",$post->only('retur')['retur']);
    $pemroses = explode(",",$post->only('gudang_retur')['gudang_retur']);

    //update transfer
    $data['status_transfer'] = $d['status'];
    $data['admin_v'] = Auth::user()->id;
    date_default_timezone_set('Asia/Jakarta');
    $data['tanggal_terkirim'] = date('Y-m-d');
    DB::table('tb_transfer_stok')->where('id','=',$d['no_transfer'])->update($data);
    //end update transfer

    for ($i=1; $i < count($barang); $i++) {
      $at['jumlah'] = $terkirim[$i];
      $at['id_gudang'] = $pengorder[$i];
      $at['id_barang'] = $barang[$i];
      $at['status'] = "aktif";

      $alldata = $terkirim[$i] + $retur[$i];

      $cek = DB::table('tb_gudang_barang as a')->select("*")->where('id_barang','=',$barang[$i])->where('id_gudang','=',$pengorder[$i])->get();
      if (count($cek) > 0) {
          //update terkirim
          $trc = DB::table('tb_gudang_barang')->where('id_barang','=',$barang[$i])->where('id_gudang','=',$pengorder[$i])->increment('jumlah', $alldata);

          //DB::table('tb_gudang_barang')->where('id_barang','=',$barang[$i])->where('id_gudang','=',$pengorder[$i])->increment('jumlah', $terkirim[$i]);
          //update retur
          //DB::table('tb_gudang_barang')->where('id_barang','=',$barang[$i])->where('id_gudang','=',$pemroses[$i])->increment('jumlah', $retur[$i]);
      }else{
          $harga = DB::table('tb_harga as a')->select("a.harga")->where('id_barang','=',$barang[$i])->get();
          $at['harga'] = $harga[0]->harga;
          DB::table('tb_gudang_barang')->insert($at);
          $trc = DB::table('tb_gudang_barang')->where('id_barang','=',$barang[$i])->where('id_gudang','=',$pemroses[$i])->increment('jumlah', $retur[$i]);

      }
    }
    echo json_encode($data);
  }

  public function pilihtransfer2($id){
    $data = DB::table('tb_detail_transfer as a')
            ->join('tb_barang as b','b.id','=','a.id_barang')
            ->join('tb_transfer_stok as d','d.no_transfer','=','a.no_transfer')
            ->join('tb_gudang_barang as c',function($join){
                        $join->on("c.id_barang","=","b.id")
                             ->on("c.id_gudang","=","d.kepada");
                    })
            ->select("a.*","b.nama_barang","b.no_sku","c.jumlah as stok","d.kepada","d.dari","d.tanggal_kirim")
            ->where("a.no_transfer","=",$id)
            ->where("a.proses","<>","0")
            ->get();
    echo json_encode($data);
  }

  public function updatepenerimaan($proses,$terkirim,$id){
    $data['terkirim'] = $terkirim;
    $data['retur'] = $proses - $terkirim;
    if ($data['retur'] > 0) {
      $data['verifikasi_return'] = "pending";
    }
    DB::table('tb_detail_transfer')->where('id','=',$id)->update($data);
    echo json_encode($data);
  }

  public function datatransferstok(){
      $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status","=","aktif")->get();
      $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status","=","aktif")->get();
      $data['data'] = DB::table('tb_transfer_stok as a')
                    ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
                    ->join('tb_barang as c','c.id','=','b.id_barang')
                    ->join('tb_gudang as d',function($join){
                                $join->on("a.dari","=","d.id");
                            })
                    ->join('tb_gudang as e',function($join){
                                $join->on("a.kepada","=","e.id");
                            })
                    ->join('tb_karyawan as f','f.id','=','a.driver')
                    ->join('tb_karyawan as g','g.id','=','a.qc')
                    ->join('users as h','h.id','=','a.admin')
                    ->join('users as i','i.id','=','a.admin_g')
                    ->leftJoin('users as j','j.id','=','a.admin_v')
                    ->select("a.id","a.no_transfer","a.tanggal_order","a.tanggal_kirim","d.nama_gudang as dari","e.nama_gudang as kepada"
                              ,"c.no_sku","c.nama_barang","b.jumlah","a.status_transfer","b.proses","b.pending","b.retur","b.terkirim"
                              ,"f.nama as driver","g.nama as qc","h.name as admin","i.name as admin_g","j.name as admin_v","a.tanggal_terkirim")
                    ->where("b.proses","<>","0")
                    ->orderBy("a.id","DESC")
                    ->limit(1000)
                    ->get();
      $data['nama_download']= "Data Transfer Stok";
      //dd($data);
      return view('Distribusi.datatransferstok',$data);
  }

  public function datatransferstoks(Request $post){
      $x = $post->except('_token');
      if($x['dari'] != null){$k['dari']=$x['dari']; $data['dari'] = $x['dari']; }
      if($x['kepada'] != null){$k['kepada']=$x['kepada']; $data['kepada'] = $x['kepada']; }
      if($x['from'] != null && $x['to'] != null){ $from=$x['from']; $to=$x['to']; $data['from'] = $x['from']; $data['to'] = $x['to']; }
      if($x['status_transfer'] != null){$k['status_transfer']=$x['status_transfer']; $data['status_transfer'] = $x['status_transfer']; }
      if($x['nama_barang'] != null){$nm=$x['nama_barang']; $data['nama_barang'] = $x['nama_barang']; }
      //dd($k);

      if(isset($k) && isset($from) && isset($nm)){
        $data['data'] = DB::table('tb_transfer_stok as a')
        ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
        ->join('tb_barang as c','c.id','=','b.id_barang')
        ->join('tb_gudang as d',function($join){
                    $join->on("a.dari","=","d.id");
                })
        ->join('tb_gudang as e',function($join){
                    $join->on("a.kepada","=","e.id");
                })
        ->leftJoin('tb_karyawan as f','f.id','=','a.driver')
        ->leftJoin('tb_karyawan as g','g.id','=','a.qc')
        ->leftJoin('users as h','h.id','=','a.admin')
        ->leftJoin('users as i','i.id','=','a.admin_g')
        ->leftJoin('users as j','j.id','=','a.admin_v')
        ->select("a.id","a.no_transfer","a.tanggal_order","a.tanggal_kirim","d.nama_gudang as dari","e.nama_gudang as kepada"
                  ,"c.no_sku","c.nama_barang","b.jumlah","a.status_transfer","b.proses","b.pending","b.retur","b.terkirim"
                  ,"f.nama as driver","g.nama as qc","h.name as admin","i.name as admin_g","j.name as admin_v","a.tanggal_terkirim")
        ->where($k)
        ->where('nama_barang','like',"%$nm%")
        ->whereBetween('tanggal_order',[$from,$to])
        ->where("b.proses","<>","0")
        ->get();
      }else if(isset($k) && isset($nm)){
        $data['data'] = DB::table('tb_transfer_stok as a')
        ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
        ->join('tb_barang as c','c.id','=','b.id_barang')
        ->join('tb_gudang as d',function($join){
                    $join->on("a.dari","=","d.id");
                })
        ->join('tb_gudang as e',function($join){
                    $join->on("a.kepada","=","e.id");
                })
        ->leftJoin('tb_karyawan as f','f.id','=','a.driver')
        ->leftJoin('tb_karyawan as g','g.id','=','a.qc')
        ->leftJoin('users as h','h.id','=','a.admin')
        ->leftJoin('users as i','i.id','=','a.admin_g')
        ->leftJoin('users as j','j.id','=','a.admin_v')
        ->select("a.id","a.no_transfer","a.tanggal_order","a.tanggal_kirim","d.nama_gudang as dari","e.nama_gudang as kepada"
                  ,"c.no_sku","c.nama_barang","b.jumlah","a.status_transfer","b.proses","b.pending","b.retur","b.terkirim"
                  ,"f.nama as driver","g.nama as qc","h.name as admin","i.name as admin_g","j.name as admin_v","a.tanggal_terkirim")
        ->where($k)
        ->where('nama_barang','like',"%$nm%")
        ->where("b.proses","<>","0")
        ->get();
      }else if(isset($from) && isset($nm)){
        $data['data'] = DB::table('tb_transfer_stok as a')
        ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
        ->join('tb_barang as c','c.id','=','b.id_barang')
        ->join('tb_gudang as d',function($join){
                    $join->on("a.dari","=","d.id");
                })
        ->join('tb_gudang as e',function($join){
                    $join->on("a.kepada","=","e.id");
                })
        ->leftJoin('tb_karyawan as f','f.id','=','a.driver')
        ->leftJoin('tb_karyawan as g','g.id','=','a.qc')
        ->leftJoin('users as h','h.id','=','a.admin')
        ->leftJoin('users as i','i.id','=','a.admin_g')
        ->leftJoin('users as j','j.id','=','a.admin_v')
        ->select("a.id","a.no_transfer","a.tanggal_order","a.tanggal_kirim","d.nama_gudang as dari","e.nama_gudang as kepada"
                  ,"c.no_sku","c.nama_barang","b.jumlah","a.status_transfer","b.proses","b.pending","b.retur","b.terkirim"
                  ,"f.nama as driver","g.nama as qc","h.name as admin","i.name as admin_g","j.name as admin_v","a.tanggal_terkirim")
        ->whereBetween('tanggal_kirim',[$from,$to])
        ->where('nama_barang','like',"%$nm%")
        ->where("b.proses","<>","0")
        ->get();
      }else if(isset($from)){
        $data['data'] = DB::table('tb_transfer_stok as a')
        ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
        ->join('tb_barang as c','c.id','=','b.id_barang')
        ->join('tb_gudang as d',function($join){
                    $join->on("a.dari","=","d.id");
                })
        ->join('tb_gudang as e',function($join){
                    $join->on("a.kepada","=","e.id");
                })
        ->leftJoin('tb_karyawan as f','f.id','=','a.driver')
        ->leftJoin('tb_karyawan as g','g.id','=','a.qc')
        ->leftJoin('users as h','h.id','=','a.admin')
        ->leftJoin('users as i','i.id','=','a.admin_g')
        ->leftJoin('users as j','j.id','=','a.admin_v')
        ->select("a.id","a.no_transfer","a.tanggal_order","a.tanggal_kirim","d.nama_gudang as dari","e.nama_gudang as kepada"
                  ,"c.no_sku","c.nama_barang","b.jumlah","a.status_transfer","b.proses","b.pending","b.retur","b.terkirim"
                  ,"f.nama as driver","g.nama as qc","h.name as admin","i.name as admin_g","j.name as admin_v","a.tanggal_terkirim")
        ->whereBetween('tanggal_kirim',[$from,$to])
        ->where("b.proses","<>","0")
        ->get();
      }else if(isset($k)){
        $data['data'] = DB::table('tb_transfer_stok as a')
        ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
        ->join('tb_barang as c','c.id','=','b.id_barang')
        ->join('tb_gudang as d',function($join){
                    $join->on("a.dari","=","d.id");
                })
        ->join('tb_gudang as e',function($join){
                    $join->on("a.kepada","=","e.id");
                })
        ->leftJoin('tb_karyawan as f','f.id','=','a.driver')
        ->leftJoin('tb_karyawan as g','g.id','=','a.qc')
        ->leftJoin('users as h','h.id','=','a.admin')
        ->leftJoin('users as i','i.id','=','a.admin_g')
        ->leftJoin('users as j','j.id','=','a.admin_v')
        ->select("a.id","a.no_transfer","a.tanggal_order","a.tanggal_kirim","d.nama_gudang as dari","e.nama_gudang as kepada"
                  ,"c.no_sku","c.nama_barang","b.jumlah","a.status_transfer","b.proses","b.pending","b.retur","b.terkirim"
                  ,"f.nama as driver","g.nama as qc","h.name as admin","i.name as admin_g","j.name as admin_v","a.tanggal_terkirim")
        ->where($k)
        ->where("b.proses","<>","0")
        ->get();
      }

      $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status","=","aktif")->get();
      $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status","=","aktif")->get();
      $data['nama_download']= "Data Transfer Stok";
      //dd($data);
      return view('Distribusi.datatransferstok',$data);
  }

  public function datatransferstokbyname(Request $post){
      $x = $post->except('_token');

      if ($x['nama_barang'] != null ||$x['nama_barang'] != "" ) {
        $nm = $x['nama_barang'];
        $data['nama_barangs'] = $x['nama_barang'];
      }
      //dd($k);

      if(isset($nm)){
        $data['data'] = DB::table('tb_transfer_stok as a')
        ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
        ->join('tb_barang as c','c.id','=','b.id_barang')
        ->join('tb_gudang as d',function($join){
                    $join->on("a.dari","=","d.id");
                })
        ->join('tb_gudang as e',function($join){
                    $join->on("a.kepada","=","e.id");
                })
        ->leftJoin('tb_karyawan as f','f.id','=','a.driver')
        ->leftJoin('tb_karyawan as g','g.id','=','a.qc')
        ->leftJoin('users as h','h.id','=','a.admin')
        ->leftJoin('users as i','i.id','=','a.admin_g')
        ->leftJoin('users as j','j.id','=','a.admin_v')
        ->select("a.id","a.no_transfer","a.tanggal_order","a.tanggal_kirim","d.nama_gudang as dari","e.nama_gudang as kepada"
                  ,"c.no_sku","c.nama_barang","b.jumlah","a.status_transfer","b.proses","b.pending","b.retur","b.terkirim"
                  ,"f.nama as driver","g.nama as qc","h.name as admin","i.name as admin_g","j.name as admin_v","a.tanggal_terkirim")
        ->where('nama_barang','like',"%$nm%")
        ->where("b.proses","<>","0")
        ->get();
      }
      $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status","=","aktif")->get();
      $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status","=","aktif")->get();
      $data['nama_download']= "Data Transfer Stok";
      //dd($data);
      return view('Distribusi.datatransferstok',$data);
  }


}
