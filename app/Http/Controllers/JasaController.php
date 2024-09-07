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

class JasaController extends Controller
{
  var $model;
  public function __construct()
  {     
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function inputjasabaru(){
    $d['bm'] = DB::table('tb_jasa as a')->select("*")->orderBy('kode', 'DESC')->limit(1)->get();
    if(count($d['bm']) > 0){
      $var = substr($d['bm'][0]->kode,3,4);
      $data['number'] = str_pad($var + 1, 4, '0', STR_PAD_LEFT);
    }else{
      $data['number'] = "0001";
    }
    return view('InputJasaBaru',$data);
  }

  public function simpanjasa(Request $post){
    $data = $post->except('_token','kode');
    $cekava = DB::table('tb_jasa as a')->select("*")->where('kode', $post->kode)->get();
    if (count($cekava) > 0) {
      $last = DB::table('tb_jasa as a')->select("*")->orderBy('kode', 'DESC')->limit(1)->get();
      $var = substr($last[0]->kode,4,3);
      $number = str_pad($var + 1, 3, '0', STR_PAD_LEFT);
      $data['kode'] = "JSU-".$number;
    }else{
      $data['kode'] = $post->kode;
    }
    $q = DB::table('tb_jasa')->insert($data);
    if ($q) {
      return redirect()->back()->with('success','Berhasil');
    }
  }

  public function datalayananjasa(){
    $data['jasa'] = DB::table('tb_jasa as a')->select("*")->get();
    return view('DataLayananJasa',$data);
  }

  public function updatejasa(Request $post){
    $data = $post->except('_token');
    $q = DB::table('tb_jasa')->where('kode',$data['kode'])->update($data);
    if ($q) {
      return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back();
    }
  }

  public function deletejasa($id){
    $q = DB::table('tb_jasa')->where('kode',$id)->delete();
    if ($q) {
      return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back();
    }
  }

  public function kasirjasa(){
    $d['bm'] = DB::table('tb_order_jasa as a')->select("*")->where("a.tanggal_transaksi","=",date('Y-m-d'))->orderBy('no_kwitansi', 'DESC')->limit(1)->get();
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
    $data['manager'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();
    $data['barang'] = DB::table('tb_jasa as a')->where("a.status","=","aktif")->get();


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
    return view('KasirJasa',$data);
  }

  public function postorderjasa(Request $post){
    $data = $post->except('_token');
    if($data['status_lunas'] == "true"){
      $jasa['payment'] = "yes";
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
        $t['keterangan'] = 'Jasa '.$data['nama_pemilik'].' ('.$data['no_kwitansi'].') Lunas';
        DB::table('tb_kas_ditangan')->insert($t);
      }else if(strtoupper($data['jenis_pembayaran']) == "TRANSFER"){
        $t['jumlah'] = $data['total_bayar'];
        $t['saldo_temp'] = 0;
        $t['jenis'] = 'in';
        $t['nama_jenis'] = 'Setoran Penjualan';
        $t['admin'] = Auth::user()->id;
        $t['keterangan'] = 'Jasa '.$data['nama_pemilik'].' ('.$data['no_kwitansi'].') Lunas';
        $t['kode_bank'] = $data['no_rekening_bank'];
        DB::table('tb_kas_dibank')->insert($t);
      }
      
    }

    date_default_timezone_set('Asia/Jakarta');
    $da['bm'] = DB::table('tb_order_jasa as a')->select("*")->where("a.tanggal_transaksi","=",date('Y-m-d'))->orderBy('no_kwitansi', 'DESC')->get();
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

    $jasa['no_kwitansi'] = 'JS-'.date('ymd').$number;
    $jasa['tanggal_transaksi'] = $data['tanggal_order'];
    $jasa['id_konsumen'] = $data['id_konsumen'];
    $jasa['gudang'] = $data['id_gudang'];
    $jasa['potongan'] = $data['potongan_jasa'];
    $jasa['petugas1'] = $data['petugas1'];
    $jasa['petugas2'] = $data['petugas2'];
    $jasa['petugas3'] = $data['petugas3'];
    $jasa['pengembang'] = $data['pengembang'];
    $jasa['leader'] = $data['leader'];
    $jasa['manager'] = $data['manager'];
    $jasa['kasir'] = cekmyid_karyawan();

    $q1 = DB::table('tb_order_jasa')->insert($jasa);
    
    $total_jasa_transaksi = 0;
    
    if ($q1) {
      $ex_jasa = explode(",",$data['data_barang']);
      $ex_biaya = explode(",",$data['data_biaya']);
      $ex_sub_biaya = explode(",",$data['data_subtotal']);
      $ex_jumlah = explode(",",$data['data_jumlah']);

      for ($i=0; $i < count($ex_jasa); $i++) {
        if ($ex_jasa[$i] != null && $ex_jasa[$i] != "undefined" && $ex_jasa[$i] != "") {
          $detailjasa['id_jasa'] = $ex_jasa[$i];
          $detailjasa['jumlah'] = $ex_jumlah[$i];
          $detailjasa['biaya'] = $ex_biaya[$i];
          $detailjasa['sub_biaya'] = $ex_sub_biaya[$i];
          $detailjasa['no_kwitansi'] = $jasa['no_kwitansi'];
          $total_jasa_transaksi += $ex_sub_biaya[$i];
          $q2 = DB::table('tb_detail_order_jasa')->insert($detailjasa);
        }
      }
      echo $jasa['no_kwitansi'];
        
        $total_jasa_transaksi -= $data['potongan_jasa'];
        $querycek = DB::table('tb_grafik')->where('months',date('F Y'))->get();
        if (count($querycek) > 0) {
          DB::table('tb_grafik')->where('months',date('F Y'))->increment('sums',$total_jasa_transaksi);
        }else{
          $y['months'] = date('F Y');
          $y['sums'] = $data['total_bayar'];
          DB::table('tb_grafik')->insert($y);
        }
      
    }

  }


  public function cetaknotajasa($id){
    $data['nota'] = $id;
    $data['transfer'] = DB::table('tb_order_jasa as a')
                          ->join('tb_konsumen as c','c.id','=','a.id_konsumen')
                          ->select("*")
                          ->where("a.no_kwitansi","=",$id)->get();

    $data['barang'] = DB::table('tb_detail_order_jasa as a')
                      ->join('tb_jasa as b','b.kode','=','a.id_jasa')
                      ->select("a.*","b.nama_jasa")
                      ->where("a.no_kwitansi",$id)
                      ->get();

    $data['dt'] = count($data['barang']);
    $page = ceil($data['dt']/10);

    $data['alamat_gudang'] = DB::table('tb_order_jasa as a')
                            ->join('tb_gudang as c','c.id','=','a.gudang')
                            ->join('districts as d','c.kecamatan','=','d.id')
                            ->where("a.no_kwitansi","=",$id)->select("c.*","d.*")->get();

    $barang = array();
    $i = 0;
    $a = 0;
    $x = 0;
    foreach ($data['barang'] as $value) {
      $barang[$i][$a]['nama_barang'] = $value->nama_jasa;
      $barang[$i][$a]['proses'] = $value->jumlah;
      $barang[$i][$a]['harga_jual'] = $value->biaya;
      $barang[$i][$a]['sub_total'] = $value->sub_biaya;
      $a++;
      $page = $x + 1;
      if ($page % 10 == 0) {
        $i++;
        $a=0;
      }
      $x++;
    }

    $data['detail'] = $barang;
    return view('CetakNotaJasa',$data);
  }

  public function datapenjualanjasa(){
    $data['data'] = array();
    if ((Auth::user()->gudang == "1" || Auth::user()->gudang =="2") && Auth::user()->level != "5") {
      $data['gudang'] = $this->model->getGudang();
    }else{
      $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
    }
    $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status","=","aktif")->get();
    $data['sales'] = DB::table('tb_karyawan as a')->select("*")->get();
    $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
    $data['user'] = DB::table('users as a')->select("*")->get();
    if (Auth::user()->level == "5") {
      $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik","=",Auth::user()->nik)->get();
      $kons = DB::table('tb_konsumen as a')->select("*")->where("a.pengembang",$p[0]->id)->get();
    }else if((Auth::user()->level == "3" && (Auth::user()->gudang == "1" || Auth::user()->gudang == "2")) || Auth::user()->level == "1" || Auth::user()->level == "4"){
      $kons = DB::table('tb_konsumen as a')->select("*")->get();
    }else{
      $kons = DB::table('tb_konsumen as a')->select("*")->where("a.kategori",Auth::user()->gudang)->get();
    }
    $text_gudang = DB::table('tb_gudang as a')->select("a.*")->get();
    $text_kategori = DB::table('tb_kategori as a')->select("a.*")->get();
    $text_harga = DB::table('tb_harga as a')->select("a.*")->get();
    $text_status_order = DB::table('tb_status_order as a')->select("a.*")->get();

    $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
    $data['barang'] = array();
    foreach ($text_barang as $value) {
      $data['barang'][$value->id]['no_sku'] =$value->no_sku;
      $data['barang'][$value->id]['nama_barang'] =$value->nama_barang;
    }

    $data['karyawan'] = array();
    $data['admin'] = array();
    $data['konsumen'] = array();

    foreach ($data['sales'] as $value) {
      $data['karyawan'][$value->id]['nama'] =$value->nama;
      $data['karyawan'][$value->id]['alamat'] =$value->alamat;
    }
    foreach ($data['user'] as $value) {
      $data['admin'][$value->id] =$value->name;
    }
    foreach ($kons as $value) {
      $data['konsumen'][$value->id]['id_konsumen'] =$value->id;
      $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] =$value->alamat;
    }
    foreach ($text_gudang as $value) {
      $data['text_gudang'][$value->id] =$value->nama_gudang;
    }
    foreach ($text_harga as $value) {
      $data['text_harga'][$value->id_barang]['harga'] =$value->harga;
      $data['text_harga'][$value->id_barang]['harga_hpp'] =$value->harga_hpp;
      $data['text_harga'][$value->id_barang]['harga_hp'] =$value->harga_hp;
    }
    foreach ($text_status_order as $value) {
      $data['text_status_order'][$value->id] =$value->nama_status;
    }
    $data['nama_download'] = "Data Order Penjualan";

    $bulan = array("Januari","Febuari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['bulan'] = array();
    for ($i=5; $i<date('m'); $i++) {
      $data['bulan'][$i] = $bulan[$i];
    }
    $data['tab'] = date('m');

    return view('DataJasa',$data);
  }

  public function getHumans(){
    $data = DB::table('tb_karyawan as a')->select("*")->get();
    echo json_encode($data);
  }

  public function datapenjualanjasas(Request $post){
    $d = $post->except('_token');
    if($d['from'] != null && $d['to'] != null){ $from=$d['from']; $to=$d['to']; $data['from'] = $d['from']; $data['to'] = $d['to']; }
    if($d['id_gudang'] != null){ $u['gudang']=$d['id_gudang']; $data['id_gudang'] = $d['id_gudang']; }
    if($d['id_konsumen'] != null){ $u['id_konsumen']=$d['id_konsumen']; $data['id_konsumen'] = $d['id_konsumen']; $data['name_konsumen'] = $d['name_konsumen']; }
    if($d['id'] != null){ $x['petugas1'] = $d['id']; $y['petugas2'] = $d['id']; $z['petugas3'] = $d['id']; $data['id'] = $d['id']; }

    if (isset($from) && isset($x)) {
      $data['data'] = DB::table('tb_order_jasa as a')
                          ->join('tb_detail_order_jasa as b','a.no_kwitansi','=','b.no_kwitansi')
                          ->select("*")

                          ->where($x)
                          ->whereBetween('tanggal_transaksi',[$from,$to])
                          ->where($u)

                          ->orWhere($y)
                          ->whereBetween('tanggal_transaksi',[$from,$to])
                          ->where($u)

                          ->orWhere($z)
                          ->whereBetween('tanggal_transaksi',[$from,$to])
                          ->where($u)

                          ->get();
    }else if(isset($from)){
      $data['data'] = DB::table('tb_order_jasa as a')
                          ->join('tb_detail_order_jasa as b','a.no_kwitansi','=','b.no_kwitansi')
                          ->select("*")

                          ->whereBetween('tanggal_transaksi',[$from,$to])
                          ->where($u)

                          ->get();
    }else if(isset($x)){
      $data['data'] = DB::table('tb_order_jasa as a')
                          ->join('tb_detail_order_jasa as b','a.no_kwitansi','=','b.no_kwitansi')
                          ->select("*")

                          ->where($x)
                          ->where($u)

                          ->orWhere($y)
                          ->where($u)

                          ->orWhere($z)
                          ->where($u)

                          ->get();
    }else{
      $data['data'] = DB::table('tb_order_jasa as a')
                          ->join('tb_detail_order_jasa as b','a.no_kwitansi','=','b.no_kwitansi')
                          ->select("*")

                          ->where($u)

                          ->get();
    }

    $data['data_kwitansi'] = array();
    foreach ($data['data'] as $key => $value) {
      if (isset($data['data_kwitansi'][$value->no_kwitansi])) {
        $data['data_kwitansi'][$value->no_kwitansi] += $value->jumlah;
      }else{
        $data['data_kwitansi'][$value->no_kwitansi] = $value->jumlah;
      }
    }

    if ((Auth::user()->gudang == "1" || Auth::user()->gudang =="2") && Auth::user()->level != "5") {
      $data['gudang'] = $this->model->getGudang();
    }else{
      $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
    }

    $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status","=","aktif")->get();
    $data['sales'] = DB::table('tb_karyawan as a')->select("*")->get();
    $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
    $data['user'] = DB::table('users as a')->select("*")->get();
    if (Auth::user()->level == "5") {
      $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik","=",Auth::user()->nik)->get();
      $kons = DB::table('tb_konsumen as a')->select("*")->where("a.pengembang",$p[0]->id)->get();
    }else if((Auth::user()->level == "3" && (Auth::user()->gudang == "1" || Auth::user()->gudang == "2")) || Auth::user()->level == "1" || Auth::user()->level == "4"){
      $kons = DB::table('tb_konsumen as a')->select("*")->get();
    }else{
      $kons = DB::table('tb_konsumen as a')->select("*")->where("a.kategori",Auth::user()->gudang)->get();
    }

    $text_gudang = DB::table('tb_gudang as a')->select("a.*")->get();
    $text_kategori = DB::table('tb_kategori as a')->select("a.*")->get();
    $text_harga = DB::table('tb_harga as a')->select("a.*")->get();
    $text_status_order = DB::table('tb_status_order as a')->select("a.*")->get();

    $text_barang = DB::table('tb_jasa as a')->select("a.*")->get();
    $data['barang'] = array();
    foreach ($text_barang as $value) {
      $data['barang'][$value->kode]['kode'] =$value->kode;
      $data['barang'][$value->kode]['nama_jasa'] =$value->nama_jasa;
    }

    $data['karyawan'] = array();
    $data['admin'] = array();
    $data['konsumen'] = array();

    foreach ($data['sales'] as $value) {
      $data['karyawan'][$value->id]['nama'] =$value->nama;
      $data['karyawan'][$value->id]['alamat'] =$value->alamat;
    }
    foreach ($data['user'] as $value) {
      $data['admin'][$value->id] =$value->name;
    }
    foreach ($kons as $value) {
      $data['konsumen'][$value->id]['id_konsumen'] =$value->id;
      $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] =$value->alamat;
    }
    foreach ($text_gudang as $value) {
      $data['text_gudang'][$value->id] =$value->nama_gudang;
    }
    foreach ($text_harga as $value) {
      $data['text_harga'][$value->id_barang]['harga'] =$value->harga;
      $data['text_harga'][$value->id_barang]['harga_hpp'] =$value->harga_hpp;
      $data['text_harga'][$value->id_barang]['harga_hp'] =$value->harga_hp;
    }


    return view('DataJasa',$data);

  }

