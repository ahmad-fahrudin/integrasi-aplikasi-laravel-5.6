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

class InsentifController extends Controller
{
  var $model;
  public function __construct()
  {
      date_default_timezone_set('Asia/Jakarta');
      $this->model = new Mase;
  }

  public function updins($nik){
    $p = DB::table('tb_karyawan as a')->select("*")->where("a.nik",$nik)->get();
    $insentif = DB::table('tb_insentif as a')
                            ->select("*")
                            ->where("a.id_karyawan",$p[0]->id)
                            ->where("a.status","aktif")
                            ->where("a.id_karyawan",'<>','22')
                            ->get();
    $insentif2 = DB::table('tb_pengembangan as a')
                            ->select("*")
                            ->where("a.id_karyawan",$p[0]->id)
                            ->where("a.status","aktif")
                            ->get();
    $saldo = 0;
    foreach ($insentif as $key => $value) {
      if ($value->jenis == "Trip" || $value->jenis == "Revisi Penambahan Insentif" || $value->jenis == "Bagi Hasil HPP" || $value->jenis == "Fee Transfer Insentif" || $value->jenis == "Bagi Hasil Stokis"){
          $saldo += $value->jumlah;
      }
      if ($value->jenis == "Potongan Insentif" || $value->jenis == "Pengambilan Insentif" || $value->jenis == "Potongan Administrasi" || $value->jenis == "Revisi Pengurangan Insentif"){
          $saldo -= $value->jumlah;
      }
    }
    foreach ($insentif2 as $key => $value) {
      if ($value->jenis == "Trip" || $value->jenis == "Revisi Penambahan Insentif" || $value->jenis == "Bagi Hasil HPP" || $value->jenis == "Fee Transfer Insentif"){
          $saldo += $value->jumlah;
      }
      if ($value->jenis == "Potongan Insentif" || $value->jenis == "Pengambilan Insentif" || $value->jenis == "Potongan Administrasi" || $value->jenis == "Revisi Pengurangan Insentif"){
          $saldo -= $value->jumlah;
      }
    }
    $data['saldo'] = $saldo;
    DB::table('tb_karyawan as a')->where("nik",$nik)->update($data);
  }

  public function inputinsentif(){
    $data['karyawan'] = DB::table('tb_karyawan as a')
                      ->where("a.status","aktif")
                      ->select("*")->get();
    if (Auth::user()->level == "4" || Auth::user()->level == "1") {
      $data['pending'] = DB::table('tb_insentif as a')->join('tb_karyawan as b','b.id','=','a.id_karyawan')
                        ->where("a.status","pending")->where("a.jenis","Pengambilan Insentif")
                        ->select("*","a.id as id_tr")->get();
    }else{
      $data['pending'] = DB::table('tb_insentif as a')
                           ->select("*","a.id as id_tr")
                           ->where("a.id_karyawan",cekmyid_karyawan())
                           ->where("a.status","pending")
                           ->where("a.jenis","Pengambilan Insentif")
                           ->get();
    }
    return view('InputInsentif',$data);
  }

