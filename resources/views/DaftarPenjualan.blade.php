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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Piutang > Penjualan Produk > <a href="https://stokis.app/?s=daftar+piutang+penjualan" target="_blank">Daftar Piutang</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <form action="{{url('daftarpenjualan')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                      <div class="row">
                       <div class="col-lg-6">
                         <div class="row">
                           <label class="col-lg-3">Tanggal Kirim</label>
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
                                   <div class="col-md-10">
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
                           <div class="col-lg-9">
                               <div class="row">
                                   <div class="col-md-11">
                                     <select name="id_gudang" class="form-control">
                                       <?php foreach ($gudang as $value): ?>
                                         <option value="{{$value->id}}"
                                           <?php if (isset($id_gudang)): ?>
                                             <?php if ($id_gudang == $value->id): ?>
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
                         <br>
                         <div class="row">
                           <label class="col-lg-3">Tempo lebih dari</label>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-9">
                                       <input type="number" name="tempo"
                                         <?php if (isset($tempo)): ?>
                                           value="{{$tempo}}"
                                         <?php endif; ?>
                                       class="form-control" placeholder="0">
                                   </div>
                               </div>
                           </div>
                           <label class="col-lg-2">hari</label>
                         </div>
                       </div>
                       <div class="col-lg-6">
                         <div class="row">
                           <label class="col-lg-3">Jabatan Petugas</label>
                           <div class="col-lg-9">
                               <div class="row">
                                   <div class="col-md-11">
                                     <select name="petugas" id="petugas" class="form-control">
                                         <option value="sales"
                                           <?php if (isset($petugas) && $petugas == "sales"): ?>
                                             selected
                                           <?php endif; ?>
                                         >Sales</option>
                                         <option value="admin_p"
                                           <?php if (isset($petugas) && $petugas == "admin_p"): ?>
                                             selected
                                           <?php endif; ?>
                                         >Admin(P)</option>
                                         <option value="admin_g"
                                           <?php if (isset($petugas) && $petugas == "admin_g"): ?>
                                             selected
                                           <?php endif; ?>
                                         >Admin(G)</option>
                                         <option value="admin_v"
                                           <?php if (isset($petugas) && $petugas == "admin_v"): ?>
                                             selected
                                           <?php endif; ?>
                                         >Admin(V)</option>
                                         <option value="dropper"
                                           <?php if (isset($petugas) && $petugas == "dropper"): ?>
                                             selected
                                           <?php endif; ?>
                                         >Dropper</option>
                                         <option value="pengirim"
                                           <?php if (isset($petugas) && $petugas == "pengirim"): ?>
                                             selected
                                           <?php endif; ?>
                                         >Pengirim</option>
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
                                       <input id="name"  type="text"
                                       <?php if (isset($id) && ($petugas == "sales" || $petugas == "dropper" || $petugas == "pengirim")){ ?>
                                         value="{{$karyawan[$id]}}"
                                       <?php }else if(isset($id) && ($petugas == "admin_p" || $petugas == "admin_g" || $petugas == "admin_v")){ ?>
                                         value="{{$admin[$id]}}"
                                       <?php } ?>
                                       class="form-control" placeholder="Pilih Petugas" readonly style="background-color:#fff">
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
                  <hr><br>
									<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Kwitansi</th>
                              <th>Tempo</th>
                              <th>Nama</th>
                              <th>Alamat</th>
                              <th>No. HP</th>
                              <th>Sales</th>
                              <th hidden>Admin (P)</th>
                              <th>Admin (G)</th>
                              <th>Admin (V)</th>
                              <th hidden>Dropper</th>
                              <th>Pengirim</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($penjualan as $value) {
                          if (!array_key_exists($value->no_kwitansi,$pembayaran)) {
                          $a = new DateTime(date("Y-m-d"));
                          $b = new DateTime($value->tanggal_terkirim);
                          $interval = $a->diff($b);
                          $x= $interval->format("%a");
                          
                          if(isset($konsumen[$value->id_konsumen]['tempo_piutang'])){
                              $tmpopiu = $konsumen[$value->id_konsumen]['tempo_piutang'];
                          }else{
                              $tmpopiu = 0;
                          }
                          
                           ?>
                          <tr <?php if ($x > $tmpopiu): ?>
                            style="background:#ffbaba;"
                          <?php endif; ?>
                          >
                              <td>{{$value->no_kwitansi}}</td>
                              <td>{{$x}} hari</td>
                              <td><?php if (isset($konsumen[$value->id_konsumen]['nama'])){
                                echo $konsumen[$value->id_konsumen]['nama'];
                              }else{
                                echo $karyawan[$value->id_konsumen]['nama'];
                              } ?>
                              </td>
                              <td><?php if (isset($konsumen[$value->id_konsumen]['alamat'])){
                                echo $konsumen[$value->id_konsumen]['alamat'];
                              }else{
                                echo $karyawan[$value->id_konsumen]['alamat'];
                              } ?></td>
                              
                              <td><?php if (isset($konsumen[$value->id_konsumen]['no_hp'])){
                                echo $konsumen[$value->id_konsumen]['no_hp'];
                              }else{
                                echo $karyawan[$value->id_konsumen]['no_hp'];
                              } ?></td>

                              <td><?php if (isset($karyawan[$value->sales]['nama'])){
                                echo $karyawan[$value->sales]['nama'];
                              }?></td>

                              <td hidden><?php if (isset($user[$value->admin_p])){
                                echo $user[$value->admin_p];
                              }?></td>

                              <td><?php if (isset($user[$value->admin_g])){
                                echo $user[$value->admin_g];
                              }?></td>

                              <td><?php if (isset($user[$value->admin_v])){
                                echo $user[$value->admin_v];
                              }?></td>

                              <td hidden><?php if (isset($karyawan[$value->dropper]['nama'])){
                                echo $karyawan[$value->dropper]['nama'];
                              }?></td>

                              <td><?php if (isset($karyawan[$value->pengirim]['nama'])){
                                echo $karyawan[$value->pengirim]['nama'];
                              }?></td>

                              <td><button onclick="Rincian('{{$value->no_kwitansi}}')" class="btn btn-warning">Lihat Rincian Produk</button>
                              <button onclick="RincianBayar('{{$value->no_kwitansi}}')" class="btn btn-primary">Lihat Rincian Pembayaran</button>
                              </td>
                          </tr>
                        <?php } } ?>
                        
                      </tbody>
                  </table>
		</div>
		<br>
        <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                <h4>&nbsp;&nbsp;&nbsp;Cetak Kwitansi Tagihan</h4>
                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-lg-6">
                      <input type="text" id="no_kwitansi" class="form-control" placeholder="Ketik No. Kwitansi...">
                    </div>
                    <div class="col-lg-6">
                      <button class="btn btn-danger" onclick="kwitansi()">Cetak</button>
                    </div>
                  </div>
                </div>
        </div>
        <br>
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

      <div class="modal fade" id="detail" role="dialog">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                <table id="examples3" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                      <tr>
                          <th>No Kwitansi</th>
                          <th>No. SKU</th>
                          <th>Nama Barang</th>
                          <th>Jumlah Terkirim</th>
                          <th>Sub Total</th>
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
        
    <div class="modal fade" id="detail2" role="dialog">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                <table id="examples2" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                      <tr>
                          <th>No Kwitansi</th>
                          <th>Sub Total</th>
                          <th>Pembayaran</th>
                          <th>Piutang</th>
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
  var cek = true;
  var data_id = [];
  $(document).ready(function() {
      var table = $('#exam').DataTable();
      $('#exam tbody').on('click', 'tr', function () {
          var data = table.row( this ).data();
          //alert( 'You clicked on '+data[0]+'\'s row' );
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
           data_id = [];
           for (var i = 0; i < response.length; i++) {
             data_id[response[i]['nik']] = response[i]['id'];
             if (value == "admin_p" || value == "admin_g" || value == "admin_v") {
               var id = response[i]['id'];
               var nama = response[i]['name'];
               table.row.add( [
                 response[i]['id'],
                 response[i]['nik'],
                 response[i]['name']
                 //response[i]['no_hp']
                 //'<button class="btn btn-success" onclick="pilihpetugas('+id+','+"'"+nama+"'"+')">Pilih</button>'
               ] ).draw( false );
             }else{
               var id = response[i]['id'];
               var nama = response[i]['nama'];
               table.row.add( [
                 response[i]['id'],
                 response[i]['nik'],
                 response[i]['nama']
                 //response[i]['no_hp']
                 //'<button class="btn btn-success" onclick="pilihpetugas('+id+','+"'"+nama+"'"+')">Pilih</button>'
               ] ).draw( false );
             }
           }
           $('#jabatan').modal('show');
         }
       });
  }
  
  function kwitansi() {
        var no_kwitansi = document.getElementById("no_kwitansi").value;
        window.open("{{url('/tagihan/')}}"+'/'+no_kwitansi);
      }

  function pilihpetugas(id,nama){
    $('#jabatan').modal('hide');
    document.getElementById("name").value = nama;
    document.getElementById("id").value = id;
  }

  function Rincian(value)
  {
    var myTable = document.getElementById("examples3");
    var rowCount = myTable.rows.length;
    for (var x=rowCount-1; x>0; x--) {
     myTable.deleteRow(x);
    }

      $.ajax({
         url: 'detailBarangTerkirim2/'+value,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           var myTable = document.getElementById("examples3");
           var rowCount = myTable.rows.length;
           for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
           }
           for (var i = 0; i < response.length; i++) {
            if (Number(response[i]['terkirim']) > 0) {
             var table = document.getElementById("examples3").getElementsByTagName('tbody')[0];
             var lastRow = table.rows.length;
             var row = table.insertRow(lastRow);
             row.id = lastRow;

             var cell1 = row.insertCell(0);
             var cell2 = row.insertCell(1);
             var cell3 = row.insertCell(2);
             var cell4 = row.insertCell(3);
             var cell5 = row.insertCell(4);
             
             if(response[i]['total_sudah_bayar'] == "undefined" || response[i]['total_sudah_bayar'] == undefined){
                 response[i]['total_sudah_bayar'] == 0;
             }
             
             cell1.innerHTML = response[i]['no_kwitansi'];
             cell2.innerHTML = response[i]['no_sku'];
             cell3.innerHTML = response[i]['nama_barang'];
             cell4.innerHTML = response[i]['terkirim'];
             cell5.innerHTML = numberWithCommas(response[i]['sub_total']);
             

             }
           }

           $('#detail').modal('show');
         }
       });
  }
  
  function RincianBayar(value)
  {
    var myTable = document.getElementById("examples3");
    var rowCount = myTable.rows.length;
    for (var x=rowCount-1; x>0; x--) {
     myTable.deleteRow(x);
    }

      $.ajax({
         url: 'detailBarangTerkirim3/'+value,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           var myTable = document.getElementById("examples2");
           var rowCount = myTable.rows.length;
           for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
           }
           for (var i = 0; i < response.length; i++) {
             var table = document.getElementById("examples2").getElementsByTagName('tbody')[0];
             var lastRow = table.rows.length;
             var row = table.insertRow(lastRow);
             row.id = lastRow;

             var cell1 = row.insertCell(0);
             var cell2 = row.insertCell(1);
             var cell3 = row.insertCell(2);
             var cell4 = row.insertCell(3);
             
             cell1.innerHTML = response[i]['no_kwitansi'];
             cell2.innerHTML = numberWithCommas(response[i]['total_bayar']);
             cell3.innerHTML = numberWithCommas(response[i]['total_sudah_bayar']);
             var hasil = Number(response[i]['total_bayar']) - Number(response[i]['total_sudah_bayar']) ;
             cell4.innerHTML = numberWithCommas(hasil);
           }

           $('#detail2').modal('show');
         }
       });
  }

  function RincianJasa(value)
  {
    var myTable = document.getElementById("examples3");
    var rowCount = myTable.rows.length;
    for (var x=rowCount-1; x>0; x--) {
     myTable.deleteRow(x);
    }

      $.ajax({
         url: 'detailJasaKonsumen/'+value,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           var myTable = document.getElementById("examples3");
           var rowCount = myTable.rows.length;
           for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
           }
           for (var i = 0; i < response.length; i++) {
             var table = document.getElementById("examples3").getElementsByTagName('tbody')[0];
             var lastRow = table.rows.length;
             var row = table.insertRow(lastRow);
             row.id = lastRow;

             var cell1 = row.insertCell(0);
             var cell2 = row.insertCell(1);
             var cell3 = row.insertCell(2);
             var cell4 = row.insertCell(3);
             var cell5 = row.insertCell(4);

             cell1.innerHTML = response[i]['no_kwitansi'];
             cell2.innerHTML = response[i]['id_jasa'];
             cell3.innerHTML = response[i]['nama_jasa'];
             cell4.innerHTML = response[i]['jumlah'];
             cell5.innerHTML = numberWithCommas(response[i]['sub_biaya']);

           }

           $('#detail').modal('show');
         }
       });
  }

</script>
@endsection
