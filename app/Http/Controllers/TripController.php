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

class TripController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }
  public function tripengiriman(){
    if (role()) {
      $data['karyawan'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();
      $data['kategori'] = DB::table('tb_kategori as a')->select("*")->where("a.status","=","aktif")->get();
      if (Auth::user()->level == "1" || Auth::user()->level == "4") {
        $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status","=","aktif")->get();
      }else{
        $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.id","=",Auth::user()->gudang)->get();
      }
      $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
      $data['konsumen'] = array();
      foreach ($konsumen as $key => $value) {
        $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] = $value->alamat;
      }
      $date = new DateTime(date('Y-m-d'));
      $date->modify("-60 day");
      $from = $date->format("Y-m-d");

      $to = new DateTime(date('Y-m-d'));
      $to->modify("+1 day");
      $to = $to->format('Y-m-d');

      $data['kwitansi'] = array();

      /*
      if (Auth::user()->level == "1" || Auth::user()->level == "4") {
        $data['kwitansi'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->select("*","a.id as id_tripost",DB::raw('SUM(b.sub_total) as tagihan'))
                            ->where("a.status_barang","=","proses")
                            ->where("b.proses",">","0")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->orWhere("a.status_barang","=","terkirim")
                            ->where("b.proses",">","0")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->whereBetween('tanggal_terkirim',[$from,$to])

                            ->orWhere("a.status_barang","=","kirim ulang")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->whereBetween('tanggal_terkirim',[$from,$to])

                            ->groupBy("b.no_kwitansi")->get();
      }else{
        $data['kwitansi'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->select("*","a.id as id_tripost",DB::raw('SUM(b.sub_total) as tagihan'))
                            ->where("a.status_barang","=","proses")
                            ->where("b.proses",">","0")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->where("a.id_gudang",Auth::user()->gudang)
                            ->orWhere("a.status_barang","=","terkirim")
                            ->where("b.proses",">","0")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->where("a.id_gudang",Auth::user()->gudang)
                            ->whereBetween('tanggal_terkirim',[$from,$to])

                            ->orWhere("a.status_barang","=","kirim ulang")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->whereBetween('tanggal_terkirim',[$from,$to])

                            ->groupBy("b.no_kwitansi")->get();
      }
      */

      if (Auth::user()->level == "1" || Auth::user()->level == "4") {
        $data['kwitansi'] = DB::table('tb_barang_keluar as a')
                            ->select("*","a.id as id_tripost")

                            ->where("a.status_barang","=","proses")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")

                            ->orWhere("a.status_barang","=","terkirim")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->whereBetween('tanggal_terkirim',[$from,$to])

                            ->orWhere("a.status_barang","=","kirim ulang")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->whereBetween('tanggal_terkirim',[$from,$to])

                            ->get();
      }else{
        $data['kwitansi'] = DB::table('tb_barang_keluar as a')
                            ->select("*","a.id as id_tripost")

                            ->where("a.status_barang","=","proses")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->where("a.id_gudang",Auth::user()->gudang)

                            ->orWhere("a.status_barang","=","terkirim")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->where("a.id_gudang",Auth::user()->gudang)
                            ->whereBetween('tanggal_terkirim',[$from,$to])

                            ->orWhere("a.status_barang","=","kirim ulang")
                            ->where("a.status_order","1")
                            ->whereNull("a.cluster")
                            ->whereBetween('tanggal_terkirim',[$from,$to])

                            ->get();
      }


      foreach($data['kwitansi'] as $key => $val){
          $a = DB::table('tb_detail_barang_keluar as a')
               ->where('no_kwitansi',$val->no_kwitansi)
               ->where("a.proses",">","0")
               ->select("*",DB::raw('SUM(a.sub_total) as tagihan'))
               ->groupBy("no_kwitansi")
               ->get();

          if(count($a)>0){
              $data['kwitansi'][$key]->tagihan = $a[0]->tagihan;
          }else{
              unset($data['kwitansi'][$key]);
          }

      }


      $ava = DB::table('tb_trip as a')->select("*")->where("a.tanggal_create","=",date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
      if(count($ava) > 0){
          $var = substr($ava[0]->no_trip,9,3);
          $data['number'] = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
      }else{
          $data['number'] = "001";
      }

      return view('TripPengiriman',$data);
    }else {
      return view('Denied');
    }
  }

  public function tripengirimanjasa(){
      $data['karyawan'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();
      $data['kategori'] = DB::table('tb_kategori as a')->select("*")->where("a.status","=","aktif")->get();
      if (Auth::user()->level == "1" || Auth::user()->level == "4") {
        $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status","=","aktif")->get();
      }else{
        $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.id","=",Auth::user()->gudang)->get();
      }
      $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
      $data['konsumen'] = array();
      foreach ($konsumen as $key => $value) {
        $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] = $value->alamat;
      }
      $date = new DateTime(date('Y-m-d'));
      $date->modify("-60 day");
      $from = $date->format("Y-m-d");

      $to = new DateTime(date('Y-m-d'));
      $to->modify("+1 day");
      $to = $to->format('Y-m-d');

      $data['kwitansi'] = array();

      $data['kwitansi'] = DB::table('tb_order_jasa as a')
                      //->join('tb_detail_order_jasa as b','b.no_kwitansi','=','a.no_kwitansi')
                      ->select("*","no_kwitansi as id_tripost")
                      //DB::raw('SUM(b.sub_biaya) as tagihan'))

                      ->whereNull("a.cluster")

                      //->groupBy("b.no_kwitansi")
                      ->limit(100)
                      ->get();

      foreach($data['kwitansi'] as $key => $val){
          $a = DB::table('tb_detail_order_jasa')
               ->where('no_kwitansi',$val->no_kwitansi)
                ->select("*",DB::raw('SUM(sub_biaya) as tagihan'))
               ->get();
          if(count($a)>0){
              $data['kwitansi'][$key]->tagihan = $a[0]->tagihan;
          }else{
              unset($data['kwitansi'][$key]);
          }
      }

      $ava = DB::table('tb_trip as a')->select("*")->where("a.tanggal_create","=",date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
      if(count($ava) > 0){
          $var = substr($ava[0]->no_trip,9,3);
          $data['number'] = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
      }else{
          $data['number'] = "001";
      }

      return view('TripPengirimanJasa',$data);
  }

  public function searchkwitansi($key){
      $date = new DateTime(date('Y-m-d'));
      $date->modify("-60 day");
      $from = $date->format("Y-m-d");

      $to = new DateTime(date('Y-m-d'));
      $to->modify("+1 day");
      $to = $to->format('Y-m-d');

      $data = DB::table('tb_barang_keluar as a')
                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                          ->select("*","a.id as id_tripost",DB::raw('SUM(b.sub_total) as tagihan'))

                          ->where('a.no_kwitansi','like',"%$key%")
                          ->where("a.status_barang","=","proses")
                          ->where("b.proses",">","0")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")

                          ->orWhere("a.status_barang","=","terkirim")
                          ->where('a.no_kwitansi','like',"%$key%")
                          ->where("b.proses",">","0")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->whereBetween('tanggal_terkirim',[$from,$to])

                          ->orWhere("a.status_barang","=","kirim ulang")
                          ->where('a.no_kwitansi','like',"%$key%")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->whereBetween('tanggal_terkirim',[$from,$to])

                          ->groupBy("b.no_kwitansi")
                          ->limit(1)
                          ->get();

      if (count($data) > 0) {
        $data[]=DB::table('tb_konsumen as a')->where('a.id',$data[0]->id_konsumen)->get();
      }

      echo json_encode($data);
  }


  public function searchkwitansijasa($key){
      $date = new DateTime(date('Y-m-d'));
      $date->modify("-60 day");
      $from = $date->format("Y-m-d");

      $to = new DateTime(date('Y-m-d'));
      $to->modify("+1 day");
      $to = $to->format('Y-m-d');

      $data = DB::table('tb_order_jasa as a')
                          ->join('tb_detail_order_jasa as b','b.no_kwitansi','=','a.no_kwitansi')
                          ->select("*",DB::raw('SUM(b.sub_biaya) as tagihan'))

                          ->where('a.no_kwitansi','like',"%$key%")
                          ->whereNull("a.cluster")

                          ->groupBy("b.no_kwitansi")
                          ->limit(1)
                          ->get();

      if (count($data) > 0) {
        $data[]=DB::table('tb_konsumen as a')->where('a.id',$data[0]->id_konsumen)->get();
      }

      echo json_encode($data);
  }


  public function trippost(Request $post){
    $d = $post->except('_token');
    $id_barang_keluar = explode(",",$d['id_barang_keluar']);
    $no_kwitansi = explode(",",$d['no_kwitansi']);
    $id_konsumen = explode(",",$d['id_konsumen']);
    $sub_total = explode(",",$d['sub_total']);

    date_default_timezone_set('Asia/Jakarta');
    $ava = DB::table('tb_trip as a')->select("*")->where("a.tanggal_create","=",date('Y-m-d'))->orderBy('id', 'DESC')->get();
    $status = true;
    $jumlah_avai = 0;
    if(count($ava) > 0){
      foreach ($ava as $key => $value):
        $gdhs = substr($value->no_trip, -1);
        $split = explode("P",$value->no_trip);
        if($gdhs != "P" && $status){
          $jumlah_avai += 1;
          $var = substr($value->no_trip,9,3);
          $data['no_trip'] = "TP-".date('ymd').str_pad($var + 1, 3, '0', STR_PAD_LEFT);
          $status = false;
        }
      endforeach;
      if ($jumlah_avai < 1) {
        $data['no_trip'] = "TP-".date('ymd')."001";
      }
    }else{
        $data['no_trip'] = "TP-".date('ymd')."001";
    }

    $data['tanggal_input'] = $d['tanggal_input'];
    $data['kategori'] = $d['kategori'];
    $data['id_gudang'] = $d['id_gudang'];
    $data['driver'] = $d['driver'];
    $data['qc'] = $d['qc'];
    $data['admin'] = $d['admin'];
    DB::table('tb_trip')->insert($data);

    for ($i=1; $i < count($id_barang_keluar); $i++) {
      $dt['no_trip'] = $data['no_trip'];
      $dt['id_barang_keluar'] = $id_barang_keluar[$i];
      $dt['no_kwitansi'] = $no_kwitansi[$i];
      $dt['id_konsumen'] = $id_konsumen[$i];
      $dt['sub_total'] = $sub_total[$i];
      DB::table('tb_detail_trip')->insert($dt);
      $x['id'] = $dt['id_barang_keluar'];
      $x['cluster'] = "yes";
      DB::table('tb_barang_keluar')->where('id','=',$x['id'])->update($x);
    }

    echo $dt['no_trip'];
  }

  public function tripsurat($id){
    $cek =  substr($id, 0, 2);
    if ($cek == "TJ") {
      $data['surat'] = DB::table('tb_trip_jasa as a')
                          ->join('tb_detail_trip_jasa as b','b.no_trip','=','a.no_trip')
                          ->select("*")
                          ->where("a.no_trip",$id)->get();

      $data['alamat'] = DB::table('tb_gudang as a')
                        ->join('tb_trip_jasa as b','b.id_gudang','=','a.id')
                        ->select("a.*")
                        ->where("b.no_trip",$id)
                        ->get();
      $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
      $data['konsumen'] = array();
      foreach ($konsumen as $key => $value) {
        $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] = $value->alamat;
      }
      $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
      $data['karyawan'] = array();
      foreach ($karyawan as $key => $value) {
        $data['karyawan'][$value->id] = $value->nama;
      }
      $admin = DB::table('users as a')->select("*")->get();
      $data['admin'] = array();
      foreach ($admin as $key => $value) {
        $data['admin'][$value->id] = $value->name;
      }
      $gudang = DB::table('tb_gudang as a')->select("*")->get();
      $data['gudang'] = array();
      foreach ($gudang as $key => $value) {
        $data['gudang'][$value->id] = $value->nama_gudang;
      }
      $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");

      $data['page'] = ceil(count($data['surat'])/28);

      $data['ongkir'] = array();
      foreach($data['surat'] as $v){
          $tmp = DB::table('tb_barang_keluar as a')->select("*")->where("a.no_kwitansi",$v->no_kwitansi)->get();
          if(count($tmp) > 0){
              $data['ongkir'][$tmp[0]->no_kwitansi] = $tmp[0]->ongkos_kirim;
          }
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
      return view('TripSuratJalanJasa',$data);


    }else{
      $data['surat'] = DB::table('tb_trip as a')
                          ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                          ->select("*")
                          ->where("a.no_trip",$id)->get();

      $data['alamat'] = DB::table('tb_gudang as a')
                        ->join('tb_trip as b','b.id_gudang','=','a.id')
                        ->select("a.*")
                        ->where("b.no_trip",$id)
                        ->get();

      $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
      $data['konsumen'] = array();
      foreach ($konsumen as $key => $value) {
        $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] = $value->alamat;
      }
      $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
      $data['karyawan'] = array();
      foreach ($karyawan as $key => $value) {
        $data['karyawan'][$value->id] = $value->nama;
      }
      $admin = DB::table('users as a')->select("*")->get();
      $data['admin'] = array();
      foreach ($admin as $key => $value) {
        $data['admin'][$value->id] = $value->name;
      }
      $gudang = DB::table('tb_gudang as a')->select("*")->get();
      $data['gudang'] = array();
      foreach ($gudang as $key => $value) {
        $data['gudang'][$value->id] = $value->nama_gudang;
      }
      $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");

      $data['page'] = ceil(count($data['surat'])/28);

      $data['ongkir'] = array();
      foreach($data['surat'] as $v){
          $tmp = DB::table('tb_barang_keluar as a')->select("*")->where("a.no_kwitansi",$v->no_kwitansi)->get();
          if(count($tmp) > 0){
              $data['ongkir'][$tmp[0]->no_kwitansi] = $tmp[0]->ongkos_kirim;
          }
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

      return view('TripSuratJalan',$data);
    }
  }

  public function tripkwitansi($id){
    $data['surat'] = DB::table('tb_trip as a')
                        ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                        ->select("*")
                        ->where("a.no_trip",$id)->get();
    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
      $data['konsumen'][$value->id]['no_hp'] = $value->no_hp;
    }
    $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
    $data['karyawan'] = array();
    foreach ($karyawan as $key => $value) {
      $data['karyawan'][$value->id] = $value->nama;
    }
    $a = 0;
    foreach ($data['surat'] as $key => $value) {
      $detail= DB::table('tb_detail_barang_keluar as a')
                          ->select("*")
                          ->where("a.no_kwitansi",$value->no_kwitansi)
                          ->where("a.proses",">","0")->get();
      $b = 0;
      foreach ($detail as $keys => $values) {
          $data['detail'][$a][$b]['id_barang'] = $values->id_barang;
          $data['detail'][$a][$b]['jumlah'] = $values->proses;
          $data['detail'][$a][$b]['harga_satuan'] = $values->harga_jual;
          $data['detail'][$a][$b]['potongan'] = $values->potongan;
          $b++;
      }
      $a++;
    }
    $barang = DB::table('tb_barang as a')->select("*")->get();
    $data['barang'] = array();
    foreach ($barang as $key => $value) {
      $data['barang'][$value->id] = $value->nama_barang;
    }
    return view('TripKwitansi',$data);
  }

  public function daftartrip(){
    if (role()) {
    if (Auth::user()->level == "1" || Auth::user()->level == "4") {
      $data['daftar'] = DB::table('tb_trip as a')
                          ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                          ->select("*",DB::raw('SUM(b.sub_total) as penjualan'),"a.id as id_trip","a.status as available")->groupBy("a.no_trip")->get();
    }else{
      $data['daftar'] = DB::table('tb_trip as a')
                          ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                          ->select("*",DB::raw('SUM(b.sub_total) as penjualan'),"a.id as id_trip","a.status as available")
                          ->where('a.id_gudang',Auth::user()->gudang)
                          ->groupBy("a.no_trip")->get();
    }
    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
    }
    $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
    $data['karyawan'] = array();
    foreach ($karyawan as $key => $value) {
      $data['karyawan'][$value->id] = $value->nama;
    }
    $admin = DB::table('users as a')->select("*")->get();
    $data['admin'] = array();
    foreach ($admin as $key => $value) {
      $data['admin'][$value->id] = $value->name;
    }
    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['gudang'][$value->id]['id'] = $value->id;
      $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
      $data['gudang'][$value->id]['status'] = $value->status;
    }
    $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");
    return view ('DaftarTrip',$data);
  }else{
    return view('Denied');
  }
  }

  public function daftartrips(Request $post){
    $d = $post->except('_token');
    if ($d['date_from'] != null && $d['date_to'] != null) {
      $from = $d['date_from']; $to = $d['date_to'];
      $data['date_from'] = $d['date_from']; $data['date_to'] = $d['date_to'];
    }
    $data['id_gudang'] = $d['id_gudang'];

    if (isset($from)) {
      $data['daftar'] = DB::table('tb_trip as a')
                          ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                          ->select("*",DB::raw('SUM(b.sub_total) as penjualan'),"a.id as id_trip","a.status as available")
                          ->where('a.id_gudang',$data['id_gudang'])
                          ->whereBetween('tanggal_input',[$from,$to])
                          ->groupBy("a.no_trip")->get();
    }else{
      $data['daftar'] = DB::table('tb_trip as a')
                          ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                          ->select("*",DB::raw('SUM(b.sub_total) as penjualan'),"a.id as id_trip","a.status as available")
                          ->where('a.id_gudang',$data['id_gudang'])
                          ->groupBy("a.no_trip")->get();
    }

    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
    }
    $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
    $data['karyawan'] = array();
    foreach ($karyawan as $key => $value) {
      $data['karyawan'][$value->id] = $value->nama;
    }
    $admin = DB::table('users as a')->select("*")->get();
    $data['admin'] = array();
    foreach ($admin as $key => $value) {
      $data['admin'][$value->id] = $value->name;
    }
    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['gudang'][$value->id]['id'] = $value->id;
      $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
      $data['gudang'][$value->id]['status'] = $value->status;
    }
    $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");
    return view ('DaftarTrip',$data);
  }

  public function daftarpendingtrip(){
    $data['karyawan'] = DB::table('tb_karyawan as a')->select("*")->get();
    $data['kategori'] = DB::table('tb_kategori as a')->select("*")->where("a.status","=","aktif")->get();
    if (Auth::user()->level == "1" || Auth::user()->level == "4") {
      $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status","=","aktif")->get();
    }else{
      $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.id","=",Auth::user()->gudang)->get();
    }
    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
    }

    $data['dt_karyawan'] = array();
    foreach ($data['karyawan'] as $key => $value) {
      $data['dt_karyawan'][$value->id]= $value->nama;
    }

    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['dt_gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['dt_gudang'][$value->id]= $value->nama_gudang;
    }

    $usr = DB::table('users as a')->select("*")->get();
    $data['usr'] = array();
    foreach ($usr as $key => $value) {
      $data['usr'][$value->id]= $value->name;
    }

    $date = new DateTime(date('Y-m-d'));
    $date->modify("-60 day");
    $from = $date->format("Y-m-d");

    $to = new DateTime(date('Y-m-d'));
    $to->modify("+1 day");
    $to = $to->format('Y-m-d');

    $data['kwitansi'] = array();


    if (Auth::user()->level == "1" || Auth::user()->level == "4") {
      $data['bk'] = DB::table('tb_barang_keluar as a')
                          ->select("*","a.id as id_tripost")

                          ->where("a.status_barang","=","proses")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")

                          ->orWhere("a.status_barang","=","terkirim")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->whereBetween('tanggal_terkirim',[$from,$to])

                          ->orWhere("a.status_barang","=","kirim ulang")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->whereBetween('tanggal_terkirim',[$from,$to])
                          ->paginate(10);

    }else{
      $data['bk'] = DB::table('tb_barang_keluar as a')
                          ->select("*","a.id as id_tripost")

                          ->where("a.status_barang","=","proses")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->where("a.id_gudang",Auth::user()->gudang)

                          ->orWhere("a.status_barang","=","terkirim")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->where("a.id_gudang",Auth::user()->gudang)
                          ->whereBetween('tanggal_terkirim',[$from,$to])

                          ->orWhere("a.status_barang","=","kirim ulang")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->whereBetween('tanggal_terkirim',[$from,$to])
                          ->paginate(10);
    }
    $ix=0;
    foreach($data['bk'] as $value){
        $dbk = DB::table('tb_detail_barang_keluar as b')
            ->select("*",DB::raw('SUM(b.sub_total) as tagihan'))
            ->where("b.proses",">","0")
            ->where("b.no_kwitansi",$value->no_kwitansi)
            ->groupBy("b.no_kwitansi")
            ->limit(1)
            ->get();
        if(count($dbk)>0){
            if($dbk[0]->tagihan > 0){
                $data['kwitansi'][$ix]['no_kwitansi'] = $value->no_kwitansi;
                $data['kwitansi'][$ix]['id_konsumen'] = $value->id_konsumen;
                $data['kwitansi'][$ix]['pengirim'] = $value->pengirim;
                $data['kwitansi'][$ix]['qc'] = $value->qc;
                $data['kwitansi'][$ix]['id_gudang'] = $value->id_gudang;
                $ix++;
            }
        }
    }


     /*   if(count($bk) > 0){
            $dbk = DB::table('tb_detail_barang_keluar as b')
                        ->select("*",DB::raw('SUM(b.sub_total) as tagihan'))
                        ->where("b.proses",">","0")
                        ->groupBy("b.no_kwitansi")
                        ->limit(1)
                        ->get();
            foreach($bk as $value){
                $data[0]['no_kwitansi'] = $value->no_kwitansi;
                $data[0]['id_tripost'] = $value->id_tripost;
                $data[0]['id_konsumen'] = $value->id_konsumen;
            }
            foreach($dbk as $value){
                $data[0]['tagihan'] = $value->tagihan;
            }
        }


    if (Auth::user()->level == "1" || Auth::user()->level == "4") {
      $data['kwitansi'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                          ->select("*","a.id as id_tripost",DB::raw('SUM(b.sub_total) as tagihan'))

                          ->where("a.status_barang","=","proses")
                          ->where("b.proses",">","0")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")

                          ->orWhere("a.status_barang","=","terkirim")
                          ->where("b.proses",">","0")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->whereBetween('tanggal_terkirim',[$from,$to])

                          ->orWhere("a.status_barang","=","kirim ulang")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->whereBetween('tanggal_terkirim',[$from,$to])

                          ->groupBy("b.no_kwitansi")->get();
    }else{
      $data['kwitansi'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                          ->select("*","a.id as id_tripost",DB::raw('SUM(b.sub_total) as tagihan'))
                          ->where("a.status_barang","=","proses")
                          ->where("b.proses",">","0")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->where("a.id_gudang",Auth::user()->gudang)
                          ->orWhere("a.status_barang","=","terkirim")
                          ->where("b.proses",">","0")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->where("a.id_gudang",Auth::user()->gudang)
                          ->whereBetween('tanggal_terkirim',[$from,$to])

                          ->orWhere("a.status_barang","=","kirim ulang")
                          ->where("a.status_order","1")
                          ->whereNull("a.cluster")
                          ->whereBetween('tanggal_terkirim',[$from,$to])

                          ->groupBy("b.no_kwitansi")->get();
    }*/

    return view('DaftarTripPending',$data);
  }


  public function daftarpendingtripjasa(){
    $data['karyawan'] = DB::table('tb_karyawan as a')->select("*")->get();
    $data['kategori'] = DB::table('tb_kategori as a')->select("*")->where("a.status","=","aktif")->get();
    if (Auth::user()->level == "1" || Auth::user()->level == "4") {
      $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.status","=","aktif")->get();
    }else{
      $data['gudang'] = DB::table('tb_gudang as a')->select("*")->where("a.id","=",Auth::user()->gudang)->get();
    }
    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
    }

    $data['dt_karyawan'] = array();
    foreach ($data['karyawan'] as $key => $value) {
      $data['dt_karyawan'][$value->id]= $value->nama;
    }

    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['dt_gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['dt_gudang'][$value->id]= $value->nama_gudang;
    }

    $usr = DB::table('users as a')->select("*")->get();
    $data['usr'] = array();
    foreach ($usr as $key => $value) {
      $data['usr'][$value->id]= $value->name;
    }

    $date = new DateTime(date('Y-m-d'));
    $date->modify("-60 day");
    $from = $date->format("Y-m-d");

    $to = new DateTime(date('Y-m-d'));
    $to->modify("+1 day");
    $to = $to->format('Y-m-d');

    $data['kwitansi'] = array();


    if (Auth::user()->level == "1" || Auth::user()->level == "4") {
      $data['js'] = DB::table('tb_order_jasa as a')
                          ->select("*")
                          ->whereNull("a.cluster")
                          ->paginate(10);
    }else{
      $data['js'] = DB::table('tb_order_jasa as a')
                          ->select("*")
                          ->where("a.gudang",Auth::user()->gudang)
                          ->whereNull("a.cluster")
                          ->paginate(10);
    }


    return view('DaftarTripPendingJasa',$data);
  }


  public function detailTrip($id){
    $cek =  substr($id, 0, 2);
    if ($cek == "TP") {
      $data = DB::table('tb_detail_trip as a')
                          ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                          ->select("*","a.id as id_detail_trip")
                          ->where("a.no_trip",$id)->get();
      echo json_encode($data);
    }else{
      $data = DB::table('tb_detail_trip_jasa as a')
                          ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                          ->select("*","a.id as id_detail_trip")
                          ->where("a.no_trip",$id)->get();
      echo json_encode($data);
    }
  }

  public function caritrip(Request $post){
    $d = $post->except('_token');
    $data['daftar'] = DB::table('tb_trip as a')
                          ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                          ->select("*",DB::raw('SUM(b.sub_total) as penjualan'),"a.id as id_trip","a.status as available")
                          ->where('b.no_kwitansi',$d['no_kwitansi'])
                          ->groupBy("a.no_trip")->get();
    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
    }
    $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
    $data['karyawan'] = array();
    foreach ($karyawan as $key => $value) {
      $data['karyawan'][$value->id] = $value->nama;
    }
    $admin = DB::table('users as a')->select("*")->get();
    $data['admin'] = array();
    foreach ($admin as $key => $value) {
      $data['admin'][$value->id] = $value->name;
    }
    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['gudang'][$value->id]['id'] = $value->id;
      $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
      $data['gudang'][$value->id]['status'] = $value->status;
    }
    $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");
    return view ('DaftarTrip',$data);
  }

  public function perhitunganinsentif(){
    if(role()){
      $gudang = DB::table('tb_gudang as a')->select("*")->get();
      $data['gudang'] = array();
      foreach ($gudang as $key => $value) {
        $data['gudang'][$value->id]['id'] = $value->id;
        $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
        $data['gudang'][$value->id]['status'] = $value->status;
      }
      $data['insentif'] = DB::table('tb_trip as a')
                          ->select("*")
                          ->whereNotNull("no_trip")
                          ->orWhere("no_trip","<>","")
                          ->get();
      $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");
      return view ('PerhitunganInsentif',$data);
    }else{
      return view('Denied');
    }
  }

  public function perhitunganinsentifjasa(){
      $gudang = DB::table('tb_gudang as a')->select("*")->get();
      $data['gudang'] = array();
      foreach ($gudang as $key => $value) {
        $data['gudang'][$value->id]['id'] = $value->id;
        $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
        $data['gudang'][$value->id]['status'] = $value->status;
      }
      $data['insentif'] = DB::table('tb_trip_jasa as a')
                          ->select("*")
                          ->whereNotNull("no_trip")
                          ->orWhere("no_trip","<>","")
                          ->get();
      $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");
      return view ('PerhitunganInsentifJasa',$data);
  }

  public function insentifsimpansession($a,$b,$c,$d,$e,$f,$g){
      $data['no_trips'] = $a;
      $data['id_trips'] = $b;
      $data['tanggal_inputs'] = $c;
      $data['kategoris'] = $d;
      $data['id_gudangs'] = $e;
      $data['operasional_kiriman'] = $f;
      $data['cek'] = $g;

      if (!isset($data['operasional_kiriman']) || $data['operasional_kiriman'] < 1) {
          $data['operasional_kiriman'] = 0;
        }
        $gudang = DB::table('tb_gudang as a')->select("*")->get();
        $data['gudang'] = array();
        foreach ($gudang as $key => $value) {
          $data['gudang'][$value->id]['id'] = $value->id;
          $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
          $data['gudang'][$value->id]['status'] = $value->status;
        }

        $gdind = DB::table('tb_gudang as a')->where('nama_gudang',$data['id_gudangs'])->select("*")->get();
        if (count($gdind)>0) {
              $data['postinduk'] = $gdind[0]->id;
        }
        if (isset($data['cek'])) {
          $data['insentif'] = DB::table('tb_trip as a')
                              ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                              ->select("*")
                              ->whereNull("a.status")
                              ->groupBy("a.no_trip")
                              ->get();
        }else{
          $data['insentif'] = DB::table('tb_trip as a')
                              ->select("*")
                              ->whereNull("status")
                              ->get();
        }

        $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");

        $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
        $data['konsumen'] = array();
        foreach ($konsumen as $key => $value) {
              $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
              $data['konsumen'][$value->id]['alamat'] = $value->alamat;
              $data['konsumen'][$value->id]['jenis_konsumen'] = $value->jenis_konsumen;
              $data['konsumen'][$value->id]['reseller'] = $value->reseller;
              $data['konsumen'][$value->id]['agen'] = $value->agen;
              $data['konsumen'][$value->id]['distributor'] = $value->distributor;
              $data['konsumen'][$value->id]['referal_by'] = $value->referal_by;
        }

        $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
        $data['karyawan'] = array();
        foreach ($karyawan as $key => $value) {
          $data['karyawan'][$value->id]['nama'] = $value->nama;
          $data['karyawan'][$value->id]['jabatan'] = $value->jabatan;
          $data['karyawan'][$value->id]['jenis_konsumen'] = $value->jenis_konsumen;
        }

        $admin = DB::table('users as a')->select("*")->get();
        $data['admin'] = array();
        foreach ($admin as $key => $value) {
          $data['admin'][$value->id] = $value->username;
        }

        $barang = DB::table('tb_barang as a')->select("*")->get();
        $data['barang'] = array();
        foreach ($barang as $key => $value) {
          $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
          $data['barang'][$value->id]['no_sku'] = $value->no_sku;
          $data['barang'][$value->id]['branded'] = $value->branded;
        }

        $harga = DB::table('tb_harga as a')->select("*")->get();
        $data['harga'] = array();
        foreach ($harga as $key => $value) {
          $data['harga'][$value->id_barang]['harga_net'] = $value->harga;
          $data['harga'][$value->id_barang]['harga_hpp'] = $value->harga_hpp;
          $data['harga'][$value->id_barang]['harga_hp'] = $value->harga_hp;
          $data['harga'][$value->id_barang]['poin'] = $value->poin;
          $data['harga'][$value->id_barang]['fee_item'] = $value->fee_item;
        }
        

        $data['data'] = DB::table('tb_detail_trip as a')
                        ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                        ->join('tb_barang_keluar as c','c.no_kwitansi','=','a.no_kwitansi')
                        //->join('tb_pembayaran as d','a.no_kwitansi','=','d.no_kwitansi')
                        ->select("a.*","b.*","c.*")
                        ->where('a.no_trip',$data['no_trips'])
                        //->where('c.status_barang','proses')
                        ->where('b.proses','>','0')
                        ->where('c.total_bayar','>',0)
                        //->where('d.status_pembayaran','Lunas')
                        //->groupBy("d.no_kwitansi")
                        ->get();
        
        foreach ($data['data'] as $key => $value) {
            if (isset($data['konsumen'][$value->id_konsumen]['referal_by'])) {
              $data['data'][$key]->jenis_konsumen_referal = $data['karyawan'][$data['konsumen'][$value->id_konsumen]['referal_by']]['jenis_konsumen'];
            }else{
              $data['data'][$key]->jenis_konsumen_referal = "";
            }
          }
        
        $data['ins'] = array();
        foreach ($data['data'] as $key => $value) {
          $cekpembayaran = DB::table('tb_pembayaran as a')
                           ->where("a.status_pembayaran","Lunas")
                           ->where('a.no_kwitansi',$value->no_kwitansi)
                           ->get();
          if(count($cekpembayaran) < 1){
            $data['ins'][$value->no_trip] = true;
          }
        }

        $gg = DB::table('tb_gudang as a')->select("*")->orderBy("a.id","ASC")->limit(1)->get();
        $data['induk'] = $gg[0]->id;

    if ($data['kategoris'] == "Non Insentif") {
      return view ('PerhitunganNonInsentif',$data);
    }else if ($data['kategoris'] == "Sales Marketing") {
      return view ('PerhitunganInsentifSales',$data);
    }else if ($data['kategoris'] == "Membership") {
      return view ('PerhitunganInsentifMember',$data);
    }else if ($data['kategoris'] == "Grosir HPP Target") {
      return view ('PerhitunganInsentifHPPTarget',$data);
    }
  }

  public function actperhitunganinsentif(Request $post){
    $data = $post->except('_token');
    if (!isset($data['operasional_kiriman']) || $data['operasional_kiriman'] < 1) {
      $data['operasional_kiriman'] = 0;
    }
    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['gudang'][$value->id]['id'] = $value->id;
      $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
      $data['gudang'][$value->id]['status'] = $value->status;
    }

    $gdind = DB::table('tb_gudang as a')->where('nama_gudang',$data['id_gudangs'])->select("*")->get();
    if (count($gdind)>0) {
          $data['postinduk'] = $gdind[0]->id;
    }
    if (isset($data['cek'])) {
      $data['insentif'] = DB::table('tb_trip as a')
                          ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                          ->select("*")
                          ->whereNull("a.status")
                          ->groupBy("a.no_trip")
                          ->get();
    }else{
      $data['insentif'] = DB::table('tb_trip as a')
                          ->select("*")
                          ->whereNull("status")
                          ->get();
    }

    $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");

    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
      $data['konsumen'][$value->id]['jenis_konsumen'] = $value->jenis_konsumen;
      $data['konsumen'][$value->id]['reseller'] = $value->reseller;
      $data['konsumen'][$value->id]['agen'] = $value->agen;
      $data['konsumen'][$value->id]['distributor'] = $value->distributor;
      $data['konsumen'][$value->id]['referal_by'] = $value->referal_by;
    }
    

    $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
    $data['karyawan'] = array();
    foreach ($karyawan as $key => $value) {
      $data['karyawan'][$value->id]['nama'] = $value->nama;
      $data['karyawan'][$value->id]['jabatan'] = $value->jabatan;
      $data['karyawan'][$value->id]['jenis_konsumen'] = $value->jenis_konsumen;
    }

    $admin = DB::table('users as a')->select("*")->get();
    $data['admin'] = array();
    foreach ($admin as $key => $value) {
      $data['admin'][$value->id] = $value->username;
    }

    $barang = DB::table('tb_barang as a')->select("*")->get();
    $data['barang'] = array();
    foreach ($barang as $key => $value) {
      $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
      $data['barang'][$value->id]['no_sku'] = $value->no_sku;
      $data['barang'][$value->id]['branded'] = $value->branded;
    }

    $harga = DB::table('tb_harga as a')->select("*")->get();
    $data['harga'] = array();
    foreach ($harga as $key => $value) {
      $data['harga'][$value->id_barang]['harga_net'] = $value->harga;
      $data['harga'][$value->id_barang]['harga_hpp'] = $value->harga_hpp;
      $data['harga'][$value->id_barang]['harga_hp'] = $value->harga_hp;
      $data['harga'][$value->id_barang]['poin'] = $value->poin;
      $data['harga'][$value->id_barang]['fee_item'] = $value->fee_item;
    }

    $data['data'] = DB::table('tb_detail_trip as a')
                    ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                    ->join('tb_barang_keluar as c','c.no_kwitansi','=','a.no_kwitansi')
                    //->join('tb_pembayaran as d','a.no_kwitansi','=','d.no_kwitansi')
                    ->select("a.*","b.*","c.*")
                    ->where('a.no_trip',$data['no_trips'])
                    //->where('c.status_barang','proses')
                    ->where('b.proses','>','0')
                    ->where('c.total_bayar','>',0)
                    //->where('d.status_pembayaran','Lunas')
                    //->groupBy("d.no_kwitansi")
                    ->get();
    $data['ins'] = array();
    foreach ($data['data'] as $key => $value) {
      $cekpembayaran = DB::table('tb_pembayaran as a')
                       ->where("a.status_pembayaran","Lunas")
                       ->where('a.no_kwitansi',$value->no_kwitansi)
                       ->get();
      if(count($cekpembayaran) < 1){
        $data['ins'][$value->no_trip] = true;
      }

      if (isset($data['konsumen'][$value->id_konsumen]['referal_by'])) {
        $data['data'][$key]->jenis_konsumen_referal = $data['karyawan'][$data['konsumen'][$value->id_konsumen]['referal_by']]['jenis_konsumen'];
      }else{
        $data['data'][$key]->jenis_konsumen_referal = "";
      }


    }



    /*$insentifcek = DB::table('tb_trip as a')
                        ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                        ->leftJoin('tb_pembayaran as c','c.no_kwitansi','=','b.no_kwitansi')
                        ->select("*")
                        ->where("c.status_pembayaran","Titip")
                        ->whereNull("a.status")
                        ->where('a.no_trip',$data['no_trips'])
                        ->orWhereNull("c.status_pembayaran")
                        ->whereNull("a.status")
                        ->where('a.no_trip',$data['no_trips'])
                        ->groupBy("a.no_trip")
                        ->get();
    dd($data['data']);
    $data['ins'] = array();
    foreach ($insentifcek as $key => $value) {
      $data['ins'][$value->no_trip] = true;
    }*/

    $gg = DB::table('tb_gudang as a')->select("*")->orderBy("a.id","ASC")->limit(1)->get();
    $data['induk'] = $gg[0]->id;

    if ($data['kategoris'] == "Non Insentif") {
      return view ('PerhitunganNonInsentif',$data);
    }else if ($data['kategoris'] == "Sales Marketing") {
      return view ('PerhitunganInsentifSales',$data);
    }else if ($data['kategoris'] == "Membership") {
      return view ('PerhitunganInsentifMember',$data);
    }else if ($data['kategoris'] == "Grosir HPP Target") {
      return view ('PerhitunganInsentifHPPTarget',$data);
    }
    //return view ('PerhitunganInsentif',$data);
  }

  public function insentifsimpansessionjasa($a,$b,$c,$d,$e,$f){
    $data['no_trips'] = $a;
    $data['id_trips'] = $a;
    $data['tanggal_inputs'] = $a;
    $data['cek'] = $a;
    $data['id_gudangs'] = $a;
    $data['operasional_kiriman'] = $a;

    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['gudang'][$value->id]['id'] = $value->id;
      $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
      $data['gudang'][$value->id]['status'] = $value->status;
    }
     $gdind = DB::table('tb_gudang as a')->where('nama_gudang',$data['id_gudangs'])->select("*")->get();
        if (count($gdind)>0) {
              $data['postinduk'] = $gdind[0]->id;
        }
        
    $gg = DB::table('tb_gudang as a')->select("*")->orderBy("a.id","ASC")->limit(1)->get();
        $data['induk'] = $gg[0]->id;
        
    if (isset($data['cek'])) {
      $data['insentif'] = DB::table('tb_trip_jasa as a')
                          ->join('tb_detail_trip_jasa as b','b.no_trip','=','a.no_trip')
                          ->select("*")
                          ->whereNull("a.status")
                          ->groupBy("a.no_trip")
                          ->get();
    }else{
      $data['insentif'] = DB::table('tb_trip_jasa as a')
                          ->select("*")
                          ->whereNull("status")
                          ->get();
    }

    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
    }

    $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
    $data['karyawan'] = array();
    foreach ($karyawan as $key => $value) {
      $data['karyawan'][$value->id]['nama'] = $value->nama;
      $data['karyawan'][$value->id]['jabatan'] = $value->jabatan;
    }

    $admin = DB::table('users as a')->select("*")->get();
    $data['admin'] = array();
    foreach ($admin as $key => $value) {
      $data['admin'][$value->id] = $value->username;
    }

    $jasa = DB::table('tb_jasa as a')->select("*")->get();
    $data['jasa'] = array();
    foreach ($jasa as $key => $value) {
      $data['jasa'][$value->kode]['nama_jasa'] = $value->nama_jasa;
      $data['jasa'][$value->kode]['kode'] = $value->kode;
      $data['jasa'][$value->kode]['biaya'] = $value->biaya;
      $data['jasa'][$value->kode]['poin'] = $value->poin;
    }

    $data['data'] = DB::table('tb_detail_trip_jasa as a')
                    ->join('tb_detail_order_jasa as b','b.no_kwitansi','=','a.no_kwitansi')
                    ->join('tb_order_jasa as c','c.no_kwitansi','=','a.no_kwitansi')
                    ->select("a.*","b.*","c.*")
                    ->where('a.no_trip',$data['no_trips'])
                    ->get();
    foreach ($data['data'] as $key => $value) {
      if (isset($data['jml_potongan'][$value->no_kwitansi])) {
        $data['jml_potongan'][$value->no_kwitansi] += 1;
      }else{
        $data['jml_potongan'][$value->no_kwitansi] = 1;
      }
    }

    $data['ins'] = array();
    foreach ($data['data'] as $key => $value) {
      $cekpembayaran = DB::table('tb_pembayaran as a')
                       ->where("a.status_pembayaran","Lunas")
                       ->where('a.no_kwitansi',$value->no_kwitansi)
                       ->get();
      if(count($cekpembayaran) < 1){
        $data['ins'][$value->no_trip] = true;
      }
    }
    return view ('PerhitunganInsentifJasa',$data);
  }

  public function actperhitunganinsentifjasa(Request $post){
    $data = $post->except('_token');
    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['gudang'][$value->id]['id'] = $value->id;
      $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
      $data['gudang'][$value->id]['status'] = $value->status;
    }
     $gdind = DB::table('tb_gudang as a')->where('nama_gudang',$data['id_gudangs'])->select("*")->get();
        if (count($gdind)>0) {
              $data['postinduk'] = $gdind[0]->id;
        }
    $gg = DB::table('tb_gudang as a')->select("*")->orderBy("a.id","ASC")->limit(1)->get();
        $data['induk'] = $gg[0]->id;
    if (isset($data['cek'])) {
      $data['insentif'] = DB::table('tb_trip_jasa as a')
                          ->join('tb_detail_trip_jasa as b','b.no_trip','=','a.no_trip')
                          ->select("*")
                          ->whereNull("a.status")
                          ->groupBy("a.no_trip")
                          ->get();
    }else{
      $data['insentif'] = DB::table('tb_trip_jasa as a')
                          ->select("*")
                          ->whereNull("status")
                          ->get();
    }

    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
    }

    $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
    $data['karyawan'] = array();
    foreach ($karyawan as $key => $value) {
      $data['karyawan'][$value->id]['nama'] = $value->nama;
      $data['karyawan'][$value->id]['jabatan'] = $value->jabatan;
    }

    $admin = DB::table('users as a')->select("*")->get();
    $data['admin'] = array();
    foreach ($admin as $key => $value) {
      $data['admin'][$value->id] = $value->username;
    }

    $jasa = DB::table('tb_jasa as a')->select("*")->get();
    $data['jasa'] = array();
    foreach ($jasa as $key => $value) {
      $data['jasa'][$value->kode]['nama_jasa'] = $value->nama_jasa;
      $data['jasa'][$value->kode]['kode'] = $value->kode;
      $data['jasa'][$value->kode]['biaya'] = $value->biaya;
      $data['jasa'][$value->kode]['poin'] = $value->poin;
    }

    $data['data'] = DB::table('tb_detail_trip_jasa as a')
                    ->join('tb_detail_order_jasa as b','b.no_kwitansi','=','a.no_kwitansi')
                    ->join('tb_order_jasa as c','c.no_kwitansi','=','a.no_kwitansi')
                    ->select("a.*","b.*","c.*")
                    ->where('a.no_trip',$data['no_trips'])
                    ->get();
    foreach ($data['data'] as $key => $value) {
      if (isset($data['jml_potongan'][$value->no_kwitansi])) {
        $data['jml_potongan'][$value->no_kwitansi] += 1;
      }else{
        $data['jml_potongan'][$value->no_kwitansi] = 1;
      }
    }

    $data['ins'] = array();
    foreach ($data['data'] as $key => $value) {
      $cekpembayaran = DB::table('tb_pembayaran as a')
                       ->where("a.status_pembayaran","Lunas")
                       ->where('a.no_kwitansi',$value->no_kwitansi)
                       ->get();
      if(count($cekpembayaran) < 1){
        $data['ins'][$value->no_trip] = true;
      }
    }
    return view ('PerhitunganInsentifJasa',$data);
  }



  public function printperhitunganinsentif($id_trips,$no_trips,$tanggal_inputs,$kategoris,$id_gudangs,$operasional_kiriman){
    //if ($operasional_kiriman > 0) {
      $data['operasional_kiriman'] = $operasional_kiriman;
    //}
    $data['id_trips'] = $id_trips;
    $data['no_trips'] = $no_trips;
    $data['tanggal_inputs'] = $tanggal_inputs;
    $data['kategoris'] = $kategoris;
    $data['id_gudangs'] = $id_gudangs;

    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['gudang'][$value->id]['id'] = $value->id;
      $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
      $data['gudang'][$value->id]['status'] = $value->status;
    }
    $data['insentif'] = DB::table('tb_trip as a')
                        ->select("*")
                        ->get();
    $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");

    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
      $data['konsumen'][$value->id]['jenis_konsumen'] = $value->jenis_konsumen;
      $data['konsumen'][$value->id]['reseller'] = $value->reseller;
      $data['konsumen'][$value->id]['agen'] = $value->agen;
      $data['konsumen'][$value->id]['distributor'] = $value->distributor;
      $data['konsumen'][$value->id]['referal_by'] = $value->referal_by;

    }

    $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
    $data['karyawan'] = array();
    foreach ($karyawan as $key => $value) {
      $data['karyawan'][$value->id]['nama'] = $value->nama;
      $data['karyawan'][$value->id]['jabatan'] = $value->jabatan;
      $data['karyawan'][$value->id]['jenis_konsumen'] = $value->jenis_konsumen;
    }

    $admin = DB::table('users as a')->select("*")->get();
    $data['admin'] = array();
    foreach ($admin as $key => $value) {
      $data['admin'][$value->id] = $value->username;
    }

    $barang = DB::table('tb_barang as a')->select("*")->get();
    $data['barang'] = array();
    foreach ($barang as $key => $value) {
      $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
      $data['barang'][$value->id]['no_sku'] = $value->no_sku;
      $data['barang'][$value->id]['branded'] = $value->branded;
    }

    $harga = DB::table('tb_harga as a')->select("*")->get();
    $data['harga'] = array();
    foreach ($harga as $key => $value) {
      $data['harga'][$value->id_barang]['harga_net'] = $value->harga;
      $data['harga'][$value->id_barang]['harga_hpp'] = $value->harga_hpp;
      $data['harga'][$value->id_barang]['harga_hp'] = $value->harga_hp;
      $data['harga'][$value->id_barang]['fee_item'] = $value->fee_item;
    }

    $data['data'] = DB::table('tb_detail_trip as a')
                    ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                    ->join('tb_barang_keluar as c','c.no_kwitansi','=','a.no_kwitansi')
                    //->join('tb_pembayaran as d','a.no_kwitansi','=','d.no_kwitansi')
                    ->select("a.*","b.*","c.*")
                    ->where('a.no_trip',$data['no_trips'])
                    //->where('c.status_barang','proses')
                    ->where('b.proses','>','0')
                    //->where('d.status_pembayaran','Lunas')
                    //->groupBy("d.no_kwitansi")
                    ->get();



      foreach ($data['data'] as $key => $value) {
        if (isset($data['konsumen'][$value->id_konsumen]['referal_by'])) {
          $data['data'][$key]->jenis_konsumen_referal = $data['karyawan'][$data['konsumen'][$value->id_konsumen]['referal_by']]['jenis_konsumen'];
        }else{
          $data['data'][$key]->jenis_konsumen_referal = "";
        }
      }



    $gdind = DB::table('tb_gudang as a')->where('nama_gudang',$id_gudangs)->select("*")->get();
    if (count($gdind)>0) {
          $data['postinduk'] = $gdind[0]->id;
    }

    $gg = DB::table('tb_gudang as a')->select("*")->orderBy("a.id","ASC")->limit(1)->get();
    $data['induk'] = $gg[0]->id;

    $data['nama_download'] = "INSENTIF -".$no_trips." - ".$id_gudangs;
    if ($data['kategoris'] == "Non Insentif") {
      return view ('PrintPerhitunganNonInsentif',$data);
    }else if ($data['kategoris'] == "Sales Marketing") {
      return view ('PrintPerhitunganInsentifSales',$data);
    }else if ($data['kategoris'] == "Membership") {
      return view ('PrintPerhitunganInsentifMember',$data);
    }else if ($data['kategoris'] == "Grosir HPP Target") {
      return view ('PrintPerhitunganInsentifHPPTarget',$data);
    }
    //return view ('PerhitunganInsentif',$data);
  }


  public function printperhitunganinsentifjasa($no_trips){

    $data['no_trips'] = $no_trips;
    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['gudang'][$value->id]['id'] = $value->id;
      $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
      $data['gudang'][$value->id]['status'] = $value->status;
    }
     
    $data['insentif'] = DB::table('tb_trip_jasa as a')
                        ->select("*")
                        ->get();
    $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");

    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($konsumen as $key => $value) {
      $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] = $value->alamat;
    }

    $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
    $data['karyawan'] = array();
    foreach ($karyawan as $key => $value) {
      $data['karyawan'][$value->id]['nama'] = $value->nama;
      $data['karyawan'][$value->id]['jabatan'] = $value->jabatan;
    }

    $admin = DB::table('users as a')->select("*")->get();
    $data['admin'] = array();
    foreach ($admin as $key => $value) {
      $data['admin'][$value->id] = $value->username;
    }

    $barang = DB::table('tb_jasa as a')->select("*")->get();
    $data['jasa'] = array();
    foreach ($barang as $key => $value) {
      $data['jasa'][$value->kode]['nama_jasa'] = $value->nama_jasa;
      $data['jasa'][$value->kode]['kode'] = $value->kode;
      $data['jasa'][$value->kode]['biaya'] = $value->biaya;
    }

    $harga = DB::table('tb_harga as a')->select("*")->get();
    $data['harga'] = array();
    foreach ($harga as $key => $value) {
      $data['harga'][$value->id_barang]['harga_net'] = $value->harga;
      $data['harga'][$value->id_barang]['harga_hpp'] = $value->harga_hpp;
      $data['harga'][$value->id_barang]['harga_hp'] = $value->harga_hp;
      $data['harga'][$value->id_barang]['fee_item'] = $value->fee_item;
    }

    $data['data'] = DB::table('tb_detail_trip_jasa as a')
                    ->join('tb_detail_order_jasa as b','b.no_kwitansi','=','a.no_kwitansi')
                    ->join('tb_order_jasa as c','c.no_kwitansi','=','a.no_kwitansi')
                    ->select("a.*","b.*","c.*")
                    ->where('a.no_trip',$data['no_trips'])
                    ->get();
    foreach ($data['data'] as $key => $value) {
      if (isset($data['jml_potongan'][$value->no_kwitansi])) {
        $data['jml_potongan'][$value->no_kwitansi] += 1;
      }else{
        $data['jml_potongan'][$value->no_kwitansi] = 1;
      }
    }

    $data['ins'] = array();
    foreach ($data['data'] as $key => $value) {
      $cekpembayaran = DB::table('tb_pembayaran as a')
                       ->where("a.status_pembayaran","Lunas")
                       ->where('a.no_kwitansi',$value->no_kwitansi)
                       ->get();
      if(count($cekpembayaran) < 1){
        $data['ins'][$value->no_trip] = true;
      }
    }
    $data['nama_download'] = "INSENTIF -".$no_trips;
    return view ('PrintPerhitunganInsentifJasa',$data);
  }


  public function cetakrinciantrip($id){
    $cek =  substr($id, 0, 2);
    if ($cek == "TP") {
    $data['data'] = DB::table('tb_detail_trip as a')
                    ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                    ->select("*")
                    ->where('a.no_trip',$id)
                    ->where('b.proses','>','0')
                    ->get();

    $data['alamat'] = DB::table('tb_gudang as a')
                      ->join('tb_trip as b','b.id_gudang','=','a.id')
                      ->select("a.*")
                      ->where("b.no_trip",$id)
                      ->get();

    //dd($data);

    $data['trip'] = $id;
    $barang = DB::table('tb_barang as a')->select("*")->get();
    $data['barang'] = array();
    foreach ($barang as $key => $value) {
      $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
      $data['barang'][$value->id]['no_sku'] = $value->no_sku;
      $data['barang'][$value->id]['branded'] = $value->branded;
    }

    $data['print'] = array();
    foreach ($data['data'] as $key => $value) {
      if($value->terkirim > 0){
         $data['print'][$value->id_barang]['nama_barang'] = $data['barang'][$value->id_barang]['nama_barang'];
          if (isset($data['print'][$value->id_barang]['jumlah'])) {
            $data['print'][$value->id_barang]['jumlah'] += $value->terkirim;
          }else{
            $data['print'][$value->id_barang]['jumlah'] = $value->terkirim;
          }
      }else if($value->terkirim == null){
          $data['print'][$value->id_barang]['nama_barang'] = $data['barang'][$value->id_barang]['nama_barang'];
          if (isset($data['print'][$value->id_barang]['jumlah'])) {
            $data['print'][$value->id_barang]['jumlah'] += $value->proses;
          }else{
            $data['print'][$value->id_barang]['jumlah'] = $value->proses;
          }
      }
    }

    $a = 1;
    $b = 1;
    foreach ($data['print'] as $key => $value) {
      $data['loop'][$a][$b] = $value;
      $b++;
      if ($b % 32 == 0) {
        $a++;
      }
    }

    return view ('PrintRincianProduk',$data);
  }else{
    $data['data'] = DB::table('tb_detail_trip_jasa as a')
                    ->join('tb_detail_order_jasa as b','b.no_kwitansi','=','a.no_kwitansi')
                    ->select("*")
                    ->where('a.no_trip',$id)
                    ->get();

    $data['alamat'] = DB::table('tb_gudang as a')
                      ->join('tb_trip_jasa as b','b.id_gudang','=','a.id')
                      ->select("a.*")
                      ->where("b.no_trip",$id)
                      ->get();

    $data['trip'] = $id;
    $barang = DB::table('tb_jasa as a')->select("*")->get();
    $data['barang'] = array();
    foreach ($barang as $key => $value) {
      $data['barang'][$value->kode] = $value->nama_jasa;
    }

    $data['print'] = array();
    foreach ($data['data'] as $key => $value) {
       $data['print'][$value->id_jasa]['nama_jasa'] = $data['barang'][$value->id_jasa];
        if (isset($data['print'][$value->id_jasa]['jumlah'])) {
          $data['print'][$value->id_jasa]['jumlah'] += $value->jumlah;
        }else{
          $data['print'][$value->id_jasa]['jumlah'] = $value->jumlah;
        }
    }

    $a = 1;
    $b = 1;
    foreach ($data['print'] as $key => $value) {
      $data['loop'][$a][$b] = $value;
      $b++;
      if ($b % 32 == 0) {
        $a++;
      }
    }
    return view ('PrintRincianProdukJasa',$data);
  }
}

