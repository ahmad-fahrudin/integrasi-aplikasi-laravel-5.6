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

class KasirController extends Controller
{
  var $model;
  public function __construct()
  {   
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function kasir(){
    /*$data['pelanggan'] = DB::table('tb_konsumen as a')
            ->join('tb_karyawan as b','b.id','=','a.pengembang')
            ->leftJoin('tb_karyawan as c','c.id','=','a.leader')
            ->select("a.*","b.nama","c.nama as nama_leader")->where("a.status","=","aktif")
            ->get();*/

    $d['bm'] = DB::table('tb_barang_keluar as a')->select("*")->where("a.status","=","aktif")->where("a.tanggal_order","=",date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
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
                            ->where("a.status","=","aktif")->where("a.kategori","=","1")->get();
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
                          ->where("a.status","=","aktif")->where("a.kategori","=","2")->get();
    }

    $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status","=","aktif")->get();
    $data['sales'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();
    $data['leader'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();
    $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();
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
    }else if (Auth::user()->gudang =="2") {
      $data['pelanggan'] = DB::table('tb_konsumen as a')
              ->join('tb_karyawan as b','b.id','=','a.pengembang')
              ->leftJoin('tb_karyawan as c','c.id','=','a.leader')
              ->select("a.*","b.nama","c.nama as nama_leader")->where("a.status","=","aktif")
              ->where("a.kategori","=",Auth::user()->gudang)
              ->get();
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
              
      $data['rekening'] = DB::table('tb_rekening as a')
                        ->select("*")
                        ->where("a.status","aktif")
                        ->get();
                        
    return view('kasir/kasir2',$data);
  }

  public function caribarangbykode($id){
    $kategori = DB::table('tb_barang as a')->join('tb_harga as b','b.id_barang','=','a.id')->where('a.nama_barang',"like","%$id%")->orWhere('a.id_barcode',"like","%$id%")->orWhere('a.no_sku',"like","%$id%")->select("*")->get();
    echo json_encode($kategori);
  }


  public function postkasir(Request $post){
    $data = $post->except('_token');
    
    if($data['status_lunas'] == "true"){
      $tagihan = str_replace(".","",$data['total_bayar']);
      $l['pembayaran'] = str_replace(".","",$data['total_bayar']);

      if($l['pembayaran'] >= $tagihan){
        $lp['status_pembayaran'] = "Lunas";
      }else{
        $lp['status_pembayaran'] = "Titip";
      }

      $lp['no_kwitansi'] = $data['no_kwitansi'];

      $lpt['no_kwitansi'] = $data['no_kwitansi'];
      $lpt['tgl_bayar'] = $data['tanggal_order'];
      $lpt['nama_penyetor'] = $data['nama_pemilik'];
      $lpt['pembayaran'] = $data['total_bayar'];

      $d['admin_k'] = Auth::user()->id;
      $cek = DB::table('tb_pembayaran as a')->select("*")->where("a.no_kwitansi","=",$data['no_kwitansi'])->get();
      if(count($cek) < 1){
        DB::table('tb_pembayaran')->insert($lp);
      }else{
        $xc['status_pembayaran'] = $lp['status_pembayaran'];
        DB::table('tb_pembayaran')->where('no_kwitansi','=',$data['no_kwitansi'])->update($xc);
      }
      DB::table('tb_detail_pembayaran')->insert($lpt);
      
      
      if(strtoupper($data['jenis_pembayaran']) == "TUNAI"){
        $t['jumlah'] = $data['total_bayar'];
        $t['saldo_temp'] = 0;
        $t['jenis'] = 'in';
        $t['nama_jenis'] = 'Setoran Penjualan';
        $t['admin'] = Auth::user()->id;
        $t['keterangan'] = 'Penjualan '.$data['nama_pemilik'].' ('.$data['no_kwitansi'].') Lunas';
        DB::table('tb_kas_ditangan')->insert($t);
      }else if(strtoupper($data['jenis_pembayaran']) == "TRANSFER"){
        $t['jumlah'] = $data['total_bayar'];
        $t['saldo_temp'] = 0;
        $t['jenis'] = 'in';
        $t['nama_jenis'] = 'Setoran Penjualan';
        $t['admin'] = Auth::user()->id;
        $t['keterangan'] = 'Penjualan '.$data['nama_pemilik'].' ('.$data['no_kwitansi'].') Lunas';
        $t['kode_bank'] = $data['no_rekening_bank'];
        DB::table('tb_kas_dibank')->insert($t);
        
      }
      
      
    }
    
    
    date_default_timezone_set('Asia/Jakarta');
    $da['bm'] = DB::table('tb_barang_keluar as a')->select("*")->where("a.tanggal_order","=",date('Y-m-d'))->orderBy('id', 'DESC')->get();
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

    $d['no_kwitansi'] = 'GR-'.date('ymd').$number;
    $d['tanggal_order'] = $data['tanggal_order'];
    $d['status_barang'] = 'terkirim';
    $d['kasir'] = 1;
    $d['id_konsumen'] = $data['id_konsumen'];
    $d['id_gudang'] = $data['id_gudang'];
    $d['status_order'] = $data['status_order'];
    $d['pengembang'] = $data['pengembang'];
    $d['sales'] = 1;
    $d['leader'] = $data['leader'];
    $d['manager'] = $data['manager'];
    $d['kategori'] = $data['kategori'];
    $d['admin_p'] = Auth::user()->id;
    $d['admin_g'] = Auth::user()->id;
    $d['admin_v'] = Auth::user()->id;
    $d['qc'] = Auth::user()->id;
    $d['total_bayar'] = $data['total_bayar'];
    $d['tanggal_terkirim'] = date('Y-m-d');
    $d['tanggal_proses'] = date('Y-m-d');
    $d['pembayaran_konsumen'] = $data['pembayaran_konsumen'];
    $d['kembalian_konsumen'] = $data['kembalian_konsumen'];

    $kons = DB::table('tb_konsumen as a')->select("*")->where("a.id",$data['id_konsumen'])->get();


    $x['no_kwitansi'] = $d['no_kwitansi'];
    $x['status_pembayaran'] = "Lunas";

    $u['no_kwitansi'] = $d['no_kwitansi'];
    $u['tgl_bayar'] = date('Y-m-d');
    $u['nama_penyetor'] = $kons[0]->nama_pemilik;
    $u['pembayaran'] = $data['total_bayar'];


    $avai = DB::table('tb_barang_keluar as a')->select("*")
                ->where("a.no_kwitansi","=",$d['no_kwitansi'])
                ->get();
                
    if (count($avai) < 1) {
      echo "success,".$d['no_kwitansi'];
      DB::table('tb_barang_keluar')->insert($d);
      //DB::table('tb_pembayaran')->insert($x);
      //DB::table('tb_detail_pembayaran')->insert($u);
    }else{
      $number += 1;
      $d['no_kwitansi'] = 'GR-'.date('ymd').$number;
      $x['no_kwitansi'] = $d['no_kwitansi'];
      $u['no_kwitansi'] = $d['no_kwitansi'];

      echo "success,".$d['no_kwitansi'];
      DB::table('tb_barang_keluar')->insert($d);
      //DB::table('tb_pembayaran')->insert($x);
      //DB::table('tb_detail_pembayaran')->insert($u);
    }
    
    
    $querycek = DB::table('tb_grafik')->where('months',date('F Y'))->get();
    if (count($querycek) > 0) {
      DB::table('tb_grafik')->where('months',date('F Y'))->increment('sums',$d['total_bayar']);
    }else{
      $y['months'] = date('F Y');
      $y['sums'] = $data['total_bayar'];
      DB::table('tb_grafik')->insert($y);
    }
    

  }


  public function postkasirdetail(Request $post){
    $data = $post->except('_token');
    $str = explode(",",$data['no_kwitansi']);
    $s['potongan'] = $data['potongan'];
    $s['no_kwitansi'] = $str[1];
    $s['id_barang'] = $data['id_barang'];
    $s['harga_net'] = $data['harga_net'] - $s['potongan'];
    $s['jumlah'] = $data['jumlah'];
    $s['harga_jual'] = $data['harga_jual'];
    $s['sub_total'] = $data['sub_total'];

    $s['proses'] = $data['jumlah'];
    $s['pending'] = 0;
    $s['terkirim'] = $data['jumlah'];
    $s['return'] = 0;

    $cek_harga = DB::table('tb_harga as a')->select("*")->where("id_barang",$data['id_barang'])->get();
    $s['harga_hp'] = $cek_harga[0]->harga_hp - $data['potonganpromo'];
    $s['harga_hpp'] = $cek_harga[0]->harga_hpp- $data['potonganpromo'];
    $s['harga_agen'] = $cek_harga[0]->harga_agen;
    $s['harga_reseller'] = $cek_harga[0]->harga_reseller;

    $s['time'] = date("h:i");
    $available = DB::table('tb_detail_barang_keluar as a')->select("*")->where($s)->get();
    if (count($available) < 1) {
      $input_detail = DB::table('tb_detail_barang_keluar')->insert($s);
      if ($input_detail) {
        $gudang = DB::table('tb_barang_keluar as a')->select("*")->where('no_kwitansi',$s['no_kwitansi'])->get();
        DB::table('tb_gudang_barang')->where('id_barang',$s['id_barang'])->where('id_gudang',$gudang[0]->id_gudang)->decrement('jumlah',$data['jumlah']);
      }
    }
  }
  
  public function endsession(){
     $now = "GR-".date('ymd');
     $data['order'] = DB::table('tb_barang_keluar as a')
                  ->select("*")
                  ->where("a.kasir",1)
                  ->where('no_kwitansi','like',"$now%")
                  ->where('admin_p',Auth::user()->id)
                  ->where('id_gudang',Auth::user()->gudang)
                  ->whereNull('cluster')
                  ->get();
     $data['bayar'] = array();
     foreach($data['order'] as $value){
         $pby = DB::table('tb_pembayaran as a')->where('no_kwitansi',$value->no_kwitansi)->get();
         if(count($pby) > 0){
             $data['bayar'][$value->no_kwitansi] = "Lunas";
         }
     }
     
     $kons = DB::table('tb_konsumen as a')->select("*")->get();
     $data['konsumen'] = array();
     foreach ($kons as $value) {
        $data['konsumen'][$value->id]['id_konsumen'] =$value->id;
        $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] =$value->alamat;
        $data['konsumen'][$value->id]['kota'] =$value->kota;
     }
     
     $regencies = DB::table('regencies as a')->select("*")->get();
     $data['regencies'] = array();
     foreach ($regencies as $value) {
        $data['regencies'][$value->id] =$value->name;
     }
     
     $users = DB::table('users as a')->select("*")->get();
     $data['users'] = array();
     foreach ($users as $value) {
        $data['users'][$value->id] =$value->name;
     }
     
     $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
     $data['karyawan'] = array();
     foreach ($karyawan as $value) {
        $data['karyawan'][$value->id] =$value->nama;
     }
     
     $gudang = DB::table('tb_gudang as a')->select("*")->get();
     $data['gudang'] = array();
     foreach ($gudang as $value) {
        $data['gudang'][$value->id] =$value->nama_gudang;
     }

     return view('EndSession',$data);
  }
  
  
  public function endsessions(Request $post){
     $dx = $post->except('_token');
     $now = "GR-".date('ymd');
     if($dx['jenis'] == "Semua"){
         $data['jenis'] = $dx['jenis'];
         $data['order'] = DB::table('tb_barang_keluar as a')
                  ->select("*")
                  ->where("a.kasir",1)
                  ->where('no_kwitansi','like',"$now%")
                  ->whereNull('cluster')
                  ->get();
     }else{
          $data['order'] = DB::table('tb_barang_keluar as a')
              ->select("*")
              ->where("a.kasir",1)
              ->where('no_kwitansi','like',"$now%")
              ->where('admin_p',Auth::user()->id)
              ->where('id_gudang',Auth::user()->gudang)
              ->whereNull('cluster')
              ->get();
     }
     
     $data['bayar'] = array();
     foreach($data['order'] as $value){
         $pby = DB::table('tb_pembayaran as a')->where('no_kwitansi',$value->no_kwitansi)->get();
         if(count($pby) > 0){
             $data['bayar'][$value->no_kwitansi] = "Lunas";
         }
     }
     
     $kons = DB::table('tb_konsumen as a')->select("*")->get();
     $data['konsumen'] = array();
     foreach ($kons as $value) {
        $data['konsumen'][$value->id]['id_konsumen'] =$value->id;
        $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] =$value->alamat;
        $data['konsumen'][$value->id]['kota'] =$value->kota;
     }
     
     $regencies = DB::table('regencies as a')->select("*")->get();
     $data['regencies'] = array();
     foreach ($regencies as $value) {
        $data['regencies'][$value->id] =$value->name;
     }
     
     $users = DB::table('users as a')->select("*")->get();
     $data['users'] = array();
     foreach ($users as $value) {
        $data['users'][$value->id] =$value->name;
     }
     
     $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
     $data['karyawan'] = array();
     foreach ($karyawan as $value) {
        $data['karyawan'][$value->id] =$value->nama;
     }
     
     $gudang = DB::table('tb_gudang as a')->select("*")->get();
     $data['gudang'] = array();
     foreach ($gudang as $value) {
        $data['gudang'][$value->id] =$value->nama_gudang;
     }
     return view('EndSession',$data);
  }
  
  
    public function endsessionjasa(){
     $now = "JS-".date('ymd');
     $data['order'] = DB::table('tb_order_jasa as a')
                  ->select("*")
                  ->where("a.kasir",cekmyid_karyawan())
                  ->where('no_kwitansi','like',"$now%")
                  ->where('gudang',Auth::user()->gudang)
                  ->whereNull('cluster')
                  ->get();
     $data['detail'] = array();
     foreach($data['order'] as $v){
              $detail = DB::table('tb_detail_order_jasa as a')
              ->select("*",DB::raw('SUM(a.sub_biaya) as tagihan'))
              ->where('no_kwitansi',$v->no_kwitansi)
              ->get();
              if(count($detail) > 0){
                 $data['detail'][$v->no_kwitansi] = $detail[0]->tagihan;
              }
     }
     
     
     $data['bayar'] = array();
     foreach($data['order'] as $value){
         $pby = DB::table('tb_pembayaran as a')->where('no_kwitansi',$value->no_kwitansi)->get();
         if(count($pby) > 0){
             $data['bayar'][$value->no_kwitansi] = "Lunas";
         }
     }
     
     
     $kons = DB::table('tb_konsumen as a')->select("*")->get();
     $data['konsumen'] = array();
     foreach ($kons as $value) {
        $data['konsumen'][$value->id]['id_konsumen'] =$value->id;
        $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] =$value->alamat;
        $data['konsumen'][$value->id]['kota'] =$value->kota;
     }
     
     $regencies = DB::table('regencies as a')->select("*")->get();
     $data['regencies'] = array();
     foreach ($regencies as $value) {
        $data['regencies'][$value->id] =$value->name;
     }
     
     $users = DB::table('users as a')->select("*")->get();
     $data['users'] = array();
     foreach ($users as $value) {
        $data['users'][$value->id] =$value->name;
     }
     
     $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
     $data['karyawan'] = array();
     foreach ($karyawan as $value) {
        $data['karyawan'][$value->id] =$value->nama;
     }
     
     $gudang = DB::table('tb_gudang as a')->select("*")->get();
     $data['gudang'] = array();
     foreach ($gudang as $value) {
        $data['gudang'][$value->id] =$value->nama_gudang;
     }
     
     return view('EndSessionJasa',$data);
  }
  
  
  public function endsessionjasas(Request $post){
     $now = "JS-".date('ymd');
     $dx = $post->except('_token');
     if($dx['jenis'] == "Semua"){
         $data['jenis'] = $dx['jenis'];
          $data['order'] = DB::table('tb_order_jasa as a')
              ->select("*")
              ->where('no_kwitansi','like',"$now%")
              ->whereNull('cluster')
                  ->get();
     }else{
          $data['order'] = DB::table('tb_order_jasa as a')
              ->select("*")
              ->where("a.kasir",cekmyid_karyawan())
              ->where('no_kwitansi','like',"$now%")
              ->where('gudang',Auth::user()->gudang)
              ->whereNull('cluster')
              ->get();
     }
     $data['detail'] = array();
     foreach($data['order'] as $v){
              $detail = DB::table('tb_detail_order_jasa as a')
              ->select("*",DB::raw('SUM(a.sub_biaya) as tagihan'))
              ->where('no_kwitansi',$v->no_kwitansi)
              ->get();
              if(count($detail) > 0){
                 $data['detail'][$v->no_kwitansi] = $detail[0]->tagihan;
              }
     }
     
     $data['bayar'] = array();
     foreach($data['order'] as $value){
         $pby = DB::table('tb_pembayaran as a')->where('no_kwitansi',$value->no_kwitansi)->get();
         if(count($pby) > 0){
             $data['bayar'][$value->no_kwitansi] = "Lunas";
         }
     }
     
     $kons = DB::table('tb_konsumen as a')->select("*")->get();
     $data['konsumen'] = array();
     foreach ($kons as $value) {
        $data['konsumen'][$value->id]['id_konsumen'] =$value->id;
        $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] =$value->alamat;
        $data['konsumen'][$value->id]['kota'] =$value->kota;
     }
     
