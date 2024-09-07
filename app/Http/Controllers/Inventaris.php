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

class Inventaris extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function inputinventaris(){
    $d['bm'] = DB::table('tb_inventaris as a')->select("*")->where("a.tanggal_order","=",date('Y-m-d'))->orderBy('dt','DESC')->limit(1)->get();
    if(count($d['bm']) > 0){
      $var = substr($d['bm'][0]->no_kwitansi,9,3);
      $data['number'] = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
    }else{
      $data['number'] = "001";
    }
      $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik","=",Auth::user()->nik)->get();
    if (Auth::user()->level == "1") {
        $data['gudang'] = $this->model->getGudang();
        $data['konsumen'] = DB::table('tb_konsumen as a')->join('tb_karyawan as b','b.id','=','a.pengembang')->select("a.*","b.nama")
                            ->where("a.status","=","aktif")->get();
        $data['kategori'] = DB::table('tb_kategori as a')->select("a.*")->where("a.status","=","aktif")->get();
    }else{
      $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.status","=","aktif")->where("a.id","=",Auth::user()->gudang)->get();
      if (Auth::user()->gudang == "1") {
        $data['kategori'] = DB::table('tb_kategori as a')->select("a.*")->where("a.status","=","aktif")
                            //->where("a.id","=","1")
                            ->get();
      }else{
        $data['kategori'] = DB::table('tb_kategori as a')->select("a.*")->where("a.status","=","aktif")
                            //->where("a.id","=","2")->orWhere("a.id","=","3")
                            ->get();
      }
      $data['konsumen'] = DB::table('tb_konsumen as a')->join('tb_karyawan as b','b.id','=','a.pengembang')->select("a.*","b.nama")
                          ->where("a.status","=","aktif")->where("a.kategori",Auth::user()->gudang)->get();
    }

