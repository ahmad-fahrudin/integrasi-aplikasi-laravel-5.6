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

class InvestasiControllerJakarta extends Controller
{
  var $model;
  public function __construct()
  {
      $this->model = new Mase;
  }

  public function inputpengadaanbarang(){
    if (role()) {
    $data['stok'] = DB::table('tb_barang as a')
    ->join('tb_gudang_barang as b','b.id_barang','=','a.id')
    ->join('tb_harga as c','c.id_barang','=','a.id')
    ->leftJoin('tb_previllage as d','d.id_gudang','=','b.id_gudang')
    ->select("a.*","a.id as id_barang","c.harga","c.harga_hpp",DB::raw('SUM(b.jumlah) as stok'))
    ->whereNotNull("d.id_gudang")
    ->groupBy("b.id_barang")
    ->get();
    $data['barangkeluar'] = DB::table('tb_barang_keluar as a')
                            ->join('tb_detail_barang_keluar as b','b.no_kwitansi','=','a.no_kwitansi')
                            ->leftJoin('tb_previllage as c','c.id_gudang','=','a.id_gudang')
                            ->select("b.id_barang","b.jumlah","b.harga_jual","b.harga_net")
                            ->where("a.status_barang","order")
                            ->whereNotNull("c.id_gudang")
                            ->get();

    $harga =  DB::table('tb_harga as a')->select("*")->get();
    foreach ($harga as $key => $value) {
      $data['harga'][$value->id_barang]['harga_hpp'] = $value->harga_hpp;
      $data['harga'][$value->id_barang]['harga_hp'] = $value->harga_hp;
    }

    $data['pengadaan'] = DB::table('tb_pengadaan_investasi_jkt as a')
                            ->select("*")
                            ->whereNull('a.status')
                            ->whereNull('a.active')
                            ->orWhere('a.status','proses')
                            ->whereNull('a.active')
                            ->get();

    $data['kulakan'] = array();
    foreach ($data['stok'] as $key => $value) {
      $data['kulakan'][$value->id]['no_sku'] = $value->no_sku;
      $data['kulakan'][$value->id]['nama_barang'] = $value->nama_barang;
      $data['kulakan'][$value->id]['stok'] = $value->stok;
      $data['kulakan'][$value->id]['orderan'] = "0";
      $data['kulakan'][$value->id]['harga_hpp'] = $value->harga_hpp;
      $data['kulakan'][$value->id]['harga'] = $value->harga;
      $data['kulakan'][$value->id]['id_barang'] = $value->id_barang;
      $data['kulakan'][$value->id_barang]['investasi'] = "0";
      $data['kulakan'][$value->id_barang]['jumlah_kulak'] = 0 - $value->stok;
      $data['kulakan'][$value->id_barang]['bagi_hasil'] = "0";
      $data['kulakan'][$value->id_barang]['cek'] = false;
    }

    /*foreach ($data['transferstok'] as $key => $value) {
      $data['kulakan'][$value->id_barang]['orderan'] += $value->orderan;
    }*/

    if (count($data['pengadaan']) > 0) {
      foreach ($data['pengadaan'] as $key => $value) {
        $data['kulakan'][$value->id_barang]['investasi'] += $value->jumlah_kulakan;
        $data['kulakan'][$value->id_barang]['jumlah_kulak'] -= $value->jumlah_kulakan;
      }
    }

    foreach ($data['barangkeluar'] as $key => $value) {
      if ($data['kulakan'][$value->id_barang]['cek']) {
        $temp = $value->jumlah;
      }else{
        $temp = $data['kulakan'][$value->id_barang]['jumlah_kulak'] + $value->jumlah;
      }
      $data['kulakan'][$value->id_barang]['jumlah_kulak'] += $value->jumlah;
      $data['kulakan'][$value->id_barang]['orderan'] += $value->jumlah;
      if($data['kulakan'][$value->id_barang]['jumlah_kulak'] > 0){
        $data['kulakan'][$value->id_barang]['cek'] = true;

        if ($value->harga_jual > $data['harga'][$value->id_barang]['harga_hpp']) {
          $data['kulakan'][$value->id_barang]['bagi_hasil'] += ($temp * ($data['harga'][$value->id_barang]['harga_hpp'] - $data['harga'][$value->id_barang]['harga_hp'])) / 4;
        }if ($value->harga_jual < $data['harga'][$value->id_barang]['harga_hp']) {
          $data['kulakan'][$value->id_barang]['bagi_hasil'] += 0;
        }else{
          $data['kulakan'][$value->id_barang]['bagi_hasil'] += ($temp * ($value->harga_jual - $data['harga'][$value->id_barang]['harga_hp'])) / 4;
        }

      }
    }

    return view('InputPengadaanBarangJakarta',$data);
  }else{
    return view('Denied');
  }
  }

