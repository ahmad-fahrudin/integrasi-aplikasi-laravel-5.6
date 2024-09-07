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

class KatalogController extends Controller
{
  var $model;
  public function __construct()
  {     
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function inputkatalog(){
    $data['kategori'] = DB::table('kt_kategori as a')->where("a.status","aktif")->select("*")->get();
    $data['color'] = DB::table('kt_color as a')->where("a.status","aktif")->select("*")->get();
    $data['label'] = DB::table('kt_label as a')->where("a.status","aktif")->select("*")->get();
    $data['brand'] = DB::table('kt_brand as a')->where("a.status","aktif")->select("*")->get();

    $data['barang'] = DB::table('tb_barang as a')->join('tb_harga as b','b.id_barang','=','a.id')
                      ->select("a.*","harga","harga_retail","label","qty1","pot1","qty2","pot2","qty3","pot3")
                      ->where("a.status","=","aktif")->whereNull('a.organized')
                      ->get();
    return view('SetingKatalog/Katalog',$data);
  }

  public function uploadkatalog(Request $post){
    $data = $post->except('_token');
    
    if($data['main_kategori'] == null || $data['kategori'] == null || $data['brand'] == null){
        return redirect()->back()->withErrors(['msg', 'The Message']);
    }
    
    $katalog['warna'] = "";
    for ($a=0; $a < $data['jumlah_warna']; $a++) {
      if (isset($data['warna'.$a])) {
        $katalog['warna'] .= $data['warna'.$a].",";
      }
    }
    $katalog['id'] = date('ymdhis');
    $katalog['nama_barang'] = $data['nama_barang'];
    $katalog['barang'] = $data['barang'];
    $katalog['berat'] = $data['berat'];
    $katalog['kategori'] = $data['kategori'];
    $katalog['deskripsi_seo'] = $data['deskripsi_seo'];
    $katalog['keyword_seo'] = $data['keyword_seo'];
    $katalog['main_kategori'] = $data['main_kategori'];
    if (isset($data['brand'])) {
      $katalog['brand'] = $data['brand'];
    }
    $katalog['deskripsi'] = $data['deskripsi'];
    if (isset($data['label']) && $data['label'] != "none") {
      $katalog['label'] = $data['label'];
    }

    $katalog['jenis'] = "single";
    $query = true;
    $query = DB::table('kt_katalog')->insert($katalog);

    if ($query) {
      $barang['organized'] = "yes";
      DB::table('tb_barang')->where('id','=',$data['barang'])->update($barang);

      for ($i=1; $i <= $data['jumlah']; $i++) {
        echo $data['jumlah']."<br>";
        if (isset($data['gambar'.$i])) {
          if ($post->hasFile('gambar'.$i)) {
            $target_dir = "gambar/product/";
            $passname = str_replace(" ","-",$post->file('gambar'.$i)->getClientOriginalName());
            $target_file = $target_dir . $passname;
            move_uploaded_file($_FILES['gambar'.$i]["tmp_name"], $target_file);
            $gambar['id_katalog'] = $katalog['id'];
            $gambar['nama_file'] = $passname;
            //echo $passname."<br>";
            DB::table('kt_gambar')->insert($gambar);
          }
        }
      }
      return redirect()->back()->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function uploadkatalogmultiple(Request $post)
  {
    $data = $post->except('_token');
    
    if($data['main_kategori'] == null || $data['kategori'] == null || $data['brand'] == null){
        return redirect()->back()->withErrors(['msg', 'The Message']);
    }
    
    $katalog['warna'] = "";
    for ($a=0; $a < $data['jumlah_warna']; $a++) {
      if (isset($data['warna'.$a])) {
        $katalog['warna'] .= $data['warna'.$a].",";
      }
    }

    $katalog['id'] = date('ymdhis');
    $katalog['nama_barang'] = $data['nama_barang'];
    $katalog['kategori'] = $data['kategori'];
    $katalog['brand'] = $data['brand'];
    $katalog['deskripsi'] = $data['deskripsi'];
    $katalog['deskripsi_seo'] = $data['deskripsi_seo'];
    $katalog['keyword_seo'] = $data['keyword_seo'];
    $katalog['main_kategori'] = $data['main_kategori'];
    if (isset($data['label']) && $data['label'] != "none") {
      $katalog['label'] = $data['label'];
    }
    $katalog['jenis'] = "multiple";

    $query = DB::table('kt_katalog')->insert($katalog);
    if ($query) {
      for ($i=1; $i <= $data['jumlah_produk']; $i++) {
        if (isset($data['barang'.$i]) && $data['barang'.$i] != "") {
          $multiple['id_katalog'] = $katalog['id'];
          $multiple['barang'] = $data['barang'.$i];
          $multiple['berat_multiple'] = $data['berat_multi'.$i];
          $c = DB::table('kt_multiple')->insert($multiple);

          if ($c) {
            $barang['organized'] = "yes";
            DB::table('tb_barang')->where('id','=',$data['barang'.$i])->update($barang);
          }

        }
      }

      for ($i=1; $i <= $data['jumlah_gambar']; $i++) {
        if (isset($data['gambar'.$i])) {
          if ($post->hasFile('gambar'.$i)) {
            $target_dir = "gambar/product/";
            $passname = str_replace(" ","-",$post->file('gambar'.$i)->getClientOriginalName());
            $target_file = $target_dir . $passname;
            move_uploaded_file($_FILES['gambar'.$i]["tmp_name"], $target_file);
            $gambar['id_katalog'] = $katalog['id'];
            $gambar['nama_file'] = $passname;
            DB::table('kt_gambar')->insert($gambar);
          }
        }
      }
      return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function datakatalog(){
    $data['kategori'] = DB::table('kt_kategori as a')->where("a.status","aktif")->select("*")->get();
    $data['color'] = DB::table('kt_color as a')->where("a.status","aktif")->select("*")->get();
    $data['label'] = DB::table('kt_label as a')->where("a.status","aktif")->select("*")->get();
    $data['brand'] = DB::table('kt_brand as a')->where("a.status","aktif")->select("*")->get();

    $data['barang'] = DB::table('tb_barang as a')->join('tb_harga as b','b.id_barang','=','a.id')
                      ->select("a.*","harga","harga_retail","qty1","pot1","qty2","pot2","qty3","pot3")
                      ->where("a.status","=","aktif")->whereNull('a.organized')->get();

    $data['katalog'] = DB::table('kt_katalog as a')->where("a.status","aktif")->select("*")->get();
    $data['databrand'] = array();
    foreach ($data['brand'] as $key => $value) {
      $data['databrand'][$value->id] = $value->nama_brand;
    }
    return view('SetingKatalog/DataKatalog',$data);
  }

  public function detailKatalog($id){
    $data = DB::table('kt_katalog as a')
            ->leftJoin('kt_multiple as b','b.id_katalog','=','a.id')
            ->leftJoin('tb_barang as c','c.id','=','b.barang')
            ->where("a.id",$id)->select("a.*","b.barang as barang_multi","b.berat_multiple","a.id as id_katalog","c.nama_barang as nama_barang_detail")->get();
    echo json_encode($data);
  }

  public function detailImage($id){
    $data = DB::table('kt_gambar as a')
            ->where("a.id_katalog",$id)->select("*")->get();
    echo json_encode($data);
  }

  public function deleteGambarProduk($id){
    $data = DB::table('kt_gambar')->where("id",$id)->delete();
    if ($data) {
      $dat['status'] = "sukses";
    }
    echo json_encode($dat);
    //if ($data) {
    //  return redirect()->back()->with('success','Berhasil');
    //}else{
    //  return redirect()->back()->withErrors(['msg', 'The Message']);
    //}
  }

  public function updatekatalog(Request $post){
    $data = $post->except('_token');
    $katalog['warna'] = "";
    $query = false;
    $query2 = false;
    for ($a=0; $a < $data['jumlah_warna']; $a++) {
      if (isset($data['warna'.$a])) {
        $katalog['warna'] .= $data['warna'.$a].",";
      }
    }
    $katalog['id'] = $data['id'];
    $katalog['nama_barang'] = $data['nama_barang'];
    $katalog['barang'] = $data['barang'];
    $katalog['berat'] = $data['berat'];
    $katalog['kategori'] = $data['kategori'];
    $katalog['brand'] = $data['brand'];
    $katalog['deskripsi'] = $data['deskripsi'];
    $katalog['deskripsi_seo'] = $data['deskripsi_seo'];
    $katalog['keyword_seo'] = $data['keyword_seo'];
    $katalog['main_kategori'] = $data['main_kategori'];
    if (isset($data['label']) && is_numeric($data['label'])) {
        $katalog['label'] = $data['label'];

        $prc['label'] = $data['label'];
        DB::table('tb_harga')->where('id_barang',$data['barang'])->update($prc);

    }
    $katalog['jenis'] = "single";
    //dd($katalog);
    $query = DB::table('kt_katalog')->where('id',$katalog['id'])->update($katalog);

    for ($i=1; $i <= $data['jumlah']; $i++) {
      echo $data['jumlah']."<br>";
      if (isset($data['gambar'.$i])) {
        if ($post->hasFile('gambar'.$i)) {
          $target_dir = "gambar/product/";
          $passname = str_replace(" ","-",$post->file('gambar'.$i)->getClientOriginalName());
          $target_file = $target_dir . $passname;
          move_uploaded_file($_FILES['gambar'.$i]["tmp_name"], $target_file);
          $gambar['id_katalog'] = $katalog['id'];
          $gambar['nama_file'] = $passname;
          $query2 = DB::table('kt_gambar')->insert($gambar);
        }
      }
    }

    if ($query || $query2) {
      $barang['organized'] = "yes";
      DB::table('tb_barang')->where('id','=',$data['barang'])->update($barang);

      if ($data['barang_old'] != $data['barang']) {
        $barang2['organized'] = null;
        DB::table('tb_barang')->where('id','=',$data['barang_old'])->update($barang2);
      }

      return redirect()->route('katalogproduk')->with('success','Berhasil');
    }else {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function updatekatalogmultiple(Request $post){
    $data = $post->except('_token');
    //dd($data);
    $katalog['warna'] = "";
    for ($a=0; $a < $data['jumlah_warna']; $a++) {
      if (isset($data['warna_multiple'.$a])) {
        $katalog['warna'] .= $data['warna_multiple'.$a].",";
      }
    }

    $katalog['id'] = $data['id'];
    $katalog['nama_barang'] = $data['nama_barang'];
    $katalog['kategori'] = $data['kategori'];
    $katalog['brand'] = $data['brand'];
    $katalog['deskripsi'] = $data['deskripsi'];
    $katalog['deskripsi_seo'] = $data['deskripsi_seo'];
    $katalog['keyword_seo'] = $data['keyword_seo'];
    $katalog['main_kategori'] = $data['main_kategori'];
    if (isset($data['label']) && is_numeric($data['label'])) {
        $katalog['label'] = $data['label'];
    }
    $katalog['jenis'] = "multiple";

    $query = DB::table('kt_katalog')->where('id',$katalog['id'])->update($katalog);
    $query2 = false;
    for ($i=1; $i <= $data['jumlah_gambar']; $i++) {
      if (isset($data['gambar'.$i])) {
        if ($post->hasFile('gambar'.$i)) {
          $target_dir = "gambar/product/";
          $passname = str_replace(" ","-",$post->file('gambar'.$i)->getClientOriginalName());
          $target_file = $target_dir . $passname;
          move_uploaded_file($_FILES['gambar'.$i]["tmp_name"], $target_file);
          $gambar['id_katalog'] = $katalog['id'];
          $gambar['nama_file'] = $passname;
          $query2 = DB::table('kt_gambar')->insert($gambar);
        }
      }
    }

    $cek = DB::table('kt_multiple')->where("id_katalog",$katalog['id'])->select("*")->get();
    foreach ($cek as $key => $value) {
      $barang2['organized'] = null;
      DB::table('tb_barang')->where('id','=',$value->barang)->update($barang2);
    }

    if ($cek) {
      DB::table('kt_multiple')->where('id_katalog','=',$katalog['id'])->delete();
    }

    for ($i=1; $i <= $data['jumlah_produk']; $i++) {
      if (isset($data['barang'.$i]) && $data['barang'.$i] != "") {
        $multiple['id_katalog'] = $katalog['id'];
        $multiple['barang'] = $data['barang'.$i];
        $multiple['berat_multiple'] = $data['berat_multi'.$i];
        $c = DB::table('kt_multiple')->insert($multiple);

        if ($c) {
          $barang['organized'] = "yes";
          DB::table('tb_barang')->where('id','=',$data['barang'.$i])->update($barang);
        }
      }
    }

    if ($query || $query2 || $c) {
      return redirect()->route('katalogproduk')->with('success','Berhasil');
      //return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }
  }

  public function katalog(){
    if(isset($_GET['nama_barang']) || isset($_GET['kategori']) || isset($_GET['main_kategori'])){
        if(isset($_GET['nama_barang'])){
            if ($_GET['nama_barang'] != "" && $_GET['nama_barang'] != null) {
            $nama_barang = $_GET['nama_barang'];
            $data['nama_barangs'] = $nama_barang;
         }
        }
      if ( isset($_GET['kategori']) && $_GET['kategori'] != "" && $_GET['kategori'] != "Semua") {
        $kategori['kategori'] = $_GET['kategori'];
        $data['kategoris'] = $_GET['kategori'];
      }
      if ( isset($_GET['main_kategori']) && $_GET['main_kategori'] != "" && $_GET['main_kategori'] != "Semua") {
        $kategori['main_kategori'] = $_GET['main_kategori'];
        $data['mainkategoris'] = $_GET['main_kategori'];
      }

      if (isset($nama_barang) && isset($kategori)) {
        $data['produk'] = DB::table('kt_katalog')
                          ->leftJoin('kt_gambar','kt_gambar.id_katalog','=','kt_katalog.id')
                          ->select("kt_katalog.*","kt_gambar.nama_file")
                          ->where('kt_katalog.status','aktif')
                          ->where($kategori)
                          ->where('kt_katalog.nama_barang','like',"%$nama_barang%")
                          ->orderBy('kt_katalog.create','DESC')
                          ->orderBy('kt_katalog.id','DESC')
                          ->groupBy("kt_katalog.id")
                          ->paginate(18);
      }else if (isset($nama_barang)) {
        $data['produk'] = DB::table('kt_katalog')
                          ->leftJoin('kt_gambar','kt_gambar.id_katalog','=','kt_katalog.id')
                          ->select("kt_katalog.*","kt_gambar.nama_file")
                          ->where('kt_katalog.status','aktif')
                          ->where('kt_katalog.nama_barang','like',"%$nama_barang%")
                          ->orderBy('kt_katalog.create','DESC')
                          ->orderBy('kt_katalog.id','DESC')
                          ->groupBy("kt_katalog.id")
                          ->paginate(18);
      }else if(isset($kategori)){
        $data['produk'] = DB::table('kt_katalog')
                          ->leftJoin('kt_gambar','kt_gambar.id_katalog','=','kt_katalog.id')
                          ->select("kt_katalog.*","kt_gambar.nama_file")
                          ->where('kt_katalog.status','aktif')
                          ->where($kategori)
                          ->orderBy('kt_katalog.create','DESC')
                          ->orderBy('kt_katalog.id','DESC')
                          ->groupBy("kt_katalog.id")
                          ->paginate(18);

      }else{
        $data['produk'] = DB::table('kt_katalog')
                          ->leftJoin('kt_gambar','kt_gambar.id_katalog','=','kt_katalog.id')
                          ->select("kt_katalog.*","kt_gambar.nama_file")
                          ->where('kt_katalog.status','aktif')
                          ->orderBy('kt_katalog.create','DESC')
                          ->orderBy('kt_katalog.id','DESC')
                          ->groupBy("kt_katalog.id")
                          ->paginate(18);
      }
    }else{
      $data['produk'] = DB::table('kt_katalog')
                        ->leftJoin('kt_gambar','kt_gambar.id_katalog','=','kt_katalog.id')
                        ->select("kt_katalog.*","kt_gambar.nama_file")
                        ->where('kt_katalog.status','aktif')
                        ->orderBy('kt_katalog.create','DESC')
                        ->orderBy('kt_katalog.id','DESC')
                        ->groupBy("kt_katalog.id")
                        ->paginate(18);
    }
      $harga= DB::table('tb_harga')->select("*")->get();
      foreach ($harga as $key => $value) {
        $data['harga'][$value->id_barang]['harga_retail'] = $value->harga_retail;
        if ( ($value->pot1 !="" && $value->qty1 != "") || ($value->pot2 !="" && $value->qty2 != "") || ($value->pot3 !="" && $value->qty3 != "")) {
          $data['harga'][$value->id_barang]['cekpromo'] = true;
        }
      }

      $barang= DB::table('tb_barang')->select("*")->get();
      foreach ($barang as $key => $value) {
        $data['barang'][$value->id]['no_sku'] = $value->no_sku;
        $data['barang'][$value->id]['keterangan'] = $value->keterangan;
      }

      $data['multi'] = array();
      foreach ($data['produk'] as $key => $value) {

        if ($value->jenis == "multiple") {
          $harga_min = 0;
          $harga_max = 0;
          $jumlah_stok = 0;
          $temp = DB::table('kt_multiple')->select("*")->where("id_katalog",$value->id)->get();

          $harga_min = $data['harga'][$temp[0]->barang]['harga_retail'];
          $harga_max = $data['harga'][$temp[0]->barang]['harga_retail'];

          foreach ($temp as $val) {
            if ($data['harga'][$val->barang]['harga_retail'] <= $harga_min) {
              $harga_min = $data['harga'][$val->barang]['harga_retail'];
            }
            if ($data['harga'][$val->barang]['harga_retail'] >= $harga_max) {
              $harga_max = $data['harga'][$val->barang]['harga_retail'];
            }

            $temp_stok = DB::table('tb_gudang_barang')->where("id_gudang","1")->where("id_barang",$val->barang)->select("*")->get();
            $jumlah_stok += $temp_stok[0]->jumlah;
          }
          $data['multi'][$value->id]['harga_min'] = $harga_min;
          $data['multi'][$value->id]['harga_max'] = $harga_max;
          $data['multi'][$value->id]['stok'] = $jumlah_stok;
        }
      }

      $stok= DB::table('tb_gudang_barang')->where("id_gudang","1")->select("*")->get();
      foreach ($stok as $key => $value) {
        $data['stok'][$value->id_barang]['stok'] = $value->jumlah;
      }

        $cek = array();

      //cek orderan stok
      $orderan_stok = DB::table('tb_barang_keluar as a')->where("a.id_gudang","1")->where("a.status_barang","order")->select("*")->get();
      foreach ($orderan_stok as $key => $value) {
        $cek[$value->no_kwitansi] = $value->no_kwitansi;
      }

      foreach ($data['produk']->items() as $key => $value) { //dd($value);
        $orderan_stok_detail = DB::table('tb_detail_barang_keluar as b')
                        ->where("b.id_barang",$value->barang)
                        ->select("*")->get();
          foreach ($orderan_stok_detail as $k => $v) {
            if(array_key_exists($v->no_kwitansi,$cek)){
              $data['stok'][$v->id_barang]['stok'] -= $v->jumlah;
            }
          }
      }
      //end cek orderan stok

      $brand = DB::table('kt_brand')->where("status","aktif")->select("*")->get();
      foreach ($brand as $key => $value) {
        $data['brand'][$value->id] = $value->img;
      }

      $label = DB::table('kt_label')->select("*")->get();
      foreach ($label as $key => $value) {
        $data['label'][$value->id]['class'] = $value->class;
        $data['label'][$value->id]['nama'] = $value->nama;
      }
      if (isset($data['mainkategoris'])) {
          $data['kategori'] = DB::table('kt_kategori')->where("status","aktif")->where("main_kategori",$data['mainkategoris'])->select("*")->get();
      }else{
          $data['kategori'] = array();
      }
      $data['mainkategori'] = DB::table('tb_main_kategori')->select("*")->get();


      $data['promo'] = DB::table('tb_promo')->whereDate('start','<=',date('Y-m-d'))->whereDate('end','>=',date('Y-m-d'))->get();
      $data['getallpromo'] = array();
      foreach ($data['promo'] as $key => $value) {
        $data['getallpromo'][$value->id_barang]['potongan'] = $value->persentase;
        $data['getallpromo'][$value->id_barang]['nama_promo'] = $value->nama_promo;
      }
      
      return view('SetingKatalog/ViewKatalog',$data);
  }

  public function changekategori($id){
    $data = DB::table('kt_kategori')->where("status","aktif")->where("main_kategori",$id)->select("*")->get();
    echo json_encode($data);
  }

  public function katalogs(Request $post){
    $d=$post->except('_token');
    if ($d['kategori'] != "Semua") {
      $kategori = $d['kategori'];
      $data['kategoris'] = $kategori;
    }
    $nama_barang = $d['nama_barang'];
    $data['nama_barangs'] = $nama_barang;

    if (isset($kategori)) {
      $data['produk'] = DB::table('kt_katalog')
                          ->leftJoin('kt_gambar','kt_gambar.id_katalog','=','kt_katalog.id')
                          ->select("kt_katalog.*","kt_gambar.nama_file")
                          ->where('kt_katalog.status','aktif')
                          ->where('kt_katalog.kategori',$kategori)
                          ->where('nama_barang','like',"%$nama_barang%")
                          ->groupBy("kt_katalog.id")
                          ->get();
    }else{
      $data['produk'] = DB::table('kt_katalog')
                          ->leftJoin('kt_gambar','kt_gambar.id_katalog','=','kt_katalog.id')
                          ->select("kt_katalog.*","kt_gambar.nama_file")
                          ->where('kt_katalog.status','aktif')
                          ->where('nama_barang','like',"%$nama_barang%")
                          ->groupBy("kt_katalog.id")
                          ->get();
    }

      $harga= DB::table('tb_harga')->select("*")->get();
      foreach ($harga as $key => $value) {
        $data['harga'][$value->id_barang]['harga_retail'] = $value->harga_retail;
      }

      $barang= DB::table('tb_barang')->select("*")->get();
      foreach ($barang as $key => $value) {
        $data['barang'][$value->id]['no_sku'] = $value->no_sku;
        $data['barang'][$value->id]['keterangan'] = $value->keterangan;
      }


      $data['multi'] = array();
      foreach ($data['produk'] as $key => $value) {
        if ($value->jenis == "multiple") {
          $harga_min = 0;
          $harga_max = 0;
          $jumlah_stok = 0;
          $temp = DB::table('kt_multiple')->select("*")->where("id_katalog",$value->id)->get();

          $harga_min = $data['harga'][$temp[0]->barang]['harga_retail'];
          $harga_max = $data['harga'][$temp[0]->barang]['harga_retail'];

          foreach ($temp as $val) {
            if ($data['harga'][$val->barang]['harga_retail'] <= $harga_min) {
              $harga_min = $data['harga'][$val->barang]['harga_retail'];
            }
            if ($data['harga'][$val->barang]['harga_retail'] >= $harga_max) {
              $harga_max = $data['harga'][$val->barang]['harga_retail'];
            }

            $temp_stok = DB::table('tb_gudang_barang')->where("id_gudang","1")->where("id_barang",$val->barang)->select("*")->get();
            $jumlah_stok += $temp_stok[0]->jumlah;
          }
          $data['multi'][$value->id]['harga_min'] = $harga_min;
          $data['multi'][$value->id]['harga_max'] = $harga_max;
          $data['multi'][$value->id]['stok'] = $jumlah_stok;
        }
      }

      $stok= DB::table('tb_gudang_barang')->where("id_gudang","1")->select("*")->get();
      foreach ($stok as $key => $value) {
        $data['stok'][$value->id_barang]['stok'] = $value->jumlah;
      }

      //cek orderan stok
      $orderan_stok = DB::table('tb_barang_keluar as a')->where("a.id_gudang","1")->where("a.status_barang","order")->select("*")->get();
      foreach ($orderan_stok as $key => $value) {
        $cek[$value->no_kwitansi] = $value->no_kwitansi;
      }

      foreach ($data['produk']->items() as $key => $value) { //dd($value);
        $orderan_stok_detail = DB::table('tb_detail_barang_keluar as b')
                        ->where("b.id_barang",$value->barang)
                        ->select("*")->get();
          foreach ($orderan_stok_detail as $k => $v) {
            if(array_key_exists($v->no_kwitansi,$cek)){
              $data['stok'][$v->id_barang]['stok'] -= $v->jumlah;
            }
          }
      }
      //end cek orderan stok

      $brand = DB::table('kt_brand')->where("status","aktif")->select("*")->get();
      foreach ($brand as $key => $value) {
        $data['brand'][$value->id] = $value->img;
      }

      $label = DB::table('kt_label')->select("*")->get();
      foreach ($label as $key => $value) {
        $data['label'][$value->id]['class'] = $value->class;
        $data['label'][$value->id]['nama'] = $value->nama;
      }

      $data['kategori'] = DB::table('kt_kategori')->where("status","aktif")->select("*")->get();
      return view('SetingKatalog/ViewKatalog',$data);
  }

  public function setkey($id){
    session_start();
    $_SESSION['key'] = $id;
    echo json_encode($_SESSION);
  }

  public function produk($id){
    session_start();
    $name = un_format_link($id);

    $barang= DB::table('tb_barang')->select("*")->get();
    foreach ($barang as $key => $value) {
      $data['barang'][$value->id]['no_sku'] = $value->no_sku;
      $data['barang'][$value->id]['keterangan'] = $value->keterangan;
    }

      $data['detailproduk'] = DB::table('kt_katalog')
                              ->leftJoin('kt_brand','kt_brand.id','=','kt_katalog.brand')
                              ->leftJoin('kt_multiple','kt_multiple.id_katalog','=','kt_katalog.id')
                              ->where("kt_katalog.id",$_SESSION['key'])
                              ->select("kt_katalog.*","kt_brand.nama_brand","kt_brand.img","kt_multiple.barang as barang_multi")->get();

      $warna = DB::table('kt_color')->where("status","aktif")->select("*")->get();
      $data['warna'] = array();
      foreach ($warna as $key => $value) {
        $data['warna'][$value->hex] = $value->warna;
      }

      if ($data['detailproduk'][0]->jenis == "single") {
        $data['harga'] = DB::table('tb_harga')->where("id_barang",$data['detailproduk'][0]->barang)->select("*")->get();
        $data['stok'] = DB::table('tb_gudang_barang')->where("id_barang",$data['detailproduk'][0]->barang)->where("id_gudang",2)->select("*")->get();
      }else{
        foreach ($data['detailproduk'] as $key => $value) {
          $harga = DB::table('tb_harga')->where("id_barang",$value->barang_multi)->select("*")->get();
          $data['harga'][$value->barang_multi]['harga_retail'] = $harga[0]->harga_retail;

          $stok = DB::table('tb_gudang_barang')->where("id_barang",$value->barang_multi)->where("id_gudang",2)->select("*")->get();
          $data['stok'][$value->barang_multi]['stok'] = $stok[0]->jumlah;

          $pilihan = DB::table('tb_barang')->where("id",$value->barang_multi)->select("*")->get();
          $data['pilihan'][$value->barang_multi]['nama_barang'] = $pilihan[0]->nama_barang;
          $data['pilihan'][$value->barang_multi]['no_sku'] = $pilihan[0]->no_sku;
          $data['pilihan'][$value->barang_multi]['keterangan'] = $pilihan[0]->keterangan;
        }
      }
      $data['gambar'] = DB::table('kt_gambar')
                              ->where("id_katalog",$data['detailproduk'][0]->id)
                              ->select("*")->get();
      return view('SetingKatalog/Detail',$data);
  }

  public function getDetailProduk($id){
    $barang= DB::table('tb_barang')->select("*")->get();
    foreach ($barang as $key => $value) {
      $data['barang'][$value->id]['no_sku'] = $value->no_sku;
      $data['barang'][$value->id]['keterangan'] = $value->keterangan;
      $data['barang'][$value->id]['nama_barang'] = $value->nama_barang;
    }
    $brand = DB::table('kt_brand')->where("status","aktif")->select("*")->get();
    foreach ($brand as $key => $value) {
      $data['brand'][$value->id] = $value->img;
    }

    $kategori = DB::table('kt_kategori')->where("status","aktif")->select("*")->get();
    foreach ($kategori as $key => $value) {
      $data['kategori'][$value->id] = $value->nama_kategori;
    }

    $label = DB::table('kt_label')->where("status","aktif")->select("*")->get();
    foreach ($label as $key => $value) {
      $data['label'][$value->id]['nama'] = $value->nama;
      $data['label'][$value->id]['class'] = $value->class;
    }

    $data['detailproduk'] = DB::table('kt_katalog')
                            ->leftJoin('kt_brand','kt_brand.id','=','kt_katalog.brand')
                            ->leftJoin('kt_multiple','kt_multiple.id_katalog','=','kt_katalog.id')
                            ->where("kt_katalog.id",$id)
                            ->select("kt_katalog.*","kt_brand.nama_brand","kt_brand.img","kt_multiple.barang as barang_multi","kt_multiple.berat_multiple")->get();

    $data['subkat'] = DB::table('kt_kategori')
                      ->leftJoin('tb_main_kategori','kt_kategori.main_kategori','=','tb_main_kategori.id')
                      ->where('kt_kategori.id',$data['detailproduk'][0]->kategori)->get();

    $warna = DB::table('kt_color')->where("status","aktif")->select("*")->get();
    $data['warna'] = array();
    foreach ($warna as $key => $value) {
      $data['warna'][$value->hex] = $value->warna;
    }
    if ($data['detailproduk'][0]->jenis == "single") {
      $data['harga'] = DB::table('tb_harga')->where("id_barang",$data['detailproduk'][0]->barang)->select("*")->get();
      $data['stok'] = DB::table('tb_gudang_barang')->where("id_barang",$data['detailproduk'][0]->barang)->where("id_gudang",1)->select("*")->get();


      /*$orderan_stok = DB::table('tb_barang_keluar as a')
                        ->join('tb_detail_barang_keluar as b','a.no_kwitansi','=','b.no_kwitansi')
                        ->where("a.id_gudang","1")->where("a.status_barang","order")
                        ->where("id_barang",$data['detailproduk'][0]->barang)
                        ->select("*")->get();
      if(count($orderan_stok) > 0){
        $data['stok'][0]->jumlah -= $orderan_stok[0]->jumlah;
      }*/


      $cek = array();
      $orderan_stok = DB::table('tb_barang_keluar as a')->where("a.id_gudang","1")->where("a.status_barang","order")->select("*")->get();
      foreach ($orderan_stok as $key => $value) {
        $cek[$value->no_kwitansi] = $value->no_kwitansi;
      }
      $orderan_stok_detail = DB::table('tb_detail_barang_keluar as b')
                        ->where("b.id_barang",$data['detailproduk'][0]->barang)
                        ->select("*")->get();
      foreach ($orderan_stok_detail as $k => $v) {
        if(array_key_exists($v->no_kwitansi,$cek)){
            $data['stok'][0]->jumlah -= $v->jumlah;
        }
      }

      $data['id_barang'] = $data['detailproduk'][0]->barang;

      $promo = DB::table('tb_promo')->whereDate('start','<=',date('Y-m-d'))->whereDate('end','>=',date('Y-m-d'))->where('id_barang',$data['detailproduk'][0]->barang)->get();
      foreach ($promo as $key => $value) {
        $data['promosingle'][$value->id_barang]['potongan'] = $value->persentase;
        $data['promosingle'][$value->id_barang]['nama_promo'] = $value->nama_promo;
        $data['promosingle'][$value->id_barang]['start'] = date("j M Y", strtotime($value->start));
        $data['promosingle'][$value->id_barang]['end'] = date("j M Y", strtotime($value->end));
      }
        

    }else{
      foreach ($data['detailproduk'] as $key => $value) {
        $harga = DB::table('tb_harga')->where("id_barang",$value->barang_multi)->select("*")->get();
        $data['harga'][$value->barang_multi]['harga'] = $harga[0]->harga_retail;
        $stok = DB::table('tb_gudang_barang')->where("id_barang",$value->barang_multi)->where("id_gudang",1)->select("*")->get();
        $data['stok'][$value->barang_multi]['stok'] = $stok[0]->jumlah;

        /*$orderan_stok = DB::table('tb_barang_keluar as a')
                        ->join('tb_detail_barang_keluar as b','a.no_kwitansi','=','b.no_kwitansi')
                        ->where("a.id_gudang","1")->where("a.status_barang","order")->where("id_barang",$value->barang_multi)
                        ->select("*")->get();
        if(count($orderan_stok) > 0){
          $data['stok'][$value->barang_multi]['stok'] -= $orderan_stok[0]->jumlah;
        }*/

        $cek = array();
        $orderan_stok = DB::table('tb_barang_keluar as a')->where("a.id_gudang","1")->where("a.status_barang","order")->select("*")->get();
        foreach ($orderan_stok as $ke => $val) {
          $cek[$val->no_kwitansi] = $val->no_kwitansi;
        }
        $orderan_stok_detail = DB::table('tb_detail_barang_keluar as b')
                        ->where("b.id_barang",$value->barang_multi)
                        ->select("*")->get();
        foreach ($orderan_stok_detail as $k => $v) {
          if(array_key_exists($v->no_kwitansi,$cek)){
             $data['stok'][$value->barang_multi]['stok'] -= $v->jumlah;
          }
        }

        $pilihan = DB::table('tb_barang')->where("id",$value->barang_multi)->select("*")->get();
        $data['pilihan'][$value->barang_multi]['nama_barang'] = $pilihan[0]->nama_barang;
        $data['pilihan'][$value->barang_multi]['no_sku'] = $pilihan[0]->no_sku;
        $data['pilihan'][$value->barang_multi]['keterangan'] = $pilihan[0]->keterangan;
      }
    }
    $data['gambar'] = DB::table('kt_gambar')
                            ->where("id_katalog",$data['detailproduk'][0]->id)
                            ->select("*")->get();
    echo json_encode($data);
  }

  public function downloadkatalog(){
    $data['produk'] = DB::table('kt_katalog')
                        ->leftJoin('kt_gambar','kt_gambar.id_katalog','=','kt_katalog.id')
                        ->select("kt_katalog.*","kt_gambar.nama_file")
                        ->where('kt_katalog.status','aktif')
                        ->orderBy('kt_katalog.kategori','ASC')
                        ->groupBy("kt_katalog.id")
                        ->get();

      $harga= DB::table('tb_harga')->select("*")->get();
      foreach ($harga as $key => $value) {
        $data['harga'][$value->id_barang]['harga_retail'] = $value->harga_retail;
      }

      $data['multi'] = array();
      foreach ($data['produk'] as $key => $value) {
        if ($value->jenis == "multiple") {
          $harga_min = 0;
          $harga_max = 0;
          $jumlah_stok = 0;
          $temp = DB::table('kt_multiple')->select("*")->where("id_katalog",$value->id)->get();

          $harga_min = $data['harga'][$temp[0]->barang]['harga_retail'];
          $harga_max = $data['harga'][$temp[0]->barang]['harga_retail'];

          foreach ($temp as $val) {
            if ($data['harga'][$val->barang]['harga_retail'] <= $harga_min) {
              $harga_min = $data['harga'][$val->barang]['harga_retail'];
            }
            if ($data['harga'][$val->barang]['harga_retail'] >= $harga_max) {
              $harga_max = $data['harga'][$val->barang]['harga_retail'];
            }

            $temp_stok = DB::table('tb_gudang_barang')->where("id_gudang","1")->where("id_barang",$val->barang)->select("*")->get();
            $jumlah_stok += $temp_stok[0]->jumlah;
          }
          $data['multi'][$value->id]['harga_min'] = $harga_min;
          $data['multi'][$value->id]['harga_max'] = $harga_max;
          $data['multi'][$value->id]['stok'] = $jumlah_stok;
        }
      }

      $stok= DB::table('tb_gudang_barang')->where("id_gudang","1")->select("*")->get();
      foreach ($stok as $key => $value) {
        $data['stok'][$value->id_barang]['stok'] = $value->jumlah;
      }

      $brand = DB::table('kt_brand')->where("status","aktif")->select("*")->get();
      foreach ($brand as $key => $value) {
        $data['brand'][$value->id] = $value->img;
      }

      $label = DB::table('kt_label')->select("*")->get();
      foreach ($label as $key => $value) {
        $data['label'][$value->id]['class'] = $value->class;
        $data['label'][$value->id]['nama'] = $value->nama;
      }

      $no=1;
      $index=0;
      foreach ($data['produk'] as $key => $value) {
        $data['produks'][$index][$no]['id'] = $value->id;
        $data['produks'][$index][$no]['barang'] = $value->barang;
        $data['produks'][$index][$no]['nama_barang'] = $value->nama_barang;
        $data['produks'][$index][$no]['berat'] = $value->berat;
        $data['produks'][$index][$no]['kategori'] = $value->kategori;
        $data['produks'][$index][$no]['brand'] = $value->brand;
        $data['produks'][$index][$no]['warna'] = $value->warna;
        $data['produks'][$index][$no]['deskripsi'] = $value->deskripsi;
        $data['produks'][$index][$no]['deskripsi_seo'] = $value->deskripsi_seo;
        $data['produks'][$index][$no]['keyword_seo'] = $value->keyword_seo;
        $data['produks'][$index][$no]['label'] = $value->label;
        $data['produks'][$index][$no]['jenis'] = $value->jenis;
        $data['produks'][$index][$no]['status'] = $value->status;
        $data['produks'][$index][$no]['create'] = $value->create;
        $data['produks'][$index][$no]['nama_file'] = $value->nama_file;
        if ($no % 12 == 0) {
          $index++;
        }
        $no++;
      }
      //dd($data['produks']);
      return view('SetingKatalog/DownloadKatalogs',$data);
  }


  public function editkatalogproduk($id){
    if(Auth::user()->level == "1" || (Auth::user()->level == "3" && Auth::user()->gudang == "2")){
        $data['main_kategori'] = DB::table('tb_main_kategori as a')->select("*")->get();
        $data['color'] = DB::table('kt_color as a')->where("a.status","aktif")->select("*")->get();
        $data['label'] = DB::table('kt_label as a')->where("a.status","aktif")->select("*")->get();
        $data['brand'] = DB::table('kt_brand as a')->where("a.status","aktif")->select("*")->get();

        $data['barang'] = DB::table('tb_barang as a')
                          ->join('tb_harga as b','b.id_barang','=','a.id')
                          ->select("a.*","harga","harga_retail","qty1","pot1","qty2","pot2","qty3","pot3")
                          ->where("a.status","=","aktif")->whereNull('a.organized')->get();

        $data['gambar'] = DB::table('kt_gambar as a')->where("a.id_katalog",$id)->select("*")->get();

        $brg = DB::table('tb_barang as a')->get();
        foreach ($brg as $key => $value) {
          $data['brg'][$value->id]['nama_barang'] = $value->nama_barang;
        }

        $data['produk'] = DB::table('kt_katalog as a')
                ->leftJoin('kt_multiple as b','b.id_katalog','=','a.id')
                ->leftJoin('tb_barang as c','c.id','=','b.barang')
                ->where("a.id",$id)->select("a.*","b.barang as barang_multi","b.berat_multiple","a.id as id_katalog","c.nama_barang as nama_barang_detail")->get();
        if (count($data['produk'])>0) {
          $data['kategori'] = DB::table('kt_kategori as a')->where("a.main_kategori",$data['produk'][0]->main_kategori)->select("*")->get();
        }else{
          $data['kategori'] = array();
        }

        if ($data['produk'][0]->jenis == "single") {
          return view('SetingKatalog/EditSingleProduk',$data);
        }else{
          return view('SetingKatalog/EditMultiProduk',$data);
        }
    }else{
        return redirect()->back();
    }
  }

}
