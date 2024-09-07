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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Laporan Harian / Trip > <a href="https://stokis.app/?s=input+insentif+trip+jasa" target="_blank">Simpan Laporan Jasa</a></li>
                          </ol>
                      </nav>
                    </h4>
                    
                    <div class="form-group">
                       <form name="form1" action="{{url('perhitunganinsentifjasa')}}" method="post" enctype="multipart/form-data">
                         {{csrf_field()}}
                       <div class="row">
                           <label class="col-lg-1">No. Trip Jasa</label>
                           <div class="col-lg-3">
                               <div class="row">
                                     <div class="col-lg-12">
                                         <div class="row">
                                             <div class="col-md-12">
                                               <div class="input-group">
                                                 <input id="no_trip"  name="no_trips" type="text" class="form-control" placeholder="Pilih No. Trip Jasa"
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

                       <?php if (isset($input)): ?>
                         <input type="hidden" name="cek" value="{{$input}}">
                       <?php endif; ?>

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
                            <th>No. Kwitansi Jasa</th>
                            <th>Tanggal Transaksi</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Cabang</th>
                            <th>Kode</th>
                            <th>Layanan Jasa</th>
                            <th>Jumlah</th>
                            <th>Biaya</th>
                            <th>Potongan</th>
                            <th>Sub Biaya</th>
                            <th>Petugas 1</th>
                            <th>Petugas 2</th>
                            <th>Petugas 3</th>
                            <th>Kasir</th>
                            <th>Pengembang</th>
                            <th>Leader</th>
                            <th>Manager</th>
                            <th>Admin(K)</th>
                            <th>Poin</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        $poin_konsumen = "";
                        $poin_idkonsumen = "";
                        $ptgs = array();
                        $jmlins = 0;
                        $omset = 0;
                        $bagihasilstokis = 0;
                        $perusahaan = 0;
                        if (isset($data)):
                          foreach ($data as $key => $value):
                            $tot_insentif = persenfee()[2]->itung_a/100 * ($value->sub_biaya - ($value->potongan/$jml_potongan[$value->no_kwitansi]));

                            if ($value->petugas1 > 0 && !in_array($value->petugas1,$ptgs)) {
                              array_push($ptgs,$value->petugas1);
                            }
                            if ($value->petugas2 > 0 && !in_array($value->petugas2,$ptgs)) {
                              array_push($ptgs,$value->petugas2);
                            }
                            if ($value->petugas3 > 0 && !in_array($value->petugas3,$ptgs)) {
                              array_push($ptgs,$value->petugas3);
                            }

                            if ($value->pengembang > 0 && !in_array($value->pengembang,$ptgs)) {
                              array_push($ptgs,$value->pengembang);
                            }
                            if ($value->leader > 0 && !in_array($value->leader,$ptgs)) {
                              array_push($ptgs,$value->leader);
                            }
                            if ($value->manager > 0 && !in_array($value->manager,$ptgs)) {
                              array_push($ptgs,$value->manager);
                            }
                            if ($value->kasir > 0 && !in_array($value->kasir,$ptgs)) {
                              array_push($ptgs,$value->kasir);
                            }
                            if ($value->admin_k > 0 && !in_array($value->admin_k,$ptgs)) {
                              array_push($ptgs,$value->admin_k);
                            }

                            if ($value->petugas1 > 0 && $value->petugas2 > 0 && $value->petugas3 > 0) {

                              if (isset($petugas1[$value->petugas1])) {
                                $petugas1[$value->petugas1] += persenfee()[2]->petugas1c/100 * $tot_insentif;
                              }else{
                                $petugas1[$value->petugas1] = persenfee()[2]->petugas1c/100 * $tot_insentif;
                              }
                              if (isset($petugas2[$value->petugas2])) {
                                $petugas2[$value->petugas2] += persenfee()[2]->petugas2c/100 * $tot_insentif;
                              }else{
                                $petugas2[$value->petugas2] = persenfee()[2]->petugas2c/100 * $tot_insentif;
                              }
                              if (isset($petugas3[$value->petugas3])) {
                                $petugas3[$value->petugas3] += persenfee()[2]->petugas3c/100 * $tot_insentif;
                              }else{
                                $petugas3[$value->petugas3] = persenfee()[2]->petugas3c/100 * $tot_insentif;
                              }

                            } else if ($value->petugas1 > 0 && $value->petugas2 > 0) {

                              if (isset($petugas1[$value->petugas1])) {
                                $petugas1[$value->petugas1] += persenfee()[2]->petugas1b/100 * $tot_insentif;
                              }else{
                                $petugas1[$value->petugas1] = persenfee()[2]->petugas1b/100 * $tot_insentif;
                              }
                              if (isset($petugas2[$value->petugas2])) {
                                $petugas2[$value->petugas2] += persenfee()[2]->petugas2b/100 * $tot_insentif;
                              }else{
                                $petugas2[$value->petugas2] = persenfee()[2]->petugas2b/100 * $tot_insentif;
                              }

                            } else if ($value->petugas1 > 0) {

                              if (isset($petugas1[$value->petugas1])) {
                                $petugas1[$value->petugas1] += persenfee()[2]->petugas1a/100 * $tot_insentif;
                              }else{
                                $petugas1[$value->petugas1] = persenfee()[2]->petugas1a/100 * $tot_insentif;
                              }

                            }

                            if (isset($pengembang[$value->pengembang])) {
                              $pengembang[$value->pengembang] += persenfee()[2]->pengembang/100 * $tot_insentif;
                            }else{
                              $pengembang[$value->pengembang]= persenfee()[2]->pengembang/100 * $tot_insentif;
                            }

                            if (isset($leader[$value->leader])) {
                              $leader[$value->leader] += persenfee()[2]->leader/100 * $tot_insentif;
                            }else{
                              $leader[$value->leader]= persenfee()[2]->leader/100 * $tot_insentif;
                            }

                            if (isset($manager[$value->manager])) {
                              $manager[$value->manager] += persenfee()[2]->manager/100 * $tot_insentif;
                            }else{
                              $manager[$value->manager]= persenfee()[2]->manager/100 * $tot_insentif;
                            }

                            if (isset($kasir[$value->kasir])) {
                              $kasir[$value->kasir] += persenfee()[2]->sales/100 * $tot_insentif;
                            }else{
                              $kasir[$value->kasir]= persenfee()[2]->sales/100 * $tot_insentif;
                            }
                            if ($value->admin_k > 0) {
                              if (isset($admin_k[$value->admin_k])) {
                                $admin_k[$value->admin_k] += persenfee()[2]->admin_k/100 * $tot_insentif;
                              }else{
                                $admin_k[$value->admin_k]= persenfee()[2]->admin_k/100 * $tot_insentif;
                              }
                            if($jasa[$value->id_jasa]['poin'] > 0){
                              $tmpp = $jasa[$value->id_jasa]['poin'] * $value->jumlah;
                              $poin_konsumen .= $tmpp.",";
                              $poin_idkonsumen .= $value->id_konsumen.",";
                              }
                            }
                            $jmlins += ($value->sub_biaya - ($value->potongan/$jml_potongan[$value->no_kwitansi]));
                            $omset += $value->sub_biaya - ($value->potongan/$jml_potongan[$value->no_kwitansi]);
                            $bagihasilstokis += persenfee()[2]->stokis/100 * $jmlins;
                            $perusahaan += persenfee()[2]->itung_b/100 * $jmlins;
                            
                            ?>
                            <tr>
                              <td>{{$value->no_kwitansi}}</td>
                              <td>{{$value->tanggal_transaksi}}</td>
                              <td>{{$konsumen[$value->id_konsumen]['nama']}}</td>
                              <td><?=$konsumen[$value->id_konsumen]['alamat']?></td>
                              <td>{{$gudang[$value->gudang]['nama_gudang']}}</td>
                              <td>{{$jasa[$value->id_jasa]['kode']}}</td>
                              <td>{{$jasa[$value->id_jasa]['nama_jasa']}}</td>
                              <td>{{$value->jumlah}}</td>
                              <td align="right">{{ribuan($value->biaya)}}</td>
                              <td align="right">{{$value->potongan/$jml_potongan[$value->no_kwitansi]}}</td>
                              <td align="right">{{ribuan($value->sub_biaya - ($value->potongan/$jml_potongan[$value->no_kwitansi]))}}</td>
                              <td>{{$karyawan[$value->petugas1]['nama']}}</td>
                              <td><?php if (isset($karyawan[$value->petugas2])): ?>
                                {{$karyawan[$value->petugas2]['nama']}}
                              <?php endif; ?></td>
                              <td><?php if (isset($karyawan[$value->petugas3])): ?>
                                {{$karyawan[$value->petugas3]['nama']}}
                              <?php endif; ?></td>
                              <td>{{$karyawan[$value->kasir]['nama']}} </td>
                              <td>{{$karyawan[$value->pengembang]['nama']}}</td>
                              <td>{{$karyawan[$value->leader]['nama']}}</td>
                              <td>
                                <?php if (isset($karyawan[$value->manager])): ?>
                                  {{$karyawan[$value->manager]['nama']}}
                                <?php endif; ?>
                              </td>
                              <td><?php if (isset($admin[$value->admin_k])){ echo $admin[$value->admin_k]; }?></td>
                              <td>{{($jasa[$value->id_jasa]['poin'])*$value->jumlah}}</td>
                            </tr>


                          <?php endforeach; ?>
                        <?php endif;?>
                      </tbody>
                  </table>
								</div>
                <br><br><br>
                <div class="table-responsive">
                <table  class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Petugas</th>
                          <th>Petugas 1</th>
                          <th>Petugas 2</th>
                          <th>Petugas 3</th>
                          <th>Kasir</th>
                          <th>Pengembang</th>
                          <th>Leader</th>
                          <th>Manager</th>
                          <th>Admin K</th>
                          <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $totins=0;  $no=1; foreach ($ptgs as $key => $value){ $jml=0;?>
                        <tr>
                          <td>{{$no}}</td>
                          <p id="id_petugas{{$no}}" hidden>{{$value}}</p>
                          <td id="karyawan{{$no}}">{{$karyawan[$value]['nama']}}</td>
                          <td align="right"><?php if (isset($petugas1[$value])){ echo ribuan($petugas1[$value]); $jml+=$petugas1[$value]; }else{echo 0;} ?></td>
                          <td align="right"><?php if (isset($petugas2[$value])){ echo ribuan($petugas2[$value]); $jml+=$petugas2[$value];}else{echo 0;} ?></td>
                          <td align="right"><?php if (isset($petugas3[$value])){ echo ribuan($petugas3[$value]); $jml+=$petugas3[$value];}else{echo 0;} ?></td>
                          <td align="right"><?php if (isset($kasir[$value])){ echo ribuan($kasir[$value]); $jml+=$kasir[$value];}else{echo 0;} ?></td>
                          <td align="right"><?php if (isset($pengembang[$value])){ echo ribuan($pengembang[$value]); $jml+=$pengembang[$value];}else{echo 0;} ?></td>
                          <td align="right"><?php if (isset($leader[$value])){ echo ribuan($leader[$value]); $jml+=$leader[$value];}else{echo 0;} ?></td>
                          <td align="right"><?php if (isset($manager[$value])){ echo ribuan($manager[$value]); $jml+=$manager[$value];}else{echo 0;} ?></td>
                          <td align="right"><?php if (isset($admin_k[$value])){ echo ribuan($admin_k[$value]); $jml+=$admin_k[$value];}else{echo 0;} ?></td>
                          <td align="right" id="insentif{{$no}}"><?=ribuan($jml)?></td>
                        </tr>
                      <?php $totins+=$jml; $no++;} ?>
                    </tbody>
                </table>
                <table align="right" class="col-md-3">
                  
                  <tr>
                    <td style="padding:5px;">TOTAL INSENTIF</td>
                    <td align="right">{{ribuan($totins)}}</td>
                  <tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                  <td style="padding:5px;">Bagi Hasil Stokis (in)</td>
                  <td align="right">{{ribuan($bagihasilstokis)}}</td>
                  </tr>
                  <tr>
                  <td style="padding:5px;">Sisa selisih jasa</td>
                  <td align="right">{{ribuan(($jmlins-$totins)-$bagihasilstokis)}}</td>
                  </tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                    <td style="padding:5px;">PENDAPATAN KOTOR</td>
                    <td align="right" id="labarugi">
                    {{ribuan($jmlins-$totins)}}
                    </td>
                  <tr>
                  <tr>
                    <td style="padding:5px;">Bagi Hasil Stokis (out)</td>
                    <td align="right" id="bagihasilstokis">
                        0
                    </td>
                  </tr>
                </table>
              </div>


              <br><br><br>
              <div class="col-md-12">
                <center>
                  <?php if (isset($cek)){ ?>
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
                          <th>No. Trip Jasa</th>
                          <th>Tanggal</th>
                          <th>Cabang</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($insentif as $value){
                      if ($value->no_trip != ""){
                        if(isset($input)){?>
                          <tr onclick="pilihtrip('{{$value->id}}','{{$value->no_trip}}','{{$value->tanggal_input}}',
                                                 '{{$gudang[$value->id_gudang]['nama_gudang']}}'
                                                 ,'{{$value->id_gudang}}')">
                              <td>{{$value->no_trip}}</td>
                              <td>{{$value->tanggal_input}}</td>
                              <td>{{$gudang[$value->id_gudang]['nama_gudang']}}</td>
                          </tr>
                      <?php
                          }else{ ?>
                            <tr onclick="pilihtrip('{{$value->id}}','{{$value->no_trip}}','{{$value->tanggal_input}}',
                                                   '{{$gudang[$value->id_gudang]['nama_gudang']}}'
                                                   ,'{{$value->id_gudang}}')">
                                <td>{{$value->no_trip}}</td>
                                <td>{{$value->tanggal_input}}</td>
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
      function pilihtrip(id,no_trip,tanggal,nama_gudang,id_gudang){
        document.getElementById("id_trip").value = id;
        document.getElementById("no_trip").value = no_trip;
        document.getElementById("tanggal_input").value = tanggal;
        document.getElementById("id_gudang").value = nama_gudang;
        document.getElementById("filter").disabled = false;
        $('#trip').modal('hide');
      }

      function Cetak(){
        var no_trips = document.getElementById("no_trip").value;

        window.open("{{url('/cetakinsentifpenjualanjasa')}}"+"/"+no_trips);

      }



      function Simpan(){
        var no_trip = document.getElementById("no_trip").value;
        var petugas="";
        var id_petugas="";
        var insentif="";
        var labarugi = document.getElementById("labarugi").innerHTML;
        var id_gudang = document.getElementById("id_gudang").value;
        var gudang_insentif = "";
        var bagihasilstokis = document.getElementById("bagihasilstokis").innerHTML;

        for (var i = 1; i < {{$no}}; i++) {
          petugas += document.getElementById("karyawan"+i).innerHTML +",";
        }
        for (var i = 1; i < {{$no}}; i++) {
          insentif += document.getElementById("insentif"+i).innerHTML +",";
        }
        for (var i = 1; i < {{$no}}; i++) {
          id_petugas += document.getElementById("id_petugas"+i).innerHTML +",";
        }
        
        var omset = {{$omset}};
        
        var nama_konsumen = "{{$poin_idkonsumen}}";
        var poin_konsumen = "{{$poin_konsumen}}";
        
        Swal.fire(
          'Simpan Insentif ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            document.getElementById("save").disabled = true;
            $.post("{{url('simpaninsentifjasa')}}",
              {nama_konsumen:nama_konsumen,poin_konsumen:poin_konsumen,omset:omset,id_gudang:id_gudang,labarugi:labarugi,no_trip:no_trip,petugas:petugas,gudang_insentif:gudang_insentif,bagihasilstokis:bagihasilstokis,insentif:insentif, id_petugas:id_petugas, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                  {
                      Swal.fire({
                          title: 'Berhasil',
                          icon: 'success',
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Lanjutkan!'
                        }).then((result) => {
                          Cetak();
                          location.href="{{url('/inputtripinsentifjasa/')}}";
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