  public function detailJasaKonsumen($id){
    $data = DB::table('tb_order_jasa as a')
            ->join('tb_detail_order_jasa as b','b.no_kwitansi','=','a.no_kwitansi')
            ->join('tb_jasa as c','c.kode','=','b.id_jasa')
            ->select("*")
            ->where("a.no_kwitansi","=",$id)
            ->get();
    echo json_encode($data);
  }


  public function daftarpenjualanjasa(){
    if(role()){
      $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status","=","aktif")->get();
      if(Auth::user()->level == "5"){
        $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik","=",Auth::user()->nik)->get();
        $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();

        $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                            ->select("a.*")
                            ->where("a.pengembang","=",$p[0]->id)
                            ->whereNull("a.payment")
                            ->orderBy("a.tanggal_transaksi","ASC")->get();

      }else if (Auth::user()->gudang == "1" ) {
        $data['gudang'] = $this->model->getGudang();

        $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                            ->select("a.*")
                              ->whereNull("a.payment")
                            ->orderBy("a.tanggal_transaksi","ASC")->get();

      }else{
        $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();

        $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                            ->select("a.*")
                            ->where("a.gudang","=",Auth::user()->gudang)
                            ->whereNull("a.payment")
                            ->orderBy("a.tanggal_transaksi","ASC")->get();
      }
      $data['nama_download'] = "Daftar Barang Terkirim";

      $user = DB::table('users as a')->get();
      foreach ($user as $key => $value) {
        $data['user'][$value->id] = $value->name;
      }

      $karyawan = DB::table('tb_karyawan as a')->get();
      foreach ($karyawan as $key => $value) {
        $data['karyawan'][$value->id]['nama'] = $value->nama;
        $data['karyawan'][$value->id]['alamat'] = $value->alamat;
      }

      $konsumen = DB::table('tb_konsumen as a')->get();
      foreach ($konsumen as $key => $value) {
        $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] = $value->alamat;
      }
    
      $data['pembayaran'] = array();
      $pembayaran = DB::table('tb_pembayaran as a')->where("status_pembayaran","Lunas")->get();
      foreach ($pembayaran as $key => $value) {
        $data['pembayaran'][$value->no_kwitansi] = $value->status_pembayaran;
      }

      return view('DaftarPenjualanJasa',$data);
    }else{
      return view ('Denied');
    }
  }
  public function daftarpenjualanjasas(Request $post){
    if(role()){
      $d=$post->except('_token');
      $Date = date('Y-m-d');
      if($d['from'] != null && $d['to'] != null){ $from = $d['from']; $to = $d['to']; $data['from'] = $d['from']; $data['to'] = $d['to'];}
      if($d['id_gudang'] != null){ $u['gudang'] = $d['id_gudang']; $a['gudang'] = $d['id_gudang']; $data['id_gudang'] = $d['id_gudang'];}
      if($d['tempo'] != null){ $tmp = ' - '.$d['tempo'].' days';  $tempo = date('Y-m-d', strtotime($Date. $tmp)); $data['tempo'] = $d['tempo']; }
      if($d['petugas'] != null && $d['id'] != null){
        $u[$d['petugas']] = $d['id'];

        /*$b['petugas1']=$d['id'];
        $c['petugas2']=$d['id'];
        $e['petugas3']=$d['id'];*/
        $data['petugas'] = $d['petugas'];
        $data['id'] = $d['id'];
      }
      if(Auth::user()->level == "5"){
        $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik","=",Auth::user()->nik)->get();
        $u['a.pengembang'] = $p[0]->id;
      }

      if (Auth::user()->level == "1" || Auth::user()->level =="2") {
        $data['gudang'] = $this->model->getGudang();
      }else{
        $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
      }
      $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status","=","aktif")->get();

      $x = DB::table('tb_karyawan as a')->select("*")->get();
      $y = DB::table('users as a')->select("*")->get();

      if (isset($from) && isset($u) && isset($tempo)) {

        $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                            ->select("a.*")

                            ->where($b)
                            ->where($a)
                            ->whereBetween('a.tanggal_transaksi',[$from,$to])
                            ->whereDate('a.tanggal_transaksi','<',$tempo)
                            ->whereNull("a.payment")

                            ->orWhere($c)
                            ->where($a)
                            ->whereBetween('a.tanggal_transaksi',[$from,$to])
                            ->whereDate('a.tanggal_transaksi','<',$tempo)
                            ->whereNull("a.payment")

                            ->orWhere($e)
                            ->where($a)
                            ->whereBetween('a.tanggal_transaksi',[$from,$to])
                            ->whereDate('a.tanggal_transaksi','<',$tempo)
                            ->whereNull("a.payment")

                            ->orderBy("a.tanggal_transaksi","ASC")->get();

      }else if (isset($from) && isset($u)){
        if (isset($b) && isset($c) && isset($e)) {
          $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                              ->select("a.*")

                              ->where($b)
                              ->where($a)
                              ->whereBetween('a.tanggal_transaksi',[$from,$to])
                              ->whereNull("a.payment")

                              ->orWhere($c)
                              ->where($a)
                              ->whereBetween('a.tanggal_transaksi',[$from,$to])
                              ->whereNull("a.payment")

                              ->orWhere($e)
                              ->where($a)
                              ->whereBetween('a.tanggal_transaksi',[$from,$to])
                              ->whereNull("a.payment")

                              ->orderBy("a.tanggal_transaksi","ASC")->get();
        }else{
          $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                              ->select("a.*")

                              ->where($a)
                              ->where($u)
                              ->whereBetween('a.tanggal_transaksi',[$from,$to])
                              ->whereNull("a.payment")

                              ->orderBy("a.tanggal_transaksi","ASC")->get();
        }

      }else if (isset($from) && isset($tempo)){

        $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                            ->select("a.*")

                            ->whereBetween('a.tanggal_transaksi',[$from,$to])
                            ->whereDate('a.tanggal_transaksi','<',$tempo)
                            ->whereNull("a.payment")

                            ->orderBy("a.tanggal_transaksi","ASC")->get();

      }else if (isset($u) && isset($tempo)){

        $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                            ->select("a.*")

                            ->where($u)
                            ->whereDate('a.tanggal_transaksi','<=',$tempo)
                            ->whereNull("a.payment")

                            ->orderBy("a.tanggal_transaksi","ASC")->get();
      }else if (isset($from)) {

        $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                            ->select("a.*")

                            ->whereBetween('a.tanggal_transaksi',[$from,$to])
                            ->whereNull("a.payment")

                            ->orderBy("a.tanggal_transaksi","ASC")->get();
      }else if (isset($u)) {

      $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                          ->select("a.*")

                          ->where($a)
                          ->where($u)
                          ->whereNull("a.payment")

                          ->orderBy("a.tanggal_transaksi","ASC")->get();

      }else if (isset($tempo)) {

        $data['penjualanjasa'] = DB::table('tb_order_jasa as a')
                            ->select("a.*")

                            ->whereDate('a.tanggal_transaksi','<',$tempo)
                            ->whereNull("a.payment")

                            ->orderBy("a.tanggal_transaksi","ASC")->get();

      }
      $data['nama_download'] = "Daftar Barang Terkirim";

      foreach ($y as $value) {
        $data['admin'][$value->id] = $value->name;
      }
      
      $data['pembayaran'] = array();
      $pembayaran = DB::table('tb_pembayaran as a')->where("status_pembayaran","Lunas")->get();
      foreach ($pembayaran as $key => $value) {
        $data['pembayaran'][$value->no_kwitansi] = $value->status_pembayaran;
      }

      $karyawan = DB::table('tb_karyawan as a')->get();
      foreach ($karyawan as $key => $value) {
        $data['karyawan'][$value->id]['nama'] = $value->nama;
        $data['karyawan'][$value->id]['alamat'] = $value->alamat;
      }

      $user = DB::table('users as a')->get();
      foreach ($user as $key => $value) {
        $data['user'][$value->id] = $value->name;
      }

      $konsumen = DB::table('tb_konsumen as a')->get();
      foreach ($konsumen as $key => $value) {
        $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] = $value->alamat;
      }
      //dd($data);
      return view('DaftarPenjualanJasa',$data);
    }else{
      return view ('Denied');
    }
  }

  public function prosespembayaranjasa(){
    if(role()){
      if (Auth::user()->level == "1") {
        $data['transferjasa'] = DB::table('tb_order_jasa as a')
                            ->select("*")
                            ->whereNull("a.payment")
                            ->get();
      }else{
        $data['transferjasa'] = DB::table('tb_order_jasa as a')
                            ->select("*")
                            ->whereNull("a.payment")
                            ->get();
      }
      $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();
      $data['leader'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();

      $user = DB::table('users as a')->select("*")->get();
      $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
      $gudang = DB::table('tb_gudang as a')->select("a.*")->get();
      $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
      $kategori = DB::table('tb_kategori as a')->select("*")->get();

      $pembayaran = DB::table('tb_pembayaran as a')->select("*")->where("a.status_pembayaran","=","Lunas")->get();
      $data['pembayaran'] = array();
      foreach ($pembayaran as $key => $value) {
        $data['pembayaran'][$value->no_kwitansi] = "Lunas";
      }

      foreach ($user as $key => $value) {
        $data['user'][$value->id] = $value->name;
      }
      foreach ($konsumen as $key => $value) {
        $data['konsumen'][$value->id]['id'] = $value->id_konsumen;
        $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] = $value->alamat;
        $data['konsumen'][$value->id]['no_hp'] = $value->no_hp;
      }
      foreach ($gudang as $key => $value) {
        $data['gudang'][$value->id] = $value->nama_gudang;
      }
      foreach ($karyawan as $key => $value) {
        $data['karyawan'][$value->id]= $value->nama;
      }
      foreach ($kategori as $key => $value) {
        $data['kategori'][$value->id] = $value->nama_kategori;
      }
            $data['rekening'] = DB::table('tb_rekening as a')
                            ->select("*")
                            ->where("a.status","aktif")
                            ->get();
      return view('ProsesPembayaranJasa',$data);
    }else{
      return view ('Denied');
    }
  }


  public function datapembayaranjasa(){
    if(role()){
      $d = DB::table('tb_karyawan as a')->select("*")->get();
      $da = DB::table('users as a')->select("*")->get();
      if (Auth::user()->level == "5") {
        $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik","=",Auth::user()->nik)->get();
        $data['pembayaran'] = array();
        /*$data['pembayaran'] = DB::table('tb_barang_keluar as a')
                            ->select("*")
                            ->where("a.status_barang","terkirim")
                            ->where("a.pengembang",$p[0]->id)
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->groupBy('a.no_kwitansi')
                            ->get();*/
      }else if(Auth::user()->gudang == "1"){
        $data['pembayaran'] = array();
        /*$data['pembayaran'] = DB::table('tb_barang_keluar as a')
                    ->select("*")
                    ->where("a.status_barang","terkirim")
                    ->whereMonth("a.tanggal_terkirim",Date('m'))
                    ->groupBy('a.no_kwitansi')
                    ->get();*/
      }else{
        $data['pembayaran'] = array();
        /*$data['pembayaran'] = DB::table('tb_barang_keluar as a')
                            ->select("*")
                            ->where("a.status_barang","terkirim")
                            ->where("a.id_gudang",Auth::user()->gudang)
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->groupBy('a.no_kwitansi')
                            ->get();*/
      }


      $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
      foreach ($konsumen as $value) {
        $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] =$value->alamat;
      }
      /*$detail = DB::table('tb_detail_pembayaran as a')
                          ->join('tb_pembayaran as o','o.no_kwitansi','=','a.no_kwitansi')
                          ->select("*",DB::raw('SUM(a.pembayaran) as pembayaran'))
                          ->groupBy('a.no_kwitansi')
                          ->get();
      $data['bayar'] = array();
      foreach ($detail as $value) {
        $data['bayar'][$value->no_kwitansi]['bayar'] =$value->pembayaran;
        $data['bayar'][$value->no_kwitansi]['tanggal_bayar'] =$value->tgl_bayar;
        $data['bayar'][$value->no_kwitansi]['penyetor'] =$value->nama_penyetor;
        $data['bayar'][$value->no_kwitansi]['status_pembayaran'] =$value->status_pembayaran;
      }

      $harga = DB::table('tb_harga as a')->select("*")->get();
      foreach ($harga as $value) {
        $data['harga'][$value->id_barang]=$value->harga_hpp;
        $data['harga'][$value->id_barang]=$value->harga_hp;
      }
      //dd($data['harga']);
      $data['barang'] = array();
      $barang = DB::table('tb_detail_barang_keluar as a')
                ->select("*")
                ->get();
      foreach ($barang as $val) {
        if ($val->terkirim < 1){
            $terkirim = 1;
        }else{
            $terkirim = $val->terkirim;
        }
        if ($val->harga_net > ($val->harga_jual - $val->potongan - ($val->sub_potongan / $terkirim))) {
          if (array_key_exists($val->no_kwitansi, $data['barang'])){
            $data['barang'][$val->no_kwitansi]['selisih'] += 0;
            $data['barang'][$val->no_kwitansi]['omset'] += $val->terkirim * $val->harga_jual;
            $harga_hpp = $data['harga'][$val->id_barang];
            $data['barang'][$val->no_kwitansi]['hpp'] += $val->terkirim * ($val->harga_jual - $harga_hpp);
          }else{
            $data['barang'][$val->no_kwitansi]['selisih'] = 0;
            $data['barang'][$val->no_kwitansi]['omset'] = $val->terkirim * $val->harga_jual;
            $harga_hpp = $data['harga'][$val->id_barang];
            $data['barang'][$val->no_kwitansi]['hpp'] = $val->terkirim * ($val->harga_jual - $harga_hpp);
          }
        }else{
          if (array_key_exists($val->no_kwitansi, $data['barang'])){
            $data['barang'][$val->no_kwitansi]['selisih'] += ($val->terkirim * (($val->harga_jual - $val->potongan)- $val->harga_net )) - $val->sub_potongan;
            $data['barang'][$val->no_kwitansi]['omset'] += $val->terkirim * $val->harga_net;
            $harga_hpp = $data['harga'][$val->id_barang];
            $data['barang'][$val->no_kwitansi]['hpp'] += $val->terkirim * ($val->harga_net - $harga_hpp);
          }else{
            $data['barang'][$val->no_kwitansi]['selisih'] = ($val->terkirim * (($val->harga_jual- $val->potongan) - $val->harga_net )) - $val->sub_potongan;
            $data['barang'][$val->no_kwitansi]['omset'] = $val->terkirim * $val->harga_net;
            $harga_hpp = $data['harga'][$val->id_barang];
            $data['barang'][$val->no_kwitansi]['hpp'] = $val->terkirim * ($val->harga_net - $harga_hpp);
          }
        }
      }*/
      $text_gudang = DB::table('tb_gudang as a')
                          ->select("*")
                          ->get();
      foreach ($text_gudang as $value) {
        $data['text_gudang'][$value->id] =$value->nama_gudang;
      }
      $text_gudang = DB::table('tb_gudang as a')
                          ->select("*")
                          ->get();
      foreach ($text_gudang as $value) {
        $data['text_gudang'][$value->id] =$value->nama_gudang;
      }

      $data['karyawan'] = array();
      $data['admin'] = array();
      foreach ($d as $value) {
        $data['karyawan'][$value->id] =$value->nama;
      }
      foreach ($d as $value) {
        $data['karyawan2'][$value->id]['nama'] =$value->nama;
        $data['karyawan2'][$value->id]['alamat'] =$value->alamat;
      }
      foreach ($da as $value) {
        $data['admin'][$value->id] =$value->name;
      }
      $data['nama_download'] = "Data Pembayaran";
      if(Auth::user()->level == "5"){
        $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
      }else if(Auth::user()->gudang == "1"){
        $data['gudang'] = $this->model->getGudang();
      }else{
        $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
      }

      $bulan = array("Januari","Febuari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
      $data['bulan'] = array();
      for ($i=5; $i<date('m'); $i++) {
        $data['bulan'][$i] = $bulan[$i];
      }
      $data['tab'] = date('m');

      $data['status_order'] = DB::table('tb_status_order as a')->select("*")->where("a.status","aktif")->get();
      $data['nama_download'] = "Data Pembayaran";
      return view('DataPembayaranJasa',$data);
    }else{
      return view ('Denied');
    }
  }

  public function datapembayaranjasas(Request $post){
    if(role()){
      $k = $post->except('_token');

      if($k['from'] != null && $k['to'] != null){ $from = $k['from']; $to = $k['to']; $data['from'] = $k['from']; $data['to'] = $k['to']; }
      if($k['id_gudang'] != null){ $u['a.gudang'] = $k['id_gudang']; $data['id_gudang'] = $k['id_gudang'];}
      if($k['status_pembayaran'] != null){
        //$u['o.status_pembayaran'] = $k['status_pembayaran'];
        $data['status_pembayaran'] = $k['status_pembayaran'];
        //if ($u['o.status_pembayaran'] == "Tempo") {
        //  $u['o.status_pembayaran'] = null;
        //}
      }
      if($k['petugas'] != null && $k['id'] != null){ $u['a.'.$k['petugas']] = $k['id']; $data['petugas'] = $k['petugas']; $data['id'] = $k['id']; }

      $d = DB::table('tb_karyawan as a')->select("*")->get();
      $da = DB::table('users as a')->select("*")->get();

      if (Auth::user()->level == "5") {
        $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik","=",Auth::user()->nik)->get();
        $u['a.pengembang'] = $p[0]->id;
      }

      if (isset($from)) {
        $data['pembayaran'] = DB::table('tb_order_jasa as a')
                            ->leftJoin('tb_detail_order_jasa as c','c.no_kwitansi','=','a.no_kwitansi')
                            ->leftJoin('tb_detail_pembayaran as o','o.no_kwitansi','=','a.no_kwitansi')
                            ->select("a.*")
                            ->where($u)
                            ->whereBetween('o.tgl_bayar',[$from,$to])
                            ->groupBy('a.no_kwitansi')
                            ->get();
      }else{
        $data['pembayaran'] = DB::table('tb_order_jasa as a')
                            ->leftJoin('tb_detail_order_jasa as c','c.no_kwitansi','=','a.no_kwitansi')
                            //->leftJoin('tb_pembayaran as o','o.no_kwitansi','=','a.no_kwitansi')
                            ->select("a.*")
                            ->where($u)
                            ->groupBy('a.no_kwitansi')
                            ->get();
      }

      /*$pembayaran =  DB::table('tb_pembayaran as a')->select("*")->get();
      $data['cek_bayar'] = array();
      foreach ($detail as $value) {
        $data['bayar'][$value->no_kwitansi]['bayar'] =$value->pembayaran;
        $data['bayar'][$value->no_kwitansi]['tanggal_bayar'] =$value->tgl_bayar;
        $data['bayar'][$value->no_kwitansi]['penyetor'] =$value->nama_penyetor;
        $data['bayar'][$value->no_kwitansi]['status_pembayaran'] =$value->status_pembayaran;
      }*/


      $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
      foreach ($konsumen as $value) {
        $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
        $data['konsumen'][$value->id]['alamat'] =$value->alamat;
      }
      $detail = DB::table('tb_detail_pembayaran as a')
                          ->join('tb_pembayaran as o','o.no_kwitansi','=','a.no_kwitansi')
                          ->select("*",DB::raw('SUM(a.pembayaran) as pembayaran'))
                          ->groupBy('a.no_kwitansi')
                          ->get();

      $data['bayar'] = array();
      foreach ($detail as $value) {
        $data['bayar'][$value->no_kwitansi]['bayar'] =$value->pembayaran;
        $data['bayar'][$value->no_kwitansi]['tanggal_bayar'] =$value->tgl_bayar;
        $data['bayar'][$value->no_kwitansi]['penyetor'] =$value->nama_penyetor;
        $data['bayar'][$value->no_kwitansi]['status_pembayaran'] =$value->status_pembayaran;
      }

      $harga = DB::table('tb_harga as a')->select("*")->get();
      foreach ($harga as $value) {
        $data['harga'][$value->id_barang]=$value->harga_hpp;
      }

      $data['barang'] = array();
      $barang = DB::table('tb_detail_order_jasa as a')
                ->select("*")
                ->get();
      foreach ($barang as $val) {
        if ($val->jumlah < 1){
            $terkirim = 1;
        }else{
            $terkirim = $val->jumlah;
        }
          if (array_key_exists($val->no_kwitansi, $data['barang'])){
            $data['barang'][$val->no_kwitansi]['selisih'] += 0;
            $data['barang'][$val->no_kwitansi]['omset'] += $val->jumlah * $val->biaya;
            //$harga_hpp = $data['harga'][$val->id_barang];
            $data['barang'][$val->no_kwitansi]['hpp'] += $val->jumlah * ($val->biaya);
          }else{
            $data['barang'][$val->no_kwitansi]['selisih'] = 0;
            $data['barang'][$val->no_kwitansi]['omset'] = $val->jumlah * $val->biaya;
            //$harga_hpp = $data['harga'][$val->id_barang];
            $data['barang'][$val->no_kwitansi]['hpp'] = $val->jumlah * ($val->biaya);
          }
      }

      $text_gudang = DB::table('tb_gudang as a')
                          ->select("*")
                          ->get();
      foreach ($text_gudang as $value) {
        $data['text_gudang'][$value->id] =$value->nama_gudang;
      }

      $bulan = array("Januari","Febuari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
      $data['bulan'] = array();
      for ($i=5; $i<date('m'); $i++) {
        $data['bulan'][$i] = $bulan[$i];
      }
      $data['tab'] = date('m');

      $data['karyawan'] = array();
      $data['admin'] = array();
      foreach ($d as $value) {
        $data['karyawan'][$value->id] =$value->nama;
      }
      foreach ($d as $value) {
        $data['karyawan2'][$value->id]['nama'] =$value->nama;
        $data['karyawan2'][$value->id]['alamat'] =$value->alamat;
      }
      foreach ($da as $value) {
        $data['admin'][$value->id] =$value->name;
      }
      $data['nama_download'] = "Data Pembayaran";
      if(Auth::user()->level == "5"){
        $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
      }else if(Auth::user()->gudang == "1" ){
        $data['gudang'] = $this->model->getGudang();
      }else{
        $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
      }
      $data['status_order'] = DB::table('tb_status_order as a')->select("*")->where("a.status","aktif")->get();
      $data['nama_download'] = "Data Pembayaran";
      //dd($data);
      return view('DataPembayaranJasa',$data);
    }else{
      return view ('Denied');
    }
  }


  public function caridatapembayaranjasa(Request $post){
    $k = $post->except('_token');
    $d = DB::table('tb_karyawan as a')->select("*")->get();
    $da = DB::table('users as a')->select("*")->get();

    $data['pembayaran'] = DB::table('tb_order_jasa as a')
                        ->leftJoin('tb_detail_order_jasa as c','c.no_kwitansi','=','a.no_kwitansi')
                        ->select("a.*")
                        ->where("a.no_kwitansi",$k['no_kwitansi'])
                        ->groupBy('a.no_kwitansi')
                        ->get();
    $data['nama_download'] = "Data Pembayaran";
    if(Auth::user()->level == "5"){
      $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
    }else if(Auth::user()->gudang == "1"){
      $data['gudang'] = $this->model->getGudang();
    }else{
      $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
    }
    $data['status_order'] = DB::table('tb_status_order as a')->select("*")->where("a.status","aktif")->get();
    $bulan = array("Januari","Febuari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['bulan'] = array();
    for ($i=5; $i<date('m'); $i++) {
      $data['bulan'][$i] = $bulan[$i];
    }
    $data['tab'] = date('m');


    $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
    foreach ($konsumen as $value) {
      $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] =$value->alamat;
    }
    $detail = DB::table('tb_detail_pembayaran as a')
                        ->join('tb_pembayaran as o','o.no_kwitansi','=','a.no_kwitansi')
                        ->select("*",DB::raw('SUM(a.pembayaran) as pembayaran'))
                        ->where("a.no_kwitansi",$k['no_kwitansi'])
                        ->groupBy('a.no_kwitansi')
                        ->get();
    $data['bayar'] = array();
    foreach ($detail as $value) {
      $data['bayar'][$value->no_kwitansi]['bayar'] =$value->pembayaran;
      $data['bayar'][$value->no_kwitansi]['tanggal_bayar'] =$value->tgl_bayar;
      $data['bayar'][$value->no_kwitansi]['penyetor'] =$value->nama_penyetor;
      $data['bayar'][$value->no_kwitansi]['status_pembayaran'] =$value->status_pembayaran;
      $data['status_pembayaran'] = $value->status_pembayaran;
    }

    $data['barang'] = array();
    $barang = DB::table('tb_detail_order_jasa as a')
              ->select("*")
              ->get();

    $harga = DB::table('tb_harga as a')->select("*")->get();
    foreach ($harga as $value) {
      $data['harga'][$value->id_barang]=$value->harga_hpp;
    }

    foreach ($barang as $val) {
      if ($val->jumlah < 1){
          $terkirim = 1;
      }else{
          $terkirim = $val->jumlah;
      }

      if (array_key_exists($val->no_kwitansi, $data['barang'])){
        $data['barang'][$val->no_kwitansi]['selisih'] += 0;
        $data['barang'][$val->no_kwitansi]['omset'] += $val->jumlah * $val->biaya;
        //$harga_hpp = $data['harga'][$val->id_barang];
        $data['barang'][$val->no_kwitansi]['hpp'] += $val->jumlah * ($val->biaya);
      }else{
        $data['barang'][$val->no_kwitansi]['selisih'] = 0;
        $data['barang'][$val->no_kwitansi]['omset'] = $val->jumlah * $val->biaya;
        //$harga_hpp = $data['harga'][$val->id_barang];
        $data['barang'][$val->no_kwitansi]['hpp'] = $val->jumlah * ($val->biaya);
      }

    }
    $d = DB::table('tb_karyawan as a')->select("*")->get();
    $da = DB::table('users as a')->select("*")->get();
    $data['karyawan'] = array();
    $data['admin'] = array();
    foreach ($d as $value) {
      $data['karyawan'][$value->id] =$value->nama;
    }
    foreach ($d as $value) {
      $data['karyawan2'][$value->id]['nama'] =$value->nama;
      $data['karyawan2'][$value->id]['alamat'] =$value->alamat;
    }
    foreach ($da as $value) {
      $data['admin'][$value->id] =$value->name;
    }
    $text_gudang = DB::table('tb_gudang as a')
                        ->select("*")
                        ->get();
    foreach ($text_gudang as $value) {
      $data['text_gudang'][$value->id] =$value->nama_gudang;
    }
    //dd($data);
    return view('DataPembayaranJasa',$data);
  }
}