     $regencies = DB::table('regencies as a')->select("*")->get();
     $data['regencies'] = array();
     foreach ($regencies as $value) {
        $data['regencies'][$value->id] =$value->name;
     }
     
     $users = DB::table('users as a')->select("*")->get();
     $data['users'] = array();
     foreach ($users as $value) {
        $data['users'][$value->id] =$value->name;
     }
     
     $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
     $data['karyawan'] = array();
     foreach ($karyawan as $value) {
        $data['karyawan'][$value->id] =$value->nama;
     }
     
     $gudang = DB::table('tb_gudang as a')->select("*")->get();
     $data['gudang'] = array();
     foreach ($gudang as $value) {
        $data['gudang'][$value->id] =$value->nama_gudang;
     }
     
     return view('EndSessionJasa',$data);
  }
  
  
  public function detailOrderJasa($id){
        $detail = DB::table('tb_detail_order_jasa as a')
              ->join('tb_jasa as b','a.id_jasa','=','b.kode')
              ->select("a.*","b.nama_jasa")
              ->where('no_kwitansi',$id)
              ->get();
        echo json_encode($detail);
  }
  
  public function prosesendsession($id){
    date_default_timezone_set('Asia/Jakarta');
    $now = "GR-".date('ymd');
    $dat = DB::table('tb_barang_keluar as a')
             ->select("*")
             ->where("a.kasir",1)
             ->where('no_kwitansi','like',"$now%")
             ->where('id_gudang',Auth::user()->gudang)
             ->where('admin_p',Auth::user()->id)
             ->whereNull('cluster')
             ->get();
    
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
    
    
    
    if(count($dat)>0){
        $data['tanggal_input'] = date('Y-m-d');
        $data['kategori'] = 1;
        $data['id_gudang'] = Auth::user()->gudang;
        $data['qc'] = cekmyid_karyawan();
        $data['admin'] = Auth::user()->id;
        $q = DB::table('tb_trip')->insert($data);
        if($q){
          foreach($dat as $value){
              $dt['no_trip'] = $data['no_trip'];
              $dt['id_barang_keluar'] = $value->id;
              $dt['no_kwitansi'] = $value->no_kwitansi;
              $dt['id_konsumen'] = $value->id_konsumen;
              $dt['sub_total'] = $value->total_bayar;
              DB::table('tb_detail_trip')->insert($dt);
              $x['id'] = $dt['id_barang_keluar'];
              $x['cluster'] = "yes";
              DB::table('tb_barang_keluar')->where('id','=',$x['id'])->update($x);
          }
          session_start();
          $_SESSION['trip'] = $data['no_trip'];
          
          
          
          if($id == "true"){
              $rdrct = DB::table('tb_trip')->where('no_trip',$data['no_trip'])->get();
              if(count($rdrct) > 0){
                  return redirect('/insentifsimpansession/'.$rdrct[0]->no_trip.'/'.$rdrct[0]->id.'/'.$rdrct[0]->tanggal_input.'/'.kategoritrip($rdrct[0]->kategori).'/'.getnamegudang($rdrct[0]->id_gudang).'/0/1');
              }else{
                  return redirect()->back();
              }
              
          }else{
              return redirect()->back()->with('success','Berhasil');
          }
          
        }
    }else{
        return redirect()->back();
    }
  }
  
  public function printbytrip($id){
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
      $data['kategori'] = array("","Non Insentif", "Sales Marketing", "Membership", "Grosir HPP Target");

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
      
     $data['bayar'] = array();
     foreach($data['surat'] as $value){
         $pby = DB::table('tb_pembayaran as a')->where('no_kwitansi',$value->no_kwitansi)->get();
         if(count($pby) > 0){
             $data['bayar'][$value->no_kwitansi] = "Lunas";
         }
     }
     
      return view('TripSuratJalanJasaBT',$data);


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
      $data['kategori'] = array("","Non Insentif", "Sales Marketing", "Membership", "Grosir HPP Target");

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
      
      
     $data['bayar'] = array();
     foreach($data['surat'] as $value){
         $pby = DB::table('tb_pembayaran as a')->where('no_kwitansi',$value->no_kwitansi)->get();
         if(count($pby) > 0){
             $data['bayar'][$value->no_kwitansi] = "Lunas";
         }
     }
      
      return view('TripSuratJalanBT',$data);
    }  
  }
  
  public function prosesendsessionjasa($id){
    date_default_timezone_set('Asia/Jakarta');
    
    $now = "JS-".date('ymd');
    $dat = DB::table('tb_order_jasa as a')
             ->select("*")
             ->where("a.kasir",cekmyid_karyawan())
             ->where('no_kwitansi','like',"$now%")
             ->where('gudang',Auth::user()->gudang)
             ->whereNull('cluster')
             ->get();
    
    $da = array();
    foreach($dat as $v){
              $detail = DB::table('tb_detail_order_jasa as a')
              ->select("*",DB::raw('SUM(a.sub_biaya) as tagihan'))
              ->where('no_kwitansi',$v->no_kwitansi)
              ->get();
              if(count($detail) > 0){
                 $da[$v->no_kwitansi] = $detail[0]->tagihan;
              }
     }
    
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
    
    if(count($dat)>0){
        $data['tanggal_input'] = date('Y-m-d');
        $data['id_gudang'] = Auth::user()->gudang;
        $data['kasir'] = cekmyid_karyawan();
        $data['admin'] = Auth::user()->id;
        $q = DB::table('tb_trip_jasa')->insert($data);
        if($q){
          foreach($dat as $value){
              $dt['no_trip'] = $data['no_trip'];
              $dt['no_kwitansi'] = $value->no_kwitansi;
              $dt['id_konsumen'] = $value->id_konsumen;
              
              if(isset($da[$value->no_kwitansi])){
                  $dt['sub_total'] = $da[$value->no_kwitansi];
              }else{
                  $dt['sub_total'] = 0;
              }
              
              DB::table('tb_detail_trip_jasa')->insert($dt);
              $x['no_kwitansi'] = $dt['no_kwitansi'];
              $x['cluster'] = "yes";
              DB::table('tb_order_jasa')->where('no_kwitansi','=',$x['no_kwitansi'])->update($x);
          }
          session_start();
          $_SESSION['trip'] = $data['no_trip'];
          
          if($id == "true"){
              $rdrct = DB::table('tb_trip_jasa')->where('no_trip',$data['no_trip'])->get();
              if(count($rdrct) > 0){
                  return redirect('/insentifsimpansessionjasa/'.$rdrct[0]->no_trip.'/'.$rdrct[0]->id.'/'.$rdrct[0]->tanggal_input.'/1'.'/'.getnamegudang($rdrct[0]->id_gudang).'/0');
              }else{
                  return redirect()->back();
              }
          }else{
              return redirect()->back()->with('success','Berhasil');
          }
          
          
          return redirect()->back()->with('success','Berhasil');
        }
    }else{
        return redirect()->back();
    }
  }
  
  public function cetaknota($id){
    $data['nota'] = $id;
    $data['transfer'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_konsumen as c','c.id','=','a.id_konsumen')
                          ->join('users as e','e.id','=','a.admin_p')
                          ->join('tb_karyawan as f','f.id','=','a.sales')
                          ->select("a.no_kwitansi","a.tanggal_proses","c.nama_pemilik","c.alamat","c.no_hp","c.kecamatan","c.kota","c.provinsi","c.id_konsumen"
                                    ,"e.name as admin_p","f.nama as sales","a.ongkos_kirim","a.pembayaran_konsumen","a.kembalian_konsumen")
                          ->where("a.no_kwitansi","=",$id)->get();

    $data['barang'] = DB::table('tb_detail_barang_keluar as a')
                      ->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select("*")
                      ->where("a.no_kwitansi",$id)
                      ->get();
    $data['dt'] = count($data['barang']);
    $page = ceil($data['dt']/10);

    $data['alamat_gudang'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_gudang as c','c.id','=','a.id_gudang')
                            ->join('districts as d','c.kecamatan','=','d.id')
                            ->where("a.no_kwitansi","=",$id)->select("c.*","d.*")->get();

   
    $barang = array();
    $i = 0;
    $a = 0;
    $x = 0;

    foreach ($data['barang'] as $value) {
      if (($value->terkirim == null && $value->proses > 0) || $value->terkirim != 0) {
        $barang[0][$a]['nama_barang'] = $value->nama_barang;
        $barang[0][$a]['part_number'] = $value->part_number;
        $barang[0][$a]['proses'] = $value->proses;
        $barang[0][$a]['return'] = $value->return;
        $barang[0][$a]['harga_jual'] = $value->harga_jual;
        $barang[0][$a]['potongan'] = $value->potongan;
        $barang[0][$a]['sub_total'] = $value->sub_total;
        $a++;
        $page = $x + 1;
        $x++;
      }
    }
    $data['detail'] = $barang;
    return view('CetakNota',$data);
  }

  public function getBarangKasir($id){
    $data = DB::table('tb_barang as a')->join('tb_harga as b','b.id_barang','=','a.id')
                      ->select("a.*","harga","harga_hp","harga_retail","qty1","pot1","qty2","pot2","qty3","pot3","label")
                      ->where("id_barcode",$id)
                      ->orWhere("no_sku",$id)->get();
    echo json_encode($data);
  }

  public function cekretail($no_hp){
    $data = DB::table('members as a')->select("id")->where("no_hp",$no_hp)->get();
    if (count($data) > 0) {
      echo json_encode(false);
    }else{
      echo json_encode(true);
    }
  }

  public function cekstok($gudang,$id){
    $data = DB::table('tb_gudang_barang as a')->select("*")->where("id_barang",$id)->where("id_gudang",$gudang)->get();
    $y = DB::table('tb_reject as a')
         ->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
         ->where("b.id_barang",$id)
         ->where("a.id_gudang",$gudang)
         ->where("b.status","pending")
         ->select('*',DB::raw('SUM(b.jumlah) as jumlahreject'))
         ->get();
    if (count($y)>0) {
      $data[0]->reject = $y[0]->jumlahreject;
    }else{
      $data[0]->reject = 0;
    }
    echo json_encode($data);
  }

  public function downloadbarcode($id){
    $tempdir="aset/img-barcode/";
    if (!file_exists($tempdir))
		mkdir($tempdir, 0755);
		$target_path=$tempdir . $id . ".png";


    $fileImage="http://localhost".dirname($_SERVER['PHP_SELF']) . "/aset/barcode.php?text=" . $id . "&codetype=code128&print=true&size=55";

    /*get content from url*/
    $content=file_get_contents($fileImage);

    /*save file */
    file_put_contents($target_path, $content);

    echo "
    <p class='result'>Result :</p>
    <p><img src='aset/barcode.php?text=" . $id . "&codetype=code39&print=true&size=55' /></p>
    <p><a href='lat_dua.php?file=$target_path'>Print Image (10 pcs) </a></p>
    ";
  }

}
