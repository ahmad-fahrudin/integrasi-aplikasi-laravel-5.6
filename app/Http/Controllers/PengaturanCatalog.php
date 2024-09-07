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

class PengaturanCatalog extends Controller
{
  var $model;
  public function __construct()
  {     
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function brand(){
    $data['brand'] = DB::table('kt_brand as a')->where("a.status","aktif")->select("*")->get();
    return view('SetingKatalog/Brand',$data);
  }

  public function addbrand(Request $post){
    $data = $post->except('_token');
    $brand['nama_brand'] = $data['nama_brand'];
    if ($post->hasFile('img')) {
      $target_dir = "gambar/brand/";
      $passname = str_replace(" ","-",$post->file('img')->getClientOriginalName());
      $brand['img'] = $passname;
      $target_file = $target_dir . $passname;
      $upload = move_uploaded_file($_FILES['img']["tmp_name"], $target_file);
      if ($upload) {
        $query = DB::table('kt_brand')->insert($brand);
      }
    }
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function editBrand($id){
      $data = DB::table('kt_brand as a')->where("a.id",$id)->select("*")->get();
      echo json_encode($data);
  }

  public function updatebrand(Request $post){
    $data = $post->except('_token');
    $brand['nama_brand'] = $data['nama_brand'];
    if ($post->hasFile('img')) {
      $target_dir = "gambar/brand/";
      $passname = str_replace(" ","-",$post->file('img')->getClientOriginalName());
      $brand['img'] = $passname;
      $target_file = $target_dir . $passname;
      $upload = move_uploaded_file($_FILES['img']["tmp_name"], $target_file);
    }
    $query = DB::table('kt_brand')->where('id','=',$data['id'])->update($brand);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function deleteBrand($id){
    $brand['status'] = "non aktif";
    $query = DB::table('kt_brand')->where('id','=',$id)->update($brand);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function caribrand($id){
    $brand = DB::table('kt_brand as a')->where('a.nama_brand',"like","%$id%")->select("*")->get();
    echo json_encode($brand);
  }

  public function carikategori($id,$mainkat){
    if ($mainkat > 0) {
      $kategori = DB::table('kt_kategori as a')->where('a.nama_kategori',"like","%$id%")->where('a.main_kategori',$mainkat)->select("*")->get();
    }else{
      $kategori = DB::table('kt_kategori as a')->where('a.nama_kategori',"like","%$id%")->select("*")->get();
    }
    echo json_encode($kategori);
  }

  public function carimainkategori($id){
    $kategori = DB::table('tb_main_kategori as a')->where('a.nama_main_kategori',"like","%$id%")->select("*")->get();
    echo json_encode($kategori);
  }

  public function color(){
    $data['color'] = DB::table('kt_color as a')->where("a.status","aktif")->select("*")->get();
    return view('SetingKatalog/Color',$data);
  }

  public function addcolor(Request $post){
    $data = $post->except('_token');
    $color['warna'] = $data['warna'];
    $color['hex'] = str_replace("#","",$data['hex']);
    $query = DB::table('kt_color')->insert($color);

    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function editColor($id){
      $data = DB::table('kt_color as a')->where("a.hex",$id)->select("*")->get();
      echo json_encode($data);
  }

  public function updatecolor(Request $post){
    $data = $post->except('_token');
    $color['warna'] = $data['warna'];
    $color['hex'] = str_replace("#","",$data['hex']);
    $query = DB::table('kt_color')->where('hex','=',$data['id'])->update($color);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function deleteColor($id){
    $color['status'] = "non aktif";
    $query = DB::table('kt_color')->where('hex','=',$id)->update($color);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function kategorikatalog(){
    $data['kategori'] = DB::table('kt_kategori as a')->where("a.status","aktif")->select("*")->get();
    $data['mainkategori'] = DB::table('tb_main_kategori as a')->select("*")->get();
    $data['data_kategori'] = array();
    foreach ($data['mainkategori'] as $key => $value) {
      $data['data_kategori'][$value->id] = $value->nama_main_kategori;
    }
    return view('SetingKatalog/Kategori',$data);
  }

  public function addkategoriproduk(Request $post){
    $data = $post->except('_token');
    $query = DB::table('tb_main_kategori')->insert($data);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function kategoriproduk(){
    $data['mainkategori'] = DB::table('tb_main_kategori as a')->select("*")->get();
    return view('SetingKatalog/MainKategori',$data);
  }

  public function addkategorikatalog(Request $post){
    $data = $post->except('_token','gbr');
        if (isset($post->gbr)) {
          if ($post->hasFile('gbr')) {
            $target_dir = "gambar/kategori/";
            $passname = str_replace(" ","-",$post->file('gbr')->getClientOriginalName());
            $target_file = $target_dir . $passname;
            move_uploaded_file($_FILES['gbr']["tmp_name"], $target_file);
            $data['gbr'] = $passname;
            $query = DB::table('kt_kategori')->insert($data);
          }
        }
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function editkategorikatalog($id){
      $data = DB::table('kt_kategori as a')->where("a.id",$id)->select("*")->get();
      echo json_encode($data);
  }

  public function editkategoriproduk($id){
      $data = DB::table('tb_main_kategori as a')->where("a.id",$id)->select("*")->get();
      echo json_encode($data);
  }

  public function updatekategorikatalog(Request $post){
    $data = $post->except('_token','gbr');
    if (isset($post->gbr)) {
          if ($post->hasFile('gbr')) {
            $target_dir = "gambar/kategori/";
            $passname = str_replace(" ","-",$post->file('gbr')->getClientOriginalName());
            $target_file = $target_dir . $passname;
            move_uploaded_file($_FILES['gbr']["tmp_name"], $target_file);
            $data['gbr'] = $passname;
        }
    }
        
    $query = DB::table('kt_kategori')->where('id','=',$data['id'])->update($data);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function updatekategoriproduk(Request $post){
    $data = $post->except('_token');
    $query = DB::table('tb_main_kategori')->where('id','=',$data['id'])->update($data);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function deletekategorikatalog($id){
    $brand['status'] = "non aktif";
    $query = DB::table('kt_kategori')->where('id','=',$id)->update($brand);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function deletekategoriproduk($id){
    $query = DB::table('tb_main_kategori')->where('id','=',$id)->delete();
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function label(){
    $data['label'] = DB::table('kt_label as a')->where("a.status","aktif")->select("*")->get();
    return view('SetingKatalog/Label',$data);
  }

  public function addlabel(Request $post){
    $data = $post->except('_token');
    $query = DB::table('kt_label')->insert($data);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function editlabel($id){
      $data = DB::table('kt_label as a')->where("a.id",$id)->select("*")->get();
      echo json_encode($data);
  }

  public function updatelabel(Request $post){
    $data = $post->except('_token');
    $query = DB::table('kt_label')->where('id','=',$data['id'])->update($data);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function deletelabel($id){
    $brand['status'] = "non aktif";
    $query = DB::table('kt_label')->where('id','=',$id)->update($brand);
    if ($query) {
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }
}
