@extends('template/master')
@section('main-content')
<style>
table {
    margin: auto;
    width: calc(100% - 40px);
}
</style>
    <div class="container-fluid">
        <div class="card">
        <div class="card-body">
<div style="background-color:white;">
      <center><b><h3>Cetak Laporan Insentif Penjualan</h3></b></center>
    <br>
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
                            <th>Jumlah Batal</th>
                            <th>Jumlah Terkirim</th>
                            <th>Harga HP</th>
                            <th>Harga HPP</th>
                            <th>Harga Net</th>
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
                            <th>Admin(V)</th>
                            <th>Admin(K)</th>
                            <th>QC</th>
                            <th>Dropper</th>
                            <th>Pengirim</th>
                            <th>Helper</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if (isset($data)):


                          $kolek_ongkir = array();
                          $jumlah_ongkir = 0;
                          foreach($data as $vjk){
                              $kolek_ongkir[$vjk->no_kwitansi] = $vjk->ongkos_kirim;
                          }
                          foreach($kolek_ongkir as $gdf){
                              $jumlah_ongkir += $gdf;
                          }

                          $fee_item = 0;
                          $index_pengadaan = 0;
                          $pengadaan = array();

                          $bagihasilstokis = 0;

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

                          $omset_selisih_0 = 0;
                          $selisih_penjualan = 0;
                          $selisih_hpp = 0;
                          $selisih_harga = 0;
                          $prosentase_omset_kosong = 0;

                          $jumlah_omset_penjualan_hp = 0;
                          $jumlah_selisih_penjualan_hp = 0;
                          $jumlah_selisih_penjualan_hp_lb = 0;
                          $jumlah_operasional_managemen_hp = 0;
                          $jumlah_operasional_managemen_hp_lb = 0;
                          $jumlah_admin_k = 0;
                          $jumlah_chandra = 0;
                          $jumlah_gudang = 0;


                          foreach ($data as $key => $value) {
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

                            if ($value->harga_jual > $harga_hp_value) {
                              $omset_penjualan_hp = $harga_hp_value * $value->terkirim;
                            }else{
                              $omset_penjualan_hp = $value->harga_jual * $value->terkirim;
                            }

                            $jumlah_omset_penjualan_hp += $omset_penjualan_hp;
                          }


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
                            if ($value->harga_agen < 1) {
                              $value->harga_agen = 0;
                            }
                            if ($value->harga_reseller < 1) {
                              $value->harga_reseller = 0;
                            }
                            //end configuration


                            $omset_kategori = 0;
                            $temp_barang_umum_hitung_bonus_driver = 0;
                            $text=str_ireplace('<p>','',$konsumen[$value->id_konsumen]['alamat']);
                            $text=str_ireplace('</p>','',$text);
                            $text=str_ireplace('&nbsp;','',$text);

                            if ($value->terkirim < 1){
                                $terkirim = 1;
                            }else{
                                $terkirim = $value->terkirim;
                            }

                            if (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) > $value->harga_net) {
                              $jumlah_omset = ($value->harga_jual - ($value->potongan + ($value->sub_potongan/$terkirim))) * $value->terkirim;
                            }else{
                              $jumlah_omset = ($value->harga_jual - ($value->potongan + ($value->sub_potongan/$terkirim))) * $value->terkirim;
                            }

                            if ($barang[$value->id_barang]['branded'] == "1") {
                              $omset_branded += $jumlah_omset;
                            }else{
                              $omset_umum += $jumlah_omset;
                              $temp_barang_umum_hitung_bonus_driver = $jumlah_omset;
                            }
                            $nilai_penjualan += $value->sub_total;

                            $jumlah_harga_jual += $value->sub_total;
                            $jumlah_harga_net += ($value->harga_net * $value->terkirim);


                            if (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) >= $value->harga_net) {
                              $selisih_penjualan += ($value->sub_total - $jumlah_omset);
                              $selisih_harga = ($value->sub_total -  ($value->harga_hp * $value->terkirim));
                              $selisih_hpp += ($jumlah_omset - ($value->terkirim * $harga_hpp_value));
                            }else{
                              $selisih_harga = ($value->sub_total -  ($value->harga_hp * $value->terkirim));
                              $selisih_hpp += ($jumlah_omset - ($value->terkirim * $harga_hpp_value));
                            }

                            $jumlah_harga_hpp += ($harga_hpp_value * $value->terkirim);
                            $jumlah_harga_hp += ($harga_hp_value * $value->terkirim);

                            $jumlah_nilai_retur += ($value->harga_jual * $value->return);

                            if ($barang[$value->id_barang]['branded'] == "0" && $value->harga_net < 200000) {
                              $omset_kategori = 1/100 * $jumlah_omset;
                            }else if($barang[$value->id_barang]['branded'] == "0" && ($value->harga_net >= 200000 && $value->harga_net <= 400000)){
                              $omset_kategori = 0.8/100 * $jumlah_omset;
                            }else if($barang[$value->id_barang]['branded'] == "0" && $value->harga_net > 400000){
                              $omset_kategori = 0.6/100 * $jumlah_omset;
                            }else if($barang[$value->id_barang]['branded'] == "1"){
                              $omset_kategori = 0.6/100 * $jumlah_omset;
                            }

                            if (($value->sub_total - $jumlah_omset) < 1) {
                              $omset_selisih_0 += $omset_kategori;
                            }

                            $pengadaan[$index_pengadaan]['id_barang'] = $value->id_barang;
                            $pengadaan[$index_pengadaan]['jumlah_kulakan'] = $value->terkirim;
                            $pengadaan[$index_pengadaan]['jumlah_investasi'] = $jumlah_omset;

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
                              <td align="center">{{$value->proses}}</td>
                              <td align="center">{{$value->return}}</td>
                              <td align="center">{{$value->terkirim}}</td>
                              <td align="right">{{ribuan($harga_hp_value)}}</td>
                              <td align="right">{{ribuan($harga_hpp_value)}}</td>
                              <td align="right">{{ribuan($value->harga_net)}}</td>
                              <td align="right">{{ribuan($value->harga_jual)}}</td>
                              <td align="right">{{ribuan($value->potongan)}}</td>
                              <td align="right">{{ribuan($value->sub_potongan/$terkirim)}}</td>
                              <td align="right">{{ribuan($value->sub_total)}}</td>
                              <td align="right">{{ribuan($selisih_harga)}}</td>
                              <td>{{$karyawan[$value->sales]['nama']}}</td>
                              <td>{{$karyawan[$value->pengembang]['nama']}}</td>
                              <td>{{$karyawan[$value->leader]['nama']}}</td>
                              <td><?php if (isset($karyawan[$value->manager])): ?>
                                {{$karyawan[$value->manager]['nama']}}
                              <?php endif; ?></td>
                              <td><?php if (isset($admin[$value->admin_g])){ echo $admin[$value->admin_g]; }?></td>
                              <td><?php if (isset($admin[$value->admin_v])){ echo $admin[$value->admin_v]; }?></td>
                              <td><?php if (isset($admin[$value->admin_k])){ echo $admin[$value->admin_k]; }?></td>
                              <td><?php if (isset($karyawan[$value->qc]['nama'])){ echo $karyawan[$value->qc]['nama']; }?></td>
                              <td><?php if (isset($karyawan[$value->dropper]['nama'])){ echo $karyawan[$value->dropper]['nama']; }?></td>
                              <td><?php if (isset($karyawan[$value->pengirim]['nama'])){ echo $karyawan[$value->pengirim]['nama']; }?></td>
                              <td><?php if (isset($karyawan[$value->helper]['nama'])){ echo $karyawan[$value->helper]['nama']; }?></td>
                            </tr>