  public function simpaninsentif(Request $post){
    if (role()) {
      $data = $post->except('_token');
      
      
      //perhitungan poin
      $upoin = array();
      if (isset($data['nama_konsumen']) && isset($data['poin_konsumen'])) {
        $poin_id = explode(",",$data['nama_konsumen']);
        $poin_poin = explode(",",$data['poin_konsumen']);
        for ($i=0; $i < count($poin_id); $i++) {
          if (isset($upoin[$poin_id[$i]])) {
            $upoin[$poin_id[$i]] += $poin_poin[$i];
          }else{
            $upoin[$poin_id[$i]] = $poin_poin[$i];
          }
        }
      }
      foreach ($upoin as $key => $value) {
        if ($key > 0 && $value > 0) {
          $kkon = DB::table('tb_konsumen')->where('id',$key)->get();
          $ppoin['id_konsumen'] = $key;
          if (count($kkon) > 0) {
            $ppoin['nama_konsumen'] = $kkon[0]->nama_pemilik;
          }
          $ppoin['jumlah'] = $value;
          $ppoin['jenis'] = "in";
          $ppoin['nama_jenis'] = "Pembagian Poin";
          $ppoin['admin'] =  Auth::user()->id;
          $ppoin['no_trip'] = $data['no_trip'];
          DB::table('tb_poin')->insert($ppoin);
          DB::table('tb_konsumen')->where('id',$key)->increment('poin',$value);
        }
      }
      //end perhitungan poin

      $u['no_trip'] = $data['no_trip'];
      $u['jenis'] = "Trip";
      $u['admin'] = Auth::user()->id;
      $petugas = explode(",",$data['nama_petugas']);
      $insentif = explode(",",$data['insentif']);
      if(isset($data['pengembangan'])){
        $pengembangan = explode(",",$data['pengembangan']);
      }
      if (isset($data['pengembang'])) {
        $pengembang = explode(",",$data['pengembang']);
      }
      if (isset($data['sales'])) {
        $sales = explode(",",$data['sales']);
      }
      if (isset($data['admin_g'])) {
        $admin_g = explode(",",$data['admin_g']);
      }
      if (isset($data['target'])) {
        $target = explode(",",$data['target']);
      }
      if (isset($data['hasil_target'])) {
        $hasil_target = explode(",",$data['hasil_target']);
      }


      if(isset($data['pengadaan_id_barang'])){
        $pengadaan_id_barang = explode(",",$data['pengadaan_id_barang']);
      }
      if(isset($data['pengadaan_jumlah_kulakan'])){
        $pengadaan_jumlah_kulakan = explode(",",$data['pengadaan_jumlah_kulakan']);
      }
      if(isset($data['pengadaan_estimasi_pendapatan'])){
        $pengadaan_estimasi_pendapatan = explode(",",$data['pengadaan_estimasi_pendapatan']);
      }
      if(isset($data['pengadaan_jumlah_investasi'])){
        $pengadaan_jumlah_investasi = explode(",",$data['pengadaan_jumlah_investasi']);
      }

      if (count($pengadaan_id_barang) > 0) {
        for ($i=0; $i < count($pengadaan_id_barang)-1; $i++) {
          $cekdatasebelum = DB::table('tb_temp_pengadaan_barang')->where('id_barang',$pengadaan_id_barang[$i])->get();
          if (count($cekdatasebelum) < 1) {
            $tmp_pembarang['id_barang'] = $pengadaan_id_barang[$i];
            $tmp_pembarang['jumlah_kulakan'] = $pengadaan_jumlah_kulakan[$i];
            $tmp_pembarang['jumlah_investasi'] = $pengadaan_jumlah_investasi[$i];
            $tmp_pembarang['estimasi_pendapatan'] = $pengadaan_estimasi_pendapatan[$i];
            $tmp_pembarang['create_by'] = Auth::user()->id;
            $tmp_pembarang['create_from_trip'] = $data['no_trip'];
            DB::table('tb_temp_pengadaan_barang')->insert($tmp_pembarang);
          }else{
            $tmp_pembarang['id_barang'] = $pengadaan_id_barang[$i];
            $tmp_pembarang['jumlah_kulakan'] = $cekdatasebelum[0]->jumlah_kulakan+$pengadaan_jumlah_kulakan[$i];
            $tmp_pembarang['jumlah_investasi'] = $cekdatasebelum[0]->jumlah_investasi+$pengadaan_jumlah_investasi[$i];
            $tmp_pembarang['estimasi_pendapatan'] = $cekdatasebelum[0]->estimasi_pendapatan+$pengadaan_estimasi_pendapatan[$i];
            $tmp_pembarang['create_by'] = Auth::user()->id;
            $tmp_pembarang['create_from_trip'] = $data['no_trip'];
            DB::table('tb_temp_pengadaan_barang')->where('id',$cekdatasebelum[0]->id)->update($tmp_pembarang);
          }

        }
      }
      
      
      if(isset($data['bagihasilstokis'])){
          $bagianstokis = str_replace(".","",$data['bagihasilstokis']);
          
          if($bagianstokis > 0){
            $lhs = DB::table('tb_gudang as a')
                  ->join('tb_karyawan as c','c.id','a.karyawan')
                  ->select("c.*")
                  ->where("a.nama_gudang",$data['gudang_insentif'])
                  ->get();
            if(count($lhs) > 0){
                  $bg_stokis['jumlah'] = $bagianstokis;
                  $bg_stokis['nama_karyawan'] = $lhs[0]->nama;
                  $bg_stokis['no_trip'] = $data['no_trip'];
                  $bg_stokis['jenis'] = "Bagi Hasil Stokis";
                  $bg_stokis['admin'] = Auth::user()->id;
                  $bg_stokis['id_karyawan'] = $lhs[0]->id;
                  $bg_stokis['saldo_temp'] = $bagianstokis;
                  $shans = DB::table('tb_insentif')->insert($bg_stokis);
                  
                  if($shans){
                      $kkr['saldo'] = $lhs[0]->saldo + $bagianstokis;
                      DB::table('tb_karyawan')->where('id',$lhs[0]->id)->update($kkr);
                  }
                  
            }
          }
      }
      
      
      

      if (isset($data['gudang_stokis']) && isset($data['bagi_hasil_stokis']) && str_replace(".","",$data['bagi_hasil_stokis']) > 0 ) {
        $gd = DB::table('users as a')
              ->join('tb_gudang as b','b.id','=','a.gudang')
              ->join('tb_karyawan as c','c.nik','=','a.nik')
              ->select("c.*","b.id as id_gdg")
              ->where("b.nama_gudang",$data['gudang_stokis'])
              ->where("a.level","3")
              ->limit(1)
              ->get();
        //if () {
          $bagihasilstokis = str_replace(".","",$data['bagi_hasil_stokis']);
          //if ($gd[0]->id_gdg == "3" || $gd[0]->id_gdg == "5" || $gd[0]->id_gdg == "10")) {
            $stokis['saldo'] = $gd[0]->saldo + $bagihasilstokis;
            $updatestokis = DB::table('tb_karyawan')->where('id','=',$gd[0]->id)->update($stokis);
            if ($updatestokis) {
              $tr['id_karyawan'] = $gd[0]->id;
              $tr['nama_karyawan'] = $gd[0]->nama;
              $tr['jumlah'] = $bagihasilstokis;
              $tr['saldo_temp'] = $stokis['saldo'];
              $tr['jenis'] = "Bagi Hasil HPP";
              $tr['no_trip'] = $data['no_trip'];
              $tr['admin'] = Auth::user()->id;
              $qtr = DB::table('tb_insentif')->insert($tr);

              if ($qtr) {
                for ($i=0; $i < count($petugas); $i++) {
                  $u['jumlah'] = $insentif[$i];
                  $u['nama_karyawan'] = $petugas[$i];
                  $u['jumlah'] = str_replace(".","",$u['jumlah']);
                  $pt = DB::table('tb_karyawan as a')
                        ->select("*")
                        ->where("a.nama",$petugas[$i])
                        ->get();
                  if ($pt && $u['jumlah'] != 0) {
                    $u['id_karyawan'] = $pt[0]->id;
                    $u['saldo_temp'] = $u['jumlah'] + $pt[0]->saldo;

                    if ($u['nama_karyawan'] == "Master") {
                      $query = DB::table('tb_pengembangan')->insert($u);
                      $a['saldo'] = $pt[0]->saldo + $u['jumlah'];
                      DB::table('tb_karyawan')->where('id','=',$pt[0]->id)->update($a);
                    }else{
                      $query = DB::table('tb_insentif')->insert($u);
                      $a['saldo'] = $pt[0]->saldo + $u['jumlah'];
                      DB::table('tb_karyawan')->where('id','=',$pt[0]->id)->update($a);
                    }

                    //tambahan target utk pengembang
                    if(isset($pengembang)){
                        if ($pengembang[$i] > 0) {
                          $t1['id_karyawan']= $petugas[$i];
                          $t1['target']= "14700000";
                          $t1['tambahan_target']= "0";
                          $t1['pencapaian_target']= str_replace(".","",$data['total_target']);
                          $t1['bonus']= str_replace(".","",$pengembang[$i]);
                          $t1['jabatan']= "Pengembang Target";
                          $ck1 = DB::table('tb_target_karyawan')->where('jabatan','Pengembang Target')->where('id_karyawan',$petugas[$i])->get();
                          if (count($ck1) < 1) {
                            DB::table('tb_target_karyawan')->insert($t1);
                          }else{
                            $upt1['pencapaian_target'] = $ck1[0]->pencapaian_target + $t1['pencapaian_target'];
                            DB::table('tb_target_karyawan')->where('jabatan','Pengembang Target')->where('id_karyawan',$petugas[$i])->update($upt1);
                          }
                        }
                    }
                    //end target pengembang

                    //tambahan target utk sales
                    if(isset($sales)){
                        if ($sales[$i] > 0) {
                          $t2['id_karyawan']= $petugas[$i];
                          $t2['target']= "2100000";
                          $t2['tambahan_target']= "0";
                          $t2['pencapaian_target']= $t2['target'] + str_replace(".","",$sales[$i]);
                          $t2['bonus']= str_replace(".","",$sales[$i]);
                          $t2['jabatan']= "Sales Target";
                          $ck2 = DB::table('tb_target_karyawan')->where('jabatan','Sales Target')->where('id_karyawan',$petugas[$i])->get();
                          if (count($ck2) < 1) {
                            DB::table('tb_target_karyawan')->insert($t2);
                          }else{
                            $upt2['pencapaian_target'] = $ck2[0]->pencapaian_target + $t2['pencapaian_target'];
                            DB::table('tb_target_karyawan')->where('jabatan','Sales Target')->where('id_karyawan',$petugas[$i])->update($upt2);
                          }
                        }
                    }
                    //end target sales

                    //tambahan target utk Admin G
                    if(isset($admin_g)){
                        if ($admin_g[$i] > 0) {
                          $t3['id_karyawan']= $petugas[$i];
                          $t3['target']= "2100000";
                          $t3['tambahan_target']= "0";
                          $t3['pencapaian_target']= str_replace(".","",$admin_g[$i]);
                          $t3['bonus']= str_replace(".","",$admin_g[$i]);
                          $t3['jabatan']= "Admin G target";
                          $ck3 = DB::table('tb_target_karyawan')->where('jabatan','Admin G target')->where('id_karyawan',$petugas[$i])->get();
                          if (count($ck3) < 1) {
                            DB::table('tb_target_karyawan')->insert($t3);
                          }else{
                            $upt3['pencapaian_target'] = $ck3[0]->pencapaian_target + $t3['pencapaian_target'];
                            DB::table('tb_target_karyawan')->where('jabatan','Admin G target')->where('id_karyawan',$petugas[$i])->update($upt3);
                          }
                        }
                    }
                    //end target Admin G


                  }
                }


                //tambahan target admin dan bonus gudang
                if(isset($target)){
                    for ($i=0; $i < count($target)-1; $i++) {
                      if ($target[$i] == "Bonus Gudang") {
                        $ts['target']= "6300000";
                      }else{
                        $ts['target']= "4200000";
                      }
                      $ts['id_karyawan']= $target[$i];
                      $ts['tambahan_target']= "0";
                      if ($i == 2) {
                        $ts['pencapaian_target']= str_replace(".","",$hasil_target[2]);
                      }else{
                        $ts['pencapaian_target']= str_replace(".","",$hasil_target[0]) + str_replace(".","",$hasil_target[1]);
                      }

                      $ts['bonus']= str_replace(".","",$hasil_target[$i]);
                      if ($i == 0) {
                        $ts['jabatan']= "Admin keuangan 1";
                      }else if ($i == 1) {
                        $ts['jabatan']= "Admin keuangan 2";
                      }else {
                        $ts['jabatan']= "";
                      }

                      if ($ts['bonus'] > 0) {
                        $ck4 = DB::table('tb_target_karyawan')->where('jabatan',$ts['jabatan'])->where('id_karyawan',$target[$i])->get();
                        if (count($ck4) < 1) {
                          DB::table('tb_target_karyawan')->insert($ts);
                        }else{
                          $upt4['pencapaian_target'] = $ck4[0]->pencapaian_target + $ts['pencapaian_target'];
                          DB::table('tb_target_karyawan')->where('jabatan',$ts['jabatan'])->where('id_karyawan',$target[$i])->update($upt4);
                        }
                      }

                    }
                }
                //end tambahan target dan admin gudang


                $laba = DB::table('tb_labarugi as a')
                      ->select("*")
                      ->where("a.status","aktif")
                      ->orderBy('id', 'desc')->limit(1)->get();
                $data['labarugi'] = str_replace(".","",$data['labarugi']);
                if (count($laba) > 0) {
                  $l['saldo_temp'] = $laba[0]->saldo_temp + $data['labarugi'];
                }else{
                  $l['saldo_temp'] = $data['labarugi'];
                }
                $l['jumlah'] = $data['labarugi'];
                $l['jenis'] = "in";
                $l['nama_jenis'] = "Laba Rugi";
                $l['admin'] = Auth::user()->id;
                $l['no_trip'] = $data['no_trip'];
                DB::table('tb_labarugi')->insert($l);
                if (isset($data['tenagatoko']) && $data['tenagatoko'] > 0) {
                  $toko = DB::table('tb_labarugi as a')
                        ->select("*")
                        ->where("a.status","aktif")
                        ->orderBy('id', 'desc')->limit(1)->get();
                  $data['tenagatoko'] = str_replace(".","",$data['tenagatoko']);
                  if (count($toko) > 0) {
                    $t['saldo_temp'] = $toko[0]->saldo_temp + $data['tenagatoko'];
                  }else{
                    $t['saldo_temp'] = $data['tenagatoko'];
                  }
                  $t['jumlah'] = $data['tenagatoko'];
                  $t['jenis'] = "in";
                  $t['nama_jenis'] = "Tenaga Toko";
                  $t['admin'] = Auth::user()->id;
                  $t['no_trip'] = $data['no_trip'];
                  DB::table('tb_labarugi')->insert($t);
                }
                if (isset($data['tenagagudang']) && $data['tenagagudang'] > 0) {
                  $gdg = DB::table('tb_labarugi as a')
                        ->select("*")
                        ->where("a.status","aktif")
                        ->orderBy('id', 'desc')->limit(1)->get();
                  $data['tenagagudang'] = str_replace(".","",$data['tenagagudang']);
                  if (count($gdg) > 0) {
                    $g['saldo_temp'] = $gdg[0]->saldo_temp + $data['tenagagudang'];
                  }else{
                    $g['saldo_temp'] = $data['tenagagudang'];
                  }
                  $g['jumlah'] = $data['tenagagudang'];
                  $g['jenis'] = "in";
                  $g['nama_jenis'] = "Tenaga Gudang";
                  $g['admin'] = Auth::user()->id;
                  $g['no_trip'] = $data['no_trip'];
                  DB::table('tb_labarugi')->insert($g);
                }
                if (isset($data['ongkos_kirim']) && $data['ongkos_kirim'] > 0) {
                  $gdgs = DB::table('tb_labarugi as a')
                        ->select("*")
                        ->where("a.status","aktif")
                        ->orderBy('id', 'desc')->limit(1)->get();
                  $data['ongkos_kirim'] = str_replace(".","",$data['ongkos_kirim']);
                  if (count($gdgs) > 0) {
                    $g['saldo_temp'] = $gdgs[0]->saldo_temp + $data['ongkos_kirim'];
                  }else{
                    $g['saldo_temp'] = $data['ongkos_kirim'];
                  }
                  $ok['jumlah'] = $data['ongkos_kirim'];
                  $ok['jenis'] = "in";
                  $ok['nama_jenis'] = "Ongkir";
                  $ok['admin'] = Auth::user()->id;
                  $ok['no_trip'] = $data['no_trip'];
                  DB::table('tb_labarugi')->insert($ok);
                }
                if (isset($data['omset_umum']) && isset($data['omset_branded'])) {
                  $dms = DB::table('tb_omset as a')
                        ->select("*")
                        ->where("a.status","aktif")
                        ->orderBy('id', 'desc')->limit(1)->get();
                  $data['omset_umum'] = str_replace(".","",$data['omset_umum']);
                  $data['omset_branded'] = str_replace(".","",$data['omset_branded']);
                  if (count($dms) > 0) {
                    $oms['omset_temp'] = $dms[0]->omset_temp + $data['omset_umum'] + $data['omset_branded'];
                  }else{
                    $oms['omset_temp'] = $data['omset_umum'] + $data['omset_branded'];
                  }
                  $oms['jumlah'] = $data['omset_umum'] + $data['omset_branded'];
                  $oms['jenis'] = "in";
                  $oms['nama_jenis'] = "Omset Trip";
                  $oms['admin'] = Auth::user()->id;
                  $oms['no_trip'] = $data['no_trip'];
                  $oms['nilai_penjualan'] = str_replace(".","",$data['nilai_penjualan']);
                  $oms['keterangan'] = $data['kategori']." ".$data['id_gudang'];
                  DB::table('tb_omset')->insert($oms);
                }
                $x['status'] = "calculated";
                $querys = DB::table('tb_trip')->where('no_trip','=',$u['no_trip'])->update($x);
              }

            }
          //}
      //  }

      }else{
        //input insentif petugas
        for ($i=0; $i < count($petugas); $i++) {
          $u['jumlah'] = $insentif[$i];
          $u['nama_karyawan'] = $petugas[$i];
          $u['jumlah'] = str_replace(".","",$u['jumlah']);
          $pt = DB::table('tb_karyawan as a')->select("*")->where("a.nama",$petugas[$i])->get();
          if (count($pt) < 1) {
            $pt = DB::table('tb_konsumen as a')->select("*")->where("a.nama_pemilik",$petugas[$i])->get();
          }
          if ($pt && $u['jumlah'] != 0) {
            $u['id_karyawan'] = $pt[0]->id;
            $u['saldo_temp'] = $u['jumlah'] + $pt[0]->saldo;

            if ($u['nama_karyawan'] == "Master") {
              $query = DB::table('tb_pengembangan')->insert($u);
              $a['saldo'] = $pt[0]->saldo + $u['jumlah'];
              DB::table('tb_karyawan')->where('id','=',$pt[0]->id)->update($a);
            }else{
              $query = DB::table('tb_insentif')->insert($u);
              $a['saldo'] = $pt[0]->saldo + $u['jumlah'];
              DB::table('tb_karyawan')->where('id','=',$pt[0]->id)->update($a);
            }

          }


          //tambahan target utk pengembang
          if(isset($pengembang)){
              if ($pengembang[$i] > 0) {
                $t1['id_karyawan']= $petugas[$i];
                $t1['target']= "14700000";
                $t1['tambahan_target']= "0";
                $t1['pencapaian_target']= str_replace(".","",$data['total_target']);
                $t1['bonus']= str_replace(".","",$pengembang[$i]);
                $t1['jabatan']= "Pengembang Target";
                $ck1 = DB::table('tb_target_karyawan')->where('jabatan','Pengembang Target')->where('id_karyawan',$petugas[$i])->get();
                if (count($ck1) < 1) {
                  DB::table('tb_target_karyawan')->insert($t1);
                }else{
                  $upt1['pencapaian_target'] = $ck1[0]->pencapaian_target + $t1['pencapaian_target'];
                  DB::table('tb_target_karyawan')->where('jabatan','Pengembang Target')->where('id_karyawan',$petugas[$i])->update($upt1);
                }
              }
          }
          //end target pengembang

          //tambahan target utk sales
          if(isset($sales)){
              if ($sales[$i] > 0) {
                $t2['id_karyawan']= $petugas[$i];
                $t2['target']= "2100000";
                $t2['tambahan_target']= "0";
                $t2['pencapaian_target']= $t2['target'] + str_replace(".","",$sales[$i]);
                $t2['bonus']= str_replace(".","",$sales[$i]);
                $t2['jabatan']= "Sales Target";
                $ck2 = DB::table('tb_target_karyawan')->where('jabatan','Sales Target')->where('id_karyawan',$petugas[$i])->get();
                if (count($ck2) < 1) {
                  DB::table('tb_target_karyawan')->insert($t2);
                }else{
                  $upt2['pencapaian_target'] = $ck2[0]->pencapaian_target + $t2['pencapaian_target'];
                  DB::table('tb_target_karyawan')->where('jabatan','Sales Target')->where('id_karyawan',$petugas[$i])->update($upt2);
                }
              }
          }
          //end target sales

          //tambahan target utk Admin G
          if(isset($admin_g)){
              if ($admin_g[$i] > 0) {
                $t3['id_karyawan']= $petugas[$i];
                $t3['target']= "2100000";
                $t3['tambahan_target']= "0";
                $t3['pencapaian_target']= str_replace(".","",$admin_g[$i]);
                $t3['bonus']= str_replace(".","",$admin_g[$i]);
                $t3['jabatan']= "Admin G target";
                $ck3 = DB::table('tb_target_karyawan')->where('jabatan','Admin G target')->where('id_karyawan',$petugas[$i])->get();
                if (count($ck3) < 1) {
                  DB::table('tb_target_karyawan')->insert($t3);
                }else{
                  $upt3['pencapaian_target'] = $ck3[0]->pencapaian_target + $t3['pencapaian_target'];
                  DB::table('tb_target_karyawan')->where('jabatan','Admin G target')->where('id_karyawan',$petugas[$i])->update($upt3);
                }
              }
          }
          //end target Admin G


        }
        //end input insentif petugas

        //input dana pengembangan Grosir HP
        if(isset($pengembangan)){
          for ($i=0; $i < count($pengembangan); $i++) {
            $peng['jumlah'] = $pengembangan[$i];
            $peng['nama_karyawan'] = $petugas[$i];
            $peng['no_trip'] = $data['no_trip'];
            $peng['jenis'] = "Trip";
            $peng['admin'] = Auth::user()->id;
            $peng['jumlah'] = intval(str_replace(".","",$peng['jumlah']));
            $ptp = DB::table('tb_karyawan as a')->select("*")->where("a.nama",$petugas[$i])->get();

            if (count($ptp) < 1) {
              $ptp = DB::table('tb_konsumen as a')->select("*")->where("a.nama_pemilik",$petugas[$i])->get();
            }

            if ($ptp && $peng['jumlah'] != 0) {
              $peng['id_karyawan'] = $ptp[0]->id;
              $peng['saldo_temp'] = $peng['jumlah'] + $ptp[0]->saldo;

              $query = DB::table('tb_pengembangan')->insert($peng);

              $bp['saldo'] = $ptp[0]->saldo + $peng['jumlah'];
              DB::table('tb_karyawan')->where('id','=',$ptp[0]->id)->update($bp);
            }
          }
        }
        //end input dana pengembangan Grosir HP

        //input pengembangan Sistem Online HP
        if (isset($data['pengembangan_sistem'])) {
          $pengsis['jumlah'] = $data['pengembangan_sistem'];
          $pengsis['nama_karyawan'] = "Pengembangan Sistem";
          $pengsis['no_trip'] = $data['no_trip'];
          $pengsis['jenis'] = "Trip";
          $pengsis['admin'] = Auth::user()->id;
          $pengsis['jumlah'] = intval(str_replace(".","",$pengsis['jumlah']));

          if ($pengsis['jumlah'] > 0) {
            $peng['saldo_temp'] = $pengsis['jumlah'];
            $query = DB::table('tb_pengembangan')->insert($pengsis);
          }
        }
        //end input pengembangan Sistem Online HP

        //input Bagi Hasil Stokis laman Online HP
        if(isset($data['bagi_hasil_stokis']) && isset($data['gudang_stokis'])){
          if ($data['gudang_stokis'] == "Stokis Lindia" || $data['gudang_stokis'] == "Stokis Parlan") {
            $laba_hasil_stokis = DB::table('tb_gudang as a')
                  ->join('users as b','a.id','b.gudang')
                  ->join('tb_karyawan as c','c.nik','b.nik')
                  ->select("c.*")
                  ->where("a.nama_gudang",$data['gudang_stokis'])
                  ->where("b.level",3)
                  ->get();
            $u_stokis['jumlah'] = $data['bagi_hasil_stokis'];
            $u_stokis['nama_karyawan'] = $laba_hasil_stokis[0]->nama;
            $u_stokis['jumlah'] = str_replace(".","",$u_stokis['jumlah']);
            $u_stokis['no_trip'] = $data['no_trip'];
            $u_stokis['jenis'] = "Bagi Hasil Stokis";
            $u_stokis['admin'] = Auth::user()->id;

            if ($laba_hasil_stokis && $u_stokis['jumlah'] > 0) {
              $u_stokis['id_karyawan'] = $laba_hasil_stokis[0]->id;
              $u_stokis['saldo_temp'] = $u_stokis['jumlah'] + $laba_hasil_stokis[0]->saldo;
              DB::table('tb_insentif')->insert($u_stokis);
              $a_stokis['saldo'] = $laba_hasil_stokis[0]->saldo + $u_stokis['jumlah'];
              DB::table('tb_karyawan')->where('id','=',$laba_hasil_stokis[0]->id)->update($a_stokis);
            }

          }else{
            $laba_hasil_stokis = DB::table('tb_labarugi as a')
                  ->select("*")
                  ->where("a.status","aktif")
                  ->orderBy('id', 'desc')->limit(1)->get();
            $data['bagi_hasil_stokis'] = str_replace(".","",$data['bagi_hasil_stokis']);
            if (count($laba_hasil_stokis) > 0) {
              $lhs['saldo_temp'] = $laba_hasil_stokis[0]->saldo_temp + $data['bagi_hasil_stokis'];
            }else{
              $lhs['saldo_temp'] = $data['bagi_hasil_stokis'];
            }
            $lhs['jumlah'] = $data['bagi_hasil_stokis'];
            $lhs['jenis'] = "in";
            $lhs['nama_jenis'] = "Bonus Gudang";
            $lhs['admin'] = Auth::user()->id;
            $lhs['no_trip'] = $data['no_trip'];
            DB::table('tb_labarugi')->insert($lhs);
          }
        }
        //end input Bagi Hasil Stokis laman Online HP

        //input insentif gudang
        if (isset($data['insentif_gudang'])) {
          $labar = DB::table('tb_labarugi as a')
                ->select("*")
                ->where("a.status","aktif")
                ->orderBy('id', 'desc')->limit(1)->get();
          $data['insentif_gudang'] = str_replace(".","",$data['insentif_gudang']);
          if ($data['insentif_gudang'] > 0) {
            if (count($labar) > 0) {
              $lrp['saldo_temp'] = $labar[0]->saldo_temp + $data['insentif_gudang'];
            }else{
              $lrp['saldo_temp'] = $data['insentif_gudang'];
            }
            $lrp['jumlah'] = $data['insentif_gudang'];
            $lrp['jenis'] = "in";
            $lrp['nama_jenis'] = "Bonus Gudang";
            $lrp['admin'] = Auth::user()->id;
            $lrp['no_trip'] = $data['no_trip'];
            DB::table('tb_labarugi')->insert($lrp);
          }
        }
        //end input insentif gudang

        //tambahan target admin dan bonus gudang
        if(isset($target)){
            for ($i=0; $i < count($target); $i++) {
              if ($target[$i] == "Bonus Gudang") {
                $ts['target']= "6300000";
              }else{
                $ts['target']= "4200000";
              }
              $ts['id_karyawan']= $target[$i];
              $ts['tambahan_target']= "0";
              if ($i == 2) {
                $ts['pencapaian_target']= str_replace(".","",$hasil_target[2]);
              }else{
                $ts['pencapaian_target']= str_replace(".","",$hasil_target[0]) + str_replace(".","",$hasil_target[1]);
              }

              $ts['bonus']= str_replace(".","",$hasil_target[$i]);
              if ($i == 0) {
                $ts['jabatan']= "Admin keuangan 1";
              }else if ($i == 1) {
                $ts['jabatan']= "Admin keuangan 2";
              }else {
                $ts['jabatan']= "";
              }
              if ($ts['bonus'] > 0) {
                $ck4 = DB::table('tb_target_karyawan')->where('jabatan',$ts['jabatan'])->where('id_karyawan',$target[$i])->get();
                if (count($ck4) < 1) {
                  DB::table('tb_target_karyawan')->insert($ts);
                }else{
                  $upt4['pencapaian_target'] = $ck4[0]->pencapaian_target + $ts['pencapaian_target'];
                  DB::table('tb_target_karyawan')->where('jabatan',$ts['jabatan'])->where('id_karyawan',$target[$i])->update($upt4);
                }
              }
            }
        }
        //end tambahan target dan admin gudang

        $laba = DB::table('tb_labarugi as a')
              ->select("*")
              ->where("a.status","aktif")
              ->orderBy('id', 'desc')->limit(1)->get();
        $data['labarugi'] = str_replace(".","",$data['labarugi']);
        if (count($laba) > 0) {
          $l['saldo_temp'] = $laba[0]->saldo_temp + $data['labarugi'];
        }else{
          $l['saldo_temp'] = $data['labarugi'];
        }
        $l['jumlah'] = $data['labarugi'];
        $l['jenis'] = "in";
        $l['nama_jenis'] = "Laba Rugi";
        $l['admin'] = Auth::user()->id;
        $l['no_trip'] = $data['no_trip'];
        DB::table('tb_labarugi')->insert($l);

        if (isset($data['tenagatoko']) && $data['tenagatoko'] > 0) {
          $toko = DB::table('tb_labarugi as a')
                ->select("*")
                ->where("a.status","aktif")
                ->orderBy('id', 'desc')->limit(1)->get();
          $data['tenagatoko'] = str_replace(".","",$data['tenagatoko']);
          if (count($toko) > 0) {
            $t['saldo_temp'] = $toko[0]->saldo_temp + $data['tenagatoko'];
          }else{
            $t['saldo_temp'] = $data['tenagatoko'];
          }
          $t['jumlah'] = $data['tenagatoko'];
          $t['jenis'] = "in";
          $t['nama_jenis'] = "Tenaga Toko";
          $t['admin'] = Auth::user()->id;
          $t['no_trip'] = $data['no_trip'];
          DB::table('tb_labarugi')->insert($t);
        }
        if (isset($data['tenagagudang']) && $data['tenagagudang'] > 0) {
          $gdg = DB::table('tb_labarugi as a')
                ->select("*")
                ->where("a.status","aktif")
                ->orderBy('id', 'desc')->limit(1)->get();
          $data['tenagagudang'] = str_replace(".","",$data['tenagagudang']);
          if (count($gdg) > 0) {
            $g['saldo_temp'] = $gdg[0]->saldo_temp + $data['tenagagudang'];
          }else{
            $g['saldo_temp'] = $data['tenagagudang'];
          }
          $g['jumlah'] = $data['tenagagudang'];
          $g['jenis'] = "in";
          $g['nama_jenis'] = "Tenaga Gudang";
          $g['admin'] = Auth::user()->id;
          $g['no_trip'] = $data['no_trip'];
          DB::table('tb_labarugi')->insert($g);
        }
        if (isset($data['ongkos_kirim']) && $data['ongkos_kirim'] > 0) {
          $gdgs = DB::table('tb_labarugi as a')
                ->select("*")
                ->where("a.status","aktif")
                ->orderBy('id', 'desc')->limit(1)->get();
          $data['ongkos_kirim'] = str_replace(".","",$data['ongkos_kirim']);
          if (count($gdgs) > 0) {
            $g['saldo_temp'] = $gdgs[0]->saldo_temp + $data['ongkos_kirim'];
          }else{
            $g['saldo_temp'] = $data['ongkos_kirim'];
          }
          $ok['jumlah'] = $data['ongkos_kirim'];
          $ok['jenis'] = "in";
          $ok['nama_jenis'] = "Ongkir";
          $ok['admin'] = Auth::user()->id;
          $ok['no_trip'] = $data['no_trip'];
          DB::table('tb_labarugi')->insert($ok);
        }
        if (isset($data['omset_umum']) && isset($data['omset_branded'])) {
          $dms = DB::table('tb_omset as a')
                ->select("*")
                ->where("a.status","aktif")
                ->orderBy('id', 'desc')->limit(1)->get();
          $data['omset_umum'] = str_replace(".","",$data['omset_umum']);
          $data['omset_branded'] = str_replace(".","",$data['omset_branded']);
          if (count($dms) > 0) {
            $oms['omset_temp'] = $dms[0]->omset_temp + $data['omset_umum'] + $data['omset_branded'];
          }else{
            $oms['omset_temp'] = $data['omset_umum'] + $data['omset_branded'];
          }
          $oms['jumlah'] = $data['omset_umum'] + $data['omset_branded'];
          $oms['jenis'] = "in";
          $oms['nama_jenis'] = "Omset Trip";
          $oms['admin'] = Auth::user()->id;
          $oms['no_trip'] = $data['no_trip'];
          $oms['nilai_penjualan'] = str_replace(".","",$data['nilai_penjualan']);
          $oms['keterangan'] = $data['kategori']." ".$data['id_gudang'];
          DB::table('tb_omset')->insert($oms);
        }
        $x['status'] = "calculated";
        $querys = DB::table('tb_trip')->where('no_trip','=',$u['no_trip'])->update($x);

      }


      echo json_encode($u);
    }else{
      return view ('Denied');
    }
  }