  public function pengadaanbarangjakarta()
  {
    if (role()) {
      $data['pengadaan'] = DB::table('tb_pengadaan_investasi_jkt as a')
                              ->join('tb_barang as b','b.id','=','a.id_barang')
                              ->select("*","a.id as id_investasi")
                              ->whereNull('a.tgl_ambil')
                              ->whereNull('a.id_pengambil')
                              ->get();
    $data['pending'] = DB::table('tb_pengadaan_investasi as a')
                            ->select(DB::raw('SUM(a.jumlah_investasi) as jumlah_investasi'))
                            ->where('a.id_pengambil',Auth::user()->id)
                            ->whereNull('a.status')
                            ->get();
    $data['pending_jkt'] = DB::table('tb_pengadaan_investasi_jkt as a')
                            ->select(DB::raw('SUM(a.jumlah_investasi) as jumlah_investasi'))
                            ->where('a.id_pengambil',Auth::user()->id)
                            ->whereNull('a.status')
                            ->get();
      return view('PengadaanBarangJakarta',$data);
    }else{
      return view('Denied');
    }
  }

  public function simpanpengadaanjakarta(Request $post){
    $d = $post->except('_token');
    for ($i=1; $i < $d['loop']; $i++) {
      if (isset($d['cek'.$i])) {
        $data['id_barang'] = $d['id_barang'.$i];
        $data['jumlah_kulakan'] = $d['jumlah_kulakan'.$i];
        $data['jumlah_investasi'] = $d['jumlah_investasi'.$i];
        $data['estimasi_pendapatan'] = $d['estimasi_pendapatan'.$i];
        $data['estimasi_waktu'] = $d['estimasi_waktu'.$i];
        $data['admin_input'] = Auth::user()->id;
        DB::table('tb_pengadaan_investasi_jkt')->insert($data);
      }
    }
    return redirect()->route('pengadaanbarangjakarta')->with('success','Berhasil');
  }

  public function updateinves($id,$estimasi){
    $data['estimasi_waktu'] = $estimasi;
    DB::table('tb_pengadaan_investasi_jkt')->where('id','=',$id)->update($data);
    echo $estimasi;
  }

  public function deleteinves($id){
    DB::table('tb_pengadaan_investasi_jkt')->where('id',$id)->delete();
    echo $id;
  }

  public function deleteinvest($id){
    $data['active'] = 'delete';
    DB::table('tb_pengadaan_investasi_jkt')->where('id',$id)->update($data);
    echo $id;
  }