<?php

//tambahan
//conf
if ($harga_hp_value > $value->harga_net) {
    $omset_penjualan_hp = $harga_hp_value * $value->terkirim;
    $selisih_penjualan_hp = (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) - $value->harga_net) * $value->terkirim;
}else{
  if ($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan) > $harga_hp_value) {
    $omset_penjualan_hp = $harga_hp_value * $value->terkirim;
    $selisih_penjualan_hp = (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) - $harga_hp_value) * $value->terkirim;
  }else{
    $omset_penjualan_hp = $value->harga_jual * $value->terkirim;
    $selisih_penjualan_hp = 0;
  }
}
//end conf

if ($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan) > $harga_hp_value) {
  $omset_penjualan_hp_lb = $harga_hp_value * $value->terkirim;
  $selisih_penjualan_hp_lb = (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) - $harga_hp_value) * $value->terkirim;
}else{
  $omset_penjualan_hp_lb = $value->harga_jual * $value->terkirim;
  $selisih_penjualan_hp_lb = 0;
}


$jumlah_selisih_penjualan_hp += $selisih_penjualan_hp;
$jumlah_selisih_penjualan_hp_lb += $selisih_penjualan_hp_lb;
if (!isset($operasional_kiriman)) {
  $operasional_kiriman = 0;
}
$persentase_omset = $omset_penjualan_hp / $jumlah_omset_penjualan_hp * 100;
$operasional_kiriman_hp = $persentase_omset / 100 * $operasional_kiriman;
$operasional_managemen_hp = ( $selisih_penjualan_hp - $operasional_kiriman)* 42.5/100;
$operasional_managemen_hp_lb = ( $selisih_penjualan_hp_lb - $operasional_kiriman_hp)* 42.5/100;
$jumlah_operasional_managemen_hp += $operasional_managemen_hp;
$jumlah_operasional_managemen_hp_lb += $operasional_managemen_hp_lb;
$sisa_selisih = $selisih_penjualan_hp - $operasional_kiriman_hp - $operasional_managemen_hp;
$investor = 0.25 * $sisa_selisih;
$perusahaan = 0.25 * $sisa_selisih;
$penjualan = 0.5 * $sisa_selisih;
//end conf

