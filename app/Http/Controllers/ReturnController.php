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

class ReturnController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function inputreturn(){
    $del =  date("Y-m-d",strtotime("-3 Months"));
    $data['transfer'] = array();
    $data['transfer2'] = array();
    /*if (Auth::user()->level == "1"|| Auth::user()->level =="4") {
      $data['transfer'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_karyawan as d','d.id','=','a.sales')
                          ->join('tb_karyawan as e','e.id','=','a.pengembang')
                          ->join('tb_karyawan as f','f.id','=','a.leader')
                          ->join('tb_karyawan as g','g.id','=','a.manager')
                          ->join('tb_kategori as i','i.id',"=",'b.kategori')
                          ->join('tb_karyawan as j','j.id',"=",'a.qc')
                          ->join('tb_karyawan as k','k.id',"=",'a.dropper')
                          ->join('tb_karyawan as l','l.id',"=",'a.pengirim')
                          ->join('users as h','h.id','=','a.admin_p')
                          ->join('users as m','m.id','=','a.admin_g')
                          ->join('users as n','n.id','=','a.admin_v')
                          ->select("a.id","a.no_kwitansi","a.tanggal_order","a.tanggal_terkirim","b.id_konsumen","b.nama_pemilik","b.alamat","b.no_hp"
                                   ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager"
                                   ,"j.nama as qc","a.dropper as id_dropper","k.nama as dropper","a.pengirim as id_pengirim","l.nama as pengirim","m.name as admin_g","a.tanggal_proses"
                                   ,"h.name as admin_p","i.nama_kategori as kategori","n.name as admin_v")
                          ->where("a.status_barang","=","terkirim")->where('tanggal_terkirim','>',$del)->get();

      $data['transfer2'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_karyawan as b','b.id','=','a.id_konsumen')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_karyawan as d','d.id','=','a.sales')
                          ->join('tb_karyawan as e','e.id','=','a.pengembang')
                          ->join('tb_karyawan as f','f.id','=','a.leader')
                          ->join('tb_karyawan as g','g.id','=','a.manager')
                          ->join('tb_karyawan as j','j.id',"=",'a.qc')
                          ->join('tb_karyawan as k','k.id',"=",'a.dropper')
                          ->join('tb_karyawan as l','l.id',"=",'a.pengirim')
                          ->join('users as h','h.id','=','a.admin_p')
                          ->join('users as m','m.id','=','a.admin_g')
                          ->join('users as n','n.id','=','a.admin_v')
                          ->select("a.id","a.no_kwitansi","a.tanggal_order","a.tanggal_terkirim","b.id as id_konsumen","b.nama as nama_pemilik","b.alamat","b.no_hp"
                                   ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager"
                                   ,"j.nama as qc","a.dropper as id_dropper","k.nama as dropper","a.pengirim as id_pengirim","l.nama as pengirim","m.name as admin_g","a.tanggal_proses"
                                   ,"h.name as admin_p","b.kategori","n.name as admin_v")
                          ->where("a.status_barang","=","terkirim")->where('tanggal_terkirim','>',$del)->get();
    }else{
      $data['transfer'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_karyawan as d','d.id','=','a.sales')
                          ->join('tb_karyawan as e','e.id','=','a.pengembang')
                          ->join('tb_karyawan as f','f.id','=','a.leader')
                          ->join('tb_karyawan as g','g.id','=','a.manager')
                          ->join('tb_kategori as i','i.id',"=",'b.kategori')
                          ->join('tb_karyawan as j','j.id',"=",'a.qc')
                          ->join('tb_karyawan as k','k.id',"=",'a.dropper')
                          ->join('tb_karyawan as l','l.id',"=",'a.pengirim')
                          ->join('users as h','h.id','=','a.admin_p')
                          ->join('users as m','m.id','=','a.admin_g')
                          ->join('users as n','n.id','=','a.admin_v')
                          ->select("a.id","a.no_kwitansi","a.tanggal_order","a.tanggal_terkirim","b.id_konsumen","b.nama_pemilik","b.alamat","b.no_hp"
                                   ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager"
                                   ,"j.nama as qc","a.dropper as id_dropper","k.nama as dropper","a.pengirim as id_pengirim","l.nama as pengirim","m.name as admin_g","a.tanggal_proses"
                                   ,"h.name as admin_p","i.nama_kategori as kategori","n.name as admin_v")
                          ->where("a.status_barang","=","terkirim")->where("a.id_gudang",Auth::user()->gudang)->where('tanggal_terkirim','>',$del)->get();
      $data['transfer2'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_karyawan as b','b.id','=','a.id_konsumen')
                          ->join('tb_gudang as c','c.id','=','a.id_gudang')
                          ->join('tb_karyawan as d','d.id','=','a.sales')
                          ->join('tb_karyawan as e','e.id','=','a.pengembang')
                          ->join('tb_karyawan as f','f.id','=','a.leader')
                          ->join('tb_karyawan as g','g.id','=','a.manager')
                          ->join('tb_karyawan as j','j.id',"=",'a.qc')
                          ->join('tb_karyawan as k','k.id',"=",'a.dropper')
                          ->join('tb_karyawan as l','l.id',"=",'a.pengirim')
                          ->join('users as h','h.id','=','a.admin_p')
                          ->join('users as m','m.id','=','a.admin_g')
                          ->join('users as n','n.id','=','a.admin_v')
                          ->select("a.id","a.no_kwitansi","a.tanggal_order","a.tanggal_terkirim","b.id as id_konsumen","b.nama as nama_pemilik","b.alamat","b.no_hp"
                                   ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager"
                                   ,"j.nama as qc","a.dropper as id_dropper","k.nama as dropper","a.pengirim as id_pengirim","l.nama as pengirim","m.name as admin_g","a.tanggal_proses"
                                   ,"h.name as admin_p","b.kategori","n.name as admin_v")
                          ->where("a.status_barang","=","terkirim")->where("a.id_gudang",Auth::user()->gudang)->where('tanggal_terkirim','>',$del)->get();
    }*/
    $data['qc'] = DB::table('tb_karyawan as a')->select("*")->where("a.jabatan","=","2")->where("a.status","=","aktif")->get();
    $data['dropper'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
    $data['pengirim'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
    return view('Return',$data);
  }

  public function searchkwitansireturn($key){
    if (Auth::user()->level == "1"|| Auth::user()->level =="4") {
      $data['transfer'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                          ->leftJoin('tb_gudang as c','c.id','=','a.id_gudang')
                          ->leftJoin('tb_karyawan as d','d.id','=','a.sales')
                          ->leftJoin('tb_karyawan as e','e.id','=','a.pengembang')
                          ->leftJoin('tb_karyawan as f','f.id','=','a.leader')
                          ->leftJoin('tb_karyawan as g','g.id','=','a.manager')
                          ->leftJoin('tb_kategori as i','i.id',"=",'b.kategori')
                          ->leftJoin('tb_karyawan as j','j.id',"=",'a.qc')
                          ->leftJoin('tb_karyawan as k','k.id',"=",'a.dropper')
                          ->leftJoin('tb_karyawan as l','l.id',"=",'a.pengirim')
                          ->leftJoin('users as h','h.id','=','a.admin_p')
                          ->leftJoin('users as m','m.id','=','a.admin_g')
                          ->leftJoin('users as n','n.id','=','a.admin_v')
                          ->select("a.id","a.no_kwitansi","a.tanggal_order","a.tanggal_terkirim","b.id_konsumen","b.nama_pemilik","b.alamat","b.no_hp"
                                   ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager"
                                   ,"j.nama as qc","a.dropper as id_dropper","k.nama as dropper","a.pengirim as id_pengirim","l.nama as pengirim","m.name as admin_g","a.tanggal_proses"
                                   ,"h.name as admin_p","i.nama_kategori as kategori","n.name as admin_v")
                          ->where("a.status_barang","=","terkirim")->where('a.no_kwitansi',$key)->get();

      $data['transfer2'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_karyawan as b','b.id','=','a.id_konsumen')
                          ->leftJoin('tb_gudang as c','c.id','=','a.id_gudang')
                          ->leftJoin('tb_karyawan as d','d.id','=','a.sales')
                          ->leftJoin('tb_karyawan as e','e.id','=','a.pengembang')
                          ->leftJoin('tb_karyawan as f','f.id','=','a.leader')
                          ->leftJoin('tb_karyawan as g','g.id','=','a.manager')
                          ->leftJoin('tb_karyawan as j','j.id',"=",'a.qc')
                          ->leftJoin('tb_karyawan as k','k.id',"=",'a.dropper')
                          ->leftJoin('tb_karyawan as l','l.id',"=",'a.pengirim')
                          ->leftJoin('users as h','h.id','=','a.admin_p')
                          ->leftJoin('users as m','m.id','=','a.admin_g')
                          ->leftJoin('users as n','n.id','=','a.admin_v')
                          ->select("a.id","a.no_kwitansi","a.tanggal_order","a.tanggal_terkirim","b.id as id_konsumen","b.nama as nama_pemilik","b.alamat","b.no_hp"
                                   ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager"
                                   ,"j.nama as qc","a.dropper as id_dropper","k.nama as dropper","a.pengirim as id_pengirim","l.nama as pengirim","m.name as admin_g","a.tanggal_proses"
                                   ,"h.name as admin_p","b.kategori","n.name as admin_v")
                          ->where("a.status_barang","=","terkirim")->where('a.no_kwitansi',$key)->get();
    }else{
      $data['transfer'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_konsumen as b','b.id','=','a.id_konsumen')
                          ->leftJoin('tb_gudang as c','c.id','=','a.id_gudang')
                          ->leftJoin('tb_karyawan as d','d.id','=','a.sales')
                          ->leftJoin('tb_karyawan as e','e.id','=','a.pengembang')
                          ->leftJoin('tb_karyawan as f','f.id','=','a.leader')
                          ->leftJoin('tb_karyawan as g','g.id','=','a.manager')
                          ->leftJoin('tb_kategori as i','i.id',"=",'b.kategori')
                          ->leftJoin('tb_karyawan as j','j.id',"=",'a.qc')
                          ->leftJoin('tb_karyawan as k','k.id',"=",'a.dropper')
                          ->leftJoin('tb_karyawan as l','l.id',"=",'a.pengirim')
                          ->leftJoin('users as h','h.id','=','a.admin_p')
                          ->leftJoin('users as m','m.id','=','a.admin_g')
                          ->leftJoin('users as n','n.id','=','a.admin_v')
                          ->select("a.id","a.no_kwitansi","a.tanggal_order","a.tanggal_terkirim","b.id_konsumen","b.nama_pemilik","b.alamat","b.no_hp"
                                   ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager"
                                   ,"j.nama as qc","a.dropper as id_dropper","k.nama as dropper","a.pengirim as id_pengirim","l.nama as pengirim","m.name as admin_g","a.tanggal_proses"
                                   ,"h.name as admin_p","i.nama_kategori as kategori","n.name as admin_v")
                          ->where("a.status_barang","=","terkirim")->where("a.id_gudang",Auth::user()->gudang)->where("a.status_barang","=","terkirim")->where('a.no_kwitansi',$key)->get();
      $data['transfer2'] = DB::table('tb_barang_keluar as a')
                          ->join('tb_karyawan as b','b.id','=','a.id_konsumen')
                          ->leftJoin('tb_gudang as c','c.id','=','a.id_gudang')
                          ->leftJoin('tb_karyawan as d','d.id','=','a.sales')
                          ->leftJoin('tb_karyawan as e','e.id','=','a.pengembang')
                          ->leftJoin('tb_karyawan as f','f.id','=','a.leader')
                          ->leftJoin('tb_karyawan as g','g.id','=','a.manager')
                          ->leftJoin('tb_karyawan as j','j.id',"=",'a.qc')
                          ->leftJoin('tb_karyawan as k','k.id',"=",'a.dropper')
                          ->leftJoin('tb_karyawan as l','l.id',"=",'a.pengirim')
                          ->leftJoin('users as h','h.id','=','a.admin_p')
                          ->leftJoin('users as m','m.id','=','a.admin_g')
                          ->leftJoin('users as n','n.id','=','a.admin_v')
                          ->select("a.id","a.no_kwitansi","a.tanggal_order","a.tanggal_terkirim","b.id as id_konsumen","b.nama as nama_pemilik","b.alamat","b.no_hp"
                                   ,"c.nama_gudang","d.nama as sales","e.nama as pengembang","f.nama as leader","g.nama as manager"
                                   ,"j.nama as qc","a.dropper as id_dropper","k.nama as dropper","a.pengirim as id_pengirim","l.nama as pengirim","m.name as admin_g","a.tanggal_proses"
                                   ,"h.name as admin_p","b.kategori","n.name as admin_v")
                          ->where("a.status_barang","=","terkirim")->where("a.id_gudang",Auth::user()->gudang)->where('a.no_kwitansi',$key)->get();
    }
    if (count($data['transfer']) > 0) {
      echo json_encode($data['transfer']);
    }else if(count($data['transfer2']) > 0){
      echo json_encode($data['transfer2']);
    }else{
      echo json_encode($data['transfer']);
    }
  }

  public function validretur(){
    if (Auth::user()->level = "1") {
      $data['retur'] = DB::table('tb_detail_barang_keluar as a')
                      //->join('tb_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                      ->select("a.*")
                      ->where("a.ket","pending")
                      ->get();
    }else{
      $data['retur'] = DB::table('tb_detail_barang_keluar as a')
                      //->join('tb_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                      ->select("a.*")
                      ->where("a.ket","pending")
                      ->where("b.id_gudang",Auth::user()->gudang)
                      ->get();
    }

     $data['detail'] = array();
     foreach ($data['retur'] as $key => $value) {
       $d = DB::table('tb_barang_keluar as a')->select("a.*")->where("a.no_kwitansi",$value->no_kwitansi)->get();
       foreach ($d as $val) {
         $data['detail'][$val->no_kwitansi]['total_bayar'] = $val->total_bayar;
         $data['detail'][$val->no_kwitansi]['status_order'] = $val->status_order;
         $data['detail'][$val->no_kwitansi]['id_gudang'] = $val->id_gudang;
         $data['detail'][$val->no_kwitansi]['id_konsumen'] = $val->id_konsumen;
         $data['detail'][$val->no_kwitansi]['tanggal_terkirim'] = $val->tanggal_terkirim;
       }
     }
     $gudang = DB::table('tb_gudang as a')->select("a.*")->get();
     foreach ($gudang as $key => $value) {
       $data['gudang'][$value->id] = $value->nama_gudang;
     }
     $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
     $data['barang'] = array();
     foreach ($text_barang as $value) {
       $data['barang'][$value->id]['no_sku'] =$value->no_sku;
       $data['barang'][$value->id]['nama_barang'] =$value->nama_barang;
     }

     $konsumen = DB::table('tb_konsumen as a')->select("*")->get();
     foreach ($konsumen as $key => $value) {
       $data['konsumen'][$value->id]['id'] = $value->id_konsumen;
       $data['konsumen'][$value->id]['nama'] = $value->nama_pemilik;
       $data['konsumen'][$value->id]['alamat'] = $value->alamat;
       $data['konsumen'][$value->id]['no_hp'] = $value->no_hp;
     }
     $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
     foreach ($karyawan as $key => $value) {
       $data['karyawan'][$value->id]['id'] = $value->id;
       $data['karyawan'][$value->id]['nama'] = $value->nama;
       $data['karyawan'][$value->id]['alamat'] = $value->alamat;
       $data['karyawan'][$value->id]['no_hp'] = $value->no_hp;
     }
    return view("ValidasiRetur",$data);
  }

  public function postpendingretur(Request $post){
    $data = $post->except('_token','id_detail_barang_keluar','id_barang','id_gudang','return');

    $str_id_detail_barang_keluar = explode(',',$post->only('id_detail_barang_keluar')['id_detail_barang_keluar']);
    $str_id_barang = explode(',',$post->only('id_barang')['id_barang']);
    $str_id_gudang = explode(',',$post->only('id_gudang')['id_gudang']);
    $str_return = explode(',',$post->only('return')['return']);
    $loop = count($str_id_barang) - 1;

    for ($i=0; $i < $loop; $i++) {
      $data['id_detail_barang_keluar'] = $str_id_detail_barang_keluar[$i];
      $data['id_barang'] = $str_id_barang[$i];
      $data['id_gudang'] = $str_id_gudang[$i];
      $data['return'] = $str_return[$i];

      $tambah = $data['return'];
      $get = DB::table('tb_detail_barang_keluar as a')->join('tb_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')->select("a.*","b.total_bayar","b.status_order")->where("a.id","=",$data['id_detail_barang_keluar'])->get();

      $d['ket'] = "pending";
      $d['temp_kembali'] = $tambah;

      DB::table('tb_detail_barang_keluar')->where('id','=',$data['id_detail_barang_keluar'])->update($d);

    }
  }

  public function postreturnbarang(Request $post){
    $data = $post->except('_token','id_detail_barang_keluar','id_barang','id_gudang','return');
    
    $str_id_detail_barang_keluar = explode(',',$post->only('id_detail_barang_keluar')['id_detail_barang_keluar']);
    $str_id_barang = explode(',',$post->only('id_barang')['id_barang']);
    $str_id_gudang = explode(',',$post->only('id_gudang')['id_gudang']);
    $str_return = explode(',',$post->only('return')['return']);
    $loop = count($str_id_barang) - 1;
    for ($i=0; $i < $loop; $i++) {
      $data['id_detail_barang_keluar'] = $str_id_detail_barang_keluar[$i];
      $data['id_barang'] = $str_id_barang[$i];
      $data['id_gudang'] = $str_id_gudang[$i];
      $data['return'] = $str_return[$i];


      $tambah = $data['return'];
      $trc = DB::table('tb_gudang_barang')->where('id_barang','=',$data['id_barang'])->where('id_gudang','=',$data['id_gudang'])->increment('jumlah', $tambah);

      //tracking data
      if ($trc) {
        $tracking['jenis_transaksi'] = "postreturnbarang";
        $tracking['nomor'] = "id detail barang keluar = ".$data['id_detail_barang_keluar'];
        $tracking['gudang'] = $data['id_gudang'];
        $tracking['barang'] = $data['id_barang'];
        $tracking['jumlah'] = $tambah;
        $tracking['stok'] = "in";
        DB::table('tracking')->insert($tracking);
      }
      
      
      $get = DB::table('tb_detail_barang_keluar as a')->join('tb_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')->select("a.*","b.total_bayar","b.status_order")->where("a.id","=",$data['id_detail_barang_keluar'])->get();

      $d['return'] = $get[0]->return + $tambah;
      $d['terkirim'] = $get[0]->terkirim - $tambah;
      $d['sub_total'] = $get[0]->sub_total - ($tambah * ($get[0]->harga_jual - $get[0]->potongan)) + (($get[0]->sub_potongan / $get[0]->terkirim) * $tambah);
      $d['sub_potongan'] = ($get[0]->sub_potongan / $get[0]->terkirim) * ($d['terkirim']);
      $d['ket'] = "kembali";
      $d['temp_kembali'] = 0;
      if ($get[0]->kembali > 0) {
        $d['kembali'] = $get[0]->kembali + $tambah;
      }else{
        $d['kembali'] = $tambah;
      }
      DB::table('tb_detail_barang_keluar')->where('id','=',$data['id_detail_barang_keluar'])->update($d);

      $s['tanggal_return'] = date('Y-m-d');
      $s['admin_r'] = Auth::user()->id;
      $s['total_bayar'] = $get[0]->total_bayar - ( $tambah * $get[0]->harga_jual ) + (($get[0]->sub_potongan / $get[0]->terkirim) * $tambah);
      $upd_brg = DB::table('tb_barang_keluar')->where('no_kwitansi','=',$data['no_kwitansi'])->update($s);
      
      //update trip jika ada
      if($upd_brg){
          $cek_trip = DB::table('tb_detail_trip as a')->select("a.*")->where("a.no_kwitansi",$data['no_kwitansi'])->get();
          if(count($cek_trip) > 0){
              $trp['sub_total'] = $s['total_bayar'];
              DB::table('tb_detail_trip')->where('no_kwitansi','=',$data['no_kwitansi'])->update($trp);
          }
      }
      
      $querycek = DB::table('tb_grafik')->where('months',date('F Y'))->get();
      if ($querycek) {
        if ($get[0]->status_order == "1") {
          $upd = ($tambah * $get[0]->harga_jual ) + (($get[0]->sub_potongan / $get[0]->terkirim) * $tambah);
          if (count($querycek) > 0) {
            DB::table('tb_grafik')->where('months',date('F Y'))->decrement('sums',$upd);
          }else{
            $y['months'] = date('F Y');
            $y['sums'] = $upd;
            DB::table('tb_grafik')->insert($y);
          }
        }
      }

      $v['sub_total'] = $s['total_bayar'];
      DB::table('tb_detail_trip')->where('no_kwitansi','=',$data['no_kwitansi'])->update($v);

      $cek_omset = DB::table('tb_detail_trip as a')
                   ->join('tb_omset as b','b.no_trip','=','a.no_trip')
                   ->select("b.*")
                   ->where('no_kwitansi','=',$data['no_kwitansi'])
                   ->limit(1)->get();
      if (count($cek_omset) > 0) {
        if (($get[0]->harga_jual - (($get[0]->sub_potongan/$get[0]->terkirim) + $get[0]->potongan)) > $get[0]->harga_net) {
          $old_omset = $get[0]->harga_net * $get[0]->terkirim;
          $new_omset = $get[0]->harga_net * ($get[0]->terkirim-$tambah);
        }else{
          $old_omset = ($get[0]->harga_jual - ($get[0]->potongan + ($get[0]->sub_potongan/$get[0]->terkirim))) * $get[0]->terkirim;
          $new_omset = ($get[0]->harga_jual - ($get[0]->potongan + ($get[0]->sub_potongan/$get[0]->terkirim))) * ($get[0]->terkirim-$tambah);
        }
         $oms_upd['jumlah'] = $cek_omset[0]->jumlah - $old_omset + $new_omset;
         DB::table('tb_omset')->where('id','=',$cek_omset[0]->id)->update($oms_upd);
      }

      $get2 = DB::table('tb_detail_pembayaran as a')->select("a.*")->where('no_kwitansi','=',$data['no_kwitansi'])->orderBy("a.pembayaran","DESC")->limit(1)->get();
      if (count($get2) > 0) {
        $x['pembayaran'] = $get2[0]->pembayaran - ( $tambah * $get[0]->harga_jual );
        DB::table('tb_detail_pembayaran')->where('id','=',$get2[0]->id)->update($x);
      }

    }

  }

  public function cancelretur($id){
    $data['ket'] = "kembali";
    $data['kembali'] = 0;
    $data['temp_kembali'] = 0;
    DB::table('tb_detail_barang_keluar')->where('id','=',$id)->update($data);
    return redirect()->back()->with('success','Berhasil');
  }

  public function datareturn(){
    if (Auth::user()->level == "1" || Auth::user()->level =="4") {
      $data['gudang'] = $this->model->getGudang();
    }else{
      $data['gudang'] = DB::table('tb_gudang as a')->select("a.*")->where("a.id","=",Auth::user()->gudang)->get();
    }
    $data['reject'] = array();
    $data['rejects'] = array();
    /*if (Auth::user()->level == "1") {
      $data['reject'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                        ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                        ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->get();
      $data['rejects'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                        ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                        ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->get();
    }else{
      $data['reject'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                        ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                        ->select("*")->where("a.status","=","aktif")->where("a.id_gudang","=",Auth::user()->gudang)->where("a.tanggal_return","<>",null)->get();
      $data['rejects'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                        ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                        ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.id_gudang","=",Auth::user()->gudang)->where("a.tanggal_return","<>",null)->get();
    }*/
    $d = DB::table('tb_karyawan as a')->select("*")->get();
    foreach ($d as $key => $value) {
      $data['karyawan'][$value->id] = $value->nama;
    }
    $e = DB::table('users as a')->select("*")->get();
    foreach ($e as $key => $value) {
      $data['admin'][$value->id] = $value->name;
    }
    $f = DB::table('tb_gudang as a')->select("*")->get();
    foreach ($f as $key => $value) {
      $data['gdg'][$value->id] = $value->nama_gudang;
    }
    $g = DB::table('tb_barang as a')->select("*")->get();
    foreach ($g as $key => $value) {
      $data['brg'][$value->id]['no_sku'] = $value->no_sku;
      $data['brg'][$value->id]['nama_barang'] = $value->nama_barang;
    }
    $h = DB::table('tb_status_order as a')->select("*")->get();
    foreach ($h as $key => $value) {
      $data['sts'][$value->id] = $value->nama_status;
    }
    $data['nama_download'] = "Data Return";
    $data['user'] = DB::table('users as a')->select("*")->where("a.status","=","aktif")->get();

    return view('DataReturn',$data);
  }

  public function datareturns(Request $post){
    $data = $post->except('_token');

    if ($data['id_gudang'] != "" && $data['id_gudang'] != null) {
       $x['id_gudang'] = $data['id_gudang'];
    }

    if ($data['admin_r'] != null) {
      $x['admin_r'] = $data['admin_r'];
    }

    $id = array();
    if ($data['nama_barang'] != null ||$data['nama_barang'] != "" ) {
      $nm = $data['nama_barang'];
      $cs = DB::table('tb_barang')->where('nama_barang','like',"%$nm%")->get();
      foreach ($cs as $key => $value) {
        array_push($id,$value->id);
      }
    }

    if (isset($x)) {

          if (isset($nm)) {
            if (isset($data['from']) && isset($data['to'])) {
              $from = $data['from'];
              $to = $data['to'];
              if (Auth::user()->level == "1"|| Auth::user()->level =="4") {
                            $data['reject'] = DB::table('tb_barang_keluar as a')
                                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                              ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                              //->join('tb_barang as e','e.id','=','b.id_barang')
                                              //->join('tb_status_order as f','f.id','=','a.status_order')
                                              ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                              ->where($x)
                                              ->whereIn('b.id_barang',$id)
                                              ->whereBetween('a.tanggal_return',[$from,$to])->get();
                            $data['rejects'] = DB::table('tb_barang_keluar as a')
                                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                              ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                              //->join('tb_barang as e','e.id','=','b.id_barang')
                                              //->join('tb_status_order as f','f.id','=','a.status_order')
                                              ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                              ->where($x)
                                              ->whereIn('b.id_barang',$id)
                                              ->whereBetween('a.tanggal_return',[$from,$to])->get();
                      }else{
                        $data['reject'] = DB::table('tb_barang_keluar as a')
                                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                          //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                          ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                          //->join('tb_barang as e','e.id','=','b.id_barang')
                                          //->join('tb_status_order as f','f.id','=','a.status_order')
                                          ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                          ->where($x)->where("a.id_gudang","=",Auth::user()->gudang)
                                          ->whereIn('b.id_barang',$id)
                                          ->whereBetween('a.tanggal_return',[$from,$to])->get();
                        $data['rejects'] = DB::table('tb_barang_keluar as a')
                                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                          //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                          ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                          //->join('tb_barang as e','e.id','=','b.id_barang')
                                          //->join('tb_status_order as f','f.id','=','a.status_order')
                                          ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                          ->where($x)->where("a.id_gudang","=",Auth::user()->gudang)
                                          ->whereIn('b.id_barang',$id)
                                          ->whereBetween('a.tanggal_return',[$from,$to])->get();
                      }
            }else {
              if (Auth::user()->level == "1"|| Auth::user()->level =="4") {
                $data['reject'] = DB::table('tb_barang_keluar as a')
                                  ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                  //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                  ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                  //->join('tb_barang as e','e.id','=','b.id_barang')
                                  //->join('tb_status_order as f','f.id','=','a.status_order')
                                  ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where($x)->whereIn('b.id_barang',$id)->get();
                $data['rejects'] = DB::table('tb_barang_keluar as a')
                                  ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                  //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                  ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                  //->join('tb_barang as e','e.id','=','b.id_barang')
                                  //->join('tb_status_order as f','f.id','=','a.status_order')
                                  ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where($x)->whereIn('b.id_barang',$id)->get();
              }else{
                $data['reject'] = DB::table('tb_barang_keluar as a')
                                  ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                  //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                  ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                  //->join('tb_barang as e','e.id','=','b.id_barang')
                                  //->join('tb_status_order as f','f.id','=','a.status_order')
                                  ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where("a.id_gudang","=",Auth::user()->gudang)->whereIn('b.id_barang',$id)->where($x)->get();
                $data['rejects'] = DB::table('tb_barang_keluar as a')
                                  ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                  //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                  ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                  //->join('tb_barang as e','e.id','=','b.id_barang')
                                  //->join('tb_status_order as f','f.id','=','a.status_order')
                                  ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where("a.id_gudang","=",Auth::user()->gudang)->whereIn('b.id_barang',$id)->where($x)->get();
              }

            }



          }else{


            if (isset($data['from']) && isset($data['to'])) {
              $from = $data['from'];
              $to = $data['to'];
              if (Auth::user()->level == "1"|| Auth::user()->level =="4") {
                            $data['reject'] = DB::table('tb_barang_keluar as a')
                                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                              ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                              //->join('tb_barang as e','e.id','=','b.id_barang')
                                              //->join('tb_status_order as f','f.id','=','a.status_order')
                                              ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                              ->where($x)
                                              ->whereBetween('a.tanggal_return',[$from,$to])->get();
                            $data['rejects'] = DB::table('tb_barang_keluar as a')
                                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                              ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                              //->join('tb_barang as e','e.id','=','b.id_barang')
                                              //->join('tb_status_order as f','f.id','=','a.status_order')
                                              ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                              ->where($x)
                                              ->whereBetween('a.tanggal_return',[$from,$to])->get();
                      }else{
                        $data['reject'] = DB::table('tb_barang_keluar as a')
                                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                          //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                          ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                          //->join('tb_barang as e','e.id','=','b.id_barang')
                                          //->join('tb_status_order as f','f.id','=','a.status_order')
                                          ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                          ->where($x)->where("a.id_gudang","=",Auth::user()->gudang)
                                          ->whereBetween('a.tanggal_return',[$from,$to])->get();
                        $data['rejects'] = DB::table('tb_barang_keluar as a')
                                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                          //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                          ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                          //->join('tb_barang as e','e.id','=','b.id_barang')
                                          //->join('tb_status_order as f','f.id','=','a.status_order')
                                          ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                          ->where($x)->where("a.id_gudang","=",Auth::user()->gudang)
                                          ->whereBetween('a.tanggal_return',[$from,$to])->get();
                      }
            }else {
              if (Auth::user()->level == "1"|| Auth::user()->level =="4") {
                $data['reject'] = DB::table('tb_barang_keluar as a')
                                  ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                  //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                  ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                  //->join('tb_barang as e','e.id','=','b.id_barang')
                                  //->join('tb_status_order as f','f.id','=','a.status_order')
                                  ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where($x)->get();
                $data['rejects'] = DB::table('tb_barang_keluar as a')
                                  ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                  //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                  ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                  //->join('tb_barang as e','e.id','=','b.id_barang')
                                  //->join('tb_status_order as f','f.id','=','a.status_order')
                                  ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where($x)->get();
              }else{
                $data['reject'] = DB::table('tb_barang_keluar as a')
                                  ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                  //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                  ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                  //->join('tb_barang as e','e.id','=','b.id_barang')
                                  //->join('tb_status_order as f','f.id','=','a.status_order')
                                  ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where("a.id_gudang","=",Auth::user()->gudang)->where($x)->get();
                $data['rejects'] = DB::table('tb_barang_keluar as a')
                                  ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                  //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                  ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                  //->join('tb_barang as e','e.id','=','b.id_barang')
                                  //->join('tb_status_order as f','f.id','=','a.status_order')
                                  ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where("a.id_gudang","=",Auth::user()->gudang)->where($x)->get();
              }

            }


          }


    }else{

      if (isset($nm)) {
        if (isset($data['from']) && isset($data['to'])) {
          $from = $data['from'];
          $to = $data['to'];
          if (Auth::user()->level == "1"|| Auth::user()->level =="4") {
                        $data['reject'] = DB::table('tb_barang_keluar as a')
                                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                          //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                          ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                          //->join('tb_barang as e','e.id','=','b.id_barang')
                                          //->join('tb_status_order as f','f.id','=','a.status_order')
                                          ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                          ->whereIn('b.id_barang',$id)
                                          ->whereBetween('a.tanggal_return',[$from,$to])->get();
                        $data['rejects'] = DB::table('tb_barang_keluar as a')
                                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                          //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                          ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                          //->join('tb_barang as e','e.id','=','b.id_barang')
                                          //->join('tb_status_order as f','f.id','=','a.status_order')
                                          ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                          ->whereIn('b.id_barang',$id)
                                          ->whereBetween('a.tanggal_return',[$from,$to])->get();
                  }else{
                    $data['reject'] = DB::table('tb_barang_keluar as a')
                                      ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                      //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                      ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                      //->join('tb_barang as e','e.id','=','b.id_barang')
                                      //->join('tb_status_order as f','f.id','=','a.status_order')
                                      ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                      ->where("a.id_gudang","=",Auth::user()->gudang)
                                      ->whereIn('b.id_barang',$id)
                                      ->whereBetween('a.tanggal_return',[$from,$to])->get();
                    $data['rejects'] = DB::table('tb_barang_keluar as a')
                                      ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                      //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                      ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                      //->join('tb_barang as e','e.id','=','b.id_barang')
                                      //->join('tb_status_order as f','f.id','=','a.status_order')
                                      ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                      ->where("a.id_gudang","=",Auth::user()->gudang)
                                      ->whereIn('b.id_barang',$id)
                                      ->whereBetween('a.tanggal_return',[$from,$to])->get();
                  }
        }else {
          if (Auth::user()->level == "1"|| Auth::user()->level =="4") {
            $data['reject'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                              //->join('tb_barang as e','e.id','=','b.id_barang')
                              //->join('tb_status_order as f','f.id','=','a.status_order')
                              ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->whereIn('b.id_barang',$id)->get();
            $data['rejects'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                              //->join('tb_barang as e','e.id','=','b.id_barang')
                              //->join('tb_status_order as f','f.id','=','a.status_order')
                              ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->whereIn('b.id_barang',$id)->get();
          }else{
            $data['reject'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                              //->join('tb_barang as e','e.id','=','b.id_barang')
                              //->join('tb_status_order as f','f.id','=','a.status_order')
                              ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where("a.id_gudang","=",Auth::user()->gudang)->whereIn('b.id_barang',$id)->get();
            $data['rejects'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                              //->join('tb_barang as e','e.id','=','b.id_barang')
                              //->join('tb_status_order as f','f.id','=','a.status_order')
                              ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where("a.id_gudang","=",Auth::user()->gudang)->whereIn('b.id_barang',$id)->get();
          }

        }



      }else{


        if (isset($data['from']) && isset($data['to'])) {
          $from = $data['from'];
          $to = $data['to'];
          if (Auth::user()->level == "1"|| Auth::user()->level =="4") {
                        $data['reject'] = DB::table('tb_barang_keluar as a')
                                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                          //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                          ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                          //->join('tb_barang as e','e.id','=','b.id_barang')
                                          //->join('tb_status_order as f','f.id','=','a.status_order')
                                          ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                          ->whereBetween('a.tanggal_return',[$from,$to])->get();
                        $data['rejects'] = DB::table('tb_barang_keluar as a')
                                          ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                          //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                          ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                          //->join('tb_barang as e','e.id','=','b.id_barang')
                                          //->join('tb_status_order as f','f.id','=','a.status_order')
                                          ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                          ->whereBetween('a.tanggal_return',[$from,$to])->get();
                  }else{
                    $data['reject'] = DB::table('tb_barang_keluar as a')
                                      ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                      //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                      ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                                      //->join('tb_barang as e','e.id','=','b.id_barang')
                                      //->join('tb_status_order as f','f.id','=','a.status_order')
                                      ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                      ->where("a.id_gudang","=",Auth::user()->gudang)
                                      ->whereBetween('a.tanggal_return',[$from,$to])->get();
                    $data['rejects'] = DB::table('tb_barang_keluar as a')
                                      ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                                      //->join('tb_gudang as c','c.id','=','a.id_gudang')
                                      ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                                      //->join('tb_barang as e','e.id','=','b.id_barang')
                                      //->join('tb_status_order as f','f.id','=','a.status_order')
                                      ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)
                                      ->where("a.id_gudang","=",Auth::user()->gudang)
                                      ->whereBetween('a.tanggal_return',[$from,$to])->get();
                  }
        }else {
          if (Auth::user()->level == "1"|| Auth::user()->level =="4") {
            $data['reject'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                              //->join('tb_barang as e','e.id','=','b.id_barang')
                              //->join('tb_status_order as f','f.id','=','a.status_order')
                              ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->get();
            $data['rejects'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                              //->join('tb_barang as e','e.id','=','b.id_barang')
                              //->join('tb_status_order as f','f.id','=','a.status_order')
                              ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->get();
          }else{
            $data['reject'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                              //->join('tb_barang as e','e.id','=','b.id_barang')
                              //->join('tb_status_order as f','f.id','=','a.status_order')
                              ->select("*")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where("a.id_gudang","=",Auth::user()->gudang)->get();
            $data['rejects'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                              //->join('tb_gudang as c','c.id','=','a.id_gudang')
                              ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                              //->join('tb_barang as e','e.id','=','b.id_barang')
                              //->join('tb_status_order as f','f.id','=','a.status_order')
                              ->select("*","d.nama as nama_pemilik")->where("a.status","=","aktif")->where("a.tanggal_return","<>",null)->where("a.id_gudang","=",Auth::user()->gudang)->get();
          }

        }


      }

    }



    if (Auth::user()->level == "1" || Auth::user()->level =="4") {
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
    $f = DB::table('tb_gudang as a')->select("*")->get();
    foreach ($f as $key => $value) {
      $data['gdg'][$value->id] = $value->nama_gudang;
    }
    $g = DB::table('tb_barang as a')->select("*")->get();
    foreach ($g as $key => $value) {
      $data['brg'][$value->id]['no_sku'] = $value->no_sku;
      $data['brg'][$value->id]['nama_barang'] = $value->nama_barang;
    }
    $h = DB::table('tb_status_order as a')->select("*")->get();
    foreach ($h as $key => $value) {
      $data['sts'][$value->id] = $value->nama_status;
    }
    $data['nama_download'] = "Data Return";
    $data['user'] = DB::table('users as a')->select("*")->where("a.status","=","aktif")->get();
    return view('DataReturn',$data);
  }


} ?>