  public function datainsentif(){
    if (role()) {
      $data['karyawan'] = DB::table('tb_karyawan as a')
                        ->where("a.status","aktif")
                        ->select("*")->get();
      if (Auth::user()->level == "4" || Auth::user()->level == "1") {
        $data['insentif'] = DB::table('tb_insentif as a')
                                ->select("*")
                                ->where("a.status","aktif")
                                ->orderBy('a.tgl_transaksi','ASC')
                                ->get();
      }else{
        $p = DB::table('tb_karyawan as a')->select("*")->where("a.nik",Auth::user()->nik)->get();
        $data['insentif'] = DB::table('tb_insentif as a')
                                ->select("*")
                                ->where("a.id_karyawan",$p[0]->id)
                                ->where("a.status","aktif")
                                ->orderBy('a.tgl_transaksi','ASC')
                                ->get();
      }
      $text_admin = DB::table('users as a')->select("a.*")->get();
      $data['admin'] = array();
      foreach ($text_admin as $value) {
        $data['admin'][$value->id] =$value->name;
      }
      $data['rekening'] = DB::table('tb_rekening as a')
                ->select("*")
                ->where("a.status","aktif")
                ->get();
      return view('DataInsentif',$data);
    }else{
      return view ('Denied');
    }
  }

  public function ambilinsentif(){
    if (role()) {
      if (Auth::user()->level == "4" || Auth::user()->level == "1") {
        $data['pending'] = DB::table('tb_insentif as a')->join('tb_karyawan as b','b.id','=','a.id_karyawan')
                          ->where("a.status","pending")->where("a.jenis","Pengambilan Insentif")
                          ->select("*","a.id as id_tr")->get();

        $data['pending2'] = DB::table('tb_pengembangan as a')->join('tb_karyawan as b','b.id','=','a.id_karyawan')
                          ->where("a.status","pending")->where("a.jenis","Pengambilan Insentif")
                          ->select("*","a.id as id_tr")->get();
      }else if(cekmyid_karyawan() == '22'){
        $data['pending'] = DB::table('tb_pengembangan as a')
                             ->select("*","a.id as id_tr")
                             ->where("a.id_karyawan",cekmyid_karyawan())
                             ->where("a.status","pending")
                             ->where("a.jenis","Pengambilan Insentif")
                             ->get();
      }else{
        $data['pending'] = DB::table('tb_insentif as a')
                             ->select("*","a.id as id_tr")
                             ->where("a.id_karyawan",cekmyid_karyawan())
                             ->where("a.status","pending")
                             ->where("a.jenis","Pengambilan Insentif")
                             ->get();
      }
      $karyawan = DB::table('tb_karyawan as a')->select("*")->get();
      $data['karyawan'] = array();
      foreach ($karyawan as $key => $value) {
        //dd($value);
        $data['karyawan'][$value->id]['nama_bank'] = $value->nama_bank;
        $data['karyawan'][$value->id]['no_rekening'] = $value->no_rekening;
        $data['karyawan'][$value->id]['ats_bank'] = $value->ats_bank;
      }
    $data['rekening'] = DB::table('tb_rekening as a')
                    ->select("*")
                    ->where("a.status","aktif")
                    ->get();
      $data['nama_download'] = "Tarik Insentif";
      return view ('AmbilInsentif',$data);
    }else{
      return view ('Denied');
    }
  }

