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

class HumanController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  //suplayer
  public function datasuplayer(){
    if (role()) {
      $data['nama_download'] = "Data Suplayer";
      $data['suplayer'] =$this->model->getSuplayer();
      return view('DataSuplayer',$data);
    }else{
      return view ('Denied');
    }
  }
  public function datasuplayers(Request $post){
    if (role()) {
      $key = $post->only('kota')['kota'];
      $data['kota'] = $key;
      $data['nama_download'] = "Data Suplayer";
      $data['suplayer'] =$this->model->getSuplayerByKota($key);
      return view('DataSuplayer',$data);
    }else{
      return view ('Denied');
    }
  }
  public function inputsuplayer(){
    if (role() && (Auth::user()->gudang == "1")) {
      $d['bm'] = DB::table('tb_suplayer as a')->select("*")->where("a.status","=","aktif")->orderBy('id', 'DESC')->limit(1)->get();
      if(count($d['bm']) > 0){
        $var = substr($d['bm'][0]->id_suplayer,9);
        $data['number'] = str_pad($var + 1, 4, '0', STR_PAD_LEFT);;
      }else{
        $data['number'] = "0001";
      }
      return view('InputSuplayer',$data);
    }else{
      return view ('Denied');
    }
  }

  public function caridetailkaryawan($id){
    $brand = DB::table('tb_karyawan as a')->where('a.nama',"like","%$id%")->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->select("*")->get();
    echo json_encode($brand);
  }

  public function inputsuplayeract(Request $post){
    $data = $post->except('_token');
    $data['status'] = "aktif";
    $this->model->insertSuplayer($data);
    return redirect()->route('datasuplayer')->with('success','Berhasil');
  }
  public function deleteSuplayer($id){
    $this->model->delSuplayer($id);
    return redirect()->back()->with('success','Berhasil');
  }
  public function editSuplayer($id){
    $data = $this->model->getSuplayerby($id);
    echo json_encode($data);
  }
  public function updatesuplayer(Request $post){
    $data = $post->except('_token','id');
    $id = $post->only('id');
    $this->model->updateSuplayer($data,$id);
    return redirect()->route('datasuplayer')->with('success','Berhasil');
  }

  //konsumen
  public function datakonsumen(){
    if (role()) {
      $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik","=",Auth::user()->nik)->get();
      if (Auth::user()->level == "1") {
        $data['kategori'] = DB::table('tb_kategori as a')->select("*")->get();
        $data['konsumen'] = DB::table('tb_konsumen as a')
        ->join('tb_kategori as b','b.id','=','a.kategori')
        ->leftJoin('tb_karyawan as c','c.id','=','a.pengembang')
        ->leftJoin('tb_konsumen as d','d.id','=','a.pengembang')
        ->leftJoin('members as e','e.no_hp','=','a.no_hp')
        ->select("a.*","b.nama_kategori","c.nama as karyawan","d.nama_pemilik as konsumen","e.email as email")
        ->where("a.status","=","aktif")
        ->get();
      }else if (Auth::user()->level =="5") {
                  $data['kategori'] = DB::table('tb_kategori as a')->select("*")->where("a.id","=",Auth::user()->gudang)->get();
                  $data['konsumen'] = DB::table('tb_konsumen as a')
                  ->join('tb_kategori as b','b.id','=','a.kategori')
                  ->leftJoin('tb_karyawan as c','c.id','=','a.pengembang')
                  ->leftJoin('tb_konsumen as d','d.id','=','a.pengembang')
                  ->leftJoin('members as e','e.no_hp','=','a.no_hp')
                  ->select("a.*","b.nama_kategori","c.nama as karyawan","d.nama_pemilik as konsumen","e.email as email")
                  ->where("a.status","=","aktif")
                  ->where("a.kategori","=",Auth::user()->gudang)
                  ->where("a.pengembang","=",$p[0]->id)
                  ->get();
      }else if (Auth::user()->gudang =="1") {
        $data['kategori'] = DB::table('tb_kategori as a')->select("*")->where("a.id","<>","")->get();
        $data['konsumen'] = DB::table('tb_konsumen as a')
                ->join('tb_kategori as b','b.id','=','a.kategori')
                ->leftJoin('tb_karyawan as c','c.id','=','a.pengembang')
                ->leftJoin('tb_konsumen as d','d.id','=','a.pengembang')
                ->leftJoin('members as e','e.no_hp','=','a.no_hp')
                ->select("a.*","b.nama_kategori","c.nama as karyawan","d.nama_pemilik as konsumen","e.email as email")
                ->where("a.kategori","<>","")
                ->where("a.status","=","aktif")
                ->get();
      }else{
        $data['kategori'] = DB::table('tb_kategori as a')->select("*")->where("a.id",Auth::user()->gudang)->get();
        $data['konsumen'] = DB::table('tb_konsumen as a')
                ->join('tb_kategori as b','b.id','=','a.kategori')
                ->leftJoin('tb_karyawan as c','c.id','=','a.pengembang')
                ->leftJoin('tb_konsumen as d','d.id','=','a.pengembang')
                ->leftJoin('members as e','e.no_hp','=','a.no_hp')
                ->select("a.*","b.nama_kategori","c.nama as karyawan","d.nama_pemilik as konsumen","e.email as email")
                ->where("a.kategori","=",Auth::user()->gudang)
                ->where("a.status","=","aktif")
                ->get();
      }
      $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","aktif")->get();
      $data['kar'] = DB::table('tb_karyawan as a')->select("*")->get();
      $data['nama_download'] = "Data Konsumen";
      foreach ($data['kar'] as $key => $value) {
        $data['karyawan'][$value->id] = $value->nama;
      }

      $data['kons'] = DB::table('tb_konsumen as a')->select("*")->get();
      foreach ($data['kons'] as $key => $value) {
        $data['customer'][$value->id] = $value->nama_pemilik;
      }

      $data['provinsi'] =  DB::table('provinces')->get();

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

      return view('DataKonsumen',$data);
    }else{
      return view ('Denied');
    }
  }
  public function datakonsumens(Request $post){
    if (role()) {
      if (isset($post->only('kategori')['kategori'])) {
        if($post->only('kategori')['kategori'] != "all"){
          $data['a.kategori'] = $post->only('kategori')['kategori'];
        }
       }
      if (isset($post->only('kota')['kota'])) {
        $data['a.kota'] = $post->only('kota')['kota'];
      }
      if (Auth::user()->level == "5") {
        $p = DB::table('tb_karyawan as a')->select("a.id")->where("a.nik","=",Auth::user()->nik)->get();
        $data['a.pengembang'] = $p[0]->id;
        $data['a.kategori'] = Auth::user()->gudang;
      }

      if(isset($data)){
          $data['konsumen'] = DB::table('tb_konsumen as a')
          ->join('tb_kategori as b','b.id','=','a.kategori')
          ->leftJoin('tb_karyawan as c','c.id','=','a.pengembang')
          ->leftJoin('tb_konsumen as d','d.id','=','a.pengembang')
          ->leftJoin('members as e','e.no_hp','=','a.no_hp')
          ->select("a.*","b.nama_kategori","c.nama as karyawan","d.nama_pemilik as konsumen","e.email as email")
          ->where("a.status","=","aktif")->where($data)->get();
      }else{
          $data['konsumen'] = DB::table('tb_konsumen as a')
          ->join('tb_kategori as b','b.id','=','a.kategori')
          ->leftJoin('tb_karyawan as c','c.id','=','a.pengembang')
          ->leftJoin('tb_konsumen as d','d.id','=','a.pengembang')
          ->leftJoin('members as e','e.no_hp','=','a.no_hp')
          ->select("a.*","b.nama_kategori","c.nama as karyawan","d.nama_pemilik as konsumen","e.email as email")
          ->where("a.status","=","aktif")->get();
      }
      if(isset($data['a.kategori'])){
         $data['v_kategori'] = $data['a.kategori'];
      }
      if(isset($data['a.kota'])){
         $data['v_kota'] = $data['a.kota'];
      }
      if (Auth::user()->gudang == "1") {
         $data['kategori'] = DB::table('tb_kategori as a')->select("*")->get();
      }else{
          $data['kategori'] = DB::table('tb_kategori as a')->select("*")->where("a.id","=",Auth::user()->gudang)->get();
      }

      $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","aktif")->get();
      $data['kar'] = DB::table('tb_karyawan as a')->select("*")->get();
      $data['nama_download'] = "Data Konsumen";
      foreach ($data['kar'] as $key => $value) {
        $data['karyawan'][$value->id] = $value->nama;
      }

      $data['kons'] = DB::table('tb_konsumen as a')->select("*")->get();
      foreach ($data['kons'] as $key => $value) {
        $data['customer'][$value->id] = $value->nama_pemilik;
      }

      $data['provinsi'] =  DB::table('provinces')->get();

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

      return view('DataKonsumen',$data);
    }else{
      return view ('Denied');
    }
  }
  public function inputkonsumenact(Request $post){
    $data = $post->except('_token');
    if($data['alamat'] == null || $data['alamat'] == ""){
        $data['alamat'] = "-";
    }
    if($data['keterangan'] == null || $data['keterangan'] == ""){
        $data['keterangan'] = "-";
    }

    $data['status'] = "aktif";
    $d = DB::table('tb_konsumen as a')->select("*")->where("a.tanggal","=",date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
    if(count($d) > 0){
      $var = substr($d[0]->id_konsumen,9);
      $number= str_pad($var + 1, 3, '0', STR_PAD_LEFT);;
    }else{
      $number = "001";
    }
    $data['id_konsumen']='PLG'.date('ymd').$number;
    $d['bm'] = DB::table('tb_konsumen as a')->select("*")->where("a.no_hp","=",$data['no_hp'])->orWhere("a.id_konsumen","=",$data['id_konsumen'])->get();
    if(count($d['bm']) > 0){
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }else{
      $kar['nik'] = $data['nik'];
      $kar['nama'] = $data['nama_pemilik'];
      $kar['nama_lengkap'] = $data['nama_pemilik'];
      $kar['jabatan'] = 10;
      $kar['alamat'] = $data['alamat'];
      $kar['kecamatan'] = $data['kecamatan'];
      $kar['kota'] = $data['kota'];
      $kar['provinsi'] = $data['provinsi'];
      $kar['no_hp'] = $data['no_hp'];
      $kar['mulai_kerja'] = date('Y-m-d');
      $kar['file'] = "";
      $kar['saldo'] = 0;
      $kar['status'] = "aktif";
      $kar['pengembang'] = $data['pengembang'];
      $kar['leader'] = $data['leader'];
      $kar['manager'] = $data['manager'];
      $kar['referal_by'] = $data['referal_by'];
      $kar['reseller'] = $data['reseller'];
      $kar['agen'] = $data['agen'];
      $kar['distributor'] = $data['distributor'];
      $kar['id_divisi'] = 6;
      $kar['jenis_konsumen'] = $data['jenis_konsumen'];
      DB::table('tb_karyawan')->insert($kar);
      $this->model->insertKonsumen($data);

    }
    return redirect()->route('datakonsumen')->with('success','Berhasil');
  }
  public function inputkonsumen(){
    if (role()) {
      $d['bm'] = DB::table('tb_konsumen as a')->select("*")->where("a.status","=","aktif")->where("a.tanggal","=",date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();
      $p = DB::table('tb_karyawan as a')->select("*")->where("a.nik","=",Auth::user()->nik)->get();
      $data['idpengembang'] = $p[0]->id;
      $data['namapengembang'] = $p[0]->nama;
      $data['idleader'] = $p[0]->pengembang;
      $data['idmanager'] = $p[0]->leader;
      
      
      
      if(count($d['bm']) > 0){
        $var = substr($d['bm'][0]->id_konsumen,9);
        $data['number'] = str_pad($var + 1, 3, '0', STR_PAD_LEFT);;
      }else{
        $data['number'] = "001";
      }
      $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","=","aktif")->get();
      $data['kategori'] = DB::table('tb_kategori as a')->select("*")->get();
      $data['provinsi'] =  DB::table('provinces')->get();
      return view('InputKonsumen',$data);
    }else{
      return view ('Denied');
    }
  }
  public function deleteKonsumen($id,$no_hp){
    $this->model->delKonsumen($id);

    $data['status'] = "non aktif";
    DB::table('tb_karyawan')
        ->where('no_hp','=',$no_hp)
        ->update($data);

    return redirect()->back()->with('success','Berhasil');
  }
  public function editKonsumen($id){
    $data['konsumen'] = $this->model->getKonsumenby($id);
    
    foreach($data['konsumen'] as $key => $value){
        $referal = DB::table('tb_karyawan')->where('id',$value->referal_by)->get();
        if(count($referal) > 0){
            $data['konsumen'][$key]->nama_referal = $referal[0]->nama;
        }else{
            $data['konsumen'][$key]->nama_referal = "";
        }
        
        $reseller = DB::table('tb_karyawan')->where('id',$value->reseller)->get();
        if(count($reseller) > 0){
            $data['konsumen'][$key]->nama_reseller = $reseller[0]->nama;
        }else{
            $data['konsumen'][$key]->nama_reseller = "";
        }
        
        $agen = DB::table('tb_karyawan')->where('id',$value->agen)->get();
        if(count($agen) > 0){
            $data['konsumen'][$key]->nama_agen = $agen[0]->nama;
        }else{
            $data['konsumen'][$key]->nama_agen = "";
        }
        
        $distributor = DB::table('tb_karyawan')->where('id',$value->distributor)->get();
        if(count($distributor) > 0){
            $data['konsumen'][$key]->nama_distributor = $distributor[0]->nama;
        }else{
            $data['konsumen'][$key]->nama_distributor = "";
        }
    }
    
    $data['kabupaten'] = DB::table('regencies as a')
                         ->select("*")
                         ->where("a.province_id","=",$data['konsumen'][0]->provinsi)
                         ->get();
    $data['kecamatan'] = DB::table('districts as a')
                         ->select("*")
                         ->where("a.regency_id","=",$data['konsumen'][0]->kota)
                         ->get();
    echo json_encode($data);
  }

  public function getkabupaten($id){
    $data = DB::table('regencies')
                      ->select("*")
                      ->where('nama_provinsi',$id)
                      ->orWhere('province_id',$id)
                      ->get();
    echo json_encode($data);
  }

  public function getkecamatan($id){
    $data = DB::table('districts')
                      ->select("*")
                      ->where('regency_name',$id)
                      ->orWhere('regency_id',$id)
                      ->get();
    echo json_encode($data);
  }

  public function getkabupatens($id){
    $data = DB::table('regencies')
                      ->select("*")
                      ->where('province_id',$id)
                      ->get();
    echo json_encode($data);
  }

  public function getkecamatans($id){
    $data = DB::table('districts')
                      ->select("*")
                      ->where('regency_id',$id)
                      ->get();
    echo json_encode($data);
  }

  public function updatekonsumen(Request $post){
    $data = $post->except('_token','id','pengembang','leader','manager','old_hp','referal_by','reseller','agen','distributor');
    if($post->only('pengembang')['pengembang'] != null){
      $data['pengembang'] = $post->only('pengembang')['pengembang'];
      $kar['pengembang'] = $data['pengembang'];
    }
    if($post->only('leader')['leader'] != null){
      $data['leader'] = $post->only('leader')['leader'];
      $kar['leader'] = $data['leader'];
    }
    if($post->only('manager')['manager'] != null){
      $data['manager'] = $post->only('manager')['manager'];
      $kar['manager'] = $data['manager'];
    }
    
    if($post->only('referal_by')['referal_by'] != null){
      $data['referal_by'] = $post->only('referal_by')['referal_by'];
      $kar['referal_by'] = $data['referal_by'];
    }
    if($post->only('reseller')['reseller'] != null){
      $data['reseller'] = $post->only('reseller')['reseller'];
      $kar['reseller'] = $data['reseller'];
    }
    if($post->only('agen')['agen'] != null){
      $data['agen'] = $post->only('agen')['agen'];
      $kar['agen'] = $data['agen'];
    }
    if($post->only('distributor')['distributor'] != null){
      $data['distributor'] = $post->only('distributor')['distributor'];
      $kar['distributor'] = $data['distributor'];
    }
    
    $id = $post->only('id');

    $this->model->updateKonsumen($data,$id);

    $kar['nik'] = $data['nik'];
    $kar['nama'] = $data['nama_pemilik'];
    $kar['nama_lengkap'] = $data['nama_pemilik'];
    $kar['alamat'] = $data['alamat'];
    $kar['no_hp'] = $data['no_hp'];
    $kar['jenis_konsumen'] = $data['jenis_konsumen'];
    $kar['kecamatan'] = $data['kecamatan'];
    $kar['kota'] = $data['kota'];
    $kar['provinsi'] = $data['provinsi'];
    
    $mems['level'] = $data['jenis_konsumen'];
    $mems['no_hp'] = $data['no_hp'];
    $mems['name'] = $data['nama_pemilik'];
    DB::table('tb_karyawan')->where('nik',$data['nik'])->update($kar);
    DB::table('members')->where('no_hp',$post->old_hp)->update($mems);

    return redirect()->route('datakonsumen')->with('success','Berhasil');
  }

  //karyawan
  public function datakaryawan(){
    if (role()) {
      $data['nama_download'] = "Data Karyawan";
      $data['karyawan'] = DB::table('tb_karyawan as a')
                            ->join('tb_jabatan as c','c.id','=','a.jabatan')
                            ->join('pay_divisi as d','d.id_divisi','=','a.id_divisi')
                            ->select("a.*","c.nama_jabatan","d.nama_divisi")
                            ->where("a.status","=","aktif")
                            ->where("a.jabatan","<>","10")
                            ->get();
      $data['jabatan'] =$this->model->getJabatan();
      $data['divisi'] =$this->model->getDivisi();
      $data['name_karyawan'] = array();
      $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();
      foreach($data['karyawan'] as $val){
          $data['name_karyawan'][$val->id] = $val->nama;
      }
      
      $data['provinsi'] =  DB::table('provinces')->get();

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
      
      
      return view('DataKaryawan',$data);
    }else{
      return view ('Denied');
    }
  }
  public function inputkaryawan(){
    if (role()) {
      $data['provinsi'] =  DB::table('provinces')->get();
      $data['jabatan'] =$this->model->getJabatan();
      $data['divisi'] =$this->model->getDivisi();
      $data['pengembang'] = DB::table('tb_karyawan as a')->select("*")->where("a.status","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")->get();
      return view('InputKaryawan',$data);
    }else{
      return view ('Denied');
    }
  }
  public function inputkaryawanact(Request $post){
    $data = $post->except('_token','file','nama_leader','nama_pengembang');

    $a['nama_investor'] = $data['nama'];
    $a['nama_lengkap'] = $data['nama_lengkap'];
    $a['nik'] = $data['nik'];
    $a['alamat'] = $data['alamat'];
    $a['no_hp'] = $data['no_hp'];
    $a['keterangan'] = "-";
    $a['no_rekening'] = $data['no_rekening'];
    $a['ats_bank'] = $data['ats_bank'];
    $a['nama_bank'] = $data['nama_bank'];
    $a['use'] = "yes";
    $a['saldo'] = 0;
    
    $a['status'] = "aktif";
    $a['ket'] = "";
  
    
    $cek = DB::table('tb_karyawan as a')->select("*")->where("a.nama",$data['nama'])->orWhere("a.nik",$data['nik'])->get();
    if (count($cek) > 0) {
      return redirect()->back()->withErrors(['msg', 'The Message']);
    }else{
        if ($post->hasFile('file')) {
          $target_dir = "gambar/file/";
          $passname = "file".date("ymdhms").'.'.request()->file->getClientOriginalExtension();
          $target_file = $target_dir . $passname;
          move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
          $data['file'] = $passname;
          $data['status'] = "aktif";
          $x = $this->model->insertKaryawan($data);

          //

          if ($x) {
              $cek_pengembang = DB::table('tb_investor')->where('nama_investor',$post->nama_pengembang)->get();
              $cek_leader = DB::table('tb_investor')->where('nama_investor',$post->nama_leader)->get();
              if(count($cek_pengembang) > 0){
                  $a['pengembang'] = $cek_pengembang[0]->id;
              }
              if(count($cek_leader) > 0){
                  $a['leader'] = $cek_leader[0]->id;
              }

              DB::table('tb_investor')->insert($a);
          }
          //

          return redirect()->route('datakaryawan')->with('success','Berhasil');
        }else{
          $data['file'] = "";
          $data['status'] = "aktif";
          $x = $this->model->insertKaryawan($data);
          if ($x) {
              $cek_pengembang = DB::table('tb_investor')->where('nama_investor',$post->nama_pengembang)->get();
              $cek_leader = DB::table('tb_investor')->where('nama_investor',$post->nama_leader)->get();
              if(count($cek_pengembang) > 0){
                  $a['pengembang'] = $cek_pengembang[0]->id;
              }
              if(count($cek_leader) > 0){
                  $a['leader'] = $cek_leader[0]->id;
              }
              DB::table('tb_investor')->insert($a);
          }
          return redirect()->route('datakaryawan')->with('success','Berhasil');
        }
    }
  }
  public function deleteKaryawan($id,$no_hp){
    $this->model->delKaryawan($id);

    $data['status'] = "non aktif";
    DB::table('tb_konsumen')
        ->where('no_hp','=',$no_hp)
        ->update($data);

    return redirect()->back()->with('success','Berhasil');
  }
  public function editKaryawan($id){
    $data = $this->model->getKaryawanby($id);
    
    
    $data['kabupaten'] = DB::table('regencies as a')
                         ->select("*")
                         ->where("a.province_id","=",$data[0]->provinsi)
                         ->get();
    $data['kecamatan'] = DB::table('districts as a')
                         ->select("*")
                         ->where("a.regency_id","=",$data[0]->kota)
                         ->get();
    
    
    echo json_encode($data);
  }
  public function updatekaryawan(Request $post){
    $data = $post->except('_token','file','id','old_nik','nama_pengembang','nama_leader','old_hp');
    $id = $post->only('id');
    $old_nik = $post->only('old_nik')['old_nik'];

    $dtid['karyawan'] = $post->only('id')['id'];

    if ($post->hasFile('file')) {
      $target_dir = "gambar/file/";
      $passname = "file".date("ymdhms").'.'.request()->file->getClientOriginalExtension();
      $target_file = $target_dir . $passname;
      move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
      $data['file'] = $passname;
    }

    $kons['nik'] = $data['nik'];
    $kons['nama_pemilik'] = $data['nama_lengkap'];
    $kons['alamat'] = $data['alamat'];
    $kons['no_hp'] = $data['no_hp'];
    $kons['pengembang'] = $data['pengembang'];
    $kons['leader'] = $data['leader'];
    
    $kons['kecamatan'] = $data['kecamatan'];
    $kons['kota'] = $data['kota'];
    $kons['provinsi'] = $data['provinsi'];

    DB::table('tb_konsumen')->where('no_hp',$post->old_hp)->update($kons);
    
    $mems['no_hp'] = $data['no_hp'];
    $mems['name'] = $data['nama'];
    DB::table('members')->where('no_hp',$post->old_hp)->update($mems);

    
    $this->model->updateKaryawan($data,$id);

    $u['nik'] = $data['nik'];
    $u['username'] = $data['nama'];
    $u['name'] = $data['nama_lengkap'];
    DB::table('users')->where('nik','=',$old_nik)->update($u);

    $x['nik'] = $data['nik'];
    $x['nama_investor'] = $data['nama'];
    $x['nama_lengkap'] = $data['nama_lengkap'];
    $x['alamat'] = $data['alamat'];
    $x['no_hp'] = $data['no_hp'];
    $x['no_rekening'] = $data['no_rekening'];
    $x['ats_bank'] = $data['ats_bank'];
    $x['nama_bank'] = $data['nama_bank'];

    $pengembang = DB::table('tb_investor')->where('nama_investor',$post->only('nama_pengembang'))->get();
    if(count($pengembang) > 0){
       $x['pengembang'] = $pengembang[0]->id;
    }
    $leader = DB::table('tb_investor')->where('nama_investor',$post->only('nama_leader'))->get();
    if(count($leader) > 0){
       $x['leader'] = $leader[0]->id;
    }

    DB::table('tb_investor')->where('nik','=',$old_nik)->update($x);

    $upgd['kepala_gudang'] = $data['nama'];
    DB::table('tb_gudang')->where($dtid)->update($upgd);

    return redirect()->route('datakaryawan')->with('success','Berhasil');
  }


  public function getSuplayer()
  {
    $data = DB::table('tb_suplayer as a')
                             ->select("*")
                             ->where("a.status","=","aktif")
                             ->get();
    echo json_encode($data);
  }

  public function inputinvestor(){
    if (role()) {
      $data['investor'] = DB::table('tb_investor as a')->select("a.*")->where("status","=","aktif")->get();
      return view('InputInvestor',$data);
    }else{
      return view ('Denied');
    }
  }

  public function inputinvestoract(Request $post){
    $data = $post->except('_token');
    $data['status'] = "aktif";
    $q = DB::table('tb_investor')->insert($data);

    if($q){
      $a['nama_lengkap'] = $data['nama_lengkap'];
      $a['nama'] = $data['nama_investor'];
      $a['nik'] = $data['nik'];
      $a['jabatan'] = 6;
      $a['alamat'] = $data['alamat'];
      $a['no_hp'] = $data['no_hp'];
      $a['mulai_kerja'] = date('Y-m-d');
      $a['file'] = " ";
      $a['no_rekening'] = $data['no_rekening'];
      $a['ats_bank'] = $data['ats_bank'];
      $a['nama_bank'] = $data['nama_bank'];
      $a['use'] = "yes";
      $a['saldo'] = 0;
      $a['status'] = "aktif";
   
      DB::table('tb_karyawan')->insert($a);
    }

    return redirect()->route('datainvestor')->with('success','Berhasil');
  }

  public function datainvestor(){
    if (role()) {
      $data['nama_download'] = "Data Investor";
      $data['investor'] = DB::table('tb_investor as a')
                          ->select("a.*")
                          ->where("status","=","aktif")
                          ->get();
      $data['inv'] = array();
      foreach ($data['investor'] as $key => $value) {
        $data['inv'][$value->id] = $value->nama_investor;
      }
      return view('DataInvestor',$data);
    }else{
      return view ('Denied');
    }
  }

  public function investorpengembang(){
      $data['nama_download'] = "Data Investor";
      $data['investor'] = DB::table('tb_investor as a')
                          ->leftJoin('users as b','b.nik','=','a.nik')
                          ->leftJoin('tb_karyawan as c','c.nik','=','a.nik')
                          ->select("a.*")
                          ->where("a.status","=","aktif")
                          ->where("b.level","6")
                          ->whereNull("c.nama")
                          ->get();
      return view('InvestorPengembang',$data);
  }

  public function editInvestor($id){
    $data = DB::table('tb_investor as a')
          ->select("a.*")
          ->where("status","=","aktif")
          ->where('id','=',$id)
          ->get();
    echo json_encode($data);
  }
  public function updateinvestor(Request $post){
    $data = $post->except('_token','id','old_nik','nama_pengembang','nama_leader');
    $id = $post->only('id');

    DB::table('tb_investor')->where('id','=',$id)->update($data);
    $u['nik'] = $data['nik'];
    $u['name'] = $data['nama_lengkap'];
    DB::table('users')->where('nik','=',$post->only('old_nik'))->update($u);

    $z['nik'] = $data['nik'];
    $z['nama_lengkap'] = $data['nama_lengkap'];
    $z['nama'] = $data['nama_investor'];
    $z['alamat'] = $data['alamat'];
    $z['no_hp'] = $data['no_hp'];
    $z['no_rekening'] = $data['no_rekening'];
    $z['ats_bank'] = $data['ats_bank'];
    $z['nama_bank'] = $data['nama_bank'];
    $pengembang = DB::table('tb_karyawan')->where('nama',$post->only('nama_pengembang'))->get();
    if(count($pengembang) > 0){
       $z['pengembang'] = $pengembang[0]->id;
    }
    $leader = DB::table('tb_karyawan')->where('nama',$post->only('nama_leader'))->get();
    if(count($leader) > 0){
       $z['leader'] = $leader[0]->id;
    }
    DB::table('tb_karyawan')->where('nik','=',$post->only('old_nik'))->update($z);

    return redirect()->route('datainvestor')->with('success','Berhasil');
  }
  public function deleteInvestor($id){
    $data['status'] = "non aktif";
    DB::table('tb_investor')
        ->where('id','=',$id)
        ->update($data);
    return redirect()->back()->with('success','Berhasil');
  }

  public function inputkaryawaninvestor(){
    $data['karyawan'] = DB::table('tb_karyawan as a')
                        ->leftJoin('tb_investor as b','b.nik','=','a.nik')
                        ->select("a.*")
                        ->whereNull("b.nik")
                        ->where("a.status","aktif")
                        ->get();
    return view('KaryawanInvestor',$data);
  }

  public function simpansebagaiinvestor(Request $post){
    $data = $post->except('_token');

    for ($i=1; $i < $data['loop']; $i++) {
      if (isset($data['check'.$i])) {
        $d = DB::table('tb_karyawan')->where('nik','=',$data['nik'.$i])->get();
        $a['nama_investor'] = $d[0]->nama;
        $a['nik'] = $d[0]->nik;
        $a['alamat'] = $d[0]->alamat;
        $a['no_hp'] = $d[0]->no_hp;
        $a['keterangan'] = "-";
        $a['no_rekening'] = $d[0]->no_rekening;
        $a['ats_bank'] = $d[0]->ats_bank;
        $a['nama_bank'] = $d[0]->nama_bank;
        $a['use'] = "yes";
        $a['saldo'] = 0;
        $a['status'] = "aktif";
        $a['ket'] = "";
        DB::table('tb_investor')->insert($a);
      }
    }
    return redirect()->back()->with('success','Berhasil');
  }

  public function simpansebagaipengembang(Request $post){
    $data = $post->except('_token');
    for ($i=1; $i < $data['loop']; $i++) {
      if (isset($data['check'.$i])) {
        $d = DB::table('tb_investor')->where('nik','=',$data['nik'.$i])->get();
        $a['nama'] = $d[0]->nama_investor;
        $a['nik'] = $d[0]->nik;
        $a['jabatan'] = 6;
        $a['alamat'] = $d[0]->alamat;
        $a['no_hp'] = $d[0]->no_hp;
        $a['mulai_kerja'] = date('Y-m-d');
        $a['file'] = " ";
        $a['no_rekening'] = $d[0]->no_rekening;
        $a['ats_bank'] = $d[0]->ats_bank;
        $a['nama_bank'] = $d[0]->nama_bank;
        $a['use'] = "yes";
        $a['saldo'] = 0;
        $a['status'] = "aktif";
        DB::table('tb_karyawan')->insert($a);
      }
    }
    return redirect()->back()->with('success','Berhasil');
  }

}