    $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status","=","aktif")->get();
    $data['sales'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
    $data['leader'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
    $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
    $data['manager'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
    $data['barang'] = DB::table('tb_barang as a')->join('tb_harga as b','b.id_barang','=','a.id')
                      ->select("a.*","harga","harga_hp","harga_hpp","harga_retail","harga_reseller","harga_agen","qty1","pot1","qty2","pot2","qty3","pot3","label")->where("a.status","=","aktif")->get();


    if (Auth::user()->level == "1") {
      $data['pelanggan'] = DB::table('tb_konsumen as a')
              ->join('tb_karyawan as b','b.id','=','a.pengembang')
              ->leftJoin('tb_karyawan as c','c.id','=','a.leader')
              ->select("a.*","b.nama","c.nama as nama_leader")->where("a.status","=","aktif")
              ->get();
    }else if (Auth::user()->level =="5") {
      $data['pelanggan'] = DB::table('tb_konsumen as a')
              ->join('tb_karyawan as b','b.id','=','a.pengembang')
              ->leftJoin('tb_karyawan as c','c.id','=','a.leader')
              ->select("a.*","b.nama","c.nama as nama_leader")->where("a.status","=","aktif")
              ->where("a.kategori","=",Auth::user()->gudang)
              ->where("a.pengembang","=",$p[0]->id)->get();
    }else{
      $data['pelanggan'] = DB::table('tb_konsumen as a')
              ->join('tb_karyawan as b','b.id','=','a.pengembang')
              ->leftJoin('tb_karyawan as c','c.id','=','a.leader')
              ->select("a.*","b.nama","c.nama as nama_leader")->where("a.status","=","aktif")
              ->where("a.kategori","=",Auth::user()->gudang)
              ->get();
    }

      $data['staff'] = DB::table('tb_karyawan as a')
              ->select("a.*")->where("a.status","=","aktif")
              ->get();

    return view('Distribusi.inventaris',$data);
  }

  public function postinventaris(Request $post){
    $data = $post->except('_token');
    date_default_timezone_set('Asia/Jakarta');
    $da['bm'] = DB::table('tb_inventaris as a')->select("*")->where("a.tanggal_order","=",date('Y-m-d'))->orderBy('dt', 'DESC')->get();
    $status = true;
    if(count($da['bm']) > 0){
      foreach ($da['bm'] as $key => $value):
        $split = explode("P",$value->no_kwitansi);
        if(count($split) < 2 && $status){
          $var = substr($value->no_kwitansi,9,3);
          $number = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
          $status = false;
        }
      endforeach;
    }else{
      $number = "001";
    }

    $d['no_kwitansi'] = 'IN-'.date('ymd').$number;
    $d['tanggal_order'] = $data['tanggal_order'];
    $d['id_konsumen'] = $data['id_konsumen'];
    $d['id_gudang'] = $data['id_gudang'];
    $d['admin_p'] = Auth::user()->id;

    $kondisi = DB::table('tb_inventaris as a')->select("*")
                ->where("a.id_konsumen","=",$data['id_konsumen'])
                ->where("a.id_gudang",$data['id_gudang'])
                ->where("a.tanggal_order",$data['tanggal_order'])
                ->where("a.admin_p",Auth::user()->id)
                ->limit(1)
                ->get();

    if (count($kondisi) < 1) {
      $avai = DB::table('tb_inventaris as a')->select("*")
                  ->where("a.no_kwitansi","=",$d['no_kwitansi'])
                  ->get();
      if (count($avai) < 1) {
        echo "success,".$d['no_kwitansi'];
        DB::table('tb_inventaris')->insert($d);
      }else{
        $number += 1;
        $d['no_kwitansi'] = 'IN-'.date('ymd').$number;
        echo "success,".$d['no_kwitansi'];
        DB::table('tb_inventaris')->insert($d);
      }
    }else{
      echo "exist,".$kondisi[0]->no_kwitansi;
    }
  }

  public function postinventarisdetail(Request $post){
    $data = $post->except('_token');
    $str = explode(",",$data['no_kwitansi']);
    $s['no_kwitansi'] = $str[1];
    $s['id_barang'] = $data['id_barang'];
    $s['jumlah'] = $data['jumlah'];
    $s['time'] = date("h:i");

    $available = DB::table('tb_inventaris_detail as a')->select("*")->where($s)->get();
    if (count($available) < 1) {
      DB::table('tb_inventaris_detail')->insert($s);
      $dx = DB::table('tb_inventaris')->where('no_kwitansi',$s['no_kwitansi'])->get();
      $fc['id_gudang'] = $dx[0]->id_gudang;
      $fc['id_barang'] = $s['id_barang'];
      DB::table('tb_gudang_barang')->where($fc)->decrement('jumlah',$s['jumlah']);
    }
  }

  public function getstokbar($id,$gd){
    $d = DB::table('tb_gudang_barang')->where('id_barang',$id)->where('id_gudang',$gd)->get();
    if (count($d)>0) {
      echo json_encode($d[0]->jumlah);
    }else{
      echo json_encode(0);
    }
  }

  public function datainventaris(){
    $data['inv'] = DB::table('tb_inventaris as a')->join('tb_inventaris_detail as b','a.no_kwitansi','b.no_kwitansi')->get();

    $karyawan = DB::table('tb_karyawan')->get();
    foreach ($karyawan as $key => $value) {
      $data['karyawan'][$value->id] = $value;
    }

    $user = DB::table('users')->get();
    foreach ($user as $key => $value) {
      $data['user'][$value->id] = $value;
    }

    $gudang = DB::table('tb_gudang')->get();
    foreach ($gudang as $key => $value) {
      $data['gudang'][$value->id] = $value;
    }

    $barang = DB::table('tb_barang')->get();
    foreach ($barang as $key => $value) {
      $data['barang'][$value->id] = $value;
    }
    return view('Distribusi.datainventaris',$data);
  }


}