  public function penarikansaldo(Request $post){
    if (role()) {
      $data = $post->except('_token');
      $data['saldo'] = str_replace(".","",$data['saldo']);
      $u['jumlah'] = $data['saldo'];
      $u['id_karyawan'] = cekmyid_karyawan();
      $u['nama_karyawan'] = cekmyname_karyawan();
      $u['jenis'] = "Pengambilan Insentif";
      $u['saldo_temp'] = saldokaryawan();
      $u['status'] = "pending";
      if ($u['saldo_temp'] >= $u['jumlah']) {
        DB::table('tb_insentif')->insert($u);
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back()->withErrors(['msg', 'The Message']);
      }
    }else{
      return view ('Denied');
    }
  }

  public function penarikansaldomas(Request $post){
    if (role()) {
      $data = $post->except('_token');
      //dd($data);
      $data['saldo'] = str_replace(".","",$data['saldo']);
      $u['jumlah'] = $data['saldo'];
      $u['id_karyawan'] = cekmyid_karyawan();
      $u['nama_karyawan'] = cekmyname_karyawan();
      $u['jenis'] = "Pengambilan Insentif";
      $u['saldo_temp'] = saldomas();
      $u['status'] = "pending";
      if ($u['saldo_temp'] >= $u['jumlah']) {
        DB::table('tb_pengembangan')->insert($u);
        return redirect()->back()->with('success','Berhasil');
      }else{
        return redirect()->back()->withErrors(['msg', 'The Message']);
      }
    }else{
      return view ('Denied');
    }
  }

