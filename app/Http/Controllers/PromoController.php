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

class PromoController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function inputpromo(){
    $data['barang'] = DB::table('tb_barang')->where('status','aktif')->get();
    return view('Promo',$data);
  }

  public function inputvoucher(){
    return view('Voucher');
  }

  public function insertpromo(Request $post){
    $data = $post->except('_token');
    if (Auth::user()->level == '1' || Auth::user()->level == '4' || Auth::user()->level == '2') {
      $q = DB::table('tb_promo')->insert($data);
      if ($q) {
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back();
      }
    }else{
      return redirect()->back();
    }
  }

  public function insertvoucher(Request $post){
    $data = $post->except('_token');
    if (Auth::user()->level == '1' || Auth::user()->level == '4' || Auth::user()->level == '2') {
      $q = DB::table('tb_voucher')->insert($data);
      if ($q) {
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back();
      }
    }else{
      return redirect()->back();
    }
  }


  public function datapromo(){
    $data['barang'] = DB::table('tb_barang')->where('status','aktif')->get();
    $data['nm_barang'] = array();
    foreach ($data['barang'] as $key => $value) {
      $data['nm_barang'][$value->id] = $value->nama_barang;
    }
    $data['promo'] = DB::table('tb_promo')->orderBy('status','ASC')->get();
    return view('DataPromo',$data);
  }

  public function datavoucher(){
    $data['voucher'] = DB::table('tb_voucher')->orderBy('status','ASC')->get();
    return view('DataVoucher',$data);
  }


  public function getdetailvoucher($id){
    $promo = DB::table('tb_voucher')
            ->where('id',$id)->get();
    echo json_encode($promo);
  }

  public function getdetailpromo($id){
    $promo = DB::table('tb_promo')
            ->join('tb_barang','tb_promo.id_barang','tb_barang.id')
            ->select('tb_promo.*','tb_barang.nama_barang')
            ->where('tb_promo.id',$id)->get();
    echo json_encode($promo);
  }

  public function simpanpromo(Request $post){
    $data = $post->except('_token');
    if (Auth::user()->level == '1' || Auth::user()->level == '4' || Auth::user()->level == '2') {

      if ($data['end'] < date('Y-m-d') ) {
        $data['status'] = "selesai";
      }else{
        $data['status'] = null;
      }

      $q = DB::table('tb_promo')->where('id',$data['id'])->update($data);
      if ($q) {
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back();
      }
    }else{
      return redirect()->back();
    }
  }

  public function simpanvoucher(Request $post){
    $data = $post->except('_token');
    if (Auth::user()->level == '1' || Auth::user()->level == '4' || Auth::user()->level == '2') {

      if ($data['end'] < date('Y-m-d') ) {
        $data['status'] = "selesai";
      }else{
        $data['status'] = null;
      }

      $q = DB::table('tb_voucher')->where('id',$data['id'])->update($data);
      if ($q) {
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back();
      }
    }else{
      return redirect()->back();
    }
  }

  public function deletepromo($id){
    if (Auth::user()->level == '1' || Auth::user()->level == '4' || Auth::user()->level == '2') {
      $q = DB::table('tb_promo')->where('id',$id)->delete();
      if ($q) {
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back();
      }
    }else{
      return redirect()->back();
    }
  }

  public function deletevoucher($id){
    if (Auth::user()->level == '1' || Auth::user()->level == '4' || Auth::user()->level == '2') {
      $q = DB::table('tb_voucher')->where('id',$id)->delete();
      if ($q) {
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back();
      }
    }else{
      return redirect()->back();
    }
  }


  public function cekpotonganperusahaan($id){
    $data = DB::table('tb_promo')
            ->where('id_barang',$id)
            ->whereDate('start','<=',date('Y-m-d'))
            ->whereDate('end','>=',date('Y-m-d'))
            ->get();
    echo json_encode($data);
  }

  public function joinpengiriman(){
    $data['trip'] = DB::table('tb_trip')->whereNull('status')->groupBy('kategori')->get();
    return view('JoinTrip',$data);
  }

  public function searchtriptujuan($id){
    $data = DB::table('tb_trip')->whereNull('status')->where('kategori',$id)->get();
    echo json_encode($data);
  }

  public function gabungkantrip($tujuan,$target){
    $dt['no_trip'] = $tujuan;
    $update_detail = DB::table('tb_detail_trip')->where('no_trip',$target)->update($dt);
    if ($update_detail) {
      $q = DB::table('tb_trip')->where('no_trip',$target)->delete();
      if ($q) {
        echo json_encode($dt);
      }
    }
  }

  public function searchdetailtrip($id){
    $data = DB::table('tb_detail_trip')->where('no_trip',$id)->get();
    echo json_encode($data);
  }

}
