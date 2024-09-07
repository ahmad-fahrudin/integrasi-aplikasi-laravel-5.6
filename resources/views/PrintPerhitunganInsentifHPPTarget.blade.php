@extends('template/master')
@section('main-content')
<style>
table {
    margin: auto;
    width: calc(100% - 40px);
}
</style>
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
									<div class="table-responsive">
                  <table id="printinsentif" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                            <th>No. Kwitansi</th>
                            <th>Tanggal Proses</th>
                            <th>Tanggal Terkirim</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Gudang</th>
                            <th>No. SKU</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Proses</th>
                            <th>Jumlah Retur</th>
                            <th>Jumlah Terkirim</th>
                            <th>Harga HP</th>
                            <th>Harga HPP</th>
                            <th>Harga Nett</th>
                            <th>Harga Jual</th>
                            <th>Potongan Promo</th>
                            <th>Potongan Harga</th>
                            <th>Jumlah Harga</th>
                            <th>Selisih Harga</th>
                            <th>Sales</th>
                            <th>Pengembang</th>
                            <th>Leader</th>
                            <th>Manager</th>
                            <th>Admin(G)</th>
                            <th>Admin(K)</th>
                            <th>QC</th>
                            <th>Dropper</th>
                            <th>Pengirim</th>
                            <th>Helper</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if (isset($data)):
                          $insentif_driver_helper = 0;
                          $jumlah_nilai_omset = 0;
                          $jumlah_nilai_omset_p = 0;
                          $jumlah_nilai_omset_l = 0;
                          $jumlah_nilai_omset_d = 0;
                          $jumlah_nilai_omset_h = 0;

                          $selisih_penjualan_hpp = 0;
                          $omset_umum = 0;
                          $omset_branded = 0;
                          $nilai_penjualan = 0;
                          $jumlah_harga_jual = 0;
                          $jumlah_harga_net = 0;
                          $jumlah_harga_hpp = 0;
                          $jumlah_harga_hp = 0;
                          $jumlah_nilai_retur= 0;

                          $operasional_barang = 0;
                          $perhitungan = array();
                          $khusus = array();

                          $selisih_penjualan = 0;
                          $selisih_hpp = 0;
                          $selisih_harga = 0;
                          $prosentase_omset_kosong = 0; //tambahan

                          $ik = 0;
                          //dd($data);

                          foreach ($data as $key => $value):
                            if ($value->status_barang == "proses") {
                              $value->terkirim = $value->proses;
                            }


                            //configuration hpp and hp
                            if ($value->harga_hpp > 0) {
                              $harga_hpp_value = $value->harga_hpp;
                            }else{
                              $harga_hpp_value = $harga[$value->id_barang]['harga_hpp'];
                            }
                            if ($value->harga_hp > 0) {
                              $harga_hp_value = $value->harga_hp;
                            }else{
                              $harga_hp_value = $harga[$value->id_barang]['harga_hp'];
                            }
                            //end configuration


                            $omset_kategori = 0;
                            $temp_barang_umum_hitung_bonus_driver = 0;
                            $text=str_ireplace('<p>','',$konsumen[$value->id_konsumen]['alamat']);
                            $text=str_ireplace('</p>','',$text);

                            if ($value->terkirim < 1){
                                $terkirim = 1;
                            }else{
                                $terkirim = $value->terkirim;
                            }

                            if (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) > $harga[$value->id_barang]['harga_hpp']) {
                              $jumlah_omset = $harga[$value->id_barang]['harga_hpp'] * $value->terkirim;
                            }else{
                              $jumlah_omset = $value->harga_jual * $value->terkirim;
                            }

                            if ($barang[$value->id_barang]['branded'] == "1") {
                              $omset_branded += $jumlah_omset;
                            }else{
                              $omset_umum += $jumlah_omset;
                              $temp_barang_umum_hitung_bonus_driver = $jumlah_omset;
                            }

                            if (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) > $value->harga_net) {
                              $omset_net = $value->harga_net * $value->terkirim;
                            }else{
                              $omset_net = $value->harga_jual * $value->terkirim;
                            }

                            $nilai_penjualan += $value->sub_total;

                            $jumlah_harga_jual += $value->sub_total;
                            $jumlah_harga_net += ($value->harga_net * $value->terkirim);

                            $jumlah_harga_hpp += ($harga[$value->id_barang]['harga_hpp'] * $value->terkirim);
                            $jumlah_harga_hp += ($harga[$value->id_barang]['harga_hp'] * $value->terkirim);

                            $jumlah_nilai_retur += ($value->harga_jual * $value->return);

                            if (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) > $harga[$value->id_barang]['harga_hpp']) {
                              $selisih_penjualan += ($value->sub_total - $jumlah_omset);
                              $selisih_harga = ($value->sub_total - $jumlah_omset);
                            }else{
                              $selisih_penjualan += ($value->sub_total - $jumlah_omset);
                              $selisih_harga = 0;
                            }

                            if ($barang[$value->id_barang]['branded'] == "0" && $harga[$value->id_barang]['harga_hpp'] < 200000) {
                              $omset_kategori = 1/100 * $jumlah_omset;
                            }else if($barang[$value->id_barang]['branded'] == "0" && ($harga[$value->id_barang]['harga_hpp'] >= 200000 && $value->harga_net <= 400000)){
                              $omset_kategori = 0.8/100 * $jumlah_omset;
                            }else if($barang[$value->id_barang]['branded'] == "0" && $harga[$value->id_barang]['harga_hpp'] > 400000){
                              $omset_kategori = 0.6/100 * $jumlah_omset;
                            }else if($barang[$value->id_barang]['branded'] == "1"){
                              $omset_kategori = 0.6/100 * $jumlah_omset;
                            }

                            ?>
                            <tr>
                              <td>{{$value->no_kwitansi}}</td>
                              <td>{{$value->tanggal_proses}}</td>
                              <td>{{$value->tanggal_terkirim}}</td>
                              <td>{{$konsumen[$value->id_konsumen]['nama']}}</td>
                              <td>{{$text}}</td>
                              <td>{{$gudang[$value->id_gudang]['nama_gudang']}}</td>
                              <td>{{$barang[$value->id_barang]['no_sku']}}</td>
                              <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                              <td>{{$value->proses}}</td>
                              <td>{{$value->return}}</td>
                              <td>{{$value->terkirim}}</td>
                              <td>{{ribuan($harga_hp_value)}}</td>
                              <td>{{ribuan($harga_hpp_value)}}</td>
                              <td>{{ribuan($value->harga_net)}}</td>
                              <td>{{ribuan($value->harga_jual)}}</td>
                              <td>{{ribuan($value->potongan)}}</td>
                              <td>{{ribuan($value->sub_potongan/$terkirim)}}</td>
                              <td>{{ribuan($value->sub_total)}}</td>
                              <td>{{ribuan($selisih_harga)}}</td>
                              <td>{{$karyawan[$value->sales]['nama']}}</td>
                              <td>{{$karyawan[$value->pengembang]['nama']}}</td>
                              <td>{{$karyawan[$value->leader]['nama']}}</td>
                              <td>{{$karyawan[$value->manager]['nama']}}</td>
                              <td><?php if (isset($admin[$value->admin_g])){ echo $admin[$value->admin_g]; }?></td>
                              <td><?php if (isset($admin[$value->admin_k])){ echo $admin[$value->admin_k]; }?></td>
                              <td><?php if (isset($karyawan[$value->qc]['nama'])){ echo $karyawan[$value->qc]['nama']; }?></td>
                              <td><?php if (isset($karyawan[$value->dropper]['nama'])){ echo $karyawan[$value->dropper]['nama']; }?></td>
                              <td><?php if (isset($karyawan[$value->pengirim]['nama'])){ echo $karyawan[$value->pengirim]['nama']; }?></td>
                              <td><?php if (isset($karyawan[$value->helper]['nama'])){ echo $karyawan[$value->helper]['nama']; }?></td>
                            </tr>