  public function verifikasipenarikan(Request $post){
    if (role()) {
      $data = $post->except('_token');
      $jumlah_ins = 0;


      $insseb = DB::table('tb_insentif')->where('id',$data['id'])->get();
      if(count($insseb) >0){
        $insentif = DB::table('tb_insentif as a')
                                ->select("*")
                                ->where("a.id_karyawan",$insseb[0]->id_karyawan)
                                ->where("a.status","aktif")
                                ->where("a.id_karyawan",'<>','22')
                                ->get();
        $insentif2 = DB::table('tb_pengembangan as a')
                                ->select("*")
                                ->where("a.id_karyawan",$insseb[0]->id_karyawan)
                                ->where("a.status","aktif")
                                ->get();
        $saldo = 0;
        foreach ($insentif as $key => $value) {
          if ($value->jenis == "Trip" || $value->jenis == "Revisi Penambahan Insentif" || $value->jenis == "Bagi Hasil HPP" || $value->jenis == "Fee Transfer Insentif" || $value->jenis == "Bagi Hasil Stokis"){
              $saldo += $value->jumlah;
          }
          if ($value->jenis == "Potongan Insentif" || $value->jenis == "Pengambilan Insentif" || $value->jenis == "Potongan Administrasi" || $value->jenis == "Revisi Pengurangan Insentif"){
              $saldo -= $value->jumlah;
          }
        }
        foreach ($insentif2 as $key => $value) {
          if ($value->jenis == "Trip" || $value->jenis == "Revisi Penambahan Insentif" || $value->jenis == "Bagi Hasil HPP" || $value->jenis == "Fee Transfer Insentif"){
              $saldo += $value->jumlah;
          }
          if ($value->jenis == "Potongan Insentif" || $value->jenis == "Pengambilan Insentif" || $value->jenis == "Potongan Administrasi" || $value->jenis == "Revisi Pengurangan Insentif"){
              $saldo -= $value->jumlah;
          }
        }
        $dxdt['saldo'] = $saldo;
        DB::table('tb_karyawan as a')->where("id",$insseb[0]->id_karyawan)->update($dxdt);
      }



      if ($data['previllage'] == "mase") {
        $data['jumlah'] = str_replace(".","",$data['jumlah']);
        $d = DB::table('tb_pengembangan as a')
             ->join('tb_karyawan as b','b.id','=','a.id_karyawan')
             ->select("*")->where('a.id',$data['id'])->get();
        $u['saldo_temp'] = $d[0]->saldo - $d[0]->jumlah + $data['jumlah'];
        $u['status'] = "aktif";
        $u['jumlah'] = $d[0]->jumlah - $data['jumlah'];
        $jumlah_ins = $d[0]->jumlah;
        date_default_timezone_set('Asia/Jakarta');
        $u['tgl_verifikasi'] = date('Y-m-d h:i:s');
        $u['admin'] = Auth::user()->id;
        $q1 = DB::table('tb_pengembangan')->where('id',$data['id'])->update($u);

        $a['id_karyawan'] = $d[0]->id_karyawan;
        $a['nama_karyawan'] = $d[0]->nama_karyawan;
        $a['jumlah'] = $data['jumlah'];
        $a['saldo_temp'] = $u['saldo_temp'] - $data['jumlah'];
        $a['jenis'] = "Potongan Administrasi";
        $a['admin'] = Auth::user()->id;
        if($q1){
            $q2 = DB::table('tb_pengembangan')->insert($a);
        }

        $e = DB::table('tb_karyawan as a')->select("*")->where('a.nik',Auth::user()->nik)->get();
        $b['id_karyawan'] = $e[0]->id;
        $b['nama_karyawan'] = $e[0]->nama;
        $b['jumlah'] = 1000;
        $b['saldo_temp'] = $e[0]->saldo + $b['jumlah'];
        $b['jenis'] = "Fee Transfer Insentif";
        $b['admin'] = Auth::user()->id;
        $b['keterangan'] = $d[0]->nama_karyawan;
        if($q2){
          $q3 = DB::table('tb_pengembangan')->insert($b);
        }

        $c['saldo'] = $e[0]->saldo + $b['jumlah'];
        if($q3){
          $q4 = DB::table('tb_karyawan')->where('id',$e[0]->id)->update($c);
        }

        $x['saldo'] = $b['saldo_temp'];
        if($q4){
          $q5 = DB::table('tb_karyawan')->where('id',$d[0]->id_karyawan)->update($x);

          if($data['transaksi'] == "tunai"){
                $kt['jumlah'] = $jumlah_ins;
                $kt['saldo_temp'] = 0;
                $kt['jenis'] = 'out';
                $kt['nama_jenis'] = "Insentif Non Gaji";
                $kt['admin'] = Auth::user()->id;
                $kt['keterangan'] = "Pengambilan Insentif ".$a['nama_karyawan'];
                $q = DB::table('tb_kas_ditangan')->insert($kt);
          }else if($data['transaksi'] == "transfer"){
                $kt['jumlah'] = $jumlah_ins;
                $kt['saldo_temp'] = 0;
                $kt['jenis'] = 'out';
                $kt['nama_jenis'] = "Insentif Non Gaji";
                $kt['admin'] = Auth::user()->id;
                $kt['keterangan'] = "Pengambilan Insentif ".$a['nama_karyawan'];
                $kt['kode_bank'] = $data['rekening'];
                $q = DB::table('tb_kas_dibank')->insert($kt);
          }

          return redirect()->back()->with('success','Berhasil');
        }

      }else{
        $data['jumlah'] = str_replace(".","",$data['jumlah']);
        $d = DB::table('tb_insentif as a')
             ->join('tb_karyawan as b','b.id','=','a.id_karyawan')
             ->select("*")->where('a.id',$data['id'])->get();
        $u['saldo_temp'] = $d[0]->saldo - $d[0]->jumlah + $data['jumlah'];
        $u['status'] = "aktif";
        $u['jumlah'] = $d[0]->jumlah - $data['jumlah'];
        $jumlah_ins = $d[0]->jumlah;
        date_default_timezone_set('Asia/Jakarta');
        $u['tgl_verifikasi'] = date('Y-m-d h:i:s');
        $u['admin'] = Auth::user()->id;
        $q1 = DB::table('tb_insentif')->where('id',$data['id'])->update($u);

        $a['id_karyawan'] = $d[0]->id_karyawan;
        $a['nama_karyawan'] = $d[0]->nama_karyawan;
        $a['jumlah'] = $data['jumlah'];
        $a['saldo_temp'] = $u['saldo_temp'] - $data['jumlah'];
        $a['jenis'] = "Potongan Administrasi";
        $a['admin'] = Auth::user()->id;
        if($q1){
            $q2 = DB::table('tb_insentif')->insert($a);
        }

        $e = DB::table('tb_karyawan as a')->select("*")->where('a.nik',Auth::user()->nik)->get();
        $b['id_karyawan'] = $e[0]->id;
        $b['nama_karyawan'] = $e[0]->nama;
        $b['jumlah'] = 1000;
        $b['saldo_temp'] = $e[0]->saldo + $b['jumlah'];
        $b['jenis'] = "Fee Transfer Insentif";
        $b['admin'] = Auth::user()->id;
        $b['keterangan'] = $d[0]->nama_karyawan;
        if($q2){
          $q3 = DB::table('tb_insentif')->insert($b);
        }

        $c['saldo'] = $e[0]->saldo + $b['jumlah'];
        if($q3){
          $q4 = DB::table('tb_karyawan')->where('id',$e[0]->id)->update($c);
        }

        $x['saldo'] = $b['saldo_temp'];
        if($q4){
          $q5 = DB::table('tb_karyawan')->where('id',$d[0]->id_karyawan)->update($x);

          if($data['transaksi'] == "tunai"){
                $kt['jumlah'] = $jumlah_ins;
                $kt['saldo_temp'] = 0;
                $kt['jenis'] = 'out';
                $kt['nama_jenis'] = "Insentif Non Gaji";
                $kt['admin'] = Auth::user()->id;
                $kt['keterangan'] = "Pengambilan Insentif ".$a['nama_karyawan'];
                $q = DB::table('tb_kas_ditangan')->insert($kt);
          }else if($data['transaksi'] == "transfer"){
                $kt['jumlah'] = $jumlah_ins;
                $kt['saldo_temp'] = 0;
                $kt['jenis'] = 'out';
                $kt['nama_jenis'] = "Insentif Non Gaji";
                $kt['admin'] = Auth::user()->id;
                $kt['keterangan'] = "Pengambilan Insentif ".$a['nama_karyawan'];
                $kt['kode_bank'] = $data['rekening'];
                $q = DB::table('tb_kas_dibank')->insert($kt);
          }

          return redirect()->back()->with('success','Berhasil');
        }
      }

    }else{
      return view ('Denied');
    }
  }