$pengadaan[$index_pengadaan]['estimasi_pendapatan'] = round($investor);
//endtambahan

//menghitung Bonus
if ($value->pengirim != null && $karyawan[$value->pengirim]['jabatan'] == "3") {
  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['bonus_driver'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['bonus_driver'] += 0 / 100 * $temp_barang_umum_hitung_bonus_driver;
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['bonus_driver'] = 0 / 100 * $temp_barang_umum_hitung_bonus_driver;
  }
}


if ($harga_hp_value > $value->harga_net) {
    $itung = $harga[$value->id_barang]['fee_item'] * $value->terkirim;
}else{
  if ($value->sub_total - $jumlah_omset > 0) {
    $itung = $harga[$value->id_barang]['fee_item'] * $value->terkirim;
  }else{
    $itung = $harga[$value->id_barang]['fee_item'] * $value->terkirim;
    $prosentase_omset_kosong += $omset_kategori;
  }
}

if ($value->harga_jual > $value->harga_net && $value->harga_net > $harga_hp_value) {
  $bagihasilstokis += 10/100 * (($value->terkirim * $value->harga_net) - ($value->terkirim * $harga_hpp_value));
}else if($value->harga_jual > $harga_hpp_value && $value->harga_jual > $harga_hp_value){
  $bagihasilstokis += 10/100 * ($value->sub_total - ($value->terkirim * $harga_hpp_value));
}else if($value->harga_jual > $harga_hp_value){
  $bagihasilstokis += 5/100 * ($value->sub_total - ($value->terkirim * $harga_hp_value));
}else{
  $bagihasilstokis = 0;
}

$pengembang = 0;

//menghitung insentif
if ($value->pengirim != null){
 if ($value->manager == null){
  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 100 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 100 / 100 * ($itung);
  }
  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 0 / 100 * ($itung);
  }
  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] = 0 / 100 * ($itung);
  }
  if (isset($perhitungan[$karyawan[$value->helper]['nama']]['helper'])) {
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] = 0 / 100 * ($itung);
  }

  $operasional_barang += 0/100 * ($itung);

 }else{
  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 100 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 100 / 100 * ($itung);
  }
  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 0 / 100 * ($itung);
  }
   if (isset($perhitungan[$karyawan[$value->manager]['nama']]['manager'])) {
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] = 0 / 100 * ($itung);
  }
  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] = 0 / 100 * ($itung);
  }

  if (isset($perhitungan[$karyawan[$value->helper]['nama']]['helper'])) {
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] = 0 / 100 * ($itung);
  }
 }

 $operasional_barang += 0/100 * ($itung);

}else{
 if ($value->manager == null){
  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 100 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 100 / 100 * ($itung);
  }

  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 0 / 100 * ($itung);
  }

  $operasional_barang += 0/100 * ($itung);

 }else{
  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 100 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 100 / 100 * ($itung);
  }

  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 0 / 100 * ($itung);
  }

  if (isset($perhitungan[$karyawan[$value->manager]['nama']]['manager'])) {
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] = 0 / 100 * ($itung);
  }

 }
 $operasional_barang += 0/100 * ($itung);
}



