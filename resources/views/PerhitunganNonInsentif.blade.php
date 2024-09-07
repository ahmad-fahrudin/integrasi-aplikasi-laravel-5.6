@extends('template/nav')
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Laporan Harian / Trip > <a href="https://stokis.app/?s=input+insentif+trip+kiriman" target="_blank">Simpan Trip Kiriman</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <p><strong>Filter Berdasarkan</strong></p>
                    <div class="form-group">
                       <form name="form1" action="{{url('perhitunganinsentif')}}" method="post" enctype="multipart/form-data">
                         {{csrf_field()}}
                       <div class="row">
                           <label class="col-lg-1">No. Trip</label>
                           <div class="col-lg-3">
                               <div class="row">
                                     <div class="col-lg-12">
                                         <div class="row">
                                             <div class="col-md-12">
                                               <div class="input-group">
                                                 <input id="no_trip"  name="no_trips" type="text" class="form-control"
                                                 <?php if (isset($no_trips)): ?> value="{{$no_trips}}" <?php endif; ?>>
                                                 <input id="id_trip" name="id_trips" type="hidden" class="form-control"
                                                 <?php if (isset($id_trips)): ?> value="{{$id_trips}}" <?php endif; ?>>
                                                 <div class="input-group-append">
                                                     <button class="btn btn-outline-secondary" onclick="caritrip()" type="button"><i class="fas fa-search"></i></button>
                                                 </div>
                                               </div>
                                             </div>
                                         </div>
                                     </div>
                               </div>
                            </div>
                       </div>
                       <br>
                       <div class="row">
                           <label class="col-lg-1">Tanggal</label>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input name="tanggal_inputs" readonly id="tanggal_input" type="date" class="form-control"
                                       <?php if (isset($tanggal_inputs)): ?>
                                         value="{{$tanggal_inputs}}"
                                       <?php endif; ?>
                                       >
                                   </div>
                                </div>
                            </div>
                       </div>
                       <br>
                       <div class="row">
                           <label class="col-lg-1">Kategori Penjual</label>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input type="text" readonly class="form-control" id="kategori" name="kategoris"
                                       <?php if (isset($kategoris)): ?> value="{{$kategoris}}" <?php endif; ?>>
                                   </div>
                               </div>
                            </div>
                       </div>
                       <br>
                       <div class="row">
                           <label class="col-lg-1">Gudang</label>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input type="text" readonly class="form-control" id="id_gudang" name="id_gudangs"
                                       <?php if (isset($id_gudangs)): ?> value="{{$id_gudangs}}" <?php endif; ?>>
                                   </div>
                               </div>
                            </div>
                       </div>
                       <br>
                       <div class="row" id="opkir"
                           <?php if (isset($operasional_kiriman) && $operasional_kiriman > 0){ ?>
                             style="visibility:visible;"
                           <?php }else{ ?>
                             style="visibility:hidden;"
                           <?php } ?>>
                           <label class="col-lg-1">Operasional Kiriman</label>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input type="text" class="form-control" id="operasional_kiriman" name="operasional_kiriman"
                                       <?php if (isset($operasional_kiriman)): ?> value="{{$operasional_kiriman}}" <?php endif; ?>>
                                   </div>
                               </div>
                            </div>
                       </div>
                      </div>

                      <br>
                      <div class="form-group">
                         <div class="col-lg-4">
                             <center><button disabled id="filter" class="btn btn-success btn-lg">Hitung</button></center>
                         </div>
                      </div>
                      </form>
                      <hr><br>
									<div class="table-responsive">
                  <table id="examples1" class="table table-striped table-bordered no-wrap" style="width:100%">
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

                          $poin_konsumen = "";
                          $poin_idkonsumen = "";

                          $kolek_ongkir = array();
                          $jumlah_ongkir = 0;
                          foreach($data as $vjk){
                              $kolek_ongkir[$vjk->no_kwitansi] = $vjk->ongkos_kirim;
                          }
                          foreach($kolek_ongkir as $gdf){
                              $jumlah_ongkir += $gdf;
                          }


                          $index_pengadaan = 0;
                          $pengadaan = array();

                          $bagihasilstokis = 0;
                          $fee_item = 0;
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
                          $investor = 0;


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

                            if (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) >= $value->harga_net) {
                              $jumlah_omset = $value->harga_hpp * $value->terkirim;
                            }else if (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) >= $value->harga_hpp) {
                              $jumlah_omset = ($value->harga_jual - ($value->potongan + ($value->sub_potongan/$terkirim))) * $value->terkirim;
                            }else if (($value->harga_jual - (($value->sub_potongan/$terkirim) + $value->potongan)) <= $value->harga_hp) {
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
                            
                            if($harga[$value->id_barang]['poin'] > 0){
                              $tmpp = $harga[$value->id_barang]['poin'] * $value->terkirim;
                              $poin_konsumen .= $tmpp.",";
                              $poin_idkonsumen .= $value->id_konsumen.",";
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
/*$investor = 0.25 * $sisa_selisih;*/
$perusahaan = 0.25 * $sisa_selisih;
$penjualan = 0.5 * $sisa_selisih;
if ($value->harga_jual > $value->harga_net && $value->harga_net > $harga_hp_value) {
  $bagihasilstokis += 10/100 * (($value->terkirim * $value->harga_net) - ($value->terkirim * $harga_hpp_value));
  $investor += perseninvestor()[0]->pengadaanbasilA/100 * (($value->terkirim * $value->harga_hpp) - ($value->terkirim * $harga_hp_value));
}else if($value->harga_jual > $harga_hpp_value && $value->harga_jual > $harga_hp_value){
  $bagihasilstokis += 10/100 * ($value->sub_total - ($value->terkirim * $harga_hpp_value));
  $investor += perseninvestor()[0]->pengadaanbasilB/100 * ($value->sub_total - ($value->terkirim * $harga_hp_value));
}else if($value->harga_jual > $harga_hp_value){
  $bagihasilstokis += 5/100 * ($value->sub_total - ($value->terkirim * $harga_hp_value));
  $investor += perseninvestor()[0]->pengadaanbasilC/100 * ($value->sub_total - ($value->terkirim * $harga_hp_value));
}else{
  $bagihasilstokis += 0;
  $investor += 0;
}
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
  if(isset($value->helper)){
      if (isset($perhitungan[$karyawan[$value->helper]['nama']]['helper'])) {
        $perhitungan[$karyawan[$value->helper]['nama']]['helper'] += 0 / 100 * ($itung);
      }else{
        $perhitungan[$karyawan[$value->helper]['nama']]['helper'] = 0 / 100 * ($itung);
      }
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
  $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 0;
}else{
  $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 0;
}


$operasional_barang += 0;
$index_pengadaan++;


 ?>


                          <?php endforeach; ?>
                        <?php endif;?>
                      </tbody>
                  </table>
								</div>
                <br><br><br>
                <?php if (isset($data)){ ?>
                <div class="row">
                  
                  <div class="col-md-3 row">
                      <label class="col-lg-4">Nilai Penjualan</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" id="nilai_penjualan" readonly class="form-control" value="{{ribuan($nilai_penjualan)}}">
                              </div>
                          </div>
                       </div>
                  </div>
                  <div class="col-md-3 row">
                      <label class="col-lg-4">Nilai Retur</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" value="{{ribuan($jumlah_nilai_retur)}}">
                              </div>
                          </div>
                       </div>
                  </div>
                  <div class="col-md-3 row">
                      <label class="col-lg-4">Selisih Penjualan</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" value="{{ribuan(($selisih_penjualan)+($jumlah_harga_hpp - $jumlah_harga_hp)+($selisih_hpp))}}">
                              </div>
                          </div>
                       </div>
                  </div>
                  
                </div>  
                </div>
                <div style="display:none" class="col-md-3 row">
                      <label class="col-lg-4">Omset Barang Umum</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" id="omset_umum" value="{{ribuan($omset_umum)}}">
                              </div>
                          </div>
                       </div>
                  </div>
                  <div style="display:none" class="col-md-3 row">
                      <label class="col-lg-4">Omset Barang Branded</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" id="omset_branded" value="{{ribuan($omset_branded)}}">
                              </div>
                          </div>
                       </div>
                  </div>
              <?php } ?>
                <br><br><br>
                <div class="table-responsive">
                <table class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
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
                        </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($data)): ?>
                        <?php
                          $no=1;
                          $total_insentif = 0;
                          $bonus_admin_insentif = 0;
                          $bonus_admin_gudang = 0;
                          //$master = 0;
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



                            <td align="right" id="insentif{{$no}}">{{ribuan($jumlah)}}</td>

                          </tr>
                        <?php $total_insentif+=$jumlah; $no++;
                        //if ($key == "Master") { $master += $jumlah; }
                        endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                </table>
              </div>

              <br>
              <h3>
              <table align="right" class="col-md-3">
                <tr hidden>
                  <td style="padding:5px;" >Operasional Toko</td>
                  <td align="right">{{ribuan($operasional_barang)}}</td>
                <tr>
                <tr hidden>
                  <td style="padding:5px;">Tenaga Toko</td>
                  <td align="right" id="tenagatoko">
                    <?php $tenaga_gudang = 0/100 * ($omset_selisih_0 + $selisih_penjualan); ?>
                    {{ribuan($tenaga_gudang)}}
                  </td>
                </tr>
                <tr hidden>
                  <td style="padding:5px;">Tenaga Gudang</td>
                  <td align="right" id="tenagagudang">
                    <?php $tenaga_toko = 0/100 * ($omset_selisih_0 + $selisih_penjualan); ?>
                    {{ribuan($tenaga_toko)}}
                  </td>
                </tr>
                <tr>
                  <td style="padding:5px;">TOTAL INSENTIF</td>
                  <td align="right"><?php $semua_insentif = $total_insentif+$operasional_barang; echo ribuan($semua_insentif); ?></td>
                </tr>
                <tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
                <tr>
                  <td style="padding:5px;">Pendapatan Kotor</td>
                  <td align="right" id="labarugi">
                    <?php if ($postinduk == $induk){ ?>
                        {{ribuan($selisih_penjualan+$selisih_hpp+$operasional_barang+($jumlah_harga_hpp - $jumlah_harga_hp) - $semua_insentif + $jumlah_ongkir)}}
                    <?php }else{ ?>
                        {{ribuan($selisih_penjualan+$selisih_hpp+$operasional_barang+($jumlah_harga_hpp - $jumlah_harga_hp) - $semua_insentif - $bagihasilstokis + $jumlah_ongkir)}}
                    <?php } ?>
                  </td>
                </tr>
                  <tr hidden>
                    <td style="padding:5px;">Bagi Hasil Stokis</td>
                    <td align="right" id="bagihasilstokis">
                        <?php if ($postinduk != $induk){ ?>
                          {{ribuan($bagihasilstokis)}}
                        <?php }else{
                          echo 0;
                        } ?>
                    </td>
                  </tr>
              </table>
            </h3>
              </div>

              <br><br><br>
              <div class="col-md-12">
                <center>
                  <?php if (isset($cek)){ ?>
                    <?php if (!isset($ins[$no_trips])): ?>
                      <input hidden type="checkbox" name="kode" value="1" id="kode" class="form-control">
                    <?php endif; ?>
                    <br><br>
                    <button class="btn btn-primary btn-lg" id="save"
                    <?php if (isset($ins[$no_trips])): ?>
                      disabled
                    <?php endif; ?>
                    onclick="Simpan()">&emsp;&emsp;&emsp;&emsp;Simpan Laporan&emsp;&emsp;&emsp;&emsp;</button>
                    <?php if (isset($ins[$no_trips])): ?>
                      <br> Kwitansi ada yang belum Lunas
                    <?php endif; ?>
                  <?php }else{ ?>
                    <button class="btn btn-success btn-lg" onclick="Cetak()">&emsp;&emsp;&emsp;&emsp;Cetak&emsp;&emsp;&emsp;&emsp;</button>
                  <?php } ?>
                </center>
              </div>
              <br><br><br>

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
                    <?php foreach ($insentif as $value){ if ($value->no_trip != ""){ ?>
                      <tr onclick="pilihtrip('{{$value->id}}','{{$value->no_trip}}','{{$value->tanggal_input}}',
                                             '{{$kategori[$value->kategori]}}','{{$gudang[$value->id_gudang]['nama_gudang']}}'
                                             ,'{{$value->kategori}}','{{$value->id_gudang}}')">
                          <td>{{$value->no_trip}}</td>
                          <td>{{$value->tanggal_input}}</td>
                          <td>{{$kategori[$value->kategori]}}</td>
                          <td>{{$gudang[$value->id_gudang]['nama_gudang']}}</td>
                      </tr>
                     <?php } } ?>
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
    if (nama_kategori == "Grosir HPP") {
      document.getElementById("opkir").style.visibility = "visible";
      document.getElementById("operasional_kiriman").value = 0;
    }else{
      document.getElementById("opkir").style.visibility = "hidden";
      document.getElementById("operasional_kiriman").value = 0;
    }
    $('#trip').modal('hide');
  }

  function Cetak(){
    var id_trips= document.getElementById("id_trip").value
    var no_trips = document.getElementById("no_trip").value
    var tanggal_inputs = document.getElementById("tanggal_input").value
    var kategoris = document.getElementById("kategori").value
    var id_gudangs = document.getElementById("id_gudang").value

    window.open("{{url('/cetakinsentifpenjualan')}}"+"/"+id_trips+"/"+no_trips+"/"+tanggal_inputs+"/"+kategoris+"/"+id_gudangs+"/"+{{$operasional_kiriman}});

  }

  function Simpan(){
    var no_trip = document.getElementById("no_trip").value;
    var nama_petugas="";
    var insentif="";
    var labarugi = document.getElementById("labarugi").innerHTML;
    var tenagatoko = document.getElementById("tenagatoko").innerHTML;
    var tenagagudang = document.getElementById("tenagagudang").innerHTML;
    var gudang_insentif = "<?php echo $id_gudangs ?>";
    var bagihasilstokis = document.getElementById("bagihasilstokis").innerHTML;

    var omset_umum = document.getElementById("omset_umum").value;
    var omset_branded = document.getElementById("omset_branded").value;
    var kategori = document.getElementById("kategori").value;
    var id_gudang = document.getElementById("id_gudang").value;
    var nilai_penjualan = document.getElementById("nilai_penjualan").value;

    var pengadaan_id_barang = "";
    var pengadaan_jumlah_kulakan = "";
    var pengadaan_jumlah_investasi = "";
    var pengadaan_estimasi_pendapatan = "";
    <?php foreach ($pengadaan as $key => $value) { ?>
        pengadaan_id_barang = pengadaan_id_barang+"{{$value['id_barang']}}"+",";
        pengadaan_jumlah_kulakan = pengadaan_jumlah_kulakan+"{{$value['jumlah_kulakan']}}"+",";
        pengadaan_jumlah_investasi = pengadaan_jumlah_investasi+"{{$value['jumlah_investasi']}}"+",";
        pengadaan_estimasi_pendapatan = pengadaan_estimasi_pendapatan+"{{$value['estimasi_pendapatan']}}"+",";
    <?php } ?>
    var kode = document.getElementById("kode");
    if (kode.checked) {
      pengadaan_estimasi = 2;
    }else{
      pengadaan_estimasi = 1;
    }

    for (var i = 1; i < {{$no}}; i++) {
      nama_petugas += document.getElementById("karyawan"+i).innerHTML +",";
    }
    for (var i = 1; i < {{$no}}; i++) {
      insentif += document.getElementById("insentif"+i).innerHTML +",";
    }

    console.log(pengadaan_id_barang);
    console.log(pengadaan_jumlah_kulakan);
    console.log(pengadaan_jumlah_investasi);
    console.log(pengadaan_estimasi);
    console.log(pengadaan_estimasi_pendapatan);

    var nama_konsumen = "{{$poin_idkonsumen}}";
    var poin_konsumen = "{{$poin_konsumen}}";


    Swal.fire(
      'Simpan Insentif ?',
      'Apakah Anda Yakin?',
      'question'
    ).then((result) => {
      if (result.value) {
        document.getElementById("save").disabled = true;
        $.post("{{url('simpaninsentif')}}",
          {nama_konsumen:nama_konsumen,poin_konsumen:poin_konsumen,pengadaan_id_barang:pengadaan_id_barang,pengadaan_jumlah_kulakan:pengadaan_jumlah_kulakan,pengadaan_jumlah_investasi:pengadaan_jumlah_investasi,pengadaan_estimasi:pengadaan_estimasi,pengadaan_estimasi_pendapatan:pengadaan_estimasi_pendapatan,
          nilai_penjualan:nilai_penjualan,id_gudang:id_gudang,kategori:kategori,omset_umum:omset_umum,omset_branded:omset_branded,gudang_insentif:gudang_insentif,bagihasilstokis:bagihasilstokis,labarugi:labarugi,tenagatoko:tenagatoko,tenagagudang:tenagagudang,no_trip:no_trip, nama_petugas:nama_petugas, insentif:insentif, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
              {
                  Swal.fire({
                      title: 'Berhasil',
                      icon: 'success',
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                      Cetak();
                      location.href="{{url('/inputtripinsentif/')}}";
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