  public function prosesinves($id,$status){
    if ($status == "selesai") {
      $data['status'] = $status;
      $query = DB::table('tb_pengadaan_investasi_jkt')->where('id',$id)->update($data);

      if ($query) {
        $d = DB::table('tb_pengadaan_investasi_jkt as a')
             ->join('users as b','b.id','=','a.id_pengambil')
             ->join('tb_investor as c','c.nik','=','b.nik')
             ->select("a.*","c.id as id_inves","c.saldo as saldo_inves","c.nik","c.nama_investor","c.pengembang","c.leader")->where('a.id','=',$id)->get();

       if ($d[0]->pengembang != "") {
         $estimasi_pendapatan = 80/100*$d['0']->estimasi_pendapatan;
       }else{
         $estimasi_pendapatan = $d['0']->estimasi_pendapatan;
       }

        $x['saldo'] = $d['0']->saldo_inves + $estimasi_pendapatan + $d['0']->jumlah_investasi;
        DB::table('tb_investor')->where('nik','=',$d['0']->nik)->update($x);

        $y['id_investor'] = $d['0']->id_inves;
        $y['jumlah'] = $d['0']->jumlah_investasi;
        $y['saldo_temp'] = $d['0']->saldo_inves + $d['0']->jumlah_investasi;
        $y['jenis'] = "selesai";
        $y['id_pengadaan'] = $d['0']->id;
        $y['id_barang'] = $d['0']->id_barang;
        $y['jumlah_Barang'] = $d['0']->jumlah_kulakan;
        $y['admin'] = $d['0']->admin_proses;
        DB::table('tb_transaksi')->insert($y);

        $c['id_investor'] = $d['0']->id_inves;
        $c['jumlah'] = $estimasi_pendapatan;
        $c['saldo_temp'] = $x['saldo'];
        $c['jenis'] = "bagi";
        $c['id_pengadaan'] = $d['0']->id;
        $c['id_barang'] = $d['0']->id_barang;
        $c['jumlah_Barang'] = $d['0']->jumlah_kulakan;
        $c['admin'] = $d['0']->admin_proses;
        DB::table('tb_transaksi')->insert($c);

        $barang = DB::table('tb_barang')->select("*")->where('id',$d['0']->id_barang)->get();

        $dlr = DB::table('tb_labarugi')->select("*")->where('status','aktif')->orderBy("id","DESC")->limit(1)->get();
        $lr['jumlah'] = $estimasi_pendapatan;
        if(count($dlr)>0){
            $lr['saldo_temp'] = $dlr['0']->saldo_temp + $estimasi_pendapatan;
        }else{
            $lr['saldo_temp'] = $estimasi_pendapatan;
        }
        $lr['jenis'] = "out";
        $lr['nama_jenis'] = "Bagi Hasil Pengadaan - (".$y['jumlah_barang'].") ".$barang[0]->nama_barang;
        $lr['admin'] = Auth::user()->id;
        $lr['keterangan'] = "- ".$d['0']->nama_investor;
        DB::table('tb_labarugi')->insert($lr);

        if ($d[0]->pengembang != "") {
          $d_pengembang_investor = DB::table('tb_investor')->select("*")->where("id",$d[0]->pengembang)->get();
          $bagi_pengembang_investor = 15/100*$d['0']->estimasi_pendapatan;
          DB::table('tb_investor')->where('id',$d[0]->pengembang)->increment('saldo', $bagi_pengembang_investor);

          $pengembang_investor['id_investor'] = $d[0]->pengembang;
          $pengembang_investor['jumlah'] = $bagi_pengembang_investor;
          $pengembang_investor['saldo_temp'] = $d_pengembang_investor[0]->saldo + $bagi_pengembang_investor;
          $pengembang_investor['jenis'] = "bagipengembang";
          $pengembang_investor['id_pengadaan'] = $d['0']->id;
          $pengembang_investor['id_barang'] = $d['0']->id_barang;
          $pengembang_investor['jumlah_barang'] = $d['0']->jumlah_kulakan;
          $pengembang_investor['admin'] = $d['0']->admin_proses;
          $pengembang_investor['keterangan'] = $d['0']->nama_investor;
          DB::table('tb_transaksi')->insert($pengembang_investor);

          $dlr_pengembang = DB::table('tb_labarugi')->select("*")->where('status','aktif')->orderBy("id","DESC")->limit(1)->get();
          $lr_pengembang['jumlah'] = $bagi_pengembang_investor;
          $lr_pengembang['saldo_temp'] = $dlr_pengembang['0']->saldo_temp + $bagi_pengembang_investor;
          $lr_pengembang['jenis'] = "out";
          $lr_pengembang['nama_jenis'] = "Bagi Hasil Pengadaan Pengembang";
          $lr_pengembang['admin'] = Auth::user()->id;
          $lr_pengembang['keterangan'] = "(".$d['0']->nama_investor.") - ".$d_pengembang_investor['0']->nama_investor;
          DB::table('tb_labarugi')->insert($lr_pengembang);
        }

        if ($d[0]->leader != "") {
          $d_leader_investor = DB::table('tb_investor')->select("*")->where("id",$d[0]->leader)->get();

          $bagi_leader_investor = 5/100*$d['0']->estimasi_pendapatan;
          DB::table('tb_investor')->where('id',$d[0]->leader)->increment('saldo', $bagi_leader_investor);

          $leader_investor['id_investor'] = $d[0]->leader;
          $leader_investor['jumlah'] = $bagi_leader_investor;
          $leader_investor['saldo_temp'] = $d_leader_investor[0]->saldo + $bagi_leader_investor;
          $leader_investor['jenis'] = "bagileader";
          $leader_investor['id_pengadaan'] = $d['0']->id;
          $leader_investor['id_barang'] = $d['0']->id_barang;
          $leader_investor['jumlah_barang'] = $d['0']->jumlah_kulakan;
          $leader_investor['admin'] = $d['0']->admin_proses;
          $leader_investor['keterangan'] = $d['0']->nama_investor;
          DB::table('tb_transaksi')->insert($leader_investor);

          $dlr_leader = DB::table('tb_labarugi')->select("*")->where('status','aktif')->orderBy("id","DESC")->limit(1)->get();
          $lr_leader['jumlah'] = $bagi_leader_investor;
          $lr_leader['saldo_temp'] = $dlr_leader['0']->saldo_temp + $bagi_leader_investor;
          $lr_leader['jenis'] = "out";
          $lr_leader['nama_jenis'] = "Bagi Hasil Pengadaan Leader";
          $lr_leader['admin'] = Auth::user()->id;
          $lr_leader['keterangan'] = "(".$d['0']->nama_investor.") - ".$d_leader_investor['0']->nama_investor;
          DB::table('tb_labarugi')->insert($lr_leader);
        }

      }
    }else{
      date_default_timezone_set('Asia/Jakarta');
      $data['tanggal_proses'] = date('Y-m-d');
      $data['status'] = $status;
      $data['admin_proses'] = Auth::user()->id;
      $query = DB::table('tb_pengadaan_investasi_jkt')->where('id',$id)->update($data);

      if ($query) {
        $cxc = DB::table('tb_pengadaan_investasi_jkt')->select("*")->where('id','=',$id)->get();
        $user = DB::table('users')->select("*")->where('id','=',$cxc[0]->id_pengambil)->get();
        $saldo_temp = DB::table('tb_investor')->select("*")->where('nik','=',$user[0]->nik)->get();

        $cx['saldo'] = $saldo_temp[0]->saldo - $cxc['0']->jumlah_investasi;
        DB::table('tb_investor')->where('id','=',$saldo_temp[0]->id)->update($cx);

        $xc['status'] = "aktif";
        $xc['saldo_temp'] = $cx['saldo'];

        DB::table('tb_transaksi')->where('id_investor','=',$saldo_temp[0]->id)->where('id_pengadaan',$id)->update($xc);
      }
    }

    echo $id;
  }