if (isset($perhitungan[$karyawan[$value->leader]['nama']]['leader'])) {
  $perhitungan[$karyawan[$value->leader]['nama']]['leader'] += 0 / 100 * ($itung);
}else{
  $perhitungan[$karyawan[$value->leader]['nama']]['leader'] = 0 / 100 * ($itung);
}


if (isset($perhitungan[$admin[$value->admin_g]]['admin_g'])) {
    $perhitungan[$admin[$value->admin_g]]['admin_g'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$admin[$value->admin_g]]['admin_g'] = 0 / 100 * ($itung);
  }

  if ($value->admin_v != null) {
  if (isset($perhitungan[$admin[$value->admin_g]]['admin_v'])) {
    $perhitungan[$admin[$value->admin_g]]['admin_v'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$admin[$value->admin_g]]['admin_v'] = 0 / 100 * ($itung);
  }
  }

  if ($value->status_barang == "terkirim" && $value->admin_k != null) {
    if (isset($perhitungan[$admin[$value->admin_k]]['admin_k'])) {
      $perhitungan[$admin[$value->admin_k]]['admin_k'] += 0 / 100 * ($itung);
    }else{
      $perhitungan[$admin[$value->admin_k]]['admin_k'] = 0 / 100 * ($itung);
    }
  }

if (isset($karyawan[$value->qc])) {
  if (isset($perhitungan[$karyawan[$value->qc]['nama']]['qc'])) {
    $perhitungan[$karyawan[$value->qc]['nama']]['qc'] += 0 / 100 * ($itung);
  }else{
    $perhitungan[$karyawan[$value->qc]['nama']]['qc'] = 0 / 100 * ($itung);
  }
}

//new script
$pengurang = 0;
if($konsumen[$value->id_konsumen]['jenis_konsumen'] == 1){

  if ($value->jenis_konsumen_referal == 1) {
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] = 0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
  }

  else if ($value->jenis_konsumen_referal == 2) {
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] +=  0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
    $pengurang = 0;
  }

  else if ($value->jenis_konsumen_referal == 3) {
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
    $pengurang = 0;
  
  }else{
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
    $pengurang = 0;
  }

}


else if($konsumen[$value->id_konsumen]['jenis_konsumen'] == 2){

  if ($value->jenis_konsumen_referal == 1) {
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] = 0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
  }

  else if ($value->jenis_konsumen_referal == 2) {
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] +=  0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
    $pengurang = 0;
  }

  else if ($value->jenis_konsumen_referal == 3) {
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] +=  0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
    $pengurang = 0;
  
  }else{
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] +=  0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
    $pengurang = 0;
  }

}


else if($konsumen[$value->id_konsumen]['jenis_konsumen'] == 3){

  if ($value->jenis_konsumen_referal == 1) {
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] +=  0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
  }

  else if ($value->jenis_konsumen_referal == 2) {
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] +=  0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
    $pengurang = 0;
  }

  else if ($value->jenis_konsumen_referal == 3) {
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] +=  0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
    $pengurang = 0;
  
  }else{
    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] +=  0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
    $pengurang = 0;
  }

}


else if($konsumen[$value->id_konsumen]['jenis_konsumen'] == 4){

    if (isset($konsumen[$value->id_konsumen]['reseller'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['reseller']]['nama']]['reseller'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['referal_by'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['referal_by']]['nama']]['referal'] = 0;
      }
    }
    
    if (isset($konsumen[$value->id_konsumen]['agen'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] +=  0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['agen']]['nama']]['agen'] =  0;
      }
    }

    if (isset($konsumen[$value->id_konsumen]['distributor'])) {
      if (isset($perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'])) {
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] += 0;
      }else{
        $perhitungan[$karyawan[$konsumen[$value->id_konsumen]['distributor']]['nama']]['distributor'] = 0;
      }
    }
    $pengurang = 0;
  
}
//end new script


if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
  $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += (100 - $pengurang)/100*$pengembang;
}else{
  $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = (100 - $pengurang)/100*$pengembang;
}