public function edit_kategori_penjualan(Request $post){
  $data = $post->except('_token');
  $sq = DB::table('tb_trip as a')->where("no_trip",$data['no_trip'])->update($data);
  if ($sq) {
    return redirect()->back()->with('success','Berhasil');
  }else{
    return redirect()->back()->with('error','Berhasil');
  }
}


public function trippostjasa(Request $post){
  $d = $post->except('_token');
  $no_kwitansi = explode(",",$d['no_kwitansi']);
  $id_konsumen = explode(",",$d['id_konsumen']);
  $sub_total = explode(",",$d['sub_total']);

  date_default_timezone_set('Asia/Jakarta');
  $ava = DB::table('tb_trip_jasa as a')->select("*")->where("a.tanggal_create","=",date('Y-m-d'))->orderBy('id', 'DESC')->get();
  $status = true;
  $jumlah_avai = 0;
  if(count($ava) > 0){
    foreach ($ava as $key => $value):
      $gdhs = substr($value->no_trip, -1);
      $split = explode("P",$value->no_trip);
      if($gdhs != "P" && $status){
        $jumlah_avai += 1;
        $var = substr($value->no_trip,9,3);
        $data['no_trip'] = "TJ-".date('ymd').str_pad($var + 1, 3, '0', STR_PAD_LEFT);
        $status = false;
      }
    endforeach;
    if ($jumlah_avai < 1) {
      $data['no_trip'] = "TJ-".date('ymd')."001";
    }
  }else{
      $data['no_trip'] = "TJ-".date('ymd')."001";
  }

  $data['tanggal_input'] = $d['tanggal_input'];

  $data['id_gudang'] = $d['id_gudang'];
  $data['kasir'] = $d['kasir'];
  $data['admin'] = $d['admin'];
  DB::table('tb_trip_jasa')->insert($data);

  for ($i=1; $i < count($no_kwitansi); $i++) {
    $dt['no_trip'] = $data['no_trip'];
    $dt['no_kwitansi'] = $no_kwitansi[$i];
    $dt['id_konsumen'] = $id_konsumen[$i];
    $dt['sub_total'] = $sub_total[$i];
    DB::table('tb_detail_trip_jasa')->insert($dt);
    $x['no_kwitansi'] = $dt['no_kwitansi'];
    $x['cluster'] = "yes";
    DB::table('tb_order_jasa')->where('no_kwitansi','=',$x['no_kwitansi'])->update($x);
  }

  echo $dt['no_trip'];
}

