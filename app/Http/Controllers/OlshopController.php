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

class OlshopController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }
  public function daftarolshop(){
    $kabupaten =  DB::table('regencies')->get();
    foreach ($kabupaten as $key => $value) {
      $data['data_kabupaten'][$value->id] = $value->name;
    }
    $data['tf'] = $this->model->getGudang();
    $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","2")->get();
    $data['order_ol'] = DB::table('tb_barang_keluar as a')
                     ->leftJoin('tb_konsumen as b','b.id','=','a.id_konsumen')
                     //->leftJoin('tb_karyawan as c','c.id','=','a.sales')
                     //->leftJoin('users as d','d.id','=','a.admin_p')
                     ->leftJoin('tb_gudang as e','e.id','=','a.id_gudang')
                     ->leftJoin('tb_status_order as f','f.id','=','a.status_order')
                     ->select("a.id","a.no_kwitansi","a.cod","a.kurir","a.service","a.tanggal_order","b.nama_pemilik","b.alamat","b.kota","a.admin_p as id_admin_p","e.nama_gudang","f.nama_status","a.status_barang","a.ket")
                     ->where("a.status","=","aktif")
                     ->where("a.status_barang","=","pending")
                     ->where("a.id_gudang","=",'1')
                     ->where("a.step",">",'1')
                     ->orderBy("a.tanggal_order","ASC")
                     ->get();
     foreach ($data['order_ol'] as $key => $value) {
       $getpay = DB::table('kt_rekap_pembayaran')->where('no_kwitansi',$value->no_kwitansi)->get();
       if(count($getpay) > 0){
         $data['order_ol'][$key]->transaction_status = $getpay[0]->transaction_status;
       }else{
         $data['order_ol'][$key]->transaction_status = "none";
       }
     }
     $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status","=","aktif")->get();
     $data['sales'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
     $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
     return view('Olshop/DaftarOrder',$data);
  }

  public function daftarpembayaranmanual(){
     $data['pembayaran'] = DB::table('kt_rekap_pembayaran as a')
         ->select("*")->whereNotNull('a.bukti')->where('a.cluster',"manual")->where('a.transaction_status',"pending")->get();
     foreach ($data['pembayaran'] as $key => $value) {
       $bk_cek = DB::table('tb_barang_keluar as a')
                 ->leftJoin('tb_konsumen as b','b.id','=','a.id_konsumen')
                 ->leftJoin('tb_gudang as e','e.id','=','a.id_gudang')
                 ->leftJoin('tb_status_order as f','f.id','=','a.status_order')
                 ->select("a.id","a.no_kwitansi","a.cod","a.kurir","a.service","a.tanggal_order","b.nama_pemilik","b.alamat","b.kota","a.admin_p as id_admin_p","e.nama_gudang","f.nama_status","a.status_barang","a.ket")
                 ->where('no_kwitansi',$value->no_kwitansi)
                 ->get();
       foreach ($bk_cek as $ky => $val) {
          $data['pembayaran'][$key]->cod = $val->cod;
          $data['pembayaran'][$key]->kurir = $val->kurir;
          $data['pembayaran'][$key]->service = $val->service;
          $data['pembayaran'][$key]->tanggal_order = $val->tanggal_order;
          $data['pembayaran'][$key]->nama_pemilik = $val->nama_pemilik;
          $data['pembayaran'][$key]->alamat = $val->alamat;
          $data['pembayaran'][$key]->id_admin_p = $val->id_admin_p;
          $data['pembayaran'][$key]->nama_gudang = $val->nama_gudang;
          $data['pembayaran'][$key]->nama_status = $val->nama_status;
          $data['pembayaran'][$key]->status_barang = $val->status_barang;
          $data['pembayaran'][$key]->ket = $val->ket;
          $data['pembayaran'][$key]->kota = $val->kota;
       }
     }

     $kabupaten =  DB::table('regencies')->get();
     foreach ($kabupaten as $key => $value) {
       $data['data_kabupaten'][$value->id] = $value->name;
     }
      $data['status_order'] = DB::table('tb_status_order as a')->select("a.*")->where("a.status","=","aktif")->get();
      $data['sales'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
      $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
    return view ('Olshop.DaftarPembayaranManual',$data);
  }

  public function approvepembayaranmanual($id){
    $pem['transaction_status'] = "settlement";
    $q = DB::table('kt_rekap_pembayaran')->where('no_kwitansi','=',$id)->update($pem);
    if ($q) {
      $k = DB::table('tb_barang_keluar as a')
           ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
           ->join('members as c','c.no_hp','=','b.no_hp')
           ->select('c.*')
           ->where('no_kwitansi','=',$id)->get();
      $d['id_member'] = $k[0]->id;
      $d['dilihat'] = 0;
      $d['text'] = "Pembayaran anda ".$id." telah berhasil diverifikasi!";
      DB::table('kt_notifikasi')->insert($d);
      return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back()->with('error','Berhasil');
    }
  }

  public function prosesorderolshop($id){
    $data['status_barang'] = "order";
    $q = DB::table('tb_barang_keluar')->where('no_kwitansi','=',$id)->update($data);
    if ($q) {
      $k = DB::table('tb_barang_keluar as a')
           ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
           ->join('members as c','c.no_hp','=','b.no_hp')
           ->select('c.*')
           ->where('no_kwitansi','=',$id)->get();
      $d['id_member'] = $k[0]->id;
      $d['dilihat'] = 0;
      $d['text'] = "Orderan anda ".$id." sedang dalam proses penyiapan barang";
      DB::table('kt_notifikasi')->insert($d);
      return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back()->with('error','Berhasil');
    }
  }

  public function inputresi(){
    $kabupaten =  DB::table('regencies')->get();
    foreach ($kabupaten as $key => $value) {
      $data['data_kabupaten'][$value->id] = $value->name;
    }
    $data['order'] = DB::table('tb_barang_keluar as a')
                     ->leftJoin('tb_konsumen as b','b.id','=','a.id_konsumen')
                     ->join('tb_gudang as e','e.id','=','a.id_gudang')
                     ->select("a.id","a.cod","a.kurir","a.service","a.no_kwitansi","a.tanggal_order","b.nama_pemilik","b.alamat","b.kota","e.nama_gudang","a.status_barang","a.keterangan")
                     ->where("a.status","=","aktif")
                     ->where("a.status_barang","=","proses")
                     ->whereNotNull("a.kurir")
                     ->whereNull("a.no_resi")
                     ->orderBy("a.tanggal_order","ASC")
                     ->get();
     foreach ($data['order'] as $key => $value) {
       $getpay = DB::table('kt_rekap_pembayaran')->where('no_kwitansi',$value->no_kwitansi)->get();
       if(count($getpay) > 0){
         $data['order'][$key]->transaction_status = $getpay[0]->transaction_status;
       }else{
         $data['order'][$key]->transaction_status = "none";
       }
     }
    return view('Olshop/InputResi',$data);
  }

  public function lacak_kurir($id){
    $get_data = DB::table('tb_barang_keluar')->where('no_kwitansi',$id)->get();

    if(count($get_data) > 0){
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "waybill=".$get_data[0]->no_resi."&courier=".$get_data[0]->kurir,
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded",
          "key: 8b92a84f1840d4abf81515cb8620ca22"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);

      $data['pelacakan'] = array();
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        $data['pelacakan'] = json_decode($response);
      }

      if(isset($data['pelacakan']->rajaongkir->result) && $data['pelacakan']->rajaongkir->result !== null){
        return view('Olshop/LacakData',$data);
      }else{
        return view('Olshop/LacakData',$data);
      }

    }else {
      return redirect()->back();
    }
  }

  public function daftarpengiriman(){
    $kabupaten =  DB::table('regencies')->get();
    foreach ($kabupaten as $key => $value) {
      $data['data_kabupaten'][$value->id] = $value->name;
    }
    $data['order'] = DB::table('tb_barang_keluar as a')
                     ->leftJoin('tb_konsumen as b','b.id','=','a.id_konsumen')
                     ->join('tb_gudang as e','e.id','=','a.id_gudang')
                     ->select("a.id","a.cod","a.kurir","a.service","a.no_resi","a.no_kwitansi","a.tanggal_order","b.nama_pemilik","b.alamat","b.kota","e.nama_gudang","a.status_barang","a.keterangan")
                     ->where("a.status","=","aktif")
                     ->where("a.status_barang","=","proses")
                     ->whereNotNull("a.kurir")
                     ->whereNotNull("a.no_resi")
                     ->orderBy("a.tanggal_order","ASC")
                     ->get();
    foreach ($data['order'] as $key => $value) {
      $getpay = DB::table('kt_rekap_pembayaran')->where('no_kwitansi',$value->no_kwitansi)->get();
      if(count($getpay) > 0){
        $data['order'][$key]->transaction_status = $getpay[0]->transaction_status;
      }else{
        $data['order'][$key]->transaction_status = "none";
      }
    }
    return view('Olshop/DaftarPengiriman',$data);
  }

  public function penjualanselesai(){
    $kabupaten =  DB::table('regencies')->get();
    foreach ($kabupaten as $key => $value) {
      $data['data_kabupaten'][$value->id] = $value->name;
    }
    $data['order'] = DB::table('tb_barang_keluar as a')
                     ->leftJoin('tb_konsumen as b','b.id','=','a.id_konsumen')
                     ->join('tb_gudang as e','e.id','=','a.id_gudang')
                     ->select("a.id","a.cod","a.kurir","a.service","a.no_resi","a.no_kwitansi","a.tanggal_order","b.nama_pemilik","b.alamat","b.kota","e.nama_gudang","a.status_barang","a.keterangan")
                     ->where("a.status","=","aktif")
                     ->where("a.status_barang","=","terkirim")
                     ->whereNotNull("a.kurir")
                     //->whereNotNull("a.no_resi")
                     ->orderBy("a.tanggal_order","ASC")
                     ->get();
   foreach ($data['order'] as $key => $value) {
     $getpay = DB::table('kt_rekap_pembayaran')->where('no_kwitansi',$value->no_kwitansi)->get();
     if(count($getpay) > 0){
       $data['order'][$key]->transaction_status = $getpay[0]->transaction_status;
     }else{
       $data['order'][$key]->transaction_status = "none";
     }
   }
    return view('Olshop/DaftarSelesai',$data);
  }

  public function simpan_kurir(Request $post){
    $data = $post->except('_token');
    $data['status_barang'] = "proses";
    $q = DB::table('tb_barang_keluar')->where('no_kwitansi','=',$data['no_kwitansi'])->update($data);
    if ($q) {

      $k = DB::table('tb_barang_keluar as a')
           ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
           ->join('members as c','c.no_hp','=','b.no_hp')
           ->select('c.*',"a.kurir","a.no_resi")
           ->where('no_kwitansi','=',$data['no_kwitansi'])->get();
      $d['id_member'] = $k[0]->id;
      $d['dilihat'] = 0;
      $d['text'] = "Pesanan Anda dengan invoice ".$data['no_kwitansi']." telah diterima oleh ".$k[0]->kurir." dengan nomor resi ".$k[0]->no_resi.". Silahkan cek di laman <a href='lacak_kurir/".$data['no_kwitansi']."'>Lacak Kiriman</a>";
      DB::table('kt_notifikasi')->insert($d);

      return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back()->with('error','Berhasil');
    }
  }

}
?>
