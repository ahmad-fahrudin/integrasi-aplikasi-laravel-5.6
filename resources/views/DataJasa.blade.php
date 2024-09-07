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
                              <li class="breadcrumb-item text-muted" aria-current="page">Layanan Jasa > <a href="https://stokis.app/?s=data+penjualan+layanan+jasa" target="_blank">Data Penjualan Jasa</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <form action="{{url('datapenjualanjasa')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                      <div class="row">
                      <div class="col-lg-6">
                       <div class="row">
                           <label class="col-lg-3">Tanggal Proses</label>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input type="date" name="from"
                                         <?php if (isset($from)): ?>
                                           value="{{$from}}"
                                         <?php endif; ?>
                                       class="form-control">
                                   </div>
                               </div>
                           </div>
                           <label class="col-lg-1">s/d</label>
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
                           <label class="col-lg-3">Cabang</label>
                           <div class="col-lg-4">
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

                     <div class="col-lg-6">

                       <div class="row">
                           <label class="col-lg-3">Nama Konsumen</label>
                           <div class="col-lg-9">
                             <div class="row">
                                 <div class="col-md-11">
                                   <div class="input-group">
                                     <input id="name_konsumen" name="name_konsumen"
                                     <?php if (isset($name_konsumen)): ?>
                                       value="{{$name_konsumen}}"
                                     <?php endif; ?>
                                     type="text" class="form-control" placeholder="Pilih Konsumen">
                                     <input id="id_konsumen"
                                     <?php if (isset($id_konsumen)): ?>
                                       value="{{$id_konsumen}}"
                                     <?php endif; ?>
                                     name="id_konsumen" type="hidden" class="form-control">
                                     <div class="input-group-append">
                                         <button class="btn btn-outline-secondary" onclick="carikonsumen()" type="button"><i class="fas fa-folder-open"></i></button>
                                     </div>
                                   </div>
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
                                      <input id="name"  type="text"
                                        <?php if (isset($id)): ?>
                                          value="{{$karyawan[$id]['nama']}}"
                                        <?php endif; ?>
                                      class="form-control" placeholder="Pilih Petugas">
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
                    <br><center><button class="btn btn-lg btn-success">Filter Data</button></center>
                    </div>
                  </form>
                  </div>
                  <hr>

                <br>

				  <div class="table-responsive">
                  <table id="dop" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Kwitansi Jasa</th>
                              <th>Tanggal</th>
                              <th>Nama Konsumen</th>
                              <th>Alamat</th>
                              <th>Kode Jasa</th>
                              <th>Layanan Jasa</th>
                              <th>Jumlah</th>
                              <th>Biaya Jasa</th>
                              <th>Potongan</th>
                              <th>Petugas 1</th>
                              <th>Petugas 2</th>
                              <th>Petugas 3</th>
                              <th>Pengembang</th>
                              <th>Leader</th>
                              <th>Manager</th>
                              <th>Admin Kasir</th>
                              <th>Admin Keuangan</th>
                              <th>Cabang</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $key => $value): ?>
                          <tr>
                            <td>{{$value->no_kwitansi}}</td>
                            <td>{{$value->tanggal_transaksi}}</td>
                            <td>{{$konsumen[$value->id_konsumen]['nama']}}</td>
                            <td><?=$konsumen[$value->id_konsumen]['alamat']?></td>
                            <td>{{$value->id_jasa}}</td>
                            <td>{{$barang[$value->id_jasa]['nama_jasa']}}</td>
                            <td>{{$value->jumlah}}</td>
                            <td>{{ribuan($value->biaya)}}</td>
                            <td>{{ribuan(($value->potongan/$data_kwitansi[$value->no_kwitansi])*$value->jumlah)}}</td>
                            <td>{{$karyawan[$value->petugas1]['nama']}}</td>
                            <td><?php if (isset($karyawan[$value->petugas2])): ?>
                              {{$karyawan[$value->petugas2]['nama']}}
                            <?php endif; ?></td>
                            <td><?php if (isset($karyawan[$value->petugas3])): ?>
                              {{$karyawan[$value->petugas3]['nama']}}
                            <?php endif; ?></td>
                            <td>{{$karyawan[$value->pengembang]['nama']}}</td>
                            <td>{{$karyawan[$value->leader]['nama']}}</td>
                            <td>
                              <?php if (isset($karyawan[$value->manager])): ?>
                                {{$karyawan[$value->manager]['nama']}}
                              <?php endif; ?>
                            </td>
                            <td>{{$karyawan[$value->kasir]['nama']}}</td>
                            <td><?php if (isset($admin[$value->admin_k])): ?>{{$admin[$value->admin_k]}}<?php endif; ?></td>
                            <td>{{$text_gudang[$value->gudang]}}</td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                  </table>
								</div>
                <br><br>
                <h4>&nbsp;&nbsp;&nbsp;Cetak Ulang Kwitansi</h4>
                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-lg-6">
                      <input type="text" id="no_kwitansi" class="form-control">
                    </div>
                    <div class="col-lg-6">
                      <button class="btn btn-warning btn-sm" onclick="kwitansi()">Cetak</button>
                    </div>
                  </div>
                </div>
                <br><br>
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

      <div class="modal fade" id="konsumen" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                      <tr>
                          <th>Nama</th>
                          <th>Alamat</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($konsumen as $key => $value): ?>
                        <tr onclick="pilihkonsumen('{{$value['id_konsumen']}}','{{$value['nama']}}')">
                          <td>{{$value['nama']}}</td>
                          <td><?=$value['alamat']?></td>
                        </tr>
                      <?php endforeach; ?>
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
      var cek = true;
      var data_id = [];
      $(document).ready(function() {
          var table = $('#exam').DataTable();
          $('#exam tbody').on('click', 'tr', function () {
              var data = table.row( this ).data();
              pilihpetugas(data[0],data[2]);
          } );
      } );

      function carikonsumen(){
        $('#konsumen').modal('show');
      }

      function carijabatan(){

          $.ajax({
             url: 'getHumans',
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){

               var table = $('#exam').DataTable();
               table.clear().draw();
               data_id = [];
               for (var i = 0; i < response.length; i++) {

                 data_id[response[i]['nik']] = response[i]['id'];
                   var id = response[i]['id'];
                   var nama = response[i]['nama'];
                   table.row.add( [
                     response[i]['id'],
                     response[i]['nik'],
                     response[i]['nama']
                   ] ).draw( false );

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

      function pilihkonsumen(id,nama){
        $('#konsumen').modal('hide');
        document.getElementById("name_konsumen").value = nama;
        document.getElementById("id_konsumen").value = id;
      }

      function Reload(bulan){
        location.href="{{url('/dataorderpenjualan/')}}"+"/"+bulan;
      }

      function kwitansi() {
        var no_kwitansi = document.getElementById("no_kwitansi").value;
        window.open("{{url('/cetaknotajasa/')}}"+'/'+no_kwitansi);
      }
      </script>

@endsection