  public function simpaninves($id){
    $loop = explode(",",$id);
    $data['tgl_ambil'] = date('Y-m-d');
    for ($i=0; $i < count($loop); $i++) {
      if ($loop[$i] != "") {
        $data['id'] = $loop[$i];
        $data['id_pengambil'] = Auth::user()->id;
        $query = DB::table('tb_pengadaan_investasi_jkt')->where('id','=',$data['id'])->update($data);

        if ($query) {
          $d = DB::table('tb_pengadaan_investasi_jkt')->select("*")->where('id','=',$data['id'])->get();
          $saldo_temp = saldo();
          //$x['saldo'] = $saldo_temp - $d['0']->jumlah_investasi;
          //DB::table('tb_investor')->where('nik','=',Auth::user()->nik)->update($x);

          $c['id_investor'] = cekmyid_investor();
          $c['jumlah'] = $d['0']->jumlah_investasi;
          //$c['saldo_temp'] = $x['saldo'];
          $c['saldo_temp'] = $saldo_temp;
          $c['jenis'] = "pengadaan";
          $c['id_pengadaan'] = $d['0']->id;
          $c['id_barang'] = $d['0']->id_barang;
          $c['jumlah_barang'] = $d['0']->jumlah_kulakan;
          $c['admin'] = $d['0']->admin_input;
          $c['status'] = "pending";
          DB::table('tb_transaksi')->insert($c);

        }

      }
    }
    echo json_encode($loop);
  }

