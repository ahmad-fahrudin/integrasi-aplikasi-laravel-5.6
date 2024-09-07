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
use App\Imports\BarangImport;
use App\Imports\KonsumenImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class PengaturanController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }
  
   public function dashboard(){
    if (role()) {
      $data['terlaris'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            //->join('tb_barang as c','c.id','=','b.id_barang')
                            ->select("b.id_barang",DB::raw('SUM(b.terkirim) as terjual'))
                            ->where("a.status_barang","=","terkirim")
                            ->where("a.status_order","=","1")
                            ->where("b.proses","<>","0")
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->whereYear("a.tanggal_terkirim",Date('Y'))
                            ->orderBy(DB::raw('SUM(b.terkirim)'),"DESC")
                            ->groupBy("b.id_barang")
                            ->limit(10)
                            ->get(); //3,64

      $d = DB::table('tb_barang as a')
                            ->select("*")
                            ->get(); //0,798

      foreach ($d as $value) {
        $data['brg'][$value->id]['nama_barang'] = $value->nama_barang;
        $data['brg'][$value->id]['no_sku'] = $value->no_sku;
      }
      return view('Dashboard',$data);
    }else{
      return view('Denied');
    }
  }

  public function penjualterbaik(){
    if (role()) {

      $data['terkirim'] = DB::table('tb_barang_keluar as a')
                      ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                      //->join('tb_karyawan as c','c.id','=','a.sales')
                      ->select("a.sales",DB::raw('SUM((b.terkirim * (harga_jual - potongan)) - sub_potongan) as diterkirim'))
                      ->where("a.status_order","=","1")
                      ->where("a.status_barang","=","terkirim")
                      ->where("b.proses","<>","0")
                      ->whereMonth("a.tanggal_terkirim",Date('m'))
                      ->whereYear("a.tanggal_terkirim",Date('Y'))
                      ->groupBy("a.sales")
                      ->get(); //3,78

      $data['order'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            //->join('tb_karyawan as c','c.id','=','a.sales')
                            ->select("a.sales",DB::raw('SUM((b.jumlah * (harga_jual - potongan)) - sub_potongan) as diorder'))
                            ->where("a.status_order","=","1")
                             ->where("a.status_barang","=","order")
                            ->whereMonth("a.tanggal_order",Date('m'))
                            ->whereYear("a.tanggal_order",Date('Y'))
                            ->groupBy("a.sales")
                            ->get(); //1,66

      $data['proses'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            //->join('tb_karyawan as c','c.id','=','a.sales')
                            ->select("a.sales",DB::raw('SUM((b.proses * (harga_jual - potongan)) - sub_potongan) as diproses'))
                            ->where("a.status_order","=","1")
                            ->where("a.status_barang","=","proses")
                            ->where("b.proses","<>","0")
                            ->whereMonth("a.tanggal_proses",Date('m'))
                            ->whereYear("a.tanggal_proses",Date('Y'))
                            ->groupBy("a.sales")
                            ->get(); //0,798

      $data['penjual'] = array();
      foreach ($data['terkirim'] as $value) {
        $data['penjual'][$value->sales]['total'] = $value->diterkirim;
        $data['penjual'][$value->sales]['terkirim'] = $value->diterkirim;
        $data['penjual'][$value->sales]['nama'] = $value->sales;
      }

      foreach ($data['order'] as $value) {
        $data['penjual'][$value->sales]['order'] = $value->diorder;
        $data['penjual'][$value->sales]['nama'] = $value->sales;
        if (array_key_exists("total",$data['penjual'][$value->sales])) {
          $data['penjual'][$value->sales]['total'] += $value->diorder;
        }else{
          $data['penjual'][$value->sales]['total'] = $value->diorder;
        }
      }

      foreach ($data['proses'] as $value) {
        $data['penjual'][$value->sales]['proses'] = $value->diproses;
        $data['penjual'][$value->sales]['nama'] = $value->sales;
        if (array_key_exists("total",$data['penjual'][$value->sales])) {
          $data['penjual'][$value->sales]['total'] += $value->diproses;
        }else{
          $data['penjual'][$value->sales]['total'] = $value->diproses;
        }
      }

      usort($data['penjual'], function($a, $b) {
          if($a['total']==$b['total']) return 0;
          return $a['total'] < $b['total']?1:-1;
      });

      $d = DB::table('tb_barang as a')
                            ->select("*")
                            ->get(); //0,798

      foreach ($d as $value) {
        $data['brg'][$value->id]['nama_barang'] = $value->nama_barang;
        $data['brg'][$value->id]['no_sku'] = $value->no_sku;
      }

      $f = DB::table('tb_karyawan as a')
                            ->select("*")
                            ->get(); //0,798

      foreach ($f as $value) {
        $data['sls'][$value->id]['nama'] = $value->nama;
      }

      return view('Dashboard2',$data);

    }
  }

  public function grafikpenjualan(){
    if (role()) {
      /*$data['grafik'] = DB::table('tb_barang_keluar as a')
                      ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                      ->select(
                        DB::raw('sum(harga_net * terkirim) as sums'),
                        DB::raw("DATE_FORMAT(tanggal_terkirim,'%M %Y') as months"))
                      ->where("a.status_order","=","1")
                      ->where("a.status_barang","=","terkirim")
                      ->where("b.proses","<>","0")
                      ->orderBy("months","DESC")
                      ->groupBy("months")
                      ->limit(12)
                      ->get(); //7,13*/
      $data['grafik'] = DB::table('tb_grafik as a')->select("months","sums")->orderBy('id','DESC')->limit(12)->get();
      return view('Dashboard3',$data);
    }
  }

  public function pembelianterbanyak(){
    if (role()) {
      $data['pembeli'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            //->join('tb_konsumen as c','c.id','=','a.id_konsumen')
                            ->select("a.id_konsumen",DB::raw('SUM(b.sub_total) as pembelian'))
                            ->where("a.status_order","=","1")
                            ->where("a.status_barang","=","terkirim")
                            ->where("b.proses","<>","0")
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->whereYear("a.tanggal_terkirim",Date('Y'))
                            ->orderBy(DB::raw('SUM(b.sub_total)'),"DESC")
                            ->groupBy("a.id_konsumen")
                            ->limit(10)
                            ->get(); //3,87
      $e = DB::table('tb_konsumen as a')
                      ->select("*")
                      ->get(); //0,798

      foreach ($e as $value) {
        $data['kns'][$value->id]['nama_pemilik'] = $value->nama_pemilik;
        $data['kns'][$value->id]['kota'] = $value->kota;
      }
      return view('Dashboard4',$data);
    }
  }

  public function penjualanterbaik($id){
    if ($id == "semua") {
      $data['terkirim'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->join('tb_karyawan as c','c.id','=','a.sales')
                            ->select("c.nama",DB::raw('SUM(b.sub_total) as diterkirim'))
                            ->where("a.status_order","=","1")
                            ->where("a.status_barang","=","terkirim")
                            ->where("b.proses","<>","0")
                            //->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->groupBy("a.sales")
                            ->get();

      $data['order'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->join('tb_karyawan as c','c.id','=','a.sales')
                            ->select("c.nama",DB::raw('SUM(b.sub_total) as diorder'))
                            ->where("a.status_order","=","1")
                            ->where("a.status_barang","=","order")
                            //->where("b.proses","<>","0")
                            //->whereMonth("a.tanggal_order",Date('m'))
                            ->groupBy("a.sales")
                            ->get();

      $data['proses'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->join('tb_karyawan as c','c.id','=','a.sales')
                            ->select("c.nama",DB::raw('SUM(b.sub_total) as diproses'))
                            ->where("a.status_order","=","1")
                            ->where("a.status_barang","=","proses")
                            ->where("b.proses","<>","0")
                            //->whereMonth("a.tanggal_proses",Date('m'))
                            ->groupBy("a.sales")
                            ->get();
    }else{
      $data['terkirim'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->join('tb_karyawan as c','c.id','=','a.sales')
                            ->select("c.nama",DB::raw('SUM(b.sub_total) as diterkirim'))
                            ->where("a.status_order","=","1")
                            ->where("b.proses","<>","0")
                            ->where("a.status_barang","=","terkirim")
                            ->whereMonth("a.tanggal_terkirim",Date('m'))
                            ->groupBy("a.sales")
                            ->get();

      $data['order'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->join('tb_karyawan as c','c.id','=','a.sales')
                            ->select("c.nama",DB::raw('SUM(b.sub_total) as diorder'))
                            ->where("a.status_order","=","1")
                            //->where("b.proses","<>","0")
                            ->where("a.status_barang","=","order")
                            ->whereMonth("a.tanggal_order",Date('m'))
                            ->groupBy("a.sales")
                            ->get();

      $data['proses'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->join('tb_karyawan as c','c.id','=','a.sales')
                            ->select("c.nama",DB::raw('SUM(b.sub_total) as diproses'))
                            ->where("a.status_order","=","1")
                            ->where("a.status_barang","=","proses")
                            ->where("b.proses","<>","0")
                            ->whereMonth("a.tanggal_proses",Date('m'))
                            ->groupBy("a.sales")
                            ->get();

    }
    $data['penjual'] = array();
    foreach ($data['terkirim'] as $value) {
      $data['penjual'][$value->nama]['terkirim'] = $value->diterkirim;
      $data['penjual'][$value->nama]['total'] = $value->diterkirim;
      $data['penjual'][$value->nama]['nama'] = $value->nama;
    }
    foreach ($data['order'] as $value) {
      $data['penjual'][$value->nama]['order'] = $value->diorder;
      $data['penjual'][$value->nama]['nama'] = $value->nama;
      if (array_key_exists("total",$data['penjual'][$value->nama])) {
        $data['penjual'][$value->nama]['total'] += $value->diorder;
      }else{
        $data['penjual'][$value->nama]['total'] = $value->diorder;
      }
    }
    foreach ($data['proses'] as $value) {
      $data['penjual'][$value->nama]['proses'] = $value->diproses;
      $data['penjual'][$value->nama]['nama'] = $value->nama;
      if (array_key_exists("total",$data['penjual'][$value->nama])) {
        $data['penjual'][$value->nama]['total'] += $value->diproses;
      }else{
        $data['penjual'][$value->nama]['total'] = $value->diproses;
      }
    }
    usort($data['penjual'], function($a, $b) {
        if($a['total']==$b['total']) return 0;
        return $a['total'] < $b['total']?1:-1;
    });

    echo json_encode($data['penjual']);
  }

  public function penjualanterlaris($id){
    if ($id == "semua") {
      $data = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->join('tb_barang as c','c.id','=','b.id_barang')
                            ->select("c.no_sku","c.nama_barang",DB::raw('SUM(b.terkirim) as terjual'))
                            ->where("a.status_barang","=","terkirim")
                            ->where("a.status_order","=","1")
                            ->orderBy(DB::raw('SUM(b.terkirim)'),"DESC")
                            ->groupBy("b.id_barang")
                            ->limit(10)
                            ->get();
    }else{
      $data = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->join('tb_barang as c','c.id','=','b.id_barang')
                            ->select("c.no_sku","c.nama_barang",DB::raw('SUM(b.terkirim) as terjual'))
                            ->where("a.status_barang","=","terkirim")
                            ->where("a.status_order","=","1")
                            ->whereMonth("a.tanggal_proses",Date('m'))
                            ->orderBy(DB::raw('SUM(b.terkirim)'),"DESC")
                            ->groupBy("b.id_barang")
                            ->limit(10)
                            ->get();
    }
    echo json_encode($data);
  }

  public function penjualanterbanyak($id){
    if ($id == "semua") {
      $data = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->join('tb_konsumen as c','c.id','=','a.id_konsumen')
                            ->select("c.nama_pemilik","c.kota", DB::raw('SUM(b.sub_total) as pembelian'))
                            ->where("a.status_order","=","1")
                            ->where("a.status_barang","=","terkirim")
                            ->orderBy(DB::raw('SUM(b.sub_total)'),"DESC")
                            ->groupBy("a.id_konsumen")
                            ->limit(10)
                            ->get();
    }else{
      $data = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->join('tb_konsumen as c','c.id','=','a.id_konsumen')
                            ->select("c.nama_pemilik","c.kota", DB::raw('SUM(b.sub_total) as pembelian'))
                            ->where("a.status_order","=","1")
                            ->where("a.status_barang","=","terkirim")
                            ->whereMonth("a.tanggal_proses",Date('m'))
                            ->orderBy(DB::raw('SUM(b.sub_total)'),"DESC")
                            ->groupBy("a.id_konsumen")
                            ->limit(10)
                            ->get();
    }
    echo json_encode($data);
  }

  //user
  public function user(){
    if (role()) {
      $data['investor'] = DB::table('tb_investor as a')
                          ->select("a.*")
                          ->where("status","=","aktif")
                          ->where("use","=","no")
                          ->get();
      $data['gudang'] = $this->model->getGudang();
      $data['level'] = $this->model->getLevel();
      $data['users'] = $this->model->getUser();
      $data['new'] = DB::table('tb_karyawan as a')
      ->select("a.*")
      ->where("a.status","=","aktif")
      ->where("a.use","=","no")
      ->get();
      
      return view('User',$data);
    }else{
      return view ('Denied');
    }
  }
  
   public function insertuser(Request $post){
    $data = $post->except('_token','password');
    $data['status'] = "aktif";
    $password = $post->only('password');
    $data['password'] = Hash::make($password['password']);
    $this->model->insertuser($data);
    $dt['use'] = "yes";
    if ($data['level'] == "6") {
      DB::table('tb_investor')->where('nik','=',$data['nik'])->update($dt);
    }else{
      DB::table('tb_karyawan')->where('nik','=',$data['nik'])->update($dt);
    }
    return redirect()->back()->with('success','Berhasil');
  }
  public function deleteuser($id){
    $this->model->delUser($id);
    return redirect()->back()->with('success','Berhasil');
  }
  public function resetuser($id){
    $data['password'] = Hash::make("12345678");
    DB::table('users')->where('id','=',$id)->update($data);
    return redirect()->back()->with('success','Berhasil');
  }
  public function editUser($id){
    $data = $this->model->getUserby($id);
    echo json_encode($data);
  }
  public function updateuser(Request $post){
    $data = $post->except('_token','id');
    $id = $post->only('id');
    $this->model->updateUser($data,$id);

    $x['nik'] = $data['nik'];
    $x['nama_lengkap'] = $data['name'];
    DB::table('tb_investor')->where('nik','=',$data['nik'])->update($x);

    $u['nik'] = $data['nik'];
    $u['nama_lengkap'] = $data['name'];
    DB::table('tb_karyawan')->where('nik','=',$data['nik'])->update($u);

    return redirect()->route('user')->with('success','Berhasil');
  }

  //gudang
  public function gudang(){
    if (role()) {
      $data['gudang'] = $this->model->getGudang();
      $data['provinsi'] =  DB::table('provinces')->get();
      $data['kabupaten'] =  DB::table('regencies')->get();
      $data['kecamatan'] =  DB::table('districts')->get();
      foreach ($data['provinsi'] as $key => $value) {
        $data['data_provinsi'][$value->id] = $value->name;
      }
      foreach ($data['kabupaten'] as $key => $value) {
        $data['data_kabupaten'][$value->id] = $value->name;
      }
      foreach ($data['kecamatan'] as $key => $value) {
        $data['data_kecamatan'][$value->id] = $value->name;
      }
      return view('Gudang',$data);
    }else{
      return view ('Denied');
    }
  }
  
  public function gudang_bahan(){
      $data['gudang'] = DB::table('tb_gudang_bahan')->where('status','aktif')->get();
      $data['provinsi'] =  DB::table('provinces')->get();
      $data['kabupaten'] =  DB::table('regencies')->get();
      $data['kecamatan'] =  DB::table('districts')->get();
      $data['kategori'] =  DB::table('tb_kategori_bahan')->where('id','<>','4')->get();
      foreach ($data['kategori'] as $key => $value) {
        $data['data_kategori'][$value->id] = $value->nama_kategori;
      }
      foreach ($data['provinsi'] as $key => $value) {
        $data['data_provinsi'][$value->id] = $value->name;
      }
      foreach ($data['kabupaten'] as $key => $value) {
        $data['data_kabupaten'][$value->id] = $value->name;
      }
      foreach ($data['kecamatan'] as $key => $value) {
        $data['data_kecamatan'][$value->id] = $value->name;
      }
      return view('Pengaturan.gudang_bahan',$data);
    }

  public function previllagegudang(){
    if (role()) {
      $data['gudang'] = DB::table('tb_gudang as a')
                        ->leftJoin('tb_previllage as b','b.id_gudang','=','a.id')
                        ->select("a.*")
                        ->where("a.status","=","aktif")
                        ->whereNull("b.id_gudang")
                        ->get();
      $data['gudangprevillage'] = DB::table('tb_gudang as a')
                        ->leftJoin('tb_previllage as b','b.id_gudang','=','a.id')
                        ->select("a.*")
                        ->where("a.status","=","aktif")
                        ->whereNotNull("b.id_gudang")
                        ->get();
      return view('PrevillageGudang',$data);
    }else{
      return view ('Denied');
    }
  }

  public function addprevillage($id){
    $data['id_gudang'] = $id;
    DB::table('tb_previllage')->insert($data);
    return redirect()->back()->with('success','Berhasil');
  }

  public function deleteprevillage($id){
    DB::table('tb_previllage')->where('id_gudang','=',$id)->delete();
    return redirect()->back()->with('success','Berhasil');
  }

  public function insertgudang(Request $post){
    $data = $post->except('_token');
    $data['status'] = "aktif";
    $d = DB::table('tb_barang as a')->select("*")->where("a.status","=","aktif")->get();
    $c = DB::table('tb_gudang as a')->select("*")->orderBy('id', 'DESC')->limit(1)->get();

    if (count($c) > 0) {
      $id = $c[0]->id + 1;
    }else{
      $id = '1';
    }

    $cek_kategori = DB::table('tb_kategori as a')->select("*")->orderBy('id', 'DESC')->limit(1)->get();
    if (count($cek_kategori) > 0) {
      $idkat = $cek_kategori[0]->id + 1;
    }else{
      $idkat = '1';
    }
    
    $cek_kategorijasa = DB::table('tb_kategori_jasa as a')->select("*")->orderBy('id', 'DESC')->limit(1)->get();
    if (count($cek_kategorijasa) > 0) {
      $idkatjas = $cek_kategorijasa[0]->id + 1;
    }else{
      $idkatjas = '1';
    }

    if ($id > $idkat) {
      $data['id'] = $id;
    }else{
      $data['id'] = $idkat;
    }

    if (count($d) > 0) {
      foreach ($d as $value) {
        $x['id_barang'] = $value->id;
        $x['id_gudang'] = $id;
        $x['jumlah']   = '0';
        $x['harga']   = '0';
        $x['status']   = 'aktif';
        DB::table('tb_gudang_barang')->insert($x);
      }
    }
    $kat['id'] = $data['id'];
    $kat['nama_kategori'] = $data['nama_gudang'];
    DB::table('tb_kategori')->insert($kat);

    $this->model->insertgudang($data);
    return redirect()->back()->with('success','Berhasil');
  }

  public function deletegudang($id){
    $this->model->delGudang($id);
    return redirect()->back()->with('success','Berhasil');
  }
  public function editGudang($id){
    $data['gudang'] = $this->model->getGudangby($id);
    $data['kabupaten'] = DB::table('regencies as a')
                         ->select("*")
                         ->where("a.province_id","=",$data['gudang'][0]->provinsi)
                         ->get();
    $data['kecamatan'] = DB::table('districts as a')
                         ->select("*")
                         ->where("a.regency_id","=",$data['gudang'][0]->kabupaten)
                         ->get();
    echo json_encode($data);
  }
  public function updategudang(Request $post){
    $data = $post->except('_token','id');
    $id = $post->only('id');
    $this->model->updateGudang($data,$id);
    return redirect()->route('gudang')->with('success','Berhasil');
  }

  public function backup(){
    if (role()) {
      return view('Backup');
    }else{
      return view ('Denied');
    }
  }

  public function jabatan(){
    if (role()) {
      $data['jabatan'] = DB::table('tb_jabatan as a')->select("*")->where("a.status","aktif")->get();
      return view('jabatan',$data);
    }else{
      return view ('Denied');
    }
  }

  public function editJabatan($id){
    $data = DB::table('tb_jabatan as a')->select("*")->where("a.status","aktif")->where("a.id",$id)->get();
    echo json_encode($data);
  }
  public function updatejabatan(Request $post){
    $data = $post->except('_token','id');
    $id = $post->only('id');
    DB::table('tb_jabatan')->where('id','=',$id)->update($data);
    return redirect()->back()->with('success','Berhasil');
  }
  public function deletejabatan($id){
    $data['status'] = "terhapus";
    DB::table('tb_jabatan')->where('id','=',$id)->update($data);
    return redirect()->back()->with('success','Berhasil');
  }
  public function postjabatan(Request $post){
    $data = $post->except('_token');
    DB::table('tb_jabatan')->insert($data);
    return redirect()->back()->with('success','Berhasil');
  }

  public function kategori(){
    if (role()) {
      $data['kategori'] = DB::table('tb_kategori as a')->select("*")->where("a.status","aktif")->get();
      return view('kategori',$data);
    }else{
      return view ('Denied');
    }
  }
  
  public function kategorijasa(){
    if (role()) {
      $data['kategorijasa'] = DB::table('tb_kategori_jasa as a')->select("*")->where("a.status","aktif")->get();
      return view('kategorijasa',$data);
    }else{
      return view ('Denied');
    }
  }

  public function editKategori($id){
    $data = DB::table('tb_kategori as a')->select("*")->where("a.status","aktif")->where("a.id",$id)->get();
    echo json_encode($data);
  }
  
  public function editkategorijasa($id){
    $data = DB::table('tb_kategori_jasa as a')->select("*")->where("a.status","aktif")->where("a.id",$id)->get();
    echo json_encode($data);
  }

  public function updatekategori(Request $post){
    $data = $post->except('_token','id');
    $id = $post->only('id');
    DB::table('tb_kategori')->where('id','=',$id)->update($data);
    return redirect()->back()->with('success','Berhasil');
  }
  
  public function updatekategorijasa(Request $post){
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
    $id = $post->only('id');
    DB::table('tb_kategori_jasa')->where('id','=',$id)->update($data);
    return redirect()->back()->with('success','Berhasil');
  }

  public function deletekategori($id){
    $data['status'] = "terhapus";
    DB::table('tb_kategori')->where('id','=',$id)->update($data);
    return redirect()->back()->with('success','Berhasil');
  }
  
  public function deletekategorijasa($id){
    $data['status'] = "terhapus";
    DB::table('tb_kategori_jasa')->where('id','=',$id)->update($data);
    return redirect()->back()->with('success','Berhasil');
  }

  public function postkategori(Request $post){
    $data = $post->except('_token');
    DB::table('tb_kategori')->insert($data);
    return redirect()->back()->with('success','Berhasil');
  }
  
  public function addkategorijasa(Request $post){
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
    DB::table('tb_kategori_jasa')->insert($data);
    return redirect()->back()->with('success','Berhasil');
  }

  public function profile(){
    if (role()) {
      if (Auth::user()->level == "6") {
        $data['profile'] = DB::table('tb_investor as a')->select("*","a.nama_investor as nama")->where('nik','=',Auth::user()->nik)->get();
      }else{
        $data['profile'] = DB::table('tb_karyawan')->where('nik','=',Auth::user()->nik)->get();
      }
      $data['user'] = DB::table('users')->where('nik','=',Auth::user()->nik)->get();
      return view('profile',$data);
    }else{
      return view ('Denied');
    }
  }

  public function changepassword(Request $post){
    $data = $post->except('_token');

    if ($data['newpass'] == $data['newpass2']) {
      if (password_verify($data['oldpass'], Auth::user()->password)) {
        $d['password'] = Hash::make($data['newpass']);
        DB::table('users')->where('nik','=',Auth::user()->nik)->update($d);
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back()->with('error','Gagal');
      }
    }else{
      return redirect()->back()->with('error','Gagal');
    }
  }

  public function surat($id){
    $split = explode("-",$id);
    if (count($split) > 1) {
      if ($split[0]=="RJ") {
              $data['transfer'] = DB::table('tb_reject as a')
                                    ->join('tb_suplayer as c','c.id','=','a.id_suplayer')
                                    ->join('users as e','e.id','=','a.admin_g')
                                    ->join('tb_karyawan as f','f.id','=','a.qc')
                                    ->leftJoin('tb_karyawan as g','g.id','=','a.driver')
                                    ->select("a.no_reject as no_transfer","a.tanggal_input as tanggal_kirim",
                                             "c.nama_pemilik as kepada","c.alamat as alamat_kepada","c.no_hp"
                                             ,"e.name as adming","f.nama as qc","g.nama as driver")
                                    ->where("a.no_reject","=",$id)->get();
              $data['barang'] = DB::table('tb_detail_reject as a')
                                ->join('tb_barang as b','b.id','=','a.id_barang')
                                ->select("a.jumlah as subjumlah","b.nama_barang")
                                ->where("a.no_reject",$data['transfer'][0]->no_transfer)
                                ->get();
              $data['alamat'] = DB::table('tb_gudang as a')
                                ->join('tb_reject as b','b.id_gudang','=','a.id')
                                ->select("a.*")
                                ->where("b.no_reject",$id)
                                ->get();
            //return view('SuratJalan',$data);
      }else{
            $cek = DB::table('tb_barang_keluar as a')->select("*")->where("a.no_kwitansi",$id)->get();
            if ($cek[0]->status_order == "2" || $cek[0]->status_order == "3") {
              $data['transfer'] = DB::table('tb_barang_keluar as a')
                                    ->leftJoin('tb_karyawan as c','c.id','=','a.id_konsumen')
                                    ->leftJoin('users as e','e.id','=','a.admin_g')
                                    ->leftJoin('tb_karyawan as f','f.id','=','a.qc')
                                    ->leftJoin('tb_karyawan as g','g.id','=','a.pengirim')
                                    ->select("a.no_kwitansi as no_transfer","a.tanggal_proses as tanggal_kirim","a.id_gudang",
                                             "c.kecamatan","c.kota as kabupaten","c.provinsi",
                                             "c.nama as kepada","c.alamat as alamat_kepada","c.no_hp"
                                             ,"e.name as adming","f.nama as qc","g.nama as driver")
                                    ->where("a.no_kwitansi","=",$id)->get();
            }else{
              $data['transfer'] = DB::table('tb_barang_keluar as a')
                                    ->leftJoin('tb_konsumen as c','c.id','=','a.id_konsumen')
                                    ->leftJoin('users as e','e.id','=','a.admin_g')
                                    ->leftJoin('tb_karyawan as f','f.id','=','a.qc')
                                    ->leftJoin('tb_karyawan as g','g.id','=','a.pengirim')
                                    ->select("a.no_kwitansi as no_transfer","a.tanggal_proses as tanggal_kirim","a.id_gudang",
                                             "c.kecamatan","c.kota as kabupaten","c.provinsi",
                                             "c.nama_pemilik as kepada","c.alamat as alamat_kepada","c.no_hp"
                                             ,"e.name as adming","f.nama as qc","g.nama as driver")
                                    ->where("a.no_kwitansi","=",$id)->get();
            }
            $data['barang'] = DB::table('tb_detail_barang_keluar as a')
                              ->join('tb_barang as b','b.id','=','a.id_barang')
                              ->select("a.proses as subjumlah","b.nama_barang")
                              ->where("a.no_kwitansi",$data['transfer'][0]->no_transfer)
                              ->where("a.proses","<>","0")
                              ->get();
            $data['alamat'] = DB::table('tb_gudang as a')
                              ->join('tb_barang_keluar as b','b.id_gudang','=','a.id')
                              ->select("a.*")
                              ->where("b.no_kwitansi",$id)
                              ->get();
          }
    }else{
        $data['transfer'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_gudang as c','c.id','=','a.dari')
                              ->join('users as e','e.id','=','a.admin_g')
                              ->join('tb_karyawan as f','f.id','=','a.qc')
                              ->leftJoin('tb_karyawan as g','g.id','=','a.driver')
                              ->select("a.no_transfer","a.tanggal_kirim","c.kepala_gudang as kepada","c.alamat as alamat_kepada","c.*"
                                        ,"e.name as adming","f.nama as qc","g.nama as driver")
                              ->where("a.no_transfer","=",$id)->get();
        $data['barang'] = DB::table('tb_detail_transfer as a')
                          ->join('tb_barang as b','b.id','=','a.id_barang')
                          ->join('tb_harga as c','c.id_barang','=','a.id_barang')
                          ->select("a.proses as subjumlah","b.nama_barang","c.harga")
                          ->where("a.no_transfer",$data['transfer'][0]->no_transfer)
                          ->where("a.proses","<>","0")
                          ->get();
        $data['alamat'] = DB::table('tb_gudang as a')
                          ->join('tb_transfer_stok as b','b.kepada','=','a.id')
                          ->select("a.*")
                          ->where("b.no_transfer",$id)
                          ->get();
    }
    $barang = array();
    $i = 0;
    $a = 0;
    $x = 0;
    foreach ($data['barang'] as $value) {
        $barang[$i][$a]['nama_barang'] = $value->nama_barang;
        $barang[$i][$a]['subjumlah'] = $value->subjumlah;
        $a++;
        $page = $x + 1;
        if ($page % 10 == 0) {
          $i++;
          $a=0;
        }
        $x++;
    }
    $data['barang'] = $barang;

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


    return view('SuratJalan',$data);
  }

  public function surattransfer($id){
    $data['transfer'] = DB::table('tb_transfer_stok as a')
                          ->join('tb_gudang as c','c.id','=','a.dari')
                          ->join('users as e','e.id','=','a.admin_g')
                          ->join('tb_karyawan as f','f.id','=','a.qc')
                          ->join('tb_karyawan as g','g.id','=','a.driver')
                          ->select("a.no_transfer","a.tanggal_kirim","c.kepala_gudang as kepada","c.alamat as alamat_kepada","c.*"
                                    ,"e.name as adming","f.nama as qc","g.nama as driver")
                          ->where("a.no_transfer","=",$id)->get();
    $data['barang'] = DB::table('tb_detail_transfer as a')
                      ->join('tb_barang as b','b.id','=','a.id_barang')
                      ->join('tb_harga as c','c.id_barang','=','a.id_barang')
                      ->select("a.proses as subjumlah","b.nama_barang","c.harga_hpp as harga","c.qty1","c.pot1","c.qty2","c.pot2","c.qty3","c.pot3")
                      ->where("a.no_transfer",$data['transfer'][0]->no_transfer)
                      ->where("a.proses","<>","0")
                      ->get();
    $data['alamat'] = DB::table('tb_gudang as a')
                      ->join('tb_transfer_stok as b','b.kepada','=','a.id')
                      ->select("a.*")
                      ->where("b.no_transfer",$id)
                      ->get();
    $data['trf'] = "transfer";
    $barang = array();
    $i = 0;
    $a = 0;
    $x = 0;
    foreach ($data['barang'] as $value) {
        $barang[$i][$a]['nama_barang'] = $value->nama_barang;
        $barang[$i][$a]['subjumlah'] = $value->subjumlah;
        $barang[$i][$a]['harga'] = $value->harga;
        if ($value->subjumlah >= $value->qty3) {
          $barang[$i][$a]['potongan'] = $value->pot3;
          $barang[$i][$a]['sub_potongan'] = $value->qty3 * $value->pot3;
        }else if($value->subjumlah >= $value->qty2){
          $barang[$i][$a]['potongan'] = $value->pot2;
          $barang[$i][$a]['sub_potongan'] = $value->qty2 * $value->pot2;
        }else if($value->subjumlah >= $value->qty1){
          $barang[$i][$a]['potongan'] = $value->pot1;
          $barang[$i][$a]['sub_potongan'] = $value->qty1 * $value->pot1;
        }else{
          $barang[$i][$a]['potongan'] = 0;
          $barang[$i][$a]['sub_potongan'] = 0;
        }

        $a++;
        $page = $x + 1;
        if ($page % 10 == 0) {
          $i++;
          $a=0;
        }
        $x++;
    }
    $data['barang'] = $barang;
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
    return view('SuratJalan',$data);
  }

  public function kwitansi($id){
    $cek = DB::table('tb_barang_keluar as a')->select("*")->where("a.no_kwitansi",$id)->get();
    if ($cek[0]->status_order == "2" || $cek[0]->status_order == "3") {
      $data['transfer'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_karyawan as c','c.id','=','a.id_konsumen')
                            ->join('users as e','e.id','=','a.admin_p')
                            ->join('tb_karyawan as f','f.id','=','a.sales')
                            ->leftJoin('tb_karyawan as g','g.id','=','a.pengirim')
                            ->select("a.no_kwitansi","a.tanggal_proses","c.nama as nama_pemilik","c.alamat","c.no_hp"
                                      ,"e.name as admin_p","f.nama as sales","g.nama as pengirim","a.ongkos_kirim")
                            ->where("a.no_kwitansi","=",$id)->get();
    }else{
      $data['transfer'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_konsumen as c','c.id','=','a.id_konsumen')
                            ->join('users as e','e.id','=','a.admin_p')
                            ->join('tb_karyawan as f','f.id','=','a.sales')
                            ->leftJoin('tb_karyawan as g','g.id','=','a.pengirim')
                            ->select("a.no_kwitansi","a.tanggal_proses","c.nama_pemilik","c.alamat","c.no_hp","c.kecamatan","c.kota","c.provinsi"
                                      ,"e.name as admin_p","f.nama as sales","g.nama as pengirim","a.ongkos_kirim")
                            ->where("a.no_kwitansi","=",$id)->get();
    }
        $data['konsu'] = DB::table('tb_konsumen')->where('id',$cek[0]->id_konsumen)->get();
        
    $data['ongkos_kirim'] = $data['transfer'][0]->ongkos_kirim;
    $data['barang'] = DB::table('tb_detail_barang_keluar as a')
                      ->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select("*")
                      ->where("a.no_kwitansi",$id)
                      ->get();
    $data['dt'] = count($data['barang']);
    $page = ceil($data['dt']/10);

    $barang = array();
    $i = 0;
    $a = 0;
    $x = 0;
    foreach ($data['barang'] as $value) {
      if (($value->terkirim == null && $value->proses > 0) || $value->terkirim != 0) {
        $barang[$i][$a]['nama_barang'] = $value->nama_barang;
        $barang[$i][$a]['part_number'] = $value->part_number;
        $barang[$i][$a]['proses'] = $value->proses;
        $barang[$i][$a]['return'] = $value->return;
        $barang[$i][$a]['harga_jual'] = $value->harga_jual;
        $barang[$i][$a]['potongan'] = $value->potongan;
        $barang[$i][$a]['sub_total'] = $value->sub_total;
        $a++;
        $page = $x + 1;
        if ($page % 10 == 0) {
          $i++;
          $a=0;
        }
      }
    }    

    //dd($barang);
    $data['detail'] = $barang;

    $data['pembayaran'] = DB::table('tb_detail_pembayaran as a')
                      //->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select(DB::raw('SUM(a.pembayaran) as total_bayar'))
                      ->where("a.no_kwitansi",$id)
                      ->get();
    $data['tagihan'] = DB::table('tb_detail_barang_keluar as a')
                      //->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select(DB::raw('SUM(a.sub_total) as tagihan'))
                      ->where("a.no_kwitansi",$id)
                      ->get();

    $data['alamat'] = DB::table('tb_gudang as a')
                      ->join('tb_barang_keluar as b','b.id_gudang','=','a.id')
                      ->select("a.*")
                      ->where("b.no_kwitansi",$id)
                      ->get();

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

    return view('Kwitansi',$data);
  }
  
  
    public function kwitansidp($id){
    $cek = DB::table('tb_barang_keluar as a')->select("*")->where("a.no_kwitansi",$id)->get();
    if ($cek[0]->status_order == "2" || $cek[0]->status_order == "3") {
      $data['transfer'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_karyawan as c','c.id','=','a.id_konsumen')
                            ->join('users as e','e.id','=','a.admin_p')
                            ->join('tb_karyawan as f','f.id','=','a.sales')
                            ->leftJoin('tb_karyawan as g','g.id','=','a.pengirim')
                            ->select("a.no_kwitansi","a.tanggal_proses","c.nama as nama_pemilik","c.alamat","c.no_hp"
                                      ,"e.name as admin_p","f.nama as sales","g.nama as pengirim","a.ongkos_kirim")
                            ->where("a.no_kwitansi","=",$id)->get();
    }else{
      $data['transfer'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_konsumen as c','c.id','=','a.id_konsumen')
                            ->join('users as e','e.id','=','a.admin_p')
                            ->join('tb_karyawan as f','f.id','=','a.sales')
                            ->leftJoin('tb_karyawan as g','g.id','=','a.pengirim')
                            ->select("a.no_kwitansi","a.tanggal_proses","c.nama_pemilik","c.alamat","c.no_hp","c.kecamatan","c.kota","c.provinsi"
                                      ,"e.name as admin_p","f.nama as sales","g.nama as pengirim","a.ongkos_kirim")
                            ->where("a.no_kwitansi","=",$id)->get();
    }
        $data['konsu'] = DB::table('tb_konsumen')->where('id',$cek[0]->id_konsumen)->get();
        
    $data['ongkos_kirim'] = $data['transfer'][0]->ongkos_kirim;
    $data['barang'] = DB::table('tb_detail_barang_keluar as a')
                      ->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select("*")
                      ->where("a.no_kwitansi",$id)
                      ->get();
    $data['dt'] = count($data['barang']);
    $page = ceil($data['dt']/10);

    $barang = array();
    $i = 0;
    $a = 0;
    $x = 0;
    foreach ($data['barang'] as $value) {
      
         if (($value->jumlah > 0) || ($value->proses == null) || ($value->terkirim == null)) {
        $barang[$i][$a]['nama_barang'] = $value->nama_barang;
        $barang[$i][$a]['part_number'] = $value->part_number;
        $barang[$i][$a]['proses'] = $value->jumlah;
        $barang[$i][$a]['return'] = $value->return;
        $barang[$i][$a]['harga_jual'] = $value->harga_jual;
        $barang[$i][$a]['potongan'] = $value->potongan;
        $barang[$i][$a]['sub_total'] = $value->sub_total;
        $a++;
        $page = $x + 1;
        if ($page % 10 == 0) {
          $i++;
          $a=0;
        }
        
        $x++;
      }
    }
    //dd($barang);
    $data['detail'] = $barang;

    $data['pembayaran'] = DB::table('tb_detail_pembayaran as a')
                      //->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select(DB::raw('SUM(a.pembayaran) as total_bayar'))
                      ->where("a.no_kwitansi",$id)
                      ->get();
    $data['tagihan'] = DB::table('tb_detail_barang_keluar as a')
                      //->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select(DB::raw('SUM(a.sub_total) as tagihan'))
                      ->where("a.no_kwitansi",$id)
                      ->get();

    $data['alamat'] = DB::table('tb_gudang as a')
                      ->join('tb_barang_keluar as b','b.id_gudang','=','a.id')
                      ->select("a.*")
                      ->where("b.no_kwitansi",$id)
                      ->get();

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

    return view('KwitansiDP',$data);
  }


  public function tagihan($id){
    $cf =  substr($id, 0, 2);
    if ($cf == "JS") {
      $cek = DB::table('tb_order_jasa as a')->select("*")->where("a.no_kwitansi",$id)->get();
      $data['transfer'] = DB::table('tb_order_jasa as a')
                            ->join('tb_konsumen as c','c.id','=','a.id_konsumen')
                            ->join('users as e','e.id','=','a.kasir')
                            //->join('tb_karyawan as f','f.id','=','a.sales')
                            //->leftJoin('tb_karyawan as g','g.id','=','a.pengirim')
                            ->select("a.potongan","a.no_kwitansi","a.tanggal_transaksi","c.nama_pemilik","c.alamat","c.no_hp","c.kecamatan","c.provinsi","c.kota"
                                      ,"e.name as admin_p")
                            ->where("a.no_kwitansi","=",$id)->get();

      $data['barang'] = DB::table('tb_detail_order_jasa as a')
                        ->join('tb_jasa as b','b.kode','=','a.id_jasa')
                        ->select("*")
                        ->where("a.no_kwitansi",$id)
                        ->get();
      $data['dt'] = count($data['barang']);
      $page = ceil($data['dt']/10);

      $barang = array();
      $i = 0;
      $a = 0;
      foreach ($data['barang'] as $key => $value) {
        $barang[$i][$a]['nama_jasa'] = $value->nama_jasa;
        $barang[$i][$a]['jumlah'] = $value->jumlah;
        $barang[$i][$a]['biaya'] = $value->biaya;
        $barang[$i][$a]['sub_biaya'] = $value->sub_biaya;
        $a++;
        $page = $key + 1;
        if ($page % 10 == 0) {
          $i++;
          $a=0;
        }
      }
      $data['detail'] = $barang;

      $data['pembayaran'] = DB::table('tb_detail_pembayaran as a')
                        ->select(DB::raw('SUM(a.pembayaran) as total_bayar'))
                        ->where("a.no_kwitansi",$id)
                        ->get();
      $data['tagihan'] = DB::table('tb_detail_order_jasa as a')
                        ->select(DB::raw('SUM(a.sub_biaya) as tagihan'))
                        ->where("a.no_kwitansi",$id)
                        ->get();
      $data['alamat'] = DB::table('tb_gudang as a')
                        ->join('tb_order_jasa as b','b.gudang','=','a.id')
                        ->select("a.*")
                        ->where("b.no_kwitansi",$id)
                        ->get();
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
      return view('TagihanJasa',$data);
    }else{
      $cek = DB::table('tb_barang_keluar as a')->select("*")->where("a.no_kwitansi",$id)->get();
      if ($cek[0]->status_order == "2" || $cek[0]->status_order == "3") {
        $data['transfer'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_karyawan as c','c.id','=','a.id_konsumen')
                              ->join('users as e','e.id','=','a.admin_p')
                              ->join('tb_karyawan as f','f.id','=','a.sales')
                              ->join('tb_karyawan as g','g.id','=','a.pengirim')
                              ->select("a.no_kwitansi","a.tanggal_terkirim","c.nama as nama_pemilik","c.alamat","c.no_hp"
                                        ,"e.name as admin_p","f.nama as sales","g.nama as pengirim","a.ongkos_kirim")
                              ->where("a.no_kwitansi","=",$id)->get();
      }else{
        $data['transfer'] = DB::table('tb_barang_keluar as a')
                              ->join('tb_konsumen as c','c.id','=','a.id_konsumen')
                              ->join('users as e','e.id','=','a.admin_p')
                              ->join('tb_karyawan as f','f.id','=','a.sales')
                              ->leftJoin('tb_karyawan as g','g.id','=','a.pengirim')
                              ->select("a.no_kwitansi","a.tanggal_terkirim","c.nama_pemilik","c.alamat","c.no_hp"
                                        ,"e.name as admin_p","f.nama as sales","g.nama as pengirim","a.ongkos_kirim",
                                        "c.kecamatan","c.provinsi","c.kota")
                              ->where("a.no_kwitansi","=",$id)->get();
      }
      $data['barang'] = DB::table('tb_detail_barang_keluar as a')
                        ->join('tb_barang as b','b.id','=','a.id_barang')
                        ->select("*")
                        ->where("a.no_kwitansi",$id)
                        ->where("a.terkirim","<>","0")
                        ->get();
      $data['dt'] = count($data['barang']);
      $page = ceil($data['dt']/10);

      $barang = array();
      $i = 0;
      $a = 0;
      foreach ($data['barang'] as $key => $value) {
        $barang[$i][$a]['nama_barang'] = $value->nama_barang;
        $barang[$i][$a]['proses'] = $value->proses;
        $barang[$i][$a]['return'] = $value->return;
        $barang[$i][$a]['harga_jual'] = $value->harga_jual;
        $barang[$i][$a]['potongan'] = $value->potongan;
        $barang[$i][$a]['sub_total'] = $value->sub_total;
        $a++;
        $page = $key + 1;
        if ($page % 10 == 0) {
          $i++;
          $a=0;
        }
      }
      $data['detail'] = $barang;

      $data['pembayaran'] = DB::table('tb_detail_pembayaran as a')
                        //->join('tb_barang as b','b.id','=','a.id_barang')
                        ->select(DB::raw('SUM(a.pembayaran) as total_bayar'))
                        ->where("a.no_kwitansi",$id)
                        ->get();
      $data['tagihan'] = DB::table('tb_detail_barang_keluar as a')
                        //->join('tb_barang as b','b.id','=','a.id_barang')
                        ->select(DB::raw('SUM(a.sub_total) as tagihan'))
                        ->where("a.no_kwitansi",$id)
                        ->get();
      $data['alamat'] = DB::table('tb_gudang as a')
                        ->join('tb_barang_keluar as b','b.id_gudang','=','a.id')
                        ->select("a.*")
                        ->where("b.no_kwitansi",$id)
                        ->get();

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
    //dd($data['transfer']);
      return view('Tagihan',$data);
    }
  }

  public function printdetailbarang($id){
    $data['barang'] = DB::table('tb_detail_transfer as a')
                      ->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select("a.jumlah","b.*")
                      ->where("a.no_transfer",$id)
                      ->get();
    $data['header'] = DB::table('tb_transfer_stok as a')
                      ->join('tb_gudang as b','b.id','=','a.dari')
                      ->select("*")
                      ->where("a.no_transfer",$id)
                      ->get();
    return view('DetailBarang',$data);
  }
  

  public function printdetailbarangkeluar($id){

    /*$pg = DB::table('tb_barang_keluar as a')
                      ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                      ->select("*")
                      ->where('a.no_kwitansi',$id)
                      ->where("a.status_barang","order")
                      ->count();

    $data['page'] = ceil($pg / 1000);


      $data['barang'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                        ->select("*")
                        ->where('a.no_kwitansi',$id)
                        ->where("a.status_barang","order")
                        ->get();

    $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
    $data['nmbarang'] = array();
    foreach ($text_barang as $value) {
      $data['nmbarang'][$value->id]['no_sku'] =$value->no_sku;
      $data['nmbarang'][$value->id]['nama_barang'] =$value->nama_barang;
    }

    $kons = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($kons as $value) {
      $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] =$value->alamat;
      $data['konsumen'][$value->id]['kota'] =$value->kota;
    }

      $kabupaten =  DB::table('regencies')->get();
      foreach ($kabupaten as $key => $value) {
        $data['data_kabupaten'][$value->id] = $value->name;
      }


    $gdg = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gdg as $value) {
      $data['gudang'][$value->id]=$value->nama_gudang;
    }

    $data['nama_download'] = "Daftar Order Masuk";
    return view('DetailBarangAll',$data);*/

    /*$cek = DB::table('tb_barang_keluar as a')->select("*")->where("a.no_kwitansi",$id)->get();
    if ($cek[0]->status_order == "2" || $cek[0]->status_order == "3") {
      $data['header'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                        ->select("a.*","d.nama as nama_pemilik","a.no_kwitansi as no_transfer","d.*")
                        ->where("a.no_kwitansi",$id)
                        ->get();
    }else{
      $data['header'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                        ->select("a.*","a.no_kwitansi as no_transfer","d.*")
                        ->where("a.no_kwitansi",$id)
                        ->get();
    }
    $data['barang'] = DB::table('tb_detail_barang_keluar as a')
                      ->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select("a.jumlah","b.*")
                      ->where("a.no_kwitansi",$id)
                      ->get();
    $data['back'] = "barangkeluar";
    return view('DetailBarangNota',$data);*/

    /*$data['nota'] = $id;
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
        $barang[$i][$a]['nama_barang'] = $value->nama_barang;
        $barang[$i][$a]['proses'] = $value->jumlah;
        $barang[$i][$a]['harga_jual'] = $value->harga_jual;
        $barang[$i][$a]['potongan'] = $value->potongan;
        $barang[$i][$a]['sub_total'] = $value->sub_total;
        $a++;
        $page = $x + 1;
        if ($page % 10 == 0) {
          $i++;
          $a=0;
        }
        $x++;
    }
    $data['detail'] = $barang;

    return view('CetakNota',$data);*/

    $cek = DB::table('tb_barang_keluar as a')->select("*")->where("a.no_kwitansi",$id)->get();
    if ($cek[0]->status_order == "2" || $cek[0]->status_order == "3") {
      $data['header'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_karyawan as d','d.id','=','a.id_konsumen')
                        ->select("a.*","d.nama as nama_pemilik","a.no_kwitansi as no_transfer","d.*")
                        ->where("a.no_kwitansi",$id)
                        ->get();
    }else{
      $data['header'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_konsumen as d','d.id','=','a.id_konsumen')
                        ->select("a.*","a.no_kwitansi as no_transfer","d.*")
                        ->where("a.no_kwitansi",$id)
                        ->get();
    }
    $data['barang'] = DB::table('tb_detail_barang_keluar as a')
                      ->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select("a.jumlah","a.warna_pilihan","b.*")
                      ->where("a.no_kwitansi",$id)
                      ->get();
    $data['back'] = "barangkeluar";

    $d = array();
    $warna = DB::table('kt_color')->get();
    foreach ($warna as $key => $value) {
      $d[$value->hex] = $value->warna;
    }
    foreach ($data['barang'] as $key => $value) {
      if($value->warna_pilihan !== null && $value->warna_pilihan !== ""){
        $data['barang'][$key]->warna = $d[$value->warna_pilihan];
      }else{
        $data['barang'][$key]->warna = "";
      }
    }
    return view('DetailBarang',$data);
  }



  public function printdetailorderstok($from,$to,$dari){
    if ($from != "null") { $fr = $from; }
    if ($to != "null") { $tp = $to; }
    if ($dari != "null") { $dr = $dari; }
    if (isset($fr) && isset($tp) && isset($dr)) {
      $data['data'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_gudang as b','b.id','=','a.dari')
                              ->join('tb_gudang as c','c.id','=','a.kepada')
                              ->join('tb_detail_transfer as d','d.no_transfer','=','a.no_transfer')
                              ->join('tb_barang as e','e.id','=','d.id_barang')
                              ->select("a.*","d.*","e.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                              ->where("a.status_transfer","order")
                              ->whereBetween('tanggal_order',[$fr,$tp])
                              ->where("kepada",$dr)
                              ->get();
    }elseif(isset($fr) && isset($tp)){
      $data['data'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_gudang as b','b.id','=','a.dari')
                              ->join('tb_gudang as c','c.id','=','a.kepada')
                              ->join('tb_detail_transfer as d','d.no_transfer','=','a.no_transfer')
                              ->join('tb_barang as e','e.id','=','d.id_barang')
                              ->select("a.*","d.*","e.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                              ->where("a.status_transfer","order")
                              ->whereBetween('tanggal_order',[$fr,$tp])
                              ->get();
    }elseif(isset($dr)) {
      $data['data'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_gudang as b','b.id','=','a.dari')
                              ->join('tb_gudang as c','c.id','=','a.kepada')
                              ->join('tb_detail_transfer as d','d.no_transfer','=','a.no_transfer')
                              ->join('tb_barang as e','e.id','=','d.id_barang')
                              ->select("a.*","d.*","e.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                              ->where("a.status_transfer","order")
                              ->where("kepada",$dr)
                              ->get();
    }else{
      $data['data'] = DB::table('tb_transfer_stok as a')
                              ->join('tb_gudang as b','b.id','=','a.dari')
                              ->join('tb_gudang as c','c.id','=','a.kepada')
                              ->join('tb_detail_transfer as d','d.no_transfer','=','a.no_transfer')
                              ->join('tb_barang as e','e.id','=','d.id_barang')
                              ->select("a.*","d.*","e.*","a.admin","b.nama_gudang as dari","c.nama_gudang as kepada")
                              ->where("a.status_transfer","order")
                              ->get();
    }
    $data['nama_download'] = "Daftar Order Stok";
    return view("printdetailorderstok",$data);
  }

  public function printdetailbarangkeluarall($from,$to,$status_order,$gudang,$sales,$pengembang,$kota){
    $d['a.id_gudang'] = $gudang;
    $d['a.status_order'] = $status_order;
    if ($sales != "null") {
      $d['a.sales'] = $sales;
    }
    if ($pengembang != "null") {
      $d['a.pengembang'] = $pengembang;
    }
    if ($kota != "null") {
      $data['kota'] = $kota;
    }
    if ($from != "null") {
      $dari = $from;
    }
    if ($to != "null") {
      $ke = $to;
    }

    $pg = DB::table('tb_barang_keluar as a')
                      ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                      ->select("*")
                      ->where($d)
                      ->where("a.status_barang","order")
                      ->count();

    $data['page'] = ceil($pg / 1000);

    if (isset($dari) && isset($ke)) {
      $data['barang'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                        ->select("*")
                        ->where($d)
                        ->whereBetween('tanggal_order',[$dari,$ke])
                        ->where("a.status_barang","order")
                        ->get();
    }else{
      //dd($d);
      $data['barang'] = DB::table('tb_barang_keluar as a')
                        ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                        ->select("*")
                        ->where($d)
                        ->where("a.status_barang","order")
                        ->get();
    }

    $text_barang = DB::table('tb_barang as a')->select("a.*")->get();
    $data['nmbarang'] = array();
    foreach ($text_barang as $value) {
      $data['nmbarang'][$value->id]['no_sku'] =$value->no_sku;
      $data['nmbarang'][$value->id]['nama_barang'] =$value->nama_barang;
      $data['nmbarang'][$value->id]['part_number'] =$value->part_number;
    }

    $kons = DB::table('tb_konsumen as a')->select("*")->get();
    $data['konsumen'] = array();
    foreach ($kons as $value) {
      $data['konsumen'][$value->id]['nama'] =$value->nama_pemilik;
      $data['konsumen'][$value->id]['alamat'] =$value->alamat;
      $data['konsumen'][$value->id]['kota'] =$value->kota;
    }

    $gdg = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gdg as $value) {
      $data['gudang'][$value->id]=$value->nama_gudang;
    }
      $kabupaten =  DB::table('regencies')->get();
      foreach ($kabupaten as $key => $value) {
        $data['data_kabupaten'][$value->id] = $value->name;
      }
    $data['nama_download'] = "Daftar Order Masuk";
    return view('DetailBarangAll',$data);
  }

  public function download_database(){
    return view('downloaddb');
  }

  public function import(Request $request){
    // validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);

		// menangkap file excel
		$file = $request->file('file');

		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();

		// upload ke folder file_siswa di dalam folder public
		$file->move('import',$nama_file);

		// import data
		Excel::import(new BarangImport, public_path('/import/'.$nama_file));

		// notifikasi dengan session
		Session::flash('sukses','Data Siswa Berhasil Diimport!');

		// alihkan halaman kembali
		return redirect()->back()->with('success','Berhasil');
  }

  public function import_konsumen(Request $request){
    // validasi
    $this->validate($request, [
      'file' => 'required|mimes:csv,xls,xlsx'
    ]);

    // menangkap file excel
    $file = $request->file('file');

    // membuat nama file unik
    $nama_file = rand().$file->getClientOriginalName();

    // upload ke folder file_siswa di dalam folder public
    $file->move('system/public/import',$nama_file);

    // import data
    Excel::import(new KonsumenImport, public_path('/import/'.$nama_file));

    // notifikasi dengan session
    //Session::flash('sukses','Data Siswa Berhasil Diimport!');

    // alihkan halaman kembali
    return redirect()->back()->with('success','Berhasil');
  }

  public function manager(){
    $data['manager'] = DB::table('tb_manager as a')
                      ->join('tb_karyawan as b','b.id','=','a.manager')
                      ->select("a.*","b.nama")
                      ->get();
    $data['karyawan'] = DB::table('tb_karyawan as a')
                      ->select("a.*")
                      ->where("a.status","=","aktif")->whereNull("a.jenis_konsumen")->orWhere("a.jenis_konsumen",'>',4)->where("a.status","=","aktif")
                      ->get();
    //dd($data);
    return view('Manager',$data);
  }

  public function carikota($id){
    $brand = DB::table('regencies as a')->where('a.name',"like","%$id%")->select("*")->get();
    echo json_encode($brand);
  }

  public function inputmanager(Request $post){
    $data = $post->except('_token');

    $cek= DB::table('tb_manager as a')
              ->select("a.*")
              ->where("a.kota",$data['kota'])
              ->get();
    if (count($cek) < 1) {
      DB::table('tb_manager')->insert($data);
      return redirect()->back()->with('success','Berhasil');
    }else{
      return redirect()->back()->with('error','Berhasil');
    }
  }

  public function updatemanager(Request $post){
    $data = $post->except('_token');
    DB::table('tb_manager')->where('id','=',$data['id'])->update($data);
    return redirect()->back()->with('success','Berhasil');
  }

  public function deletemanager($id){
    DB::table('tb_manager')->where('id', '=', $id)->delete();
    return redirect()->back()->with('success','Berhasil');
  }

  public function carimanager($kota){
    $cek= DB::table('tb_manager as a')
              ->join('tb_karyawan as b','b.id','=','a.manager')
              ->select("a.*","b.nama")
              ->where("a.kota",$kota)
              ->orWhere("a.id_kota",$kota)
              ->get();
    echo json_encode($cek);
  }

  public function carimanagerbyid($id){
    $cek= DB::table('tb_karyawan as a')
              ->select("a.*")
              ->where("a.id",$id)
              ->get();
    echo json_encode($cek);
  }

  public function updatekaryawan(Request $post){
    $data = $post->except('_token','old_nik');
    $old_nik = $post->only('old_nik');
    DB::table('tb_karyawan')->where('id','=',$data['id'])->update($data);
    $u['nik'] = $data['nik'];
    $u['name'] = $data['nama_lengkap'];
    $u['username'] = $data['nama'];
    DB::table('users')->where('id','=',Auth::user()->id)->update($u);

    $x['nik'] = $data['nik'];
    $x['nama_investor'] = $data['nama'];
    $x['nama_lengkap'] = $data['nama_lengkap'];
    $x['alamat'] = $data['alamat'];
    $x['no_hp'] = $data['no_hp'];
    $x['no_rekening'] = $data['no_rekening'];
    $x['ats_bank'] = $data['ats_bank'];
    $x['nama_bank'] = $data['nama_bank'];
    DB::table('tb_investor')->where('nik','=',$old_nik['old_nik'])->update($x);
    echo json_encode($u);
  }

  public function rekening(){
    if (role()) {
      $data['rekening'] = DB::table('tb_rekening as a')
                        ->select("a.*")
                        ->where("status","aktif")
                        ->get();
      //dd($data);
      return view('Rekening',$data);
    }else{
      return view('Denied');
    }
  }
    public function insertrekening(Request $post){
      if (role()) {
        $data = $post->except('_token');
        $data['status'] = "aktif";
        DB::table('tb_rekening')->insert($data);
        return redirect()->back()->with('success','Berhasil');
      }else{
        return view('Denied');
      }
    }

    public function updaterekening(Request $post){
      $data = $post->except('_token');
      DB::table('tb_rekening')->where('id','=',$data['id'])->update($data);
      return redirect()->back()->with('success','Berhasil');
    }

    public function deleterekening($id){
      $data['status'] = 'non aktif';
      DB::table('tb_rekening')->where('id','=',$id)->update($data);
      return redirect()->back()->with('success','Berhasil');
    }

    public function edt(){
      $data['apl'] = DB::table('aplikasi')->get();
      return view('EditWeb',$data);
    }

    public function fee(){
      $data['pfee'] = DB::table('persenfee')->get();
      return view('PersenInsentif',$data);
    }
    
    public function feesales(){
      $data['pfee'] = DB::table('persenfee')->get();
      return view('PersenInsentifSales',$data);
    }
    
    public function feejasa(){
      $data['pfee'] = DB::table('persenfee')->get();
      return view('PersenInsentifJasa',$data);
    }
    
    public function bagihasilinvestor(){
      $data['pinvest'] = DB::table('perseninvestor')->get();
      return view('PersenInvestor',$data);
    }

    public function saveaplikasi(Request $post){
      $data = $post->except('_token');

      $upd['nama'] = $data['nama'];
      $upd['deskripsi_index'] = $data['deskripsi_index'];
      $upd['keyword_index'] = $data['keyword_index'];
      if ($post->hasFile('icon')) {
        $target_dir = "gambar/";
        $passname = str_replace(" ","-",$post->file('icon')->getClientOriginalName());
        $target_file = $target_dir . $passname;
        move_uploaded_file($_FILES['icon']["tmp_name"], $target_file);
        $upd['icon'] = $passname;
      }
      if ($post->hasFile('favicon')) {
        $target_dir = "gambar/";
        $passname = str_replace(" ","-",$post->file('favicon')->getClientOriginalName());
        $target_file = $target_dir . $passname;
        move_uploaded_file($_FILES['favicon']["tmp_name"], $target_file);
        $upd['favicon'] = $passname;
      }
      if ($post->hasFile('foto')) {
        $target_dir = "gambar/";
        $passname = str_replace(" ","-",$post->file('foto')->getClientOriginalName());
        $target_file = $target_dir . $passname;
        move_uploaded_file($_FILES['foto']["tmp_name"], $target_file);
        $upd['foto'] = $passname;
      }
      if ($post->hasFile('gbr_booking')) {
        $target_dir = "gambar/";
        $passname = str_replace(" ","-",$post->file('gbr_booking')->getClientOriginalName());
        $target_file = $target_dir . $passname;
        move_uploaded_file($_FILES['gbr_booking']["tmp_name"], $target_file);
        $upd['gbr_booking'] = $passname;
      }
      if ($post->hasFile('barner1')) {
        $target_dir = "gambar/";
        $passname = str_replace(" ","-",$post->file('barner1')->getClientOriginalName());
        $target_file = $target_dir . $passname;
        move_uploaded_file($_FILES['barner1']["tmp_name"], $target_file);
        $upd['barner1'] = $passname;
      }
       if ($post->hasFile('barner2')) {
        $target_dir = "gambar/";
        $passname = str_replace(" ","-",$post->file('barner2')->getClientOriginalName());
        $target_file = $target_dir . $passname;
        move_uploaded_file($_FILES['barner2']["tmp_name"], $target_file);
        $upd['barner2'] = $passname;
      }
       if ($post->hasFile('barner3')) {
        $target_dir = "gambar/";
        $passname = str_replace(" ","-",$post->file('barner3')->getClientOriginalName());
        $target_file = $target_dir . $passname;
        move_uploaded_file($_FILES['barner3']["tmp_name"], $target_file);
        $upd['barner3'] = $passname;
      }
      $upd['alamat'] = $data['alamat'];
      $upd['gmaps'] = $data['gmaps'];
      $upd['cs'] = $data['cs'];
      $upd['no_hp'] = $data['no_hp'];
      $upd['console'] = $data['console'];
      $upd['rechaptca'] = $data['rechaptca'];
      $upd['secretkey'] = $data['secretkey'];
        
      $upd['sandbox_server'] = $data['sandbox_server'];
      $upd['sandbox_client'] = $data['sandbox_client'];
      $upd['production_server'] = $data['production_server'];
      $upd['production_client'] = $data['production_client'];
      $upd['develop'] = $data['develop'];

      $upd['analystics'] = $data['analystics'];
      $upd['toko'] = $data['toko'];
      $upd['apk'] = $data['apk'];
      $upd['email'] = $data['email'];
      $upd['facebook'] = $data['facebook'];
      $upd['instagram'] = $data['instagram'];
      $upd['youtube'] = $data['youtube'];
      $upd['shopee'] = $data['shopee'];
      $upd['tokopedia'] = $data['tokopedia'];
      $upd['lazada'] = $data['lazada'];
      $upd['blibli'] = $data['blibli'];
      $upd['tiktok'] = $data['tiktok'];
      
      $upd['ongkir'] = $data['ongkir'];
      $upd['booking'] = $data['booking'];
      $upd['jdl_booking'] = $data['jdl_booking'];
      $upd['text_booking'] = $data['text_booking'];
      
      DB::table('aplikasi')->where('id','<>',0)->update($upd);
      return redirect()->back()->with('success','Berhasil');
    }
    
    public function savepersenfee(Request $post){
      $data = $post->except('_token');
      $updf['pereferralUR'] = $data['pereferralUR'];
      $updf['upline1UR'] = $data['upline1UR'];
      $updf['upline2UR'] = $data['upline2UR'];
      $updf['pereferralUA'] = $data['pereferralUA'];
      $updf['upline1UA'] = $data['upline1UA'];
      $updf['pereferralUD'] = $data['pereferralUD'];
      $updf['pereferralRA'] = $data['pereferralRA'];
      $updf['upline1RA'] = $data['upline1RA'];
      $updf['pereferralRD'] = $data['pereferralRD'];
      $updf['pereferralAD'] = $data['pereferralAD'];
      $updf['pereferralUU'] = $data['pereferralUU'];
      $updf['upline1UU'] = $data['upline1UU'];
      $updf['upline2UU'] = $data['upline2UU'];
      $updf['upline3UU'] = $data['upline3UU'];
      $updf['pereferralRR'] = $data['pereferralRR'];
      $updf['upline1RR'] = $data['upline1RR'];
      $updf['upline2RR'] = $data['upline2RR'];
      $updf['pereferralAA'] = $data['pereferralAA'];
      $updf['upline1AA'] = $data['upline1AA'];
      $updf['pereferralDD'] = $data['pereferralDD'];
      $updf['pereferralRU'] = $data['pereferralRU'];
      $updf['upline1RU'] = $data['upline1RU'];
      $updf['upline2RU'] = $data['upline2RU'];
      $updf['upline3RU'] = $data['upline3RU'];
      $updf['pereferralAU'] = $data['pereferralAU'];
      $updf['upline1AU'] = $data['upline1AU'];
      $updf['upline2AU'] = $data['upline2AU'];
      $updf['upline3AU'] = $data['upline3AU'];
      $updf['pereferralDU'] = $data['pereferralDU'];
      $updf['upline1DU'] = $data['upline1DU'];
      $updf['upline2DU'] = $data['upline2DU'];
      $updf['upline3DU'] = $data['upline3DU'];
      $updf['pereferralDA'] = $data['pereferralDA'];
      $updf['upline1DA'] = $data['upline1DA'];
      $updf['pereferralAR'] = $data['pereferralAR'];
      $updf['upline1AR'] = $data['upline1AR'];
      $updf['upline2AR'] = $data['upline2AR'];
      $updf['pereferralDR'] = $data['pereferralDR'];
      $updf['upline1DR'] = $data['upline1DR'];
      $updf['upline2DR'] = $data['upline2DR'];
      
      $updf['itung_a'] = $data['itung_a'];
      $updf['itung_b'] = $data['itung_b'];
      $updf['sales'] = $data['sales'];
      $updf['pengembang'] = $data['pengembang'];
      $updf['leader'] = $data['leader'];
      $updf['manager'] = $data['manager'];
      $updf['dropper'] = $data['dropper'];
      $updf['pengirim'] = $data['pengirim'];
      $updf['helper'] = $data['helper'];
      $updf['admin_g'] = $data['admin_g'];
      $updf['admin_v'] = $data['admin_v'];
      $updf['admin_k'] = $data['admin_k'];
      $updf['qc'] = $data['qc'];
      $updf['stokis'] = $data['stokis'];
      DB::table('persenfee')->where('id','=',1)->update($updf);
      return redirect()->back()->with('success','Berhasil');
    }
    
    public function savepersenfee1(Request $post){
      $data = $post->except('_token');
      $updf['itung_a'] = $data['itung_a'];
      $updf['itung_b'] = $data['itung_b'];
      $updf['sales'] = $data['sales'];
      $updf['pengembang'] = $data['pengembang'];
      $updf['leader'] = $data['leader'];
      $updf['manager'] = $data['manager'];
      $updf['dropper'] = $data['dropper'];
      $updf['pengirim'] = $data['pengirim'];
      $updf['helper'] = $data['helper'];
      $updf['admin_g'] = $data['admin_g'];
      $updf['admin_v'] = $data['admin_v'];
      $updf['admin_k'] = $data['admin_k'];
      $updf['qc'] = $data['qc'];
      $updf['stokis'] = $data['stokis'];
      DB::table('persenfee')->where('id','=',2)->update($updf);
      return redirect()->back()->with('success','Berhasil');
    }
    public function savepersenfee2(Request $post){
      $data = $post->except('_token');
      $updf['petugas1a'] = $data['petugas1a'];
      $updf['petugas1b'] = $data['petugas1b'];
      $updf['petugas2b'] = $data['petugas2b'];
      $updf['petugas1c'] = $data['petugas1c'];
      $updf['petugas2c'] = $data['petugas2c'];
      $updf['petugas3c'] = $data['petugas3c'];
      
      $updf['itung_a'] = $data['itung_a'];
      $updf['itung_b'] = $data['itung_b'];
      $updf['sales'] = $data['sales'];
      $updf['pengembang'] = $data['pengembang'];
      $updf['leader'] = $data['leader'];
      $updf['manager'] = $data['manager'];
      $updf['admin_k'] = $data['admin_k'];
      $updf['qc'] = $data['qc'];
      $updf['stokis'] = $data['stokis'];
      DB::table('persenfee')->where('id','=',3)->update($updf);
      return redirect()->back()->with('success','Berhasil');
    }
    
    public function saveperseninvest(Request $post){
      $data = $post->except('_token');
      $updf['pengadaanbasilA'] = $data['pengadaanbasilA'];
      $updf['pengadaanbasilB'] = $data['pengadaanbasilB'];
      $updf['pengadaanbasilC'] = $data['pengadaanbasilC'];
      $updf['pengadaanLS3'] = $data['pengadaanLS3'];
      $updf['pengadaanLS6'] = $data['pengadaanLS6'];
      $updf['pengadaanLS12'] = $data['pengadaanLS12'];
      $updf['pengadaan_P'] = $data['pengadaan_P'];
      $updf['pengadaan_L'] = $data['pengadaan_L'];
      
      $updf['investasiLS3'] = $data['investasiLS3'];
      $updf['investasiLS6'] = $data['investasiLS6'];
      $updf['investasiLS12'] = $data['investasiLS12'];
      $updf['investasi_P'] = $data['investasi_P'];
      $updf['investasi_L'] = $data['investasi_L'];

      DB::table('perseninvestor')->where('id','<>',0)->update($updf);
      return redirect()->back()->with('success','Berhasil');
    }
    
    
   

    public function gudang_service(){
      $data['gudang'] = DB::table('tb_gudang_service')->where('status','aktif')->get();
      $data['provinsi'] =  DB::table('provinces')->get();
      $data['kabupaten'] =  DB::table('regencies')->get();
      $data['kecamatan'] =  DB::table('districts')->get();
      foreach ($data['provinsi'] as $key => $value) {
        $data['data_provinsi'][$value->id] = $value->name;
      }
      foreach ($data['kabupaten'] as $key => $value) {
        $data['data_kabupaten'][$value->id] = $value->name;
      }
      foreach ($data['kecamatan'] as $key => $value) {
        $data['data_kecamatan'][$value->id] = $value->name;
      }
      return view('Pengaturan.gudang_service',$data);
    }

    public function insertgudangservice(Request $post){
      $data = $post->except('_token');
      $data['status'] = "aktif";

      $c = DB::table('tb_gudang_service as a')->select("*")->orderBy('id', 'DESC')->limit(1)->get();

      if (count($c) > 0) {
        $id = $c[0]->id + 1;
      }else{
        $id = '1';
      }
      $data['id'] = $id ;
      DB::table('tb_gudang_service')->insert($data);
      return redirect()->back()->with('success','Berhasil');
    }

    public function editgudangservice($id){
      $data['gudang'] = DB::table('tb_gudang_service')->where('id',$id)->get();
      $data['kabupaten'] = DB::table('regencies as a')
                           ->select("*")
                           ->where("a.province_id","=",$data['gudang'][0]->provinsi)
                           ->get();
      $data['kecamatan'] = DB::table('districts as a')
                           ->select("*")
                           ->where("a.regency_id","=",$data['gudang'][0]->kabupaten)
                           ->get();
      echo json_encode($data);
    }

    public function updategudangservice(Request $post){
      $data = $post->except('_token','id','karyawan');
      if ($post->karyawan == null || $post->karyawan == "") {
      }else{
        $data['karyawan'] = $post->karyawan;
      }
      $id = $post->only('id');
      $q = DB::table('tb_gudang_service')->where('id','=',$id)->update($data);
      if ($q) {
            return redirect()->back()->with('success','Berhasil');
      }else{
            return redirect()->back()->with('error','Gagal');
      }
    }

    public function deletegudangservice($id){
      $data['status'] = "non aktif";
      DB::table('tb_gudang_service')->where('id','=',$id)->update($data);
      return redirect()->back()->with('success','Berhasil');
    }



    public function cetaklabel($id){

    $cek = DB::table('tb_barang_keluar as a')->select("*")->where("a.no_kwitansi",$id)->get();
    if ($cek[0]->status_order == "2" || $cek[0]->status_order == "3") {
      $data['transfer'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_karyawan as c','c.id','=','a.id_konsumen')
                            ->join('users as e','e.id','=','a.admin_p')
                            ->join('tb_karyawan as f','f.id','=','a.sales')
                            ->leftJoin('tb_karyawan as g','g.id','=','a.pengirim')
                            ->select("a.no_kwitansi","a.tanggal_proses","a.dropship","a.tujuan","c.nama as nama_pemilik","c.alamat","c.no_hp"
                                      ,"e.name as admin_p","f.nama as sales","g.nama as pengirim","a.ongkos_kirim")
                            ->where("a.no_kwitansi","=",$id)->get();
    }else{
      $data['transfer'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_konsumen as c','c.id','=','a.id_konsumen')
                            ->join('users as e','e.id','=','a.admin_p')
                            ->join('tb_karyawan as f','f.id','=','a.sales')
                            ->leftJoin('tb_karyawan as g','g.id','=','a.pengirim')
                            ->select("a.no_kwitansi","a.tanggal_proses","a.dropship","a.tujuan","c.nama_pemilik","c.alamat","c.no_hp","c.kecamatan","c.kota","c.provinsi"
                                      ,"e.name as admin_p","f.nama as sales","g.nama as pengirim","a.ongkos_kirim")
                            ->where("a.no_kwitansi","=",$id)->get();
    }
    $data['ongkos_kirim'] = $data['transfer'][0]->ongkos_kirim;
    $data['barang'] = DB::table('tb_detail_barang_keluar as a')
                      ->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select("*")
                      ->where("a.no_kwitansi",$id)
                      ->get();
    $data['dt'] = count($data['barang']);
    $page = ceil($data['dt']/10);

    $barang = array();
    $i = 0;
    $a = 0;
    $x = 0;
    foreach ($data['barang'] as $value) {
      if (($value->terkirim == null && $value->proses > 0) || $value->terkirim != 0) {
        $barang[$i][$a]['nama_barang'] = $value->nama_barang;
        $barang[$i][$a]['proses'] = $value->proses;
        $barang[$i][$a]['harga_jual'] = $value->harga_jual;
        $barang[$i][$a]['potongan'] = $value->potongan;
        $barang[$i][$a]['sub_total'] = $value->sub_total;
        $a++;
        $page = $x + 1;
        if ($page % 10 == 0) {
          $i++;
          $a=0;
        }
        $x++;
      }
    }
    //dd($barang);
    $data['detail'] = $barang;

    $data['pembayaran'] = DB::table('tb_detail_pembayaran as a')
                      //->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select(DB::raw('SUM(a.pembayaran) as total_bayar'))
                      ->where("a.no_kwitansi",$id)
                      ->get();
    $data['tagihan'] = DB::table('tb_detail_barang_keluar as a')
                      //->join('tb_barang as b','b.id','=','a.id_barang')
                      ->select(DB::raw('SUM(a.sub_total) as tagihan'))
                      ->where("a.no_kwitansi",$id)
                      ->get();

    $data['alamat'] = DB::table('tb_gudang as a')
                      ->join('tb_barang_keluar as b','b.id_gudang','=','a.id')
                      ->select("a.*")
                      ->where("b.no_kwitansi",$id)
                      ->get();

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
    
    if(count($data['transfer']) > 0){
        if(isset($data['transfer'][0]->dropship) && isset($data['transfer'][0]->tujuan)){
            $data['drp'] = DB::table('kt_alamat')->where('id',$data['transfer'][0]->tujuan)->get();
        }
    }
    return view('CetakLabel',$data);
  }

}
