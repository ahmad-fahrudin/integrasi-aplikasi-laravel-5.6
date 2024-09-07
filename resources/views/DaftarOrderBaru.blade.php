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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Orderan Gudang > <a href="https://stokis.app/?s=cara+mengelola+daftar+order+masuk" target="_blank">Daftar Order Masuk (TO & PO)</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <div class="form-group">
                      <form action="{{url('daftarorderbaru')}}" method="post">
                      {{csrf_field()}}
                      
                      <div class="row">
                      <div class="col-md-6">
                       <div class="row">
                           <label class="col-lg-3">Tanggal Order</label>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-11">
                                       <input type="date" id="from" name="from"
                                         <?php if (isset($from)): ?>
                                           value="{{$from}}"
                                         <?php endif; ?>
                                       class="form-control">
                                   </div>
                               </div>
                           </div>
                           <label class="col-lg-0.5">&emsp;s/d&emsp;</label>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-11">
                                       <input type="date" id="to" name="to"
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
                           <label class="col-lg-3">Status Order</label>
                           <div class="col-lg-8">
                               <div class="row">
                                   <div class="col-md-11">
                                       <select name="status_order" id="status_order" class="form-control">
                                         <?php foreach ($status_order as $value): ?>
                                           <option value="{{$value->id}}"
                                             <?php if (isset($v_status_order)): ?>
                                               <?php if ($v_status_order == $value->id ): ?>
                                                 selected
                                               <?php endif; ?>
                                             <?php endif; ?>
                                           >{{$value->nama_status}}</option>
                                         <?php endforeach; ?>
                                       </select>
                                   </div>
                               </div>
                           </div>
                           </div>
                           <br>
                           <div class="row">
                           <label class="col-lg-3">Cabang</label>
                           <div class="col-lg-8">
                               <div class="row">
                                   <div class="col-md-11">
                                     <select name="id_gudang" id="gudang" class="form-control">
                                       <?php foreach ($gudang as $value): ?>
                                         <option value="{{$value->id}}"
                                           <?php if (isset($id_gudang)): ?>
                                             <?php if ($id_gudang == $value->id ): ?>
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
                         </div>

                            <div class="col-md-6">
                                <div class="row">  
                           <label class="col-lg-3">Sales</label>
                           <div class="col-lg-8">
                               <div class="row">
                                   <div class="col-md-11">
                                     <div class="input-group">
                                       <input id="val_sales"  type="text"
                                         <?php if (isset($v_sales)): ?>
                                           value="{{$karyawan[$v_sales]}}"
                                         <?php endif; ?>
                                       class="form-control" placeholder="Pilih Nama Sales" readonly style="background:#fff">
                                       <input id="id_sales" name="sales"
                                         <?php if (isset($v_sales)): ?>
                                           value="{{$v_sales}}"
                                         <?php endif; ?>
                                       type="hidden" class="form-control">
                                       <div class="input-group-append">
                                           <button class="btn btn-outline-secondary" id="cari_barang" onclick="carisales()" type="button"><i class="fas fa-folder-open"></i></button>
                                       </div>
                                     </div>
                                   </div>
                               </div>
                           </div>
                           </div>
                           <br>
                           <div class="row">
                           <label class="col-lg-3">Pengembang</label>
                           <div class="col-lg-8">
                               <div class="row">
                                   <div class="col-md-11">
                                     <div class="input-group">
                                       <input id="val_pengembang"
                                         <?php if (isset($v_pengembang)): ?>
                                           value="{{$karyawan[$v_pengembang]}}"
                                         <?php endif; ?>
                                       type="text" class="form-control" placeholder="Pilih Nama Pengembang" readonly style="background:#fff">
                                       <input id="id_pengembang" name="pengembang"
                                         <?php if (isset($v_pengembang)): ?>
                                           value="{{$v_pengembang}}"
                                         <?php endif; ?>
                                       type="hidden" class="form-control">
                                       <div class="input-group-append">
                                           <button class="btn btn-outline-secondary" id="cari_barang" onclick="caripengembang()" type="button"><i class="fas fa-folder-open"></i></button>
                                       </div>
                                     </div>
                                   </div>
                               </div>
                           </div>
                            </div>
                            <br>
                            <div class="row">
                            <label class="col-lg-3">Tujuan Kiriman</label>
                           <div class="col-lg-8">
                               <div class="row">
                                   <div class="col-md-11">
                                       <input name="kota" id="kota" type="text"
                                         <?php if (isset($kota)): ?>
                                           value="{{$kota}}"
                                         <?php endif; ?>
                                       class="form-control" placeholder="Ketik Nama Kota/Kabupaten...">
                                   </div>
                               </div>
                           </div>
                           </div>
                           
                            </div>
                       </div>
                       <br>
                       <div class="form-group">
                          <div class="col-lg-12">
                              <center><button id="filter" class="btn btn-success btn-lg">Filter Data</button></center>
                          </div>
                       </div>
                     </form>
                     </div>
                      </div>
                      <br><hr>
				<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Kwitansi</th>
                              <th>Tanggal Order</th>
                              <th>Nama Member</th>
                              <th>Alamat</th>
                              <th>Kota/Kabupaten</th>
                              <th>Sales</th>
                              <th hidden>Admin(P)</th>
                              <th>Cabang</th>
                              <th>Status Order</th>
                              <th>Catatan</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($order as $value) { ?>
                          <tr <?php if ($value->status_barang == "kirim ulang"): ?>
                            style="background:#ffc8c8;"
                          <?php endif; ?>>
                              <td>{{$value->no_kwitansi}}</td>
                              <td>{{date("d-m-Y", strtotime($value->tanggal_order))}}</td>
                              <td>{{$value->nama_pemilik}}</td>
                              <td><?php echo $value->alamat; ?></td>
                              <td><?php if(is_numeric($value->kota)) { echo $data_kabupaten[$value->kota]; }else{ echo $value->kota; } ?></td>
                              <td>{{$value->sales}}</td>
                              <td hidden>{{$value->admin_p}}</td>
                              <td>{{$value->nama_gudang}}</td>
                              <td>{{$value->nama_status." ".$value->ket}}</td>
                              <td>{{$value->keterangan}} {{$value->ket_tmbhn}}</td>
                              <td>
                                <?php
                                  if (Auth::user()->level == "1" || Auth::user()->id == $value->id_admin_p){
                                    $ck = 1;
                                  }else{
                                    $ck = 0;
                                  } ?>
                                  <button onclick="Rincian('{{$value->no_kwitansi}}','{{$ck}}')" class="btn btn-primary">Lihat Rincian</button>
                                  <button onclick="PrintDetail('{{$value->no_kwitansi}}')" class="btn btn-dark">Cetak SO Gudang</button>
                                  
                                  <?php if (Auth::user()->level == "1" || Auth::user()->id == $value->id_admin_p || ( Auth::user()->gudang == $value->id_gudang && Auth::user()->level == '3' ) ): ?>
                                    <button onclick="Transfer('{{$value->no_kwitansi}}')" class="btn btn-success">Ganti Gudang</button>
                                  <?php endif; ?>
                                  
                                  <?php if (Auth::user()->level == "1" || Auth::user()->id == $value->id_admin_p): ?>
                                    <button onclick="Cancel('{{$value->no_kwitansi}}')" class="btn btn-danger">Cancel Order</button>
                                  <?php endif; ?>
                                  <?php if (Auth::user()->level == "1" || Auth::user()->level == "4" ): ?>
                                    <a href="../admin/kwitansidp/{{$value->no_kwitansi}}" target="_blank"><button class="btn btn-warning">Cetak Nota DP</button></a>
                                  <?php endif; ?>
                                  </td>
                          </tr>
                         <?php }
                         if (isset($lain)) {
                         foreach ($lain as $key => $value) { ?>
                           <tr <?php if ($value->status_barang == "kirim ulang"): ?>
                             style="background:#ffc8c8;"
                           <?php endif; ?>>
                               <td>{{$value->no_kwitansi}}</td>
                               <td>{{date("d-m-Y", strtotime($value->tanggal_order))}}</td>
                               <td>{{$value->nama}}</td>
                               <td><?php echo $value->alamat; ?></td>
                               <td></td>
                               <td>{{$value->sales}}</td>
                               <td>{{$value->admin_p}}</td>
                               <td>{{$value->nama_gudang}}</td>
                               <td>{{$value->nama_status." ".$value->ket}}</td>
                               <td>
                                   <?php if (Auth::user()->level == "1" || Auth::user()->level == $value->id_admin_p){
                                       $ck = 1;
                                     }else{
                                       $ck = 0;
                                     } ?>

                                   <button onclick="Rincian('{{$value->no_kwitansi}}','{{$ck}}')" class="btn btn-primary">Lihat Rincian</button>
                                   <button onclick="PrintDetail('{{$value->no_kwitansi}}')" class="btn btn-dark">Cetak SO Gudang</button>
                                  
                                  <?php if (Auth::user()->level == "1" || Auth::user()->id == $value->id_admin_p || ( Auth::user()->gudang == $value->id_gudang && Auth::user()->level == '3' ) ): ?>
                                    <button onclick="Transfer('{{$value->no_kwitansi}}')" class="btn btn-success">Ganti Gudang</button>
                                  <?php endif; ?>
                                  
                                   <?php if (Auth::user()->level == "1" || Auth::user()->level == $value->id_admin_p): ?>
                                     <button onclick="Cancel('{{$value->no_kwitansi}}')" class="btn btn-danger">Cancel Order</button>
                                   <?php endif; ?>
                                   <?php if (Auth::user()->level == "1" || Auth::user()->level == "4" ): ?>
                                    <a href="../admin/kwitansidp/{{$value->no_kwitansi}}" target="_blank"><button class="btn btn-warning">Cetak Nota DP</button></a>
                                  <?php endif; ?>
                                  </td>
                           </tr>
                         <?php } } ?>
                      </tbody>
                  </table>
                  <br>
                  <button onclick="PrintDetailAll()" class="btn btn-light btn-outline-primary">Cetak Semua SO Gudang</button></td>
                  <br><br>
				</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="sales" role="dialog">
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
                        <th hidden>NIK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($sales as $value): ?>
                      <tr onclick="pilihsales('{{$value->id}}','{{$value->nama}}')">
                          <td hidden>{{$value->nik}}</td>
                          <td>{{$value->nama}}</td>
                          <td><?php echo $value->alamat; ?></td>
                          <td>{{$value->no_hp}}</td>
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

      <div class="modal fade" id="pengembang" role="dialog">
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
                          <th hidden>NIK</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>No. Telepon</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($sales as $value): ?>
                        <tr onclick="pilihpengembang('{{$value->id}}','{{$value->nama}}')">
                            <td hidden>{{$value->nik}}</td>
                            <td>{{$value->nama}}</td>
                            <td><?php echo $value->alamat; ?></td>
                            <td>{{$value->no_hp}}</td>
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
                        <th>No. Kwitansi</th>
                        <th>No. SKU</th>
                        <th>Nama Barang</th>
                        <th>Item No.</th>
                        <th>Warna Pilihan.</th>
                        <th>Jumlah Order</th>
                        <th>Tindakan</th>
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

      <div class="modal fade" id="tfan" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <table class="table" width="100%">
                  <tr>
                    <td>No. Kwitansi</td>
                    <td id="no_kwitansi">No Kwitansi</td>
                  </tr>
                  <tr>
                    <td>Nama Konsumen</td>
                    <td id="nama_pemilik">No Kwitansi</td>
                  </tr>
                  <tr>
                    <td>Cabang Sebelumnya</td>
                    <td id="before">No. Kwitansi</td>
                  </tr>
                  <tr>
                    <td>Transfer Ke</td>
                    <td>
                    <select id="gudang_transfer" class="form-control">
                      <?php foreach ($tf as $value): ?>
                        <option value="{{$value->id}}">{{$value->nama_gudang}}</option>
                      <?php endforeach; ?>
                    </select>
                    </td>
                  </tr>
                </table>
                <center><button onclick="SimpanTransfer()" class="btn btn-primary">Transfer</button></center>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
      <script>

      function carisales(){
        $('#sales').modal('show');
      }
      function caripengembang(){
        $('#pengembang').modal('show');
      }
      function pilihsales(id,nama){
        document.getElementById("val_sales").value = nama;
        document.getElementById("id_sales").value = id;
        $('#sales').modal('hide');
      }
      function pilihpengembang(id,nama){
        document.getElementById("val_pengembang").value = nama;
        document.getElementById("id_pengembang").value = id;
        $('#pengembang').modal('hide');
      }

      function PrintDetail(value){
        window.open("{{url('/printdetailbarangkeluar/')}}"+'/'+value);
        //location.href ="{{url('/printdetailbarangkeluar/')}}"+"/"+value;
      }
      function PrintDetailAll(){
        var from = document.getElementById("from").value;
        var to = document.getElementById("to").value;
        var status_order = document.getElementById("status_order").value;
        var gudang = document.getElementById("gudang").value;
        var sales = document.getElementById("id_sales").value;
        var pengembang = document.getElementById("id_pengembang").value;
        var kota = document.getElementById("kota").value;
        if (from == "") { from="null" }
        if (to == "") { to="null" }
        if (sales == "") { sales="null" }
        if (pengembang == "") { pengembang="null" }
        if (kota == "") { kota="null" }
        
        window.open("{{url('/printdetailbarangkeluarall/')}}"+'/'+from+'/'+to+'/'+status_order+'/'+gudang+'/'+sales+'/'+pengembang+'/'+kota);
        //location.href ="{{url('/printdetailbarangkeluarall/')}}"+"/"+value;
      }

      function Deleted(nama,id){
        Swal.fire(
          'Hapus '+nama+'?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            location.href="{{url('/deleteitempenjualan/')}}"+"/"+id;
          }
        });
      }

      function Cancel(value){
        Swal.fire(
          'Hapus '+value+'?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            location.href="{{url('/deleteOrderBaru/')}}"+"/"+value;
          }
        });
      }

      function Transfer(value){
        $.ajax({
           url: 'detailKwitansi/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("no_kwitansi").innerHTML= response[0]['no_kwitansi'];
             document.getElementById("nama_pemilik").innerHTML= response[0]['nama_pemilik'];
             document.getElementById("before").innerHTML= response[0]['nama_gudang'];
             $('#tfan').modal('show');
           }
         });
      }

      function SimpanTransfer(){
        var kwitansi = document.getElementById("no_kwitansi").innerHTML;
        var update = document.getElementById("gudang_transfer").value;

        $.post("simpantransferstok",
          {no_kwitansi:kwitansi,id_gudang:update, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
              {
                  Swal.fire({
                      title: 'Berhasil',
                      icon: 'success',
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                      if (result.value) {
                        location.href="{{url('/daftarorderbaru/')}}";
                      }else{
                        location.href="{{url('/daftarorderbaru/')}}";
                      }
                    });
              }).fail(function(jqXHR, textStatus, errorThrown)
          {
              alert(textStatus);
          });

      }

      function Rincian(value,cek)
      {


          $.ajax({
             url: 'detailBarangKeluar/'+value,
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
                 //var table = document.getElementById("exam").getElementsByTagName('tbody')[0];
                 var table = document.getElementById("examples3").getElementsByTagName('tbody')[0];
                 var lastRow = table.rows.length;
                 var row = table.insertRow(lastRow);
                 row.id = lastRow;

                 var cell1 = row.insertCell(0);
                 var cell2 = row.insertCell(1);
                 var cell3 = row.insertCell(2);
                 var cell4 = row.insertCell(3);
                 var cell5 = row.insertCell(4);
                 var cell6 = row.insertCell(5);
                 var cell7 = row.insertCell(6);

                 cell1.innerHTML = response[i]['no_kwitansi'];
                 cell2.innerHTML = response[i]['no_sku'];
                 cell3.innerHTML = response[i]['nama_barang'];
                 cell4.innerHTML = response[i]['part_number'];
                 cell5.innerHTML = response[i]['warna_pilihan'];
                 cell6.innerHTML = response[i]['jumlah'];
                 var vl = "'"+response[i]['nama_barang']+"',"+response[i]['id_link'];
                 if (cek == '1') {
                    cell7.innerHTML = '<button onclick="Deleted('+vl+')" class="btn btn-danger">Hapus</button>';
                 }
               }

               $('#detail').modal('show');
             }
           });
      }
      
      function kwitansidp() {
        var no_kwitansi = document.getElementById("no_kwitansi").value;
        window.open("{{url('/kwitansidp/')}}"+'/'+no_kwitansi);
      }
      </script>

@endsection