$operasional_barang += 0;
$index_pengadaan++;



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
          <td></td>
				</tr>

        <tr>
					<td>Nilai Penjualan</td>
					<td align="right">{{ribuan($nilai_penjualan)}}</td>
					<td>Nilai Retur</td>
					<td align="right">{{ribuan($jumlah_nilai_retur)}}</td>
					<td>Selisih Penjualan</td>
					<td align="right">{{ribuan(($selisih_penjualan)+($jumlah_harga_hpp - $jumlah_harga_hp)+($selisih_hpp))}}</td>
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
          <td></td>
				</tr>

        <tr>
					<th>No</th>
					<th>Nama Petugas</th>
					<th>Sales</th>
					<th>Pengembang</th>
					<th>Leader</th>
					<th>Manager</th>
					<th>Admin G</th>
					<th>Admin V</th>
					<th>Admin K</th>
					<th>QC</th>
					<th>Driver</th>
					<th>Helper</th>
					
          <th>Referal</th>
          <th>Reseller</th>
          <th>Agen</th>
          <th>Distributor</th>

					<th>Jumlah</th>
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
          <td></td><td></td>
				</tr>

        <?php if (isset($data)): ?>
          <?php
            $no=1;
            $total_insentif = 0;
            $bonus_admin_insentif = 0;
            $bonus_admin_gudang = 0;
            $master = 0;
            foreach ($perhitungan as $key => $value):
            $jumlah = 0;
            ?>
            <tr>
              <td>{{$no}}</td>
                            <td id="karyawan{{$no}}">{{$key}}</td>
                            <td align="right"><?php if (isset($value['sales'])) {
                                    echo ribuan($value['sales']);
                                    $jumlah += $value['sales'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['pengembang'])) {
                                    echo ribuan($value['pengembang']);
                                    $jumlah += $value['pengembang'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['leader'])) {
                                    echo ribuan($value['leader']);
                                    $jumlah += $value['leader'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['manager'])) {
                                    echo ribuan($value['manager']);
                                    $jumlah += $value['manager'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['admin_g'])) {
                                    echo ribuan($value['admin_g']);
                                    $jumlah += $value['admin_g'];
                                    $bonus_admin_gudang += $value['admin_g'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['admin_v'])) {
                                    echo ribuan($value['admin_v']);
                                    $jumlah += $value['admin_v'];
                                    $bonus_admin_gudang += $value['admin_v'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['admin_k'])) {
                                    echo ribuan($value['admin_k']);
                                    $jumlah += $value['admin_k'];
                                    $bonus_admin_insentif += $value['admin_k'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['qc'])) {
                                    echo ribuan($value['qc']);
                                    $jumlah += $value['qc'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['pengirim'])) {
                                    echo ribuan($value['pengirim']);
                                    $jumlah += $value['pengirim'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['helper'])) {
                                    echo ribuan($value['helper']);
                                    $jumlah += $value['helper'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
    
                            
                            <td align="right"><?php if (isset($value['referal'])) {
                                    echo ribuan($value['referal']);
                                    $jumlah += $value['referal'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['reseller'])) {
                                    echo ribuan($value['reseller']);
                                    $jumlah += $value['reseller'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['agen'])) {
                                    echo ribuan($value['agen']);
                                    $jumlah += $value['agen'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td align="right"><?php if (isset($value['distributor'])) {
                                    echo ribuan($value['distributor']);
                                    $jumlah += $value['distributor'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>


              <td align="right">{{ribuan($jumlah)}}</td>
              <td></td><td></td><td></td><td></td>
              <td></td><td></td><td></td><td></td><td></td>
              <td></td><td></td><td></td><td></td>
            </tr>
          <?php $total_insentif+=$jumlah; $no++;
          //if ($key == "Master") {
            //$master += $jumlah;
          //}
          endforeach; ?>
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
													<td>TOTAL INSENTIF</td>
													<td align="right"><?php $semua_insentif = $total_insentif+$operasional_barang; echo ribuan($semua_insentif); ?></td>
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
													<td>Pendapatan Kotor</td>
													<td align="right" id="labarugi">
                            <?php if ($postinduk == $induk){ ?>
                                {{ribuan($selisih_penjualan+$selisih_hpp+$operasional_barang+($jumlah_harga_hpp - $jumlah_harga_hp) - $semua_insentif + $jumlah_ongkir)}}
                            <?php }else{ ?>
                                {{ribuan($selisih_penjualan+$selisih_hpp+$operasional_barang+($jumlah_harga_hpp - $jumlah_harga_hp) - $semua_insentif - $bagihasilstokis + $jumlah_ongkir)}}
                            <?php } ?>
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

                    <td>
                      
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

@endsection