public function daftartripjasa(){
  if (Auth::user()->level == "1" || Auth::user()->level == "4") {
    $data['daftar'] = DB::table('tb_trip_jasa as a')
                        ->join('tb_detail_trip_jasa as b','b.no_trip','=','a.no_trip')
                        ->select("*",DB::raw('SUM(b.sub_total) as penjualan'),"a.id as id_trip","a.status as available")->groupBy("a.no_trip")->get();
  }else{
    $data['daftar'] = DB::table('tb_trip_jasa as a')
                        ->join('tb_detail_trip_jasa as b','b.no_trip','=','a.no_trip')
                        ->select("*",DB::raw('SUM(b.sub_total) as penjualan'),"a.id as id_trip","a.status as available")
                        ->where('a.id_gudang',Auth::user()->gudang)
                        ->groupBy("a.no_trip")->get();
  }


  $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
  $data['konsumen'] = array();
  foreach ($konsumen as $key => $value) {
    $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
    $data['konsumen'][$value->id]['alamat'] = $value->alamat;
  }
  $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
  $data['karyawan'] = array();
  foreach ($karyawan as $key => $value) {
    $data['karyawan'][$value->id] = $value->nama;
  }
  $admin = DB::table('users as a')->select("*")->get();
  $data['admin'] = array();
  foreach ($admin as $key => $value) {
    $data['admin'][$value->id] = $value->name;
  }
  $gudang = DB::table('tb_gudang as a')->select("*")->get();
  $data['gudang'] = array();
  foreach ($gudang as $key => $value) {
    $data['gudang'][$value->id]['id'] = $value->id;
    $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
    $data['gudang'][$value->id]['status'] = $value->status;
  }
  $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");
  return view ('DaftarTripJasa',$data);
}

}
