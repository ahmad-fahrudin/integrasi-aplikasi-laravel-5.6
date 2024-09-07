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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Data Pembayaran > <a href="https://stokis.app/?s=data+pembayaran+layanan+jasa" target="_blank">Layanan Jasa</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                <p><strong>Cari Data Berdasarkan</strong></p>
                  <div class="col-md-4">
                    <form action="{{url('caridatapembayaranjasa')}}" method="post">
                      {{csrf_field()}}
                    <div class="row">
                      <label class="col-lg-3">No Kwitansi</label>
                      <div class="col-lg-9">
                          <div class="row">
                              <div class="col-md-11">
                                <div class="input-group">
                                  <input type="text" name="no_kwitansi" class="form-control" required placeholder="Ketik No. Kwitansi">
                                  <div class="input-group-append">
                                      <button class="btn btn-success"><i class="fas fa-search"></i></button>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                    </div>
                  </form>
                  </div>
                  </div>


                  <hr>
                  <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <form action="{{url('datapembayaranjasa')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                       <div class="row">
                           <label class="col-lg-3">Tanggal Bayar</label>
                           <div class="col-lg-5">
                               <div class="row">
                                   <div class="col-md-9">
                                       <input type="date" name="from"
                                         <?php if (isset($from)): ?>
                                           value="{{$from}}"
                                         <?php endif; ?>
                                       class="form-control">
                                   </div>
                                   <label class="col-lg-3">s/d</label>
                               </div>
                           </div>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input type="date" name="to"
                                         <?php if (isset($to)): ?>
                                           value="{{$to}}"
                                         <?php endif; ?>
                                       class="form-control">
                                   </div>
                               </div>
                           </div>
                       </div>
                       <br>
                       <div class="row">
                           <label class="col-lg-3">Status Pembayaran</label>
                           <div class="col-lg-9">
                               <div class="row">
                                   <div class="col-md-12">
                                     <select name="status_pembayaran" class="form-control">
                                         <option value="Tempo"
                                         <?php if (isset($status_pembayaran) && $status_pembayaran == "Tempo"): ?>
                                           selected
                                         <?php endif; ?>
                                         >Tempo</option>
                                         <option value="Titip"
                                         <?php if (isset($status_pembayaran) && $status_pembayaran == "Titip"): ?>
                                           selected
                                         <?php endif; ?>
                                         >Titip</option>
                                         <option value="Lunas"
                                         <?php if (isset($status_pembayaran) && $status_pembayaran == "Lunas"): ?>
                                           selected
                                         <?php endif; ?>
                                         >Lunas</option>
                                     </select>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <br>
                       <div class="row">
                           <label class="col-lg-3">Cabang</label>
                           <div class="col-lg-9">
                               <div class="row">
                                   <div class="col-md-12">
                                     <select name="id_gudang" class="form-control">
                                       <?php foreach ($gudang as $value): ?>
                                         <option value="{{$value->id}}"
                                           <?php if (isset($id_gudang)): ?>
                                             <?php if ($value->id == $id_gudang): ?>
                                               selected
                                             <?php endif; ?>
                                           <?php endif; ?>
                                        >{{$value->nama_gudang}}</option>
                                       <?php endforeach; ?>
                                     </select>
                                   </div>
                               </div>
                           </div>
                       </div>
                     </div>

                     <div class="col-md-6">
                      <div class="row">
                          <label class="col-lg-3">Jabatan Petugas</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-11">
                                    <select name="petugas" id="petugas" class="form-control">
                                        <option value="kasir"
                                        <?php if (isset($petugas) && $petugas == "kasir"): ?>
                                          selected
                                        <?php endif; ?>
                                        >Kasir</option>
                                        <option value="petugas1"
                                        <?php if (isset($petugas) && $petugas == "petugas1"): ?>
                                          selected
                                        <?php endif; ?>
                                        >Petugas 1</option>
                                        <option value="petugas2"
                                        <?php if (isset($petugas) && $petugas == "petugas2"): ?>
                                          selected
                                        <?php endif; ?>
                                        >Petugas 2</option>
                                        <option value="petugas3"
                                        <?php if (isset($petugas) && $petugas == "petugas3"): ?>
                                          selected
                                        <?php endif; ?>
                                        >Petugas 3</option>
                                        <option value="leader"
                                        <?php if (isset($petugas) && $petugas == "leader"): ?>
                                          selected
                                        <?php endif; ?>
                                        >Leader</option>
                                        <option value="manager"
                                        <?php if (isset($petugas) && $petugas == "manager"): ?>
                                          selected
                                        <?php endif; ?>
                                        >Manager</option>
                                    </select>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <br>
                      <div class="row">
                          <label class="col-lg-3">Nama Petugas</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-11">
                                    <div class="input-group">
                                      <input id="name"
                                      <?php if (isset($id) && ($petugas == "kasir" || $petugas == "petugas1" || $petugas == "petugas2" || $petugas == "petugas3"|| $petugas == "manager"|| $petugas == "leader") ){ ?>
                                        value="{{$karyawan[$id]}}"
                                      <?php }else if (isset($id)){?>
                                        value="{{$karyawan[$id]}}"
                                      <?php } ?>
                                      type="text" class="form-control" placeholder="Pilih Petugas" readonly style="background:#fff">
                                      <input id="id" name="id"
                                      <?php if (isset($id)): ?>
                                        value="{{$id}}"
                                      <?php endif; ?>
                                       type="hidden" class="form-control">
                                      <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" onclick="carijabatan()" type="button"><i class="fas fa-folder-open"></i></button>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                   </div>
                   <br>
                   <center><button class="btn btn-success btn-lg">Filter Data</button></center>
                  </div>
                  </form>
                  </div>
                  <hr>
                    <br>

                  <!--ul class="nav nav-tabs mb-3">
                      <?php foreach ($bulan as $key => $value): ?>
                      <li class="nav-item">
                          <a onclick="Reload({{$key+1}})" data-toggle="tab" aria-expanded="false" class="nav-link
                              <?php if(isset($tabs)){
                              if($key+1 == $tabs){ ?>
                                active
                              <?php } } ?>
                              ">
                              <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                              <span class="d-none d-lg-block">&emsp;{{$value}}&emsp;</span>
                          </a>
                      </li>
                      <?php endforeach; ?>
                  </ul-->

									<div class="table-responsive">
                  <table id="dp" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Kwitansi</th>
                              <th>Nama Member</th>
                              <th>Alamat</th>
                              <th>Total Bayar</th>
                              <th>Potongan</th>
                              <th>Pembayaran</th>
                              <th>Sisa Piutang</th>
                              <th>Kasir</th>
                              <th>Petugas 1</th>
                              <th>Petugas 2</th>
                              <th>Petugas 3</th>
                              <th>Leader</th>
                              <th>Manager</th>
                              <th>Gudang</th>
                              <th>Tanggal Bayar</th>
                              <th>Penyetor</th>
                              <th>Status Pembayaran</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php

                        $total_penjualan = 0;
                        $total_pembayaran = 0;
                        $total_piutang= 0;
                        $total_selisih_harga = 0;
                        $total_omset = 0;
                        $total_hpp = 0;

                        foreach ($pembayaran as $value):
                        if (isset($status_pembayaran)){
                          if ($status_pembayaran == "Tempo"){ ?>
                            <?php if(!isset($bayar[$value->no_kwitansi]['status_pembayaran'])){
                            if (array_key_exists($value->no_kwitansi, $barang) ) {
                              //if (isset($from) && $bayar[$value->no_kwitansi]['tanggal_bayar'] > $from && $bayar[$value->no_kwitansi]['tanggal_bayar'] < $to) {
                              $total_penjualan += 0;
                              $total_selisih_harga += $barang[$value->no_kwitansi]['selisih'];
                              $total_omset += $barang[$value->no_kwitansi]['omset'] - $value->potongan;
                              $total_hpp += $barang[$value->no_kwitansi]['hpp'];
                            ?>
                            <tr
                              <?php if(array_key_exists($value->no_kwitansi, $bayar) && $bayar[$value->no_kwitansi]['status_pembayaran'] == "Lunas"){
                                echo "style='background:#c1ffcb'";
                              } ?>
                            >
                            <td>{{$value->no_kwitansi}}</td>
                            <td><?php
                                if(isset($konsumen[$value->id_konsumen]['nama'])) {
                                    echo $konsumen[$value->id_konsumen]['nama'];
                                }else{
                                    echo $karyawan2[$value->id_konsumen]['nama'];
                                } ?>

                            </td>
                            <td><?php
                                if(isset($konsumen[$value->id_konsumen]['alamat'])) {
                                    echo $konsumen[$value->id_konsumen]['alamat'];
                                }else{
                                    echo $karyawan2[$value->id_konsumen]['alamat'];
                                }
                            ?></td>
                            <td align="right"><?php echo ribuan($barang[$value->no_kwitansi]['omset']); ?></td>
                            <td align="right"><?php echo ribuan($value->potongan); ?></td>
                            <td align="right"><?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                              echo rupiah($bayar[$value->no_kwitansi]['bayar']);
                              $total_pembayaran += $bayar[$value->no_kwitansi]['bayar'];

                              if (isset($bayar[$value->no_kwitansi]['bayar'])) {
                                $piutang = $barang[$value->no_kwitansi]['omset'] - $bayar[$value->no_kwitansi]['bayar'];
                              }else{
                                $piutang = $barang[$value->no_kwitansi]['omset'];
                              }

                              $total_piutang += $piutang;
                            }else{
                              echo "0";
                              if (isset($bayar[$value->no_kwitansi]['bayar'])) {
                                $piutang = $barang[$value->no_kwitansi]['omset'] - $bayar[$value->no_kwitansi]['bayar'];
                              }else{
                                $piutang = $barang[$value->no_kwitansi]['omset'];
                              }
                              $total_piutang += $piutang;
                            } ?></td>

                            <td align="right"><?php if ($piutang<0) {
                              echo rupiah($piutang);
                            }else{
                              echo rupiah($piutang);
                            } ?></td>

                            <td align="left">{{$karyawan[$value->kasir]}}</td>
                            <td align="left"><?php if (isset($karyawan[$value->petugas1])): ?>{{$karyawan[$value->petugas1]}}<?php endif; ?></td>
                            <td align="left"><?php if (isset($karyawan[$value->petugas2])): ?>{{$karyawan[$value->petugas2]}}<?php endif; ?></td>
                            <td align="left"><?php if (isset($karyawan[$value->petugas3])): ?>{{$karyawan[$value->petugas3]}}<?php endif; ?></td>
                            <td>{{$karyawan[$value->leader]}}</td>
                            <td><?php if (isset($karyawan[$value->manager])): ?>{{$karyawan[$value->manager]}}<?php endif; ?></td>
                            <td align="right">{{$text_gudang[$value->gudang]}}</td>
                            <td align="right">
                              <?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                              echo tanggal($bayar[$value->no_kwitansi]['tanggal_bayar']);
                              }?>
                            </td>
                            <td align="left">
                              <?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                              echo $bayar[$value->no_kwitansi]['penyetor'];
                              }?>
                            </td>
                            <td align="left">
                              <?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                              echo $bayar[$value->no_kwitansi]['status_pembayaran'];
                              }?>
                            </td>
                            </tr>
                          <?php } } }else{

                            if(isset($bayar[$value->no_kwitansi]) && $status_pembayaran == $bayar[$value->no_kwitansi]['status_pembayaran']){
                            if (array_key_exists($value->no_kwitansi, $barang)) {
                              //if (isset($from) && $bayar[$value->no_kwitansi]['tanggal_bayar'] > $from && $bayar[$value->no_kwitansi]['tanggal_bayar'] < $to) {
                              $total_penjualan += $barang[$value->no_kwitansi]['omset'] - $value->potongan;
                              $total_selisih_harga += $barang[$value->no_kwitansi]['selisih'];
                              $total_hpp += $barang[$value->no_kwitansi]['hpp'];
                              $total_omset += $barang[$value->no_kwitansi]['omset'] - $value->potongan;
                            ?>
                            <tr
                              <?php if(array_key_exists($value->no_kwitansi, $bayar) && $bayar[$value->no_kwitansi]['status_pembayaran'] == "Lunas"){
                                echo "style='background:#c1ffcb'";
                              } ?>
                            >
                              <td>{{$value->no_kwitansi}}</td>
                              <td><?php
                                  if(isset($konsumen[$value->id_konsumen]['nama'])) {
                                      echo $konsumen[$value->id_konsumen]['nama'];
                                  }else{
                                      echo $karyawan2[$value->id_konsumen]['nama'];
                                  } ?>

                              </td>
                              <td><?php
                                  if(isset($konsumen[$value->id_konsumen]['alamat'])) {
                                      echo $konsumen[$value->id_konsumen]['alamat'];
                                  }else{
                                      echo $karyawan2[$value->id_konsumen]['alamat'];
                                  }
                              ?></td>
                              <td align="right"><?php echo ribuan($barang[$value->no_kwitansi]['omset']); ?></td>
                              <td align="right"><?php echo ribuan($value->potongan); ?></td>
                              <td align="right"><?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                                echo rupiah($bayar[$value->no_kwitansi]['bayar']);
                                $total_pembayaran += $bayar[$value->no_kwitansi]['bayar'];
                                $piutang = 0;
                                $total_piutang += $piutang;
                              }else{
                                echo "0";
                                $piutang = $value->total_bayar;
                                $total_piutang += $piutang;
                              } ?></td>

                              <td align="right"><?php if ($piutang<0) {
                                echo rupiah($piutang);
                              }else{
                                echo rupiah($piutang);
                              } ?></td>

                              <td align="left">{{$karyawan[$value->kasir]}}</td>
                              <td align="left"><?php if (isset($karyawan[$value->petugas1])): ?>{{$karyawan[$value->petugas1]}}<?php endif; ?></td>
                              <td align="left"><?php if (isset($karyawan[$value->petugas2])): ?>{{$karyawan[$value->petugas2]}}<?php endif; ?></td>
                              <td align="left"><?php if (isset($karyawan[$value->petugas3])): ?>{{$karyawan[$value->petugas3]}}<?php endif; ?></td>
                              <td>{{$karyawan[$value->leader]}}</td>
                              <td><?php if (isset($karyawan[$value->manager])): ?>{{$karyawan[$value->manager]}}<?php endif; ?></td>
                              <td align="right">{{$text_gudang[$value->gudang]}}</td>
                              <td align="right">
                                <?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                                echo tanggal($bayar[$value->no_kwitansi]['tanggal_bayar']);
                                }?>
                              </td>
                              <td align="left">
                                <?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                                echo $bayar[$value->no_kwitansi]['penyetor'];
                                }?>
                              </td>
                              <td align="left">
                                <?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                                echo $bayar[$value->no_kwitansi]['status_pembayaran'];
                                }?>
                              </td>
                            </tr>
                        <?php } } } }else{ ?>




                          <tr
                            <?php if(array_key_exists($value->no_kwitansi, $bayar) && $bayar[$value->no_kwitansi]['status_pembayaran'] == "Lunas"){
                              echo "style='background:#c1ffcb'";
                            } ?>
                          >
                          <td>{{$value->no_kwitansi}}</td>
                          <td><?php
                              if(isset($konsumen[$value->id_konsumen]['nama'])) {
                                  echo $konsumen[$value->id_konsumen]['nama'];
                              }else{
                                  echo $karyawan2[$value->id_konsumen]['nama'];
                              } ?>

                          </td>
                          <td><?php
                              if(isset($konsumen[$value->id_konsumen]['alamat'])) {
                                  echo $konsumen[$value->id_konsumen]['alamat'];
                              }else{
                                  echo $karyawan2[$value->id_konsumen]['alamat'];
                              }
                          ?></td>
                          <td align="right"><?php echo ribuan($barang[$value->no_kwitansi]['omset']); ?></td>

                          <td align="right"><?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                            echo rupiah($bayar[$value->no_kwitansi]['bayar']);
                            $total_pembayaran += $bayar[$value->no_kwitansi]['bayar'];

                            if (isset($bayar[$value->no_kwitansi]['bayar'])) {
                              $piutang = $barang[$value->no_kwitansi]['omset'] - $bayar[$value->no_kwitansi]['bayar'];
                            }else{
                              $piutang = $barang[$value->no_kwitansi]['omset'];
                            }

                            $total_piutang += $piutang;
                          }else{
                            echo "0";
                            if (isset($bayar[$value->no_kwitansi]['bayar'])) {
                              $piutang = $barang[$value->no_kwitansi]['omset'] - $bayar[$value->no_kwitansi]['bayar'];
                            }else{
                              $piutang = $barang[$value->no_kwitansi]['omset'];
                            }
                            $total_piutang += $piutang;
                          } ?></td>

                          <td align="right"><?php if ($piutang<0) {
                            echo rupiah($piutang);
                          }else{
                            echo rupiah($piutang);
                          } ?></td>

                          <td align="left">{{$karyawan[$value->kasir]}}</td>
                          <td align="left"><?php if (isset($karyawan[$value->petugas1])): ?>{{$karyawan[$value->petugas1]}}<?php endif; ?></td>
                          <td align="left"><?php if (isset($karyawan[$value->petugas2])): ?>{{$karyawan[$value->petugas2]}}<?php endif; ?></td>
                          <td align="left"><?php if (isset($karyawan[$value->petugas3])): ?>{{$karyawan[$value->petugas3]}}<?php endif; ?></td>
                          <td>{{$karyawan[$value->leader]}}</td>
                          <td><?php if (isset($karyawan[$value->manager])): ?>{{$karyawan[$value->manager]}}<?php endif; ?></td>
                          <td align="right">{{$text_gudang[$value->gudang]}}</td>
                          <td align="right">
                            <?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                            echo tanggal($bayar[$value->no_kwitansi]['tanggal_bayar']);
                            }?>
                          </td>
                          <td align="left">
                            <?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                            echo $bayar[$value->no_kwitansi]['penyetor'];
                            }?>
                          </td>
                          <td align="left">
                            <?php if (array_key_exists($value->no_kwitansi, $bayar)) {
                            echo $bayar[$value->no_kwitansi]['status_pembayaran'];
                            }?>
                          </td>
                          </tr>




                        <?php } endforeach; ?>
                      </tbody>
                  </table>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-3">
                      Total Penjualan : <br>{{rupiah($total_penjualan)}}
                    </div>
                    <div class="col-md-3">
                      Total Pembayaran : <br>{{rupiah($total_pembayaran)}}
                    </div>
                    <div class="col-md-3">
                      Total Sisa Piutang : <br>{{rupiah($total_piutang)}}
                    </div>
                    <div hidden class="col-md-3">
                      Total Omset : <br>{{rupiah($total_omset)}}
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="jabatan" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="exam" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIK</th>
                        <th>Nama</th>
                    </tr>
                  </thead>
                  <tbody>
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

    <script>
    $(document).ready(function() {
        var table = $('#exam').DataTable();
        $('#exam tbody').on('click', 'tr', function () {
            var data = table.row( this ).data();
            pilihpetugas(data[0],data[2]);
        } );
    } );
    function carijabatan(){
      var value = document.getElementById("petugas").value;

        $.ajax({
           url: 'getHuman/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             var table = $('#exam').DataTable();
             table.clear().draw();
             for (var i = 0; i < response.length; i++) {
               if (value == "admin_p" || value == "admin_g" || value == "admin_v") {
                 var id = response[i]['id'];
                 var nama = response[i]['name'];
                 table.row.add( [
                   response[i]['id'],
                   response[i]['nik'],
                   response[i]['name']
                   //'<button class="btn btn-success" onclick="pilihpetugas('+id+','+"'"+nama+"'"+')">Pilih</button>'
                 ] ).draw( false );
               }else{
                 var id = response[i]['id'];
                 var nama = response[i]['nama'];
                 table.row.add( [
                   response[i]['id'],
                   response[i]['nik'],
                   response[i]['nama']
                   //'<button class="btn btn-success" onclick="pilihpetugas('+id+','+"'"+nama+"'"+')">Pilih</button>'
                 ] ).draw( false );
               }
             }
             $('#jabatan').modal('show');
           }
         });
    }
    function pilihpetugas(id,nama){
      $('#jabatan').modal('hide');
      document.getElementById("name").value = nama;
      document.getElementById("id").value = id;
    }

    function Reload(bulan){
      location.href="{{url('/datapembayaranjasa/')}}"+"/"+bulan;
    }

    </script>

@endsection
