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

class PriceController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function index(){
    if (role()) {
      $data['price'] = $this->model->getPrice();
      $data['nama_download'] = "Price List ".date('d-m-Y');
      return view('PriceList',$data);
    }else{
      return view ('Denied');
    }
  }
  public function indexs(Request $post){
    if (role()) {
      $data = $post->except('_token');
      if ($data['tanggal_from'] != null) { $datefrom = $data['tanggal_from']; $dt['datefrom'] = $data['tanggal_from']; }
      if ($data['tanggal_to'] != null) { $dateto = $data['tanggal_to']; $dt['dateto'] = $data['tanggal_to']; }
      if ($data['harga_from'] != null) { $hargafrom = $data['harga_from']; $dt['harga_from'] = $data['harga_from']; }
      if ($data['harga_to'] != null) { $hargato = $data['harga_to']; $dt['harga_to'] = $data['harga_to']; }
      if (isset($data['branded'])) { $branded = $data['branded']; $dt['branded'] = $data['branded']; }

      $dt['nama_download'] = "Price List ".date('d-m-Y');

      if(isset($datefrom) && isset($hargafrom) && isset($branded)){
        $dt['price'] = DB::table('tb_harga as a')->join('tb_barang as b','b.id','=','a.id_barang')->select("a.*","b.no_sku","b.nama_barang","b.part_number")
        ->where("b.status","=","aktif")
        ->whereBetween('harga',[$hargafrom,$hargato])
        ->whereBetween('tanggal',[$datefrom,$dateto])
        ->where("b.branded","=",$branded)
        ->get();
      }else if(isset($datefrom) && isset($hargafrom)){
        $dt['price'] = DB::table('tb_harga as a')->join('tb_barang as b','b.id','=','a.id_barang')->select("a.*","b.no_sku","b.nama_barang","b.part_number")
        ->where("b.status","=","aktif")
        ->whereBetween('harga',[$hargafrom,$hargato])
        ->whereBetween('tanggal',[$datefrom,$dateto])
        ->get();
      }else if(isset($datefrom) && isset($branded)){
        $dt['price'] = DB::table('tb_harga as a')->join('tb_barang as b','b.id','=','a.id_barang')->select("a.*","b.no_sku","b.nama_barang","b.part_number")
        ->where("b.status","=","aktif")
        ->whereBetween('tanggal',[$datefrom,$dateto])
        ->where("b.branded","=",$branded)
        ->get();
      }else if(isset($hargafrom) && isset($branded)){
        $dt['price'] = DB::table('tb_harga as a')->join('tb_barang as b','b.id','=','a.id_barang')->select("a.*","b.no_sku","b.nama_barang","b.part_number")
        ->where("b.status","=","aktif")
        ->where("b.branded","=",$branded)
        ->whereBetween('harga',[$hargafrom,$hargato])
        ->get();
      }else if(isset($datefrom)){
        $dt['price'] = DB::table('tb_harga as a')->join('tb_barang as b','b.id','=','a.id_barang')->select("a.*","b.no_sku","b.nama_barang","b.part_number")
        ->where("b.status","=","aktif")
        ->whereBetween('tanggal',[$datefrom,$dateto])
        ->get();
      }else if(isset($hargafrom)){
        $dt['price'] = DB::table('tb_harga as a')->join('tb_barang as b','b.id','=','a.id_barang')->select("a.*","b.no_sku","b.nama_barang","b.part_number")
        ->where("b.status","=","aktif")
        ->whereBetween('harga',[$hargafrom,$hargato])
        ->get();
      }else if(isset($branded)){
        $dt['price'] = DB::table('tb_harga as a')->join('tb_barang as b','b.id','=','a.id_barang')->select("a.*","b.no_sku","b.nama_barang","b.part_number")
        ->where("b.status","=","aktif")
        ->where("b.branded","=",$branded)
        ->get();
      }
      //dd($dt);
      return view('PriceList',$dt);
    }else{
      return view ('Denied');
    }
  }
  public function updateprice(){
    if (role()) {
      $data['price'] = $this->model->getPrice();
      $data['label'] = DB::table('kt_label as a')
                            ->select("*")
                            ->where("a.status","=","aktif")
                            ->get();
      return view('PriceUpdate',$data);
    }else{
      return view ('Denied');
    }
  }
  public function updateprices(Request $post){
    if (role()) {
      $data = $post->except('_token','id_barang','label','old_harga_hp');
      $data['harga_coret'] = str_replace(".","",$data['harga_coret'] );
      $data['harga_retail'] = str_replace(".","",$data['harga_retail'] );
      $data['harga_reseller'] = str_replace(".","",$data['harga_reseller'] );
      $data['harga_agen'] = str_replace(".","",$data['harga_agen'] );
      $data['harga'] = str_replace(".","",$data['harga'] );
      $data['harga_hpp'] = str_replace(".","",$data['harga_hpp'] );
      $data['harga_hp'] = str_replace(".","",$data['harga_hp'] );
      $data['poin'] = str_replace(".","",$data['poin'] );
      $data['fee_item'] = str_replace(".","",$data['fee_item'] );
      $data['pot1'] = str_replace(".","",$data['pot1'] );
      $data['pot2'] = str_replace(".","",$data['pot2'] );
      $data['pot3'] = str_replace(".","",$data['pot3'] );

      if($post->label != "0"){
          $data['label'] = $post->label;
          $update['label'] = $data['label'];
      }else{
          $data['label'] = "";
          $update['label'] = "";
      }

      $q = DB::table('tb_harga')->where('id','=',$data['id'])->update($data);
      if ($q) {
        $cek = DB::table('kt_katalog as a')
                ->leftJoin('kt_multiple as b','b.id_katalog','=','a.id')
                ->where("a.barang",$post->id_barang)
                ->orWhere("b.barang",$post->id_barang)
                ->select("*")->get();
        if (count($cek) > 0) {
            if(isset($update)){
              DB::table('kt_katalog as a')
              ->leftJoin('kt_multiple as b','b.id_katalog','=','a.id')
              ->where("a.barang",$post->id_barang)
              ->orWhere("b.barang",$post->id_barang)
              ->update($update);
            }
        }

        $jumlah_stok = DB::table('tb_gudang_barang as a')->where("a.id_barang",$post->id_barang)->select(DB::raw('SUM(a.jumlah) as stok'))->get();
        $nama_barang = DB::table('tb_barang as a')->where("a.id",$post->id_barang)->select('*')->get();
        $old_lb = DB::table('tb_labarugi as a')->orderBy("a.id","DESC")->limit(1)->get();



        if (count($jumlah_stok) > 0) {
          $harga_hp_brg = str_replace(".","",$post->harga_hp);
          $harga_hp_brg_old = str_replace(".","",$post->old_harga_hp); 
          
          $labarugi['jumlah'] = $jumlah_stok[0]->stok * ($harga_hp_brg - $harga_hp_brg_old);
          if (count($old_lb) > 0) {
            $labarugi['saldo_temp'] = $old_lb[0]->saldo_temp + $labarugi['jumlah'];
          }else{
            $labarugi['saldo_temp'] = $labarugi['jumlah'];
          }
          if ($labarugi['jumlah'] > 0) {
              $labarugi['jenis'] = "in";
          }else{
              $labarugi['jenis'] = "out";
          }

          if ($labarugi['jumlah'] < 0) {
            $labarugi['jumlah'] = $labarugi['jumlah'] * -1;
          }

          $labarugi['nama_jenis'] = "Penyesuaian harga barang ".$nama_barang[0]->nama_barang;
          $labarugi['admin'] = Auth::user()->id;

          if ($labarugi['jumlah'] !== 0) {
            DB::table('tb_labarugi')->insert($labarugi);
          }
        }
        
        

      }
      return redirect()->back()->with('success','Berhasil');
    }else{
      return view ('Denied');
    }
  }

  public function historybarang(){
    if (role()) {
      $gudang = Auth::user()->gudang;
      $bm = DB::table('tb_barang_masuk as a')
                            ->select("*")
                            ->where("a.gudang","=",$gudang)
                            ->whereMonth("a.tgl_masuk",Date('m'))
                            ->get();
      $data['barangmasuk'] = array();
      foreach ($bm as $key => $value) {
        if (array_key_exists($value->barang,$data['barangmasuk'])) {
          $data['barangmasuk'][$value->barang] += $value->jumlah;
        }else{
          $data['barangmasuk'][$value->barang] = $value->jumlah;
        }
      }

      $bk = DB::table('tb_barang_keluar as a')->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->select("*")
                            ->where("a.status_barang","=","terkirim")
                            ->where("a.id_gudang","=",$gudang)
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->orWhere("a.status_barang","=","proses")
                            ->where("a.id_gudang","=",$gudang)
                            ->whereMonth("a.tanggal_proses",Date('m'))
                            ->get();
      $data['barangkeluar'] = array();
      foreach ($bk as $key => $value) {
        if ($value->status_barang == "terkirim") {
          if (array_key_exists($value->id_barang,$data['barangkeluar'])) {
            $data['barangkeluar'][$value->id_barang] += ($value->terkirim + $value->kembali);
            if (isset($data['barangretur'][$value->id_barang])) {
                $data['barangretur'][$value->id_barang] += $value->kembali;
            }else{
                $data['barangretur'][$value->id_barang] = $value->kembali;
            }
          }else{
            $data['barangkeluar'][$value->id_barang] = ($value->terkirim + $value->kembali);
            if (isset($data['barangretur'][$value->id_barang])) {
              $data['barangretur'][$value->id_barang] += $value->kembali;
            }else{
              $data['barangretur'][$value->id_barang] = $value->kembali;
            }
          }
        }else{
          if (array_key_exists($value->id_barang,$data['barangkeluar'])) {
            $data['barangkeluar'][$value->id_barang] += $value->proses;
          }else{
            $data['barangkeluar'][$value->id_barang] = $value->proses;
          }
        }
      }

      $rjk = DB::table('tb_reject as a')->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                            ->select("*")
                            ->where("a.id_gudang","=",$gudang)
                            ->whereMonth("a.tanggal_input",Date('m'))
                            ->get();
      $data['reject'] = array();
      foreach ($rjk as $key => $value) {
        if (array_key_exists($value->id_barang,$data['reject'])) {
          $data['reject'][$value->id_barang] += $value->jumlah;
        }else{
          $data['reject'][$value->id_barang] = $value->jumlah;
        }
      }

      $tfin = DB::table('tb_transfer_stok as a')->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
                            ->select("*")
                            ->where("a.dari","=",$gudang)
                            ->where("a.status_transfer","terkirim")
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->orWhere("a.status_transfer","proses")
                            ->where("a.kepada","=",$gudang)
                            ->whereMonth("a.tanggal_kirim",Date('m'))
                            ->get();
      $data['tfin'] = array();
      foreach ($tfin as $key => $value) {
        if (array_key_exists($value->id_barang,$data['tfin'])) {
          $data['tfin'][$value->id_barang] += $value->terkirim;
        }else{
          $data['tfin'][$value->id_barang] = $value->terkirim;
        }
      }

      $tfout = DB::table('tb_transfer_stok as a')->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
                            ->select("*")
                            ->where("a.status_transfer","proses")
                            ->where("a.kepada","=",$gudang)
                            ->whereMonth("a.tanggal_kirim",Date('m'))
                            ->orWhere("a.status_transfer","terkirim")
                            ->where("a.kepada","=",$gudang)
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->get();
      $data['tfout'] = array();
      foreach ($tfout as $key => $value) {
        if ($value->status_transfer == "terkirim") {
          if (array_key_exists($value->id_barang,$data['tfout'])) {
            $data['tfout'][$value->id_barang] += $value->terkirim;
          }else{
            $data['tfout'][$value->id_barang] = $value->terkirim;
          }
        }else{
          if (array_key_exists($value->id_barang,$data['tfout'])) {
            $data['tfout'][$value->id_barang] += $value->proses;
          }else{
            $data['tfout'][$value->id_barang] = $value->proses;
          }
        }
      }

      $data['stok'] = DB::table('tb_barang as a')
      ->join('tb_gudang_barang as b','b.id_barang','=','a.id')
      ->join('tb_harga as c','c.id_barang','=','a.id')
      ->select("a.*","c.harga",DB::raw('SUM(b.jumlah) as stok'))
      ->where("b.id_gudang",$gudang)
      ->groupBy("b.id_barang")
      ->get();

      $data['gudang'] = DB::table('tb_gudang as a')
      ->select("*")
      ->where("status","aktif")
      ->get();

      $data['nama_download'] = "History Barang ".date('d-m-Y');
      return view('HistoryBarang',$data);
    }else{
      return view ('Denied');
    }
  }

  public function historybarangs(Request $post){
    $g = $post->except('_token');
    if (role()) {
      $gudang = $g['gudang'];
      $data['gdg'] = $g['gudang'];
      $bm = DB::table('tb_barang_masuk as a')
                            ->select("*")
                            ->where("a.gudang","=",$gudang)
                            ->whereMonth("a.tgl_masuk",Date('m'))
                            ->get();
      $data['barangmasuk'] = array();
      foreach ($bm as $key => $value) {
        if (array_key_exists($value->barang,$data['barangmasuk'])) {
          $data['barangmasuk'][$value->barang] += $value->jumlah;
        }else{
          $data['barangmasuk'][$value->barang] = $value->jumlah;
        }
      }

      $bk = DB::table('tb_barang_keluar as a')->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->select("*")
                            ->where("a.status_barang","=","terkirim")
                            ->where("a.id_gudang","=",$gudang)
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->orWhere("a.status_barang","=","proses")
                            ->where("a.id_gudang","=",$gudang)
                            ->whereMonth("a.tanggal_proses",Date('m'))
                            ->get();
      $data['barangkeluar'] = array();
      foreach ($bk as $key => $value) {
        if ($value->status_barang == "terkirim") {
          if (array_key_exists($value->id_barang,$data['barangkeluar'])) {
            $data['barangkeluar'][$value->id_barang] += $value->terkirim;
          }else{
            $data['barangkeluar'][$value->id_barang] = $value->terkirim;
          }
        }else{
          if (array_key_exists($value->id_barang,$data['barangkeluar'])) {
            $data['barangkeluar'][$value->id_barang] += $value->proses;
          }else{
            $data['barangkeluar'][$value->id_barang] = $value->proses;
          }
        }
      }

      $rjk = DB::table('tb_reject as a')->join('tb_detail_reject as b','b.no_reject','=','a.no_reject')
                            ->select("*")
                            ->where("a.id_gudang","=",$gudang)
                            ->whereMonth("a.tanggal_input",Date('m'))
                            ->get();
      $data['reject'] = array();
      foreach ($rjk as $key => $value) {
        if (array_key_exists($value->id_barang,$data['reject'])) {
          $data['reject'][$value->id_barang] += $value->jumlah;
        }else{
          $data['reject'][$value->id_barang] = $value->jumlah;
        }
      }

      $tfin = DB::table('tb_transfer_stok as a')->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
                            ->select("*")
                            ->where("a.dari","=",$gudang)
                            ->where("a.status_transfer","terkirim")
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->orWhere("a.status_transfer","proses")
                            ->where("a.kepada","=",$gudang)
                            ->whereMonth("a.tanggal_kirim",Date('m'))
                            ->get();
      $data['tfin'] = array();
      foreach ($tfin as $key => $value) {
        if (array_key_exists($value->id_barang,$data['tfin'])) {
          $data['tfin'][$value->id_barang] += $value->terkirim;
        }else{
          $data['tfin'][$value->id_barang] = $value->terkirim;
        }
      }

      $tfout = DB::table('tb_transfer_stok as a')->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
                            ->select("*")
                            ->where("a.status_transfer","proses")
                            ->where("a.kepada","=",$gudang)
                            ->whereMonth("a.tanggal_kirim",Date('m'))
                            ->orWhere("a.status_transfer","terkirim")
                            ->where("a.kepada","=",$gudang)
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->get();
      $data['tfout'] = array();
      foreach ($tfout as $key => $value) {
        if ($value->status_transfer == "terkirim") {
          if (array_key_exists($value->id_barang,$data['tfout'])) {
            $data['tfout'][$value->id_barang] += $value->terkirim;
          }else{
            $data['tfout'][$value->id_barang] = $value->terkirim;
          }
        }else{
          if (array_key_exists($value->id_barang,$data['tfout'])) {
            $data['tfout'][$value->id_barang] += $value->proses;
          }else{
            $data['tfout'][$value->id_barang] = $value->proses;
          }
        }
      }

      $data['stok'] = DB::table('tb_barang as a')
      ->join('tb_gudang_barang as b','b.id_barang','=','a.id')
      ->join('tb_harga as c','c.id_barang','=','a.id')
      ->select("a.*","c.harga",DB::raw('SUM(b.jumlah) as stok'))
      ->where("b.id_gudang",$gudang)
      ->groupBy("b.id_barang")
      ->get();

      $data['gudang'] = DB::table('tb_gudang as a')
      ->select("*")
      ->where("status","aktif")
      ->get();

      $data['nama_download'] = "History Barang ".date('d-m-Y');
      return view('HistoryBarang',$data);
    }else{
      return view ('Denied');
    }
  }

}
