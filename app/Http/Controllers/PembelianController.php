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

class PembelianController extends Controller
{
  public function __construct()
  {   
      date_default_timezone_set('Asia/Jakarta');
  }
  
  public function daftarpembelian(){
    $data['gudang'] = DB::table('tb_gudang as a')->where("a.status","aktif")->get();
    $data['stok'] = DB::table('tb_barang as a')
    ->join('tb_gudang_barang as b','b.id_barang','=','a.id')
    ->select("a.*",DB::raw('SUM(b.jumlah) as stok'))
    ->groupBy("b.id_barang")
    ->get();
    $data['barangkeluar'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->select("b.id_barang",DB::raw('SUM(b.jumlah) as orderan'))
                            ->where("a.status_barang","order")
                            ->groupBy("b.id_barang")
                            ->get();

    $data['transferstok'] = DB::table('tb_transfer_stok as a')
                            ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
                            ->select("b.id_barang",DB::raw('SUM(b.jumlah) as orderan'))
                            ->where("a.status_transfer","order")
                            ->groupBy("b.id_barang")
                            ->get();
    $data['kulakan'] = array();
    foreach ($data['stok'] as $key => $value) {
      $data['kulakan'][$value->id]['no_sku'] = $value->no_sku;
      $data['kulakan'][$value->id]['nama_barang'] = $value->nama_barang;
      $data['kulakan'][$value->id]['part_number'] = $value->part_number;
      $data['kulakan'][$value->id]['stok'] = $value->stok;
      $data['kulakan'][$value->id]['orderan'] = "0";
    }

    foreach ($data['barangkeluar'] as $key => $value) {
      $data['kulakan'][$value->id_barang]['orderan'] += $value->orderan;
    }

    foreach ($data['transferstok'] as $key => $value) {
      $data['kulakan'][$value->id_barang]['orderan'] += $value->orderan;
    }
    $data['nama_download'] = "Daftar Kulakan ".date('d-m-Y');
    //dd($data['kulakan']);
    return view("Pembelian",$data);
  }

  public function cariKulakan($id){
    $data['gudang'] = DB::table('tb_gudang as a')->where("a.status","aktif")->get();
    if ($id == "all") {
      $data['stok'] = DB::table('tb_barang as a')
      ->join('tb_gudang_barang as b','b.id_barang','=','a.id')
      ->select("a.*",DB::raw('SUM(b.jumlah) as stok'))
      ->groupBy("b.id_barang")
      ->get();
      $data['barangkeluar'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                              ->select("b.id_barang",DB::raw('SUM(b.jumlah) as orderan'))
                              ->where("a.status_barang","order")
                              ->groupBy("b.id_barang")
                              ->get();

      $data['transferstok'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
                              ->select("b.id_barang",DB::raw('SUM(b.jumlah) as orderan'))
                              ->where("a.status_transfer","order")
                              ->groupBy("b.id_barang")
                              ->get();
      $data['kulakan'] = array();
      foreach ($data['stok'] as $key => $value) {
        $data['kulakan'][$value->id]['no_sku'] = $value->no_sku;
        $data['kulakan'][$value->id]['nama_barang'] = $value->nama_barang;
        $data['kulakan'][$value->id]['part_number'] = $value->part_number;
        $data['kulakan'][$value->id]['stok'] = $value->stok;
        $data['kulakan'][$value->id]['orderan'] = "0";
      }

      foreach ($data['barangkeluar'] as $key => $value) {
        $data['kulakan'][$value->id_barang]['orderan'] += $value->orderan;
      }

      foreach ($data['transferstok'] as $key => $value) {
        $data['kulakan'][$value->id_barang]['orderan'] += $value->orderan;
      }
    }else{
      $data['stok'] = DB::table('tb_barang as a')
      ->join('tb_gudang_barang as b','b.id_barang','=','a.id')
      ->select("a.*",DB::raw('SUM(b.jumlah) as stok'))
      ->groupBy("b.id_barang")
      ->get();
      $data['barangkeluar'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                              ->select("b.id_barang",DB::raw('SUM(b.jumlah) as orderan'))
                              ->where("a.status_barang","order")
                              ->where("a.id_gudang",$id)
                              ->groupBy("b.id_barang")
                              ->get();

      $data['transferstok'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_detail_transfer as b','b.no_transfer','=','a.no_transfer')
                              ->select("b.id_barang",DB::raw('SUM(b.jumlah) as orderan'))
                              ->where("a.status_transfer","order")
                              ->where("a.kepada",$id)
                              ->groupBy("b.id_barang")
                              ->get();
      $data['kulakan'] = array();
      foreach ($data['stok'] as $key => $value) {
        $data['kulakan'][$value->id]['no_sku'] = $value->no_sku;
        $data['kulakan'][$value->id]['nama_barang'] = $value->nama_barang;
        $data['kulakan'][$value->id]['part_number'] = $value->part_number;
        $data['kulakan'][$value->id]['stok'] = $value->stok;
        $data['kulakan'][$value->id]['orderan'] = "0";
      }

      foreach ($data['barangkeluar'] as $key => $value) {
        $data['kulakan'][$value->id_barang]['orderan'] += $value->orderan;
      }

      foreach ($data['transferstok'] as $key => $value) {
        $data['kulakan'][$value->id_barang]['orderan'] += $value->orderan;
      }
    }
    $data['v_gudang'] = $id;
    $data['nama_download'] = "Daftar Kulakan ".date('d-m-Y');
    return view("Pembelian",$data);
  }


}
?>