<?php

//menghitung Bonus
if ($karyawan[$value->pengirim]['jabatan'] == "9") {
  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['bonus_driver'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['bonus_driver'] += 0.6 / 100 * $temp_barang_umum_hitung_bonus_driver;
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['bonus_driver'] = 0.6 / 100 * $temp_barang_umum_hitung_bonus_driver;
  }
}

  $itung = 0.5 * ($value->sub_total - $jumlah_omset);
  $operasional_barang += 60/100*$itung;

if (isset($perhitungan[$karyawan[$value->sales]['nama']]['nilai_omset'])) {
  $perhitungan[$karyawan[$value->sales]['nama']]['nilai_omset'] += $jumlah_omset;
  $perhitungan[$karyawan[$value->sales]['nama']]['jabatan'] = $karyawan[$value->sales]['jabatan'];
}else{
  $perhitungan[$karyawan[$value->sales]['nama']]['nilai_omset'] = $jumlah_omset;
  $perhitungan[$karyawan[$value->sales]['nama']]['jabatan'] = $karyawan[$value->sales]['jabatan'];
}


if (isset($perhitungan[$karyawan[$value->sales]['nama']]['selisih_hpp'])) {
  $perhitungan[$karyawan[$value->sales]['nama']]['selisih_hpp'] += $selisih_harga;
  $selisih_penjualan_hpp += $selisih_harga;
}else{
  $perhitungan[$karyawan[$value->sales]['nama']]['selisih_hpp'] = $selisih_harga;
  $selisih_penjualan_hpp += $selisih_harga;
}