  public function bataltarik($id){
    DB::table('tb_insentif')->where('id',$id)->delete();
    $u['status'] = "success";
    echo json_encode($u);
  }

  public function bataltarikmase($id){
    DB::table('tb_pengembangan')->where('id',$id)->delete();
    $u['status'] = "success";
    echo json_encode($u);
  }


  public function potonganinsentif(){
    if (role()) {
      $data['karyawan'] = DB::table('tb_karyawan as a')
                        ->where("a.status","aktif")
                        ->select("*")->get();
      return view('PotonganInsentif',$data);
    }else{
      return view ('Denied');
    }
  }

  public function inputpotongan(Request $post){
    if (role()) {
      $data = $post->except('_token');
      $data['old_saldo'] = str_replace(".","",$data['old_saldo']);
      $data['jumlah'] = str_replace(".","",$data['jumlah']);
      $u['id_karyawan'] = $data['id_karyawan'];
      $u['nama_karyawan'] = $data['nama_karyawan'];
      $u['jumlah'] = $data['jumlah'];
      $u['saldo_temp'] = $data['old_saldo'] - $data['jumlah'];
      $u['jenis'] = "Potongan Insentif";
      $u['admin'] = Auth::user()->id;

      DB::table('tb_insentif')->insert($u);

      $x['saldo'] = $u['saldo_temp'];
      DB::table('tb_karyawan')->where('id',$data['id_karyawan'])->update($x);
      return redirect()->back()->with('success','Berhasil');
    }else{
      return view ('Denied');
    }
  }

