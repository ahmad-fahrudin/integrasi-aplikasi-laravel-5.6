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
                              <li class="breadcrumb-item text-muted" aria-current="page">POS Kasir Toko > <a href="https://stokis.app/?s=history+kasir+toko" target="_blank">Histori Transaksi hari ini</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
    
                    <?php if (Auth::user()->level == "1"): ?>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <div class="form-group">
                       <form name="form1" action="{{url('endsession')}}" method="post" enctype="multipart/form-data">
                         {{csrf_field()}}
                       <div class="row">
                           <label class="col-lg-1">Transaksi</label>
                           <div class="col-lg-2">
                               <div class="row">
                                   <div class="col-md-12">
                                       <select class="form-control" name="jenis">
                                           <option selected disable>Pilih</option>
                                           <option
                                           <?php if(isset($jenis)){ echo "selected"; } ?> >Semua</option>
                                       </select>
                                   </div>
                                </div>
                            </div>
                        <div class="row">
                           <label class="col-lg-1"></label>
                           <div class="col-lg-2">
                               <div class="row">
                                   <div class="col-md-12">
                                       <center><input type="submit" value="Filter" class="btn btn-success"></center>
                                   </div>
                                </div>
                            </div>
                        </div>
                      </div>
                      </form>
                      </div>
                      
                      </div>
                      <?php endif; ?>
                    <hr>
                
				<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Kwitansi</th>
                              <th>Tanggal Order</th>
                              <th>Nama</th>
                              <th>Alamat</th>
                              <th hidden>Kota/Kabupaten</th>
                              <th hidden>Sales</th>
                              <th>Kasir</th>
                              <th>Cabang</th>
                              <th>Nilai Penjualan</th>
                              <th>Status</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $totju = 0;foreach ($order as $value) { $totju+=$value->total_bayar; ?>
                          <tr>
                              <td>{{$value->no_kwitansi}}</td>
                              <td>{{date("d-m-Y", strtotime($value->tanggal_order))}}</td>
                              <td>{{$konsumen[$value->id_konsumen]['nama']}}</td>
                              <td><?=$konsumen[$value->id_konsumen]['alamat']?></td>
                              <td hidden>
                                  <?php if(!is_numeric($konsumen[$value->id_konsumen]['kota'])){
                                    echo $konsumen[$value->id_konsumen]['kota'];
                                  }else{
                                    echo $regencies[$konsumen[$value->id_konsumen]['kota']];
                                  }?>
                              </td>
                              <td hidden>{{$karyawan[$value->sales]}}</td>
                              <td>{{$users[$value->admin_p]}}</td>
                              <td>{{$gudang[$value->id_gudang]}}</td>
                              <td align="right">{{ribuan($value->total_bayar)}}</td>
                              <td align="right">
                                  <?php if(isset($bayar[$value->no_kwitansi])){ echo "Lunas"; }else{ echo "Belum Lunas"; } ?>
                              </td>
                              <td class="d-flex">
                                <?php
                                  if (Auth::user()->level == "1" || (isset($value->id_admin_p) && Auth::user()->id == $value->id_admin_p)){
                                    $ck = 1;
                                  }else{
                                    $ck = 0;
                                  } ?>
                                  <button onclick="Rincian('{{$value->no_kwitansi}}','{{$ck}}')" class="btn btn-primary m-1">Lihat Rincian</button>
                                  <button onclick="PrintDetail('{{$value->no_kwitansi}}')" class="btn btn-primary m-1">Print Nota</button>
                                  <button onclick="PrintDetail2('{{$value->no_kwitansi}}')" class="btn btn-primary d-none d-md-block m-1">Nota Besar</button>
                          </tr>
                         <?php } ?>
                      </tbody>
                  </table>
				 </div>
				 <br>
				 <div style="float:left;font-weight:bold">Total penjualan hari ini: Rp {{ribuan($totju)}},-</div>
				 <br>
				 <hr>
				 
    		        <div <?php if(Auth::user()->level != 1){echo "hidden"; } ?>>
                        <input type="checkbox" name="simpaninsentif" id="simpaninsentif" style="width:20px;height:20px;" value="lunas">&emsp;Checklist untuk simpan Laporan Harian (Insentif / Omset / Pendapatan)
                        <br>
                    </div>
                 <hr>
				 <button class="btn btn-danger m-1" onclick="SimpanEndSession()">End Session</button>
				 <button id="ctk" class="btn btn-primary m-1" disabled onclick="CetakHistoryNota()">Cetak Laporan</button>
				 <br>
				</div>
				
              </div>
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
                        <th>Qty</th>
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
              var trip="";
      <?php session_start(); if(isset($_SESSION['trip'])){?>
          trip = "{{$_SESSION['trip']}}";
          document.getElementById("ctk").disabled = false;
      <?php } ?>
      function PrintDetail(value){
        window.open("{{url('/cetaknota/')}}"+'/'+value);
        //location.href ="{{url('/printdetailbarangkeluar/')}}"+"/"+value;
      }
      function PrintDetail2(value){
        location.href ="{{url('/kwitansi/')}}"+"/"+value;
      }
      
      function SimpanEndSession(){
          var simpaninsentif = document.getElementById("simpaninsentif");
          var status = false;
          if (simpaninsentif.checked == true){
            status = true;
          } else {
            status = false;
          }
  
        Swal.fire(
          'End Session Hari ini?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            location.href="{{url('/prosesendsession/')}}/"+status;
          }
        });
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
        //location.href ="{{url('/printdetailbarangkeluar/')}}"+"/"+value;
      }
          function CetakHistoryNota(){
          window.open("{{url('/printbytrip/')}}"+'/'+trip);
      }
      function Deleted(nama,id){
        Swal.fire(
          'Delete '+nama+'?',
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
          'Delete '+value+'?',
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

                 cell1.innerHTML = response[i]['no_kwitansi'];
                 cell2.innerHTML = response[i]['no_sku'];
                 cell3.innerHTML = response[i]['nama_barang'];
                 cell4.innerHTML = response[i]['terkirim'];
                 cell5.innerHTML = numberWithCommas(response[i]['sub_total']);
                 var vl = "'"+response[i]['nama_barang']+"',"+response[i]['id_link'];
               }

               $('#detail').modal('show');
             }
           });
      }
      </script>

@endsection