if (isset($perhitungan[$karyawan[$value->sales]['nama']]['insentif_driver'])) {
  $perhitungan[$karyawan[$value->sales]['nama']]['insentif_driver'] += ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 25.5/100;
  //$insentif_driver_helper += ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 25.5/100;
}else{
  $perhitungan[$karyawan[$value->sales]['nama']]['insentif_driver'] = ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 25.5/100;
  //$insentif_driver_helper += ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 25.5/100;
}

if (isset($perhitungan[$karyawan[$value->sales]['nama']]['insentif_helper'])) {
  $perhitungan[$karyawan[$value->sales]['nama']]['insentif_helper'] += ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 9.5/100;
  //$insentif_driver_helper += ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 9.5/100;
}else{
  $perhitungan[$karyawan[$value->sales]['nama']]['insentif_helper'] = ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 9.5/100;
  //$insentif_driver_helper += ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 9.5/100;
}

if (isset($perhitungan[$karyawan[$value->sales]['nama']]['bonus_driver'])) {
  $perhitungan[$karyawan[$value->sales]['nama']]['bonus_driver'] += 0.3/100*$jumlah_omset;
  $insentif_driver_helper += 0.3/100*$jumlah_omset;
}else{
  $perhitungan[$karyawan[$value->sales]['nama']]['bonus_driver'] = 0.3/100*$jumlah_omset;
  $insentif_driver_helper += 0.3/100*$jumlah_omset;
}

if (isset($perhitungan[$karyawan[$value->sales]['nama']]['bonus_helper'])) {
  $perhitungan[$karyawan[$value->sales]['nama']]['bonus_helper'] += 0.1/100*$jumlah_omset;
  $insentif_driver_helper += 0.1/100*$jumlah_omset;
}else{
  $perhitungan[$karyawan[$value->sales]['nama']]['bonus_helper'] = 0.1/100*$jumlah_omset;
  $insentif_driver_helper += 0.1/100*$jumlah_omset;
}

$jumlah_nilai_omset += $jumlah_omset;


if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['nilai_omset_p'])) {
  $perhitungan[$karyawan[$value->pengembang]['nama']]['nilai_omset_p'] += $jumlah_omset;
}else{
  $perhitungan[$karyawan[$value->pengembang]['nama']]['nilai_omset_p'] = $jumlah_omset;
}
$jumlah_nilai_omset_p += $jumlah_omset;


if (isset($perhitungan[$karyawan[$value->leader]['nama']]['nilai_omset_l'])) {
  $perhitungan[$karyawan[$value->leader]['nama']]['nilai_omset_l'] += $jumlah_omset;
}else{
  $perhitungan[$karyawan[$value->leader]['nama']]['nilai_omset_l'] = $jumlah_omset;
}
$jumlah_nilai_omset_l += $jumlah_omset;


if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['nilai_omset_d'])) {
  $perhitungan[$karyawan[$value->pengirim]['nama']]['nilai_omset_d'] += $jumlah_omset;
}else{
  $perhitungan[$karyawan[$value->pengirim]['nama']]['nilai_omset_d'] = $jumlah_omset;
}
$jumlah_nilai_omset_d += $jumlah_omset;

if (isset($perhitungan[$karyawan[$value->helper]['nama']]['nilai_omset_h'])) {
  $perhitungan[$karyawan[$value->helper]['nama']]['nilai_omset_h'] += $jumlah_omset;
}else{
  $perhitungan[$karyawan[$value->helper]['nama']]['nilai_omset_h'] = $jumlah_omset;
}
$jumlah_nilai_omset_h += $jumlah_omset;