  public function revisiinsentif(){
    if (role()) {
      $data['karyawan'] = DB::table('tb_karyawan as a')
                        ->where("a.status","aktif")
                        ->select("*")->get();
      return view('RevisiInsentif',$data);
    }else{
      return view ('Denied');
    }
  }

  public function inputrevisi(Request $post){
    if (role()) {
      $data = $post->except('_token');
      $data['old_saldo'] = str_replace(".","",$data['old_saldo']);
      $data['jumlah'] = str_replace(".","",$data['jumlah']);
      $u['id_karyawan'] = $data['id_karyawan'];
      $u['nama_karyawan'] = $data['nama_karyawan'];
      $u['jumlah'] = $data['jumlah'];
      $u['saldo_temp'] = $data['old_saldo'] + $data['jumlah'];
      $u['jenis'] = "Potongan Insentif";
      $u['admin'] = Auth::user()->id;

      DB::table('tb_insentif')->insert($u);

      $x['saldo'] = $u['saldo_temp'];
      DB::table('tb_karyawan')->where('id',$data['id_karyawan'])->update($x);
      return redirect()->back()->with('success','Berhasil');
    }else{
      return view ('Denied');
    }
  }

  public function prosesinsentif(Request $post){
    $data = $post->except('_token');

    $data['old_saldo'] = str_replace(".","",$data['old_saldo']);
    $data['jumlah'] = str_replace(".","",$data['jumlah']);
    $u['id_karyawan'] = $data['id_karyawan'];
    $u['nama_karyawan'] = $data['nama_karyawan'];
    $u['jumlah'] = $data['jumlah'];
    if ($data['cek'] == "out") {
      $u['saldo_temp'] = $data['old_saldo'] - $data['jumlah'];
    }else{
      $u['saldo_temp'] = $data['old_saldo'] + $data['jumlah'];
    }
    $u['jenis'] = $data['jenis'];
    $u['admin'] = Auth::user()->id;
    //if ($data['jenis'] == "Pengambilan Insentif") {
    //  $u['status'] = "pending";
    //  $u['saldo_temp'] = $data['old_saldo'];
    //}
    if ($data['jenis'] == "Pengambilan Insentif") {
      $u['tgl_verifikasi'] = date('Y-m-d h:i:s');
    }
    $u['keterangan'] = $data['keterangan'];
    $u['admin'] = Auth::user()->id;
    DB::table('tb_insentif')->insert($u);
    //if ($data['jenis'] != "Pengambilan Insentif") {
      $x['saldo'] = $u['saldo_temp'];
      DB::table('tb_karyawan')->where('id',$data['id_karyawan'])->update($x);
    //}

    if ($data['jenis'] == "Pengambilan Insentif") {
     if($data['transaksi'] == "tunai"){
            $kt['jumlah'] = $data['jumlah'];
            $kt['saldo_temp'] = 0;
            $kt['jenis'] = $data['cek'];
            $kt['nama_jenis'] = "Insentif Non Gaji";
            $kt['admin'] = Auth::user()->id;
            $kt['keterangan'] = "Pengambilan Insentif ".$data['nama_karyawan'];
            $q = DB::table('tb_kas_ditangan')->insert($kt);
      }else if($data['transaksi'] == "transfer"){
            $kt['jumlah'] = $data['jumlah'];
            $kt['saldo_temp'] = 0;
            $kt['jenis'] = $data['cek'];
            $kt['nama_jenis'] = "Insentif Non Gaji";
            $kt['admin'] = Auth::user()->id;
            $kt['keterangan'] = "Pengambilan Insentif ".$data['nama_karyawan'];
            $kt['kode_bank'] = $data['rekening'];
            $q = DB::table('tb_kas_dibank')->insert($kt);
      }
    }

    return redirect()->back()->with('success','Berhasil');
  }

  public function inputtripinsentif(){
    if(role()){
      $gudang = DB::table('tb_gudang as a')->select("*")->get();
      $data['gudang'] = array();
      foreach ($gudang as $key => $value) {
        $data['gudang'][$value->id]['id'] = $value->id;
        $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
        $data['gudang'][$value->id]['status'] = $value->status;
      }
      $data['insentif'] = DB::table('tb_trip as a')
                          ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                          ->select("*",DB::raw('SUM(b.sub_total) as total'))
                          ->whereNull("a.status")
                          ->groupBy("a.no_trip")
                          ->get();
      $insentifcek = DB::table('tb_trip as a')
                          ->join('tb_detail_trip as b','b.no_trip','=','a.no_trip')
                          ->leftJoin('tb_pembayaran as c','c.no_kwitansi','=','b.no_kwitansi')
                          ->select("*")
                          ->where("c.status_pembayaran","Titip")
                          ->whereNull("a.status")
                          ->orWhereNull("c.status_pembayaran")
                          ->whereNull("a.status")
                          ->groupBy("a.no_trip")
                          ->get();
      $data['ins'] = array();
      foreach ($insentifcek as $key => $value) {
        $data['ins'][$value->no_trip] = true;
      }
      //dd($data['ins']);
      $data['input'] = true;
      $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");
      return view ('PerhitunganInsentif',$data);
    }else{
      return view('Denied');
    }
  }

  public function inputtripinsentifjasa(){
    $gudang = DB::table('tb_gudang as a')->select("*")->get();
    $data['gudang'] = array();
    foreach ($gudang as $key => $value) {
      $data['gudang'][$value->id]['id'] = $value->id;
      $data['gudang'][$value->id]['nama_gudang'] = $value->nama_gudang;
      $data['gudang'][$value->id]['status'] = $value->status;
    }
    $data['input'] = true;
    $data['insentif'] = DB::table('tb_trip_jasa as a')
                        ->select("*")
                        ->whereNotNull("no_trip")
                        ->whereNull("status")
                        ->orWhere("no_trip","<>","")
                        ->whereNull("status")
                        ->get();
    
    $data['kategori'] = array("","Non Insentif","Sales Marketing", "Membership", "Grosir HPP Target");
    return view ('PerhitunganInsentifJasa',$data);
  }