  public function datapengadaanbarang(){
    if (role()) {
      if (Auth::user()->level == "6") {
        $data['pengadaan_pending'] = DB::table('tb_pengadaan_investasi_jkt as a')
                                ->join('tb_barang as b','b.id','=','a.id_barang')
                                ->select("*","a.id as id_investasi","a.status as status")
                                ->whereNotNull('a.tgl_ambil')
                                ->whereNotNull('a.id_pengambil')
                                ->where('a.id_pengambil',Auth::user()->id)
                                ->whereNull('a.active')
                                ->whereNull('a.status')
                                ->get();
        $data['pengadaan_proses'] = DB::table('tb_pengadaan_investasi_jkt as a')
                                ->join('tb_barang as b','b.id','=','a.id_barang')
                                ->select("*","a.id as id_investasi","a.status as status")
                                ->whereNotNull('a.tgl_ambil')
                                ->whereNotNull('a.id_pengambil')
                                ->where('a.id_pengambil',Auth::user()->id)
                                ->whereNull('a.active')
                                ->where('a.status','proses')
                                ->get();
        $data['pengadaan_selesai'] = DB::table('tb_pengadaan_investasi_jkt as a')
                                ->join('tb_barang as b','b.id','=','a.id_barang')
                                ->select("*","a.id as id_investasi","a.status as status")
                                ->whereNotNull('a.tgl_ambil')
                                ->whereNotNull('a.id_pengambil')
                                ->where('a.id_pengambil',Auth::user()->id)
                                ->whereNull('a.active')
                                ->where('a.status','selesai')
                                ->get();                        
      }else{
        $data['pengadaan_pending'] = DB::table('tb_pengadaan_investasi_jkt as a')
                                ->join('tb_barang as b','b.id','=','a.id_barang')
                                ->select("*","a.id as id_investasi","a.status as status")
                                ->whereNotNull('a.tgl_ambil')
                                ->whereNotNull('a.id_pengambil')
                                ->whereNull('a.active')
                                ->whereNull('a.status')
                                ->get();
        $data['pengadaan_proses'] = DB::table('tb_pengadaan_investasi_jkt as a')
                                ->join('tb_barang as b','b.id','=','a.id_barang')
                                ->select("*","a.id as id_investasi","a.status as status")
                                ->whereNotNull('a.tgl_ambil')
                                ->whereNotNull('a.id_pengambil')
                                ->whereNull('a.active')
                                ->where('a.status','proses')
                                ->get();
        $data['pengadaan_selesai'] = DB::table('tb_pengadaan_investasi_jkt as a')
                                ->join('tb_barang as b','b.id','=','a.id_barang')
                                ->select("*","a.id as id_investasi","a.status as status")
                                ->whereNotNull('a.tgl_ambil')
                                ->whereNotNull('a.id_pengambil')
                                ->whereNull('a.active')
                                ->where('a.status','selesai')
                                ->get();
      }
      $data['user'] = DB::table('users as a')->select("*")->get();
      foreach ($data['user'] as $value) {
        $data['admin'][$value->id] =$value->name;
      }
      $data['investor'] = array();
      $investor = DB::table('users as a')->join('tb_investor as b','b.nik','=','a.nik')->select("a.*","b.alamat","b.no_hp")->where("a.status","aktif")->get();
      foreach ($investor as $value) {
        $data['investor'][$value->id]['id'] =$value->id;
        $data['investor'][$value->id]['nama'] =$value->name;
        $data['investor'][$value->id]['alamat'] =$value->alamat;
        $data['investor'][$value->id]['no_hp'] =$value->no_hp;
      }
      //dd($data);
      return view('DataPengadaanBarangJakarta',$data);
    }else{
      return view('Denied');
    }
  }

  public function datapengadaanbarangs(Request $post){
    $d = $post->except('_token');
    if (isset($d['id_pengambil'])) {
      $u['id_pengambil'] = $d['id_pengambil'];
      $data['id_pengambil'] = $d['id_pengambil'];
      $data['nama_pengambil'] = $d['nama_pengambil'];
    }
    if(isset($u)){
      $data['status'] = array();
      $data['pengadaan_pending'] = DB::table('tb_pengadaan_investasi_jkt as a')
                              ->join('tb_barang as b','b.id','=','a.id_barang')
                              ->select("*","a.id as id_investasi","a.status as status")
                              ->where($u)
                              ->whereNotNull('a.tgl_ambil')
                              ->whereNotNull('a.id_pengambil')
                              ->whereNull('a.active')
                              ->whereNull('a.status')
                              ->get();
      $data['pengadaan_proses'] = DB::table('tb_pengadaan_investasi_jkt as a')
                              ->join('tb_barang as b','b.id','=','a.id_barang')
                              ->select("*","a.id as id_investasi","a.status as status")
                              ->where($u)
                              ->whereNotNull('a.tgl_ambil')
                              ->whereNotNull('a.id_pengambil')
                              ->whereNull('a.active')
                              ->where('a.status','proses')
                              ->get();
      $data['pengadaan_selesai'] = DB::table('tb_pengadaan_investasi_jkt as a')
                              ->join('tb_barang as b','b.id','=','a.id_barang')
                              ->select("*","a.id as id_investasi","a.status as status")
                              ->where($u)
                              ->whereNotNull('a.tgl_ambil')
                              ->whereNotNull('a.id_pengambil')
                              ->whereNull('a.active')
                              ->where('a.status','selesai')
                              ->get();
    }
    $data['user'] = DB::table('users as a')->select("*")->get();
    foreach ($data['user'] as $value) {
      $data['admin'][$value->id] =$value->name;
    }
    $data['investor'] = array();
    $investor = DB::table('users as a')->join('tb_investor as b','b.nik','=','a.nik')->select("a.*","b.alamat","b.no_hp")->where("a.level","6")->where("a.status","aktif")->get();
    foreach ($investor as $value) {
      $data['investor'][$value->id]['id'] =$value->id;
      $data['investor'][$value->id]['nama'] =$value->name;
      $data['investor'][$value->id]['alamat'] =$value->alamat;
      $data['investor'][$value->id]['no_hp'] =$value->no_hp;
    }
    return view('DataPengadaanBarangJakarta',$data);
  }

}