//menghitung insentif
  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 60 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 60 / 100 * ($itung);
  }
  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 10 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 10 / 100 * ($itung);
  }

  if (isset($perhitungan[$karyawan[$value->leader]['nama']]['leader'])) {
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] += 0;
  }else{
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] = 0;
  }

  if (isset($perhitungan[$karyawan[$value->manager]['nama']]['manager'])) {
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] += 5 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] = 5 / 100 * ($itung);
  }

  if (isset($perhitungan[$admin[$value->admin_g]]['admin_g'])) {
    $perhitungan[$admin[$value->admin_g]]['admin_g'] += 0;
  }else{
    $perhitungan[$admin[$value->admin_g]]['admin_g'] = 0;
  }

  $perhitungan[$admin[$value->admin_g]]['admin_gudang_jabatan'] = true;

  if ($value->status_barang == "terkirim" && $value->admin_k != null) {
    if (isset($perhitungan[$admin[$value->admin_k]]['admin_k'])) {
      $perhitungan[$admin[$value->admin_k]]['admin_k'] += 0;
    }else{
      $perhitungan[$admin[$value->admin_k]]['admin_k'] = 0;
    }
  }

  if (isset($perhitungan[$karyawan[$value->qc]['nama']]['qc'])) {
    $perhitungan[$karyawan[$value->qc]['nama']]['qc'] += 2.5 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->qc]['nama']]['qc'] = 2.5 / 100 * ($itung);
  }

  if (isset($perhitungan[$karyawan[$value->dropper]['nama']]['dropper'])) {
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] += 0;
  }else{
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] = 0;
  }

  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] += ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 25.5/100;;
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] = ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 25.5/100;;
  }

  if (isset($perhitungan[$karyawan[$value->helper]['nama']]['helper'])) {
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] += ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 9.5/100;
  }else{
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] = ((50/100*($value->sub_total - $omset_net)) + $omset_kategori) * 9.5/100;
  }

  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['bonus_drivers'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['bonus_drivers'] += 0.3/100*$jumlah_omset;
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['bonus_drivers'] = 0.3/100*$jumlah_omset;
  }
  if (isset($perhitungan[$karyawan[$value->helper]['nama']]['bonus_helpers'])) {
    $perhitungan[$karyawan[$value->helper]['nama']]['bonus_helpers'] += 0.1/100*$jumlah_omset;
  }else{
    $perhitungan[$karyawan[$value->helper]['nama']]['bonus_helpers'] = 0.1/100*$jumlah_omset;
  }



  $khusus[$ik]['hpp'] = $jumlah_omset;
  $khusus[$ik]['karyawan_sales'] = $karyawan[$value->sales]['nama'];
  $khusus[$ik]['karyawan_pengembang'] = $karyawan[$value->pengembang]['nama'];
  $khusus[$ik]['karyawan_leader'] = $karyawan[$value->leader]['nama'];
  $khusus[$ik]['karyawan_driver'] = $karyawan[$value->pengirim]['nama'];
  $khusus[$ik]['karyawan_helper'] = $karyawan[$value->helper]['nama'];

  if($value->admin_k != null && $value->admin_k != ""){
      $khusus[$ik]['karyawan_admin_k'] = $admin[$value->admin_k];
  }
  $khusus[$ik]['karyawan_admin_g'] = $admin[$value->admin_g];
  $khusus[$ik]['karyawan_admin_g_mujib'] = 'Mujib';

  $khusus[$ik]['jabatan'] = $karyawan[$value->sales]['jabatan'];

  $ik++;
 ?>


                          <?php endforeach; ?>
                        <?php endif;?>


                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>

                        <?php
                        $total_ins = 0;
                        $operasional_managemen = 0;
                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['nilai_omset'])) {
                            if($jumlah_nilai_omset < 1){ $jumlah_nilai_omset=1; }
                            if (isset($perhitungan[$key]['persentase_omset'])) {
                              $perhitungan[$key]['persentase_omset'] += $value['nilai_omset']/$jumlah_nilai_omset*100;
                            }else{
                              $perhitungan[$key]['persentase_omset'] = $value['nilai_omset']/$jumlah_nilai_omset*100;
                            }
                          }
                          if (isset($value['selisih_hpp'])) {
                            if (isset($perhitungan[$key]['operasional_managemen'])) {
                              $perhitungan[$key]['operasional_managemen'] += $value['nilai_omset']/100*3.9;
                            }else{
                              $perhitungan[$key]['operasional_managemen'] = $value['nilai_omset']/100*3.9;
                            }
                            $operasional_managemen += $value['nilai_omset']/100*3.9;
                          }
                        }

                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['persentase_omset'])) {
                            if (isset($perhitungan[$key]['operasional_kiriman'])) {
                              $perhitungan[$key]['operasional_kiriman'] += $value['persentase_omset']/100*$operasional_kiriman;
                            }else{
                              $perhitungan[$key]['operasional_kiriman'] = $value['persentase_omset']/100*$operasional_kiriman;
                            }
                          }
                        }

                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['operasional_kiriman']) && isset($value['insentif_driver'])) {
                              //$perhitungan[$key]['insentif'] = $value['selisih_hpp']-$value['operasional_managemen']-$value['insentif_driver']-$value['insentif_helper']-$value['bonus_driver']-$value['bonus_helper']-$value['operasional_kiriman'];
                              $perhitungan[$key]['insentif'] = $value['selisih_hpp']-$value['operasional_managemen']-$value['operasional_kiriman'];
                              $total_ins += $perhitungan[$key]['insentif'];
                          }
                        }

                        if($jumlah_nilai_omset_p < 1){ $jumlah_nilai_omset_p=1; }

                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['nilai_omset_p'])) {
                            if (isset($perhitungan[$key]['persentase_omset_p'])) {
                              $perhitungan[$key]['persentase_omset_p'] += $value['nilai_omset_p']/$jumlah_nilai_omset_p*100;
                            }else{
                              $perhitungan[$key]['persentase_omset_p'] = $value['nilai_omset_p']/$jumlah_nilai_omset_p*100;
                            }
                          }
                        }

                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['persentase_omset_p'])) {
                              $perhitungan[$key]['insentif_p'] = $value['persentase_omset_p']/100*($total_ins);
                          }
                        }

                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['nilai_omset_l'])) {
                            if (isset($perhitungan[$key]['persentase_omset_l'])) {
                              $perhitungan[$key]['persentase_omset_l'] += $value['nilai_omset_l']/$jumlah_nilai_omset_p*100;
                            }else{
                              $perhitungan[$key]['persentase_omset_l'] = $value['nilai_omset_l']/$jumlah_nilai_omset_p*100;
                            }
                          }
                        }

                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['persentase_omset_l'])) {
                              $perhitungan[$key]['insentif_l'] = $value['persentase_omset_l']/100*($total_ins);
                          }
                        }


                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['nilai_omset_d'])) {
                            if (isset($perhitungan[$key]['persentase_omset_d'])) {
                              $perhitungan[$key]['persentase_omset_d'] += $value['nilai_omset_d']/$jumlah_nilai_omset_p*100;
                            }else{
                              $perhitungan[$key]['persentase_omset_d'] = $value['nilai_omset_d']/$jumlah_nilai_omset_p*100;
                            }
                          }
                        }
                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['persentase_omset_d'])) {
                              $perhitungan[$key]['insentif_d'] = $value['persentase_omset_d']/100*($total_ins);
                          }
                        }

                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['nilai_omset_h'])) {
                            if (isset($perhitungan[$key]['persentase_omset_h'])) {
                              $perhitungan[$key]['persentase_omset_h'] += $value['nilai_omset_h']/$jumlah_nilai_omset_p*100;
                            }else{
                              $perhitungan[$key]['persentase_omset_h'] = $value['nilai_omset_h']/$jumlah_nilai_omset_p*100;
                            }
                          }
                        }
                        foreach ($perhitungan as $key => $value) {
                          if (isset($value['persentase_omset_h'])) {
                              $perhitungan[$key]['insentif_h'] = $value['persentase_omset_h']/100*($total_ins);
                          }
                        }

                        foreach ($khusus as $key => $value) {

                          if (isset($perhitungan[$value['karyawan_pengembang']]['insentif_pengembang_khusus'])) {
                              $perhitungan[$value['karyawan_pengembang']]['insentif_pengembang_khusus'] += ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.15;
                          }else{
                              $perhitungan[$value['karyawan_pengembang']]['insentif_pengembang_khusus'] = ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.15;
                          }

                          //target Pengembang
                          if (isset($perhitungan[$value['karyawan_pengembang']]['target_pengembang'])) {
                              $perhitungan[$value['karyawan_pengembang']]['target_pengembang'] += ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.20;
                          }else{
                              $perhitungan[$value['karyawan_pengembang']]['target_pengembang'] = ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.20;
                          }
                          //end target pengembang

                          if (isset($perhitungan[$value['karyawan_leader']]['insentif_leader_khusus'])) {
                              $perhitungan[$value['karyawan_leader']]['insentif_leader_khusus'] += ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.10;
                          }else{
                              $perhitungan[$value['karyawan_leader']]['insentif_leader_khusus'] = ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.10;
                          }

                          if ($value['jabatan'] != '9' && $value['jabatan'] != '10') {
                              if(isset($value['karyawan_admin_k'])){
                                if (isset($perhitungan[$value['karyawan_admin_k']]['insentif_admink_khusus'])) {
                                  $perhitungan[$value['karyawan_admin_k']]['insentif_admink_khusus'] += ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.10;
                                }else{
                                  $perhitungan[$value['karyawan_admin_k']]['insentif_admink_khusus'] = ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.10;
                                }
                              }

                            if (isset($perhitungan[$value['karyawan_admin_g']]['insentif_adming_khusus'])) {
                              $perhitungan[$value['karyawan_admin_g']]['insentif_adming_khusus'] += ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.06;
                            }else{
                              $perhitungan[$value['karyawan_admin_g']]['insentif_adming_khusus'] = ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.06;
                            }

                            if (isset($perhitungan[$value['karyawan_admin_g_mujib']]['insentif_adming_khusus'])) {
                              $perhitungan[$value['karyawan_admin_g_mujib']]['insentif_adming_khusus'] += ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.04;
                            }else{
                              $perhitungan[$value['karyawan_admin_g_mujib']]['insentif_adming_khusus'] = ($value['hpp']/$jumlah_nilai_omset_p*100)/100 * $total_ins * 0.04;
                            }
                          }

                        }

                        //dd($perhitungan); ?>

                        <tr>
                					<td>Omset Barang Umum (HPP)</td>
                					<td>{{ribuan($omset_umum)}}</td>
                					<td>Nilai Penjualan</td>
                					<td>{{ribuan($nilai_penjualan)}}</td>
                					<td>Selisih Penjualan HPP</td>
                					<td>{{ribuan($selisih_penjualan)}}</td>
                					<td>Selisih HP</td>
                					<td><?php $selisih_hp = $omset_branded + $omset_umum - $jumlah_harga_hp; echo ribuan($selisih_hp); ?></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                				</tr>

                				<tr>
                					<td>Omset Barang Branded (HPP)</td>
                					<td>{{ribuan($omset_branded)}}</td>
                					<td>Nilai Retur</td>
                					<td>{{ribuan($jumlah_nilai_retur)}}</td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                				</tr>

                				<tr>
                          <?php for ($i=0; $i < 29; $i++) {
                            echo "<td></td>";
                          } ?>
                				</tr>
                				<tr>
                          <?php for ($i=0; $i < 29; $i++) {
                            echo "<td></td>";
                          } ?>
                				</tr>

                        <tr>
                					<td>Selisih Penjualan HPP</td>
                					<td>{{ribuan($selisih_penjualan_hpp)}}</td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                				</tr>
                        <tr>
                					<td>Operasional Kiriman</td>
                					<td>{{ribuan($operasional_kiriman)}}</td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                				</tr>
                        <tr>
                					<td>Operasional Managemen</td>
                					<td>{{ribuan($operasional_managemen)}}</td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                				</tr>
                        <tr>
                					<td>Insentif Driver + Helper</td>
                					<td>{{ribuan($insentif_driver_helper)}}</td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                				</tr>
                        <tr>
                					<td>Jumlah Insentif</td>
                					<td>{{ribuan($total_ins)}}</td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                					<td></td>
                				</tr>

                        <tr>
                          <th>No</th>
                          <th>Nama Petugas</th>
                          <th>Sales</th>
                          <th>Pengembang</th>
                          <th>Leader</th>
                          <th>Driver</th>
                          <th>Helper</th>
                          <th>Bonus Driver</th>
                          <th>Bonus Helper</th>
                          <th>Jumlah</th>
                          <th>Pengembang</th>
                          <th>Sales</th>
                          <th>Admin G</th>
                          <th>Nuryatun</th>
                          <th>Vera</th>
                          <th>Bonus Gudang</th>
                					<th></th>
                					<th></th>
                					<th></th>
                					<th></th>
                					<th></th>
                					<th></th>
                					<th></th>
                					<th></th>
                					<th></th>
                					<th></th>
                					<th></th>
                					<th></th>
                					<th></th>
                				</tr>

                        <?php if (isset($data)): ?>
                          <?php
                            $total_target = 0;
                            $no=1;
                            $total_insentif = 0;
                            $bonus_admin_insentif = 0;
                            $bonus_admin_gudang = 0;
                            $mas = 0;
                            foreach ($perhitungan as $key => $value):
                            $jumlah = 0;
                            ?>
                            <tr>
                              <td>{{$no}}</td>
                              <td id="karyawan{{$no}}">{{$key}}</td>
                              <td><?php if (isset($value['insentif']) && $value['insentif'] > 0) {
                                      echo ribuan($value['insentif'] * 10/100);
                                      $jumlah += $value['insentif'] * 10/100;
                                    }else{
                                      echo "0";
                                    } ?>
                              </td>
                              <td><?php if (isset($value['insentif_pengembang_khusus']) && $value['insentif_pengembang_khusus'] > 0) {
                                      echo ribuan($value['insentif_pengembang_khusus']);
                                      $jumlah += $value['insentif_pengembang_khusus'];
                                    }else{
                                      echo "0";
                                    } ?>
                              </td>
                              <td><?php if (isset($value['insentif_leader_khusus']) && $value['insentif_leader_khusus'] > 0) {
                                      echo ribuan($value['insentif_leader_khusus']);
                                      $jumlah += $value['insentif_leader_khusus'];
                                    }else{
                                      echo "0";
                                    } ?>
                              </td>

                              <td>
                                <?php if (isset($value['insentif_d']) && $value['insentif_d'] > 0) {
                                        echo ribuan($value['insentif_d']* 15/100);
                                        $jumlah += $value['insentif_d']* 15/100;
                                      }else{
                                        echo "0";
                                      }?>
                              </td>
                              <td><?php if (isset($value['insentif_h']) && $value['insentif_h'] > 0) {
                                      echo ribuan($value['insentif_h']* 5/100);
                                      $jumlah += $value['insentif_h']* 5/100;
                                    }else{
                                      echo "0";
                                    } ?>
                              </td>
                              <td><?php if (isset($value['bonus_drivers'])) {
                                      echo ribuan($value['bonus_drivers']);
                                      $jumlah += $value['bonus_drivers'];
                                    }else{
                                      echo "0";
                                    } ?>
                              </td>
                              <td><?php if (isset($value['bonus_helpers'])) {
                                      echo ribuan($value['bonus_helpers']);
                                      $jumlah += $value['bonus_helpers'];
                                    }else{
                                      echo "0";
                                    } ?>
                              </td>
                              <td id="insentif{{$no}}">{{ribuan($jumlah)}}</td>

                              <td id="pengembang{{$no}}"><?php if (isset($value['target_pengembang']) && $value['target_pengembang'] > 0) {
                                      echo ribuan($value['target_pengembang']);
                                      $total_target += $value['target_pengembang'];
                                    }else{
                                      echo "0";
                                    } ?></td>
                              <td id="sales{{$no}}"><?php if (isset($value['insentif']) && $value['insentif'] > 0) {
                                      echo ribuan($value['insentif'] * 3/100);
                                      $total_target += $value['insentif'] * 3/100;
                                    }else{
                                      echo "0";
                                    } ?></td>
                              <td id="admin_g{{$no}}"><?php if (isset($value['admin_gudang_jabatan'])){ $total_target += $total_ins*3/100; ?>{{ribuan($total_ins*3/100)}}<?php }else{ echo "0"; } ?></td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <?php
                              for ($i=0; $i < 13; $i++) {
                                echo "<td></td>";
                              }
                               ?>
                            </tr>
                          <?php $total_insentif+=$jumlah; $no++;
                          if ($key == "MAS") {
                            $mas += $jumlah;
                          }
                          endforeach; ?>


                          <tr>
                            <td>{{$no}}</td>
                            <td id="target1">Vera</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td id="hasil_target1">{{ribuan($total_ins*5/100)}}<?php $total_target += $total_ins*5/100; ?></td>
                            <td>0</td>
                            <?php
                            for ($i=0; $i < 13; $i++) {
                              echo "<td></td>";
                            }
                             ?>
                          </tr>
                          <?php $no++; ?>
                          <tr>
                            <td>{{$no}}</td>
                            <td id="target2">Nuryatun</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td id="hasil_target2">{{ribuan($total_ins*5/100)}}<?php $total_target += $total_ins*5/100; ?></td>
                            <td>0</td>
                            <td>0</td>
                            <?php
                            for ($i=0; $i < 13; $i++) {
                              echo "<td></td>";
                            }
                             ?>
                          </tr>
                          <?php $no++; ?>
                          <tr>
                            <td>{{$no}}</td>
                            <td id="target3">Bonus Gudang</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td id="hasil_target3">{{ribuan($total_ins*9/100)}}<?php $total_target += $total_ins*9/100; ?></td>
                            <?php
                            for ($i=0; $i < 13; $i++) {
                              echo "<td></td>";
                            }
                             ?>
                          </tr>


                        <?php endif; ?>

                        <tr>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
                          <td></td>
													<td></td>
													<td>TOTAL INSENTIF</td>
													<td>{{ribuan($total_insentif)}}</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>

												<tr>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>

												<tr>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
                          <td></td>
													<td></td>
													<td>Laba/Rugi Kotor</td>
													<td><?php if ($id_gudangs == "Gudang Bandung"){ ?>
                            {{ribuan(($selisih_hp+$operasional_kiriman+$operasional_managemen)-($selisih_hp/4))}}
                          <?php }else{ ?>
                            {{ribuan($selisih_hp+$operasional_kiriman+$operasional_managemen)}}
                          <?php } ?></td>
                          <td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>

                        <tr>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
                          <td></td>
													<td></td>
													<td>Bagi Hasil Stokis</td>
													<td>
                            <?php if ($id_gudangs == "Gudang Bandung"){ ?>
                              {{ribuan($selisih_hp/4)}}
                            <?php }else{ echo "0";} ?>
                          </td>
                          <td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
                      </tbody>
                  </table>
								</div>







            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="trip" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="examples2" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>No Trip</th>
                          <th>Tanggal</th>
                          <th>Kategori</th>
                          <th>Gudang</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($insentif as $value){ ?>
                      <tr onclick="pilihtrip('{{$value->id}}','{{$value->no_trip}}','{{$value->tanggal_input}}',
                                             '{{$kategori[$value->kategori]}}','{{$gudang[$value->id_gudang]['nama_gudang']}}'
                                             ,'{{$value->kategori}}','{{$value->id_gudang}}')">
                          <td>{{$value->no_trip}}</td>
                          <td>{{$value->tanggal_input}}</td>
                          <td>{{$kategori[$value->kategori]}}</td>
                          <td>{{$gudang[$value->id_gudang]['nama_gudang']}}</td>
                      </tr>
                     <?php } ?>
                  </tbody>
              </table>
            </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
  function caritrip(){
    $('#trip').modal('show');
  }
  function pilihtrip(id,no_trip,tanggal,nama_kategori,nama_gudang,id_kategori,id_gudang){
    document.getElementById("id_trip").value = id;
    document.getElementById("no_trip").value = no_trip;
    document.getElementById("tanggal_input").value = tanggal;
    document.getElementById("kategori").value = nama_kategori;
    document.getElementById("id_gudang").value = nama_gudang;
    document.getElementById("filter").disabled = false;
    $('#trip').modal('hide');
  }
  function Cetak(){
    var id_trips= document.getElementById("id_trip").value
    var no_trips = document.getElementById("no_trip").value
    var tanggal_inputs = document.getElementById("tanggal_input").value
    var kategoris = document.getElementById("kategori").value
    var id_gudangs = document.getElementById("id_gudang").value

    window.open("{{url('/cetakinsentifpenjualan')}}"+"/"+id_trips+"/"+no_trips+"/"+tanggal_inputs+"/"+kategoris+"/"+id_gudangs);

  }
  function Simpan(){
    var no_trip = document.getElementById("no_trip").value;
    var nama_petugas="";
    var insentif="";
    var labarugi = document.getElementById("labarugi").innerHTML;
    for (var i = 1; i <= {{$no}}; i++) {
      nama_petugas += document.getElementById("karyawan"+i).innerHTML +",";
    }
    for (var i = 1; i <= {{$no}}; i++) {
      insentif += document.getElementById("insentif"+i).innerHTML +",";
    }

    Swal.fire(
      'Simpan Investasi ?',
      'Apakah Anda Yakin?',
      'question'
    ).then((result) => {
      if (result.value) {
        document.getElementById("save").disabled = true;
        $.post("simpaninsentif",
          {labarugi:labarugi,no_trip:no_trip, nama_petugas:nama_petugas, insentif:insentif, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
              {
                  Swal.fire({
                      title: 'Berhasil',
                      icon: 'success',
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                      Cetak();
                      location.href="{{url('/perhitunganinsentif/')}}";
                    });
              }).fail(function(jqXHR, textStatus, errorThrown)
          {
              alert(textStatus);
          });
      }
    });

  }
</script>
@endsection
