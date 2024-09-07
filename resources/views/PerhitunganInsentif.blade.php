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
                                                 <input id="no_trip"  name="no_trips" type="text" class="form-control" placeholder="Pilih No. Trip Pengiriman"
                                                 <?php if (isset($no_trips)): ?> value="{{$no_trips}}" <?php endif; ?>>
                                                 <input id="id_trip" name="id_trips" type="hidden" class="form-control"
                                                 <?php if (isset($id_trips)): ?> value="{{$id_trips}}" <?php endif; ?>>
                                                 <div class="input-group-append">
                                                     <button class="btn btn-outline-secondary" onclick="caritrip()" type="button"><i class="fas fa-folder-open"></i></button>
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
                           <label class="col-lg-1">Kategori Penjualan</label>
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
                           <label class="col-lg-1">Cabang</label>
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
                      <?php if (isset($input)): ?>
                        <input type="hidden" name="cek" value="{{$input}}">
                      <?php endif; ?>
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
                            <th>Cabang</th>
                            <th>No. SKU</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Proses</th>
                            <th>Jumlah Batal</th>
                            <th>Jumlah Terkirim</th>
                            <th>Harga HP</th>
                            <th>Harga HPP</th>
                            <th>Harga Nett</th>
                            <th>Harga Jual</th>
                            <th>Jumlah Harga</th>
                            <th>Potongan</th>
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
                          $omset_umum = 0;
                          $omset_branded = 0;
                          $nilai_penjualan = 0;
                          $jumlah_harga_jual = 0;
                          $jumlah_harga_net = 0;
                          $jumlah_harga_hpp = 0;
                          $jumlah_harga_hp = 0;
                          $jumlah_nilai_retur= 0;

                          $perhitungan = array();

                          foreach ($data as $key => $value):
                            $temp_barang_umum_hitung_bonus_driver = 0;
                            $text=str_ireplace('<p>','',$konsumen[$value->id_konsumen]['alamat']);
                            $text=str_ireplace('</p>','',$text);

                            if ($value->harga_jual > $value->harga_net) {
                              $jumlah_omset = $value->harga_net * $value->terkirim;
                            }else{
                              $jumlah_omset = $value->harga_jual * $value->terkirim;
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

                            $jumlah_harga_hpp += ($harga[$value->id_barang]['harga_hpp'] * $value->terkirim);
                            $jumlah_harga_hp += ($harga[$value->id_barang]['harga_hp'] * $value->terkirim);

                            $jumlah_nilai_retur += ($value->harga_jual * $value->return);

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
                              <td>{{$harga[$value->id_barang]['harga_hp']}}</td>
                              <td>{{$harga[$value->id_barang]['harga_hpp']}}</td>
                              <td>{{$value->harga_net}}</td>
                              <td>{{$value->harga_jual}}</td>
                              <td>{{$value->sub_total}}</td>
                              <td>{{$value->sub_potongan + ($value->terkirim*$value->potongan)}}</td>
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


//menghitung insentif
if ($karyawan[$value->sales]['jabatan'] == "9" && $karyawan[$value->manager] != "22"){
  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 40 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 40 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->leader]['nama']]['leader'])) {
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] += 10 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] = 10 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->manager]['nama']]['manager'])) {
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] += 10 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] = 10 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$admin[$value->admin_g]]['admin_g'])) {
    $perhitungan[$admin[$value->admin_g]]['admin_g'] += 0;
  }else{
    $perhitungan[$admin[$value->admin_g]]['admin_g'] = 0;
  }

  if (isset($perhitungan[$admin[$value->admin_k]]['admin_k'])) {
    $perhitungan[$admin[$value->admin_k]]['admin_k'] += 0;
  }else{
    $perhitungan[$admin[$value->admin_k]]['admin_k'] = 0;
  }

  if (isset($perhitungan[$karyawan[$value->dropper]['nama']]['dropper'])) {
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->helper]['nama']]['helper'])) {
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

}else if ($karyawan[$value->sales]['jabatan'] == "1" && $karyawan[$value->manager] != "22"){

  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 10 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 10 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 45 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 45 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->leader]['nama']]['leader'])) {
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] += 10 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] = 10 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if(isset($perhitungan[$karyawan[$value->manager]['nama']]['manager'])){
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] += 10 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] = 10 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$admin[$value->admin_g]]['admin_g'])) {
    $perhitungan[$admin[$value->admin_g]]['admin_g'] += 0;
  }else{
    $perhitungan[$admin[$value->admin_g]]['admin_g'] = 0;
  }

  if (isset($perhitungan[$admin[$value->admin_k]]['admin_k'])) {
    $perhitungan[$admin[$value->admin_k]]['admin_k'] += 0;
  }else{
    $perhitungan[$admin[$value->admin_k]]['admin_k'] = 0;
  }

  if (isset($perhitungan[$karyawan[$value->dropper]['nama']]['dropper'])) {
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->helper]['nama']]['helper'])) {
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

}else if (($karyawan[$value->sales]['jabatan'] == "12" || $karyawan[$value->sales]['jabatan'] == "13" || $karyawan[$value->sales]['jabatan'] == "16"
|| $karyawan[$value->sales]['jabatan'] == "17" || $karyawan[$value->sales]['jabatan'] == "2") && $karyawan[$value->manager] != "22"){

  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 50 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 50 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->leader]['nama']]['leader'])) {
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] += 10 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] = 10 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if(isset($perhitungan[$karyawan[$value->manager]['nama']]['manager'])){
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] += 10 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] = 10 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$admin[$value->admin_g]]['admin_g'])) {
    $perhitungan[$admin[$value->admin_g]]['admin_g'] += 2 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$admin[$value->admin_g]]['admin_g'] = 2 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$admin[$value->admin_k]]['admin_k'])) {
    $perhitungan[$admin[$value->admin_k]]['admin_k'] += 1 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$admin[$value->admin_k]]['admin_k'] = 1 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->dropper]['nama']]['dropper'])) {
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->helper]['nama']]['helper'])) {
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

}else if ($karyawan[$value->sales]['jabatan'] == "9" && $karyawan[$value->manager] == "22"){

  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 50 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 50 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->leader]['nama']]['leader'])) {
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->manager]['nama']]['manager'])) {
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] += 0;
  }else{
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] = 0;
  }

  if (isset($perhitungan[$admin[$value->admin_g]]['admin_g'])) {
    $perhitungan[$admin[$value->admin_g]]['admin_g'] += 0;
  }else{
    $perhitungan[$admin[$value->admin_g]]['admin_g'] = 0;
  }

  if (isset($perhitungan[$admin[$value->admin_k]]['admin_k'])) {
    $perhitungan[$admin[$value->admin_k]]['admin_k'] += 0;
  }else{
    $perhitungan[$admin[$value->admin_k]]['admin_k'] = 0;
  }

  if (isset($perhitungan[$karyawan[$value->dropper]['nama']]['dropper'])) {
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->helper]['nama']]['helper'])) {
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

}else if ($karyawan[$value->sales]['jabatan'] == "1" && $karyawan[$value->manager] == "22"){

  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 10 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 10 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 55 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 55 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->leader]['nama']]['leader'])) {
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->manager]['nama']]['manager'])) {
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] += 0;
  }else{
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] = 0;
  }

  if (isset($perhitungan[$admin[$value->admin_g]]['admin_g'])) {
    $perhitungan[$admin[$value->admin_g]]['admin_g'] += 0;
  }else{
    $perhitungan[$admin[$value->admin_g]]['admin_g'] = 0;
  }

  if (isset($perhitungan[$admin[$value->admin_k]]['admin_k'])) {
    $perhitungan[$admin[$value->admin_k]]['admin_k'] += 0;
  }else{
    $perhitungan[$admin[$value->admin_k]]['admin_k'] = 0;
  }

  if (isset($perhitungan[$karyawan[$value->dropper]['nama']]['dropper'])) {
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->helper]['nama']]['helper'])) {
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

}else if (($karyawan[$value->sales]['jabatan'] == "12" || $karyawan[$value->sales]['jabatan'] == "13" || $karyawan[$value->sales]['jabatan'] == "16"
|| $karyawan[$value->sales]['jabatan'] == "17" || $karyawan[$value->sales]['jabatan'] == "2") && $karyawan[$value->manager] == "22"){

  if (isset($perhitungan[$karyawan[$value->sales]['nama']]['sales'])) {
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->sales]['nama']]['sales'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'])) {
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] += 55 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengembang]['nama']]['pengembang'] = 55 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->leader]['nama']]['leader'])) {
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->leader]['nama']]['leader'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->manager]['nama']]['manager'])) {
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] += 0;
  }else{
    $perhitungan[$karyawan[$value->manager]['nama']]['manager'] = 0;
  }

  if (isset($perhitungan[$admin[$value->admin_g]]['admin_g'])) {
    $perhitungan[$admin[$value->admin_g]]['admin_g'] += 2 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$admin[$value->admin_g]]['admin_g'] = 2 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$admin[$value->admin_k]]['admin_k'])) {
    $perhitungan[$admin[$value->admin_k]]['admin_k'] += 1 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$admin[$value->admin_k]]['admin_k'] = 1 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->dropper]['nama']]['dropper'])) {
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->dropper]['nama']]['dropper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'])) {
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] += 15 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->pengirim]['nama']]['pengirim'] = 15 / 100 * ($value->sub_total - $jumlah_omset);
  }

  if (isset($perhitungan[$karyawan[$value->helper]['nama']]['helper'])) {
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] += 5 / 100 * ($value->sub_total - $jumlah_omset);
  }else{
    $perhitungan[$karyawan[$value->helper]['nama']]['helper'] = 5 / 100 * ($value->sub_total - $jumlah_omset);
  }
} ?>


                          <?php endforeach; ?>
                        <?php endif;?>
                      </tbody>
                  </table>
								</div>
                <br><br><br>
                <?php if (isset($data)){ ?>
                <div class="row">
                  <div class="col-md-3 row">
                      <label class="col-lg-4">Omset Barang Umum</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" value="{{$omset_umum}}">
                              </div>
                          </div>
                       </div>
                  </div>
                  <div class="col-md-3 row">
                      <label class="col-lg-4">Nilai Penjualan</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" value="{{$nilai_penjualan}}">
                              </div>
                          </div>
                       </div>
                  </div>
                  <div class="col-md-3 row">
                      <label class="col-lg-4">Selisih Penjualan</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" value="{{$jumlah_harga_jual - $jumlah_harga_net}}">
                              </div>
                          </div>
                       </div>
                  </div>
                  <div class="col-md-3 row">
                      <label class="col-lg-4">Selisih HP</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" value="{{$jumlah_harga_hpp - $jumlah_harga_hp}}">
                              </div>
                          </div>
                       </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 row">
                      <label class="col-lg-4">Omset Barang Branded</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" value="{{$omset_branded}}">
                              </div>
                          </div>
                       </div>
                  </div>
                  <div class="col-md-3 row">
                      <label class="col-lg-4">Nilai Retur</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" value="{{$jumlah_nilai_retur}}">
                              </div>
                          </div>
                       </div>
                  </div>
                  <div class="col-md-3 row">
                      <label class="col-lg-4">Selisih HPP</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="text" readonly class="form-control" value="{{$jumlah_harga_net - $jumlah_harga_hpp}}">
                              </div>
                          </div>
                       </div>
                  </div>
                </div>
              <?php } ?>
                <br><br><br>
                <div class="table-responsive">
                <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Petugas</th>
                          <th>Sales</th>
                          <th>Pengembang</th>
                          <th>Leader</th>
                          <th>Manager</th>
                          <th>Admin G</th>
                          <th>Admin K</th>
                          <th>Droping</th>
                          <th>Driver</th>
                          <th>Helper</th>
                          <th>Bonus Driver</th>
                          <th>Bonus Helper</th>
                          <th>Admin Insentif</th>
                          <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($data)): ?>
                        <?php
                          $no=1;
                          foreach ($perhitungan as $key => $value):
                          $jumlah = 0;
                          ?>
                          <tr>
                            <td>{{$no}}</td>
                            <td>{{$key}}</td>
                            <td><?php if (isset($value['sales'])) {
                                    echo $value['sales'];
                                    $jumlah += $value['sales'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['pengembang'])) {
                                    echo $value['pengembang'];
                                    $jumlah += $value['pengembang'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['leader'])) {
                                    echo $value['leader'];
                                    $jumlah += $value['leader'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['manager'])) {
                                    echo $value['manager'];
                                    $jumlah += $value['manager'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['admin_g'])) {
                                    echo $value['admin_g'];
                                    $jumlah += $value['admin_g'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['admin_k'])) {
                                    echo $value['admin_k'];
                                    $jumlah += $value['admin_k'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['dropper'])) {
                                    echo $value['dropper'];
                                    $jumlah += $value['dropper'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['pengirim'])) {
                                    echo $value['pengirim'];
                                    $jumlah += $value['pengirim'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['helper'])) {
                                    echo $value['helper'];
                                    $jumlah += $value['helper'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['bonus_driver'])) {
                                    echo $value['bonus_driver'];
                                    $jumlah += $value['bonus_driver'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['bonus_helper'])) {
                                    echo $value['bonus_helper'];
                                    $jumlah += $value['bonus_helper'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td><?php if (isset($value['bonus_admin'])) {
                                    echo $value['bonus_admin'];
                                    $jumlah += $value['bonus_admin'];
                                  }else{
                                    echo "0";
                                  } ?>
                            </td>
                            <td>{{$jumlah}}</td>

                          </tr>
                        <?php $no++; endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                </table>
              </div>

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
                          <th>No. Trip</th>
                          <th>Tanggal</th>
                          <th>Kategori</th>
                          <th>Cabang</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($insentif as $value){
                      if ($value->no_trip != ""){
                        if(isset($input)){
                          if($value->total > 0){?>
                          <tr onclick="pilihtrip('{{$value->id}}','{{$value->no_trip}}','{{$value->tanggal_input}}',
                                                 '{{$kategori[$value->kategori]}}','{{$gudang[$value->id_gudang]['nama_gudang']}}'
                                                 ,'{{$value->kategori}}','{{$value->id_gudang}}')">
                              <td>{{$value->no_trip}}</td>
                              <td>{{$value->tanggal_input}}</td>
                              <td>{{$kategori[$value->kategori]}}</td>
                              <td>{{$gudang[$value->id_gudang]['nama_gudang']}}</td>
                          </tr>
                      <?php }
                          }else{ ?>
                            <tr onclick="pilihtrip('{{$value->id}}','{{$value->no_trip}}','{{$value->tanggal_input}}',
                                                   '{{$kategori[$value->kategori]}}','{{$gudang[$value->id_gudang]['nama_gudang']}}'
                                                   ,'{{$value->kategori}}','{{$value->id_gudang}}')">
                                <td>{{$value->no_trip}}</td>
                                <td>{{$value->tanggal_input}}</td>
                                <td>{{$kategori[$value->kategori]}}</td>
                                <td>{{$gudang[$value->id_gudang]['nama_gudang']}}</td>
                            </tr>
                          <?php }
                        }
                      } ?>
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
    if (nama_kategori == "Grosir HPP" || nama_kategori == "Grosir HP" || nama_kategori == "Online HP" || nama_kategori == "Grosir HPP Target") {
      document.getElementById("opkir").style.visibility = "visible";
      document.getElementById("operasional_kiriman").value = 0;
    }else{
      document.getElementById("opkir").style.visibility = "hidden";
      document.getElementById("operasional_kiriman").value = 0;
    }
    $('#trip').modal('hide');
  }
</script>
@endsection