  public function danapengambangan(){
    $data['karyawan'] = DB::table('tb_karyawan as a')
                      ->where("a.status","aktif")
                      ->select("*")->get();

    if (Auth::user()->level == "4" || Auth::user()->level == "1") {
      $data['pengembangan'] = DB::table('tb_pengembangan as a')
                              ->select("*")
                              ->where("a.status","aktif")
                              //->where("a.id_karyawan",'<>','22')
                              ->get();
    }else{
      $p = DB::table('tb_karyawan as a')->select("*")->where("a.nik",Auth::user()->nik)->get();
      if (cekmyid_karyawan() == '22') {
        $data['pengembangan'] = DB::table('tb_pengembangan as a')
                                ->select("*")
                                ->where("a.id_karyawan",$p[0]->id)
                                ->where("a.status","aktif")
                                ->orWhere("a.nama_karyawan",'Pengembangan Sistem')
                                ->get();
      }else{
        $data['pengembangan'] = DB::table('tb_pengembangan as a')
                                ->select("*")
                                ->where("a.id_karyawan",$p[0]->id)
                                ->where("a.status","aktif")
                                //->where("a.id_karyawan",'<>','22')
                                ->get();
      }
    }
    $text_admin = DB::table('users as a')->select("a.*")->get();
    $data['admin'] = array();
    foreach ($text_admin as $value) {
      $data['admin'][$value->id] =$value->name;
    }
    return view('DataPengembangan',$data);
  }

  public function ceksaldopengembang($id){
    $saldo = 0;
    if($id == '22'){
        $insentif2 = DB::table('tb_pengembangan as a')
                  ->select("*")
                  ->where("a.id_karyawan",$id)
                  ->where("a.status","aktif")
                  ->orWhere("a.nama_karyawan",'Pengembangan Sistem')
                  ->where("a.status","aktif")
                  ->get();
    }else{
        $insentif2 = DB::table('tb_pengembangan as a')
                  ->select("*")
                  ->where("a.id_karyawan",$id)
                  ->where("a.status","aktif")
                  ->get();
    }
    foreach ($insentif2 as $k => $value) {
        if ($value->jenis == "Trip" || $value->jenis == "Revisi Penambahan Insentif" || $value->jenis == "Bagi Hasil HPP" || $value->jenis == "Fee Transfer Insentif"){
            $saldo += $value->jumlah;
        }
        if ($value->jenis == "Potongan Insentif" || $value->jenis == "Pengambilan Insentif" || $value->jenis == "Potongan Administrasi" || $value->jenis == "Revisi Pengurangan Insentif"){
            $saldo -= $value->jumlah;
        }
      }
    $data['saldo'] = $saldo;
    echo json_encode($data);
  }

  public function prosespengembangan(Request $post){
    $data = $post->except('_token');
    $data['old_saldo'] = str_replace(".","",$data['old_saldo']);
    $data['jumlah'] = str_replace(".","",$data['jumlah']);
    $u['id_karyawan'] = $data['id_karyawan'];
    $u['nama_karyawan'] = $data['nama_karyawan'];
    $u['jumlah'] = $data['jumlah'];
    if ($data['cek'] == "out") {
      $u['saldo_temp'] = $data['old_saldo'] - $data['jumlah'];
    }else{
      $u['saldo_temp'] = $data['old_saldo'] + $data['jumlah'];
    }
    $u['jenis'] = $data['jenis'];
    $u['admin'] = Auth::user()->id;
    if ($data['jenis'] == "Pengambilan Insentif") {
      $u['tgl_verifikasi'] = date('Y-m-d h:i:s');
    }
    $u['keterangan'] = $data['keterangan'];
    $u['admin'] = Auth::user()->id;

    DB::table('tb_pengembangan')->insert($u);
    $x['saldo'] = $u['saldo_temp'];
    DB::table('tb_karyawan')->where('id',$data['id_karyawan'])->update($x);
    return redirect()->back()->with('success','Berhasil');
  }

  public function simpaninsentifjasa(Request $post){
      $data = $post->except('_token');
      
      //perhitungan poin
      $upoin = array();
      if (isset($data['nama_konsumen']) && isset($data['poin_konsumen'])) {
        $poin_id = explode(",",$data['nama_konsumen']);
        $poin_poin = explode(",",$data['poin_konsumen']);
        for ($i=0; $i < count($poin_id); $i++) {
          if (isset($upoin[$poin_id[$i]])) {
            $upoin[$poin_id[$i]] += $poin_poin[$i];
          }else{
            $upoin[$poin_id[$i]] = $poin_poin[$i];
          }
        }
      }
      foreach ($upoin as $key => $value) {
        if ($key > 0 && $value > 0) {
          $kkon = DB::table('tb_konsumen')->where('id',$key)->get();
          $ppoin['id_konsumen'] = $key;
          if (count($kkon) > 0) {
            $ppoin['nama_konsumen'] = $kkon[0]->nama_pemilik;
          }
          $ppoin['jumlah'] = $value;
          $ppoin['jenis'] = "in";
          $ppoin['nama_jenis'] = "Pembagian Poin";
          $ppoin['admin'] =  Auth::user()->id;
          $ppoin['no_trip'] = $data['no_trip'];
          DB::table('tb_poin')->insert($ppoin);
          DB::table('tb_konsumen')->where('id',$key)->increment('poin',$value);
        }
      }
      //end perhitungan poin

      $u['no_trip'] = $data['no_trip'];
      $u['jenis'] = "Trip";
      $u['admin'] = Auth::user()->id;
      $petugas = explode(",",$data['petugas']);
      $id_petugas = explode(",",$data['id_petugas']);
      $insentif = explode(",",$data['insentif']);


        if (isset($data['omset'])) {
          $dms = DB::table('tb_omset as a')
                ->select("*")
                ->where("a.status","aktif")
                ->orderBy('id', 'desc')->limit(1)->get();
          $data['omset'] = str_replace(".","",$data['omset']);
          $oloms = $data['omset'];
          $data['omset'] = persenfee()[2]->itung_b/100*$data['omset'];
          if (count($dms) > 0) {
            $oms['omset_temp'] = $dms[0]->omset_temp + $data['omset'];
          }else{
            $oms['omset_temp'] = $data['omset'];
          }
          $oms['jumlah'] = $data['omset'];
          $oms['jenis'] = "in";
          $oms['nama_jenis'] = "Omset Trip Jasa";
          $oms['admin'] = Auth::user()->id;
          $oms['no_trip'] = $data['no_trip'];
          $oms['nilai_penjualan'] = str_replace(".","",$oloms);
          $oms['keterangan'] = $data['id_gudang'];
          DB::table('tb_omset')->insert($oms);
        }


        //input insentif petugas
        for ($i=0; $i < count($petugas); $i++) {
          $u['jumlah'] = $insentif[$i];
          $u['nama_karyawan'] = $petugas[$i];
          $u['jumlah'] = str_replace(".","",$u['jumlah']);
          $pt = DB::table('tb_karyawan as a')->select("*")->where("a.id",$id_petugas[$i])->get();
          if (count($pt) < 1) {
            $pt = DB::table('tb_konsumen as a')->select("*")->where("a.id",$id_petugas[$i])->get();
          }
          if ($pt && $u['jumlah'] != 0) {
            $u['id_karyawan'] = $id_petugas[$i];
            $u['saldo_temp'] = $u['jumlah'] + $pt[0]->saldo;
            $query = DB::table('tb_insentif')->insert($u);
            $a['saldo'] = $pt[0]->saldo + $u['jumlah'];
            DB::table('tb_karyawan')->where('id','=',$pt[0]->id)->update($a);
          }

        }
        //end input insentif petugas


        $laba = DB::table('tb_labarugi as a')
              ->select("*")
              ->where("a.status","aktif")
              ->orderBy('id', 'desc')->limit(1)->get();
        $data['labarugi'] = str_replace(".","",$data['labarugi']);
        if (count($laba) > 0) {
          $l['saldo_temp'] = $laba[0]->saldo_temp + $data['labarugi'];
        }else{
          $l['saldo_temp'] = $data['labarugi'];
        }
        $l['jumlah'] = $data['labarugi'];
        $l['jenis'] = "in";
        $l['nama_jenis'] = "Pendapatan";
        $l['admin'] = Auth::user()->id;
        $l['no_trip'] = $data['no_trip'];
        DB::table('tb_labarugi')->insert($l);


        $x['status'] = "calculated";
        $querys = DB::table('tb_trip_jasa')->where('no_trip','=',$u['no_trip'])->update($x);


      echo json_encode($u);
  }

}
