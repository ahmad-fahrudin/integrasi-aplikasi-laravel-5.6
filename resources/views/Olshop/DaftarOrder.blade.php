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
                          <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Orderan Web Store > <a href="https://stokis.app/?s=cara+proses+order+pending+dari+web+store" target="_blank">Order Pending</a></li>
                      </ol>
                  </nav>
                </h4>
                <hr>
              <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>No. Kwitansi</th>
                          <th>Tanggal Order</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Kota/Kabupaten</th>
                          <th>Gudang</th>
                          <th>Status Order</th>
                          <th>Kurir</th>
                          <th>Status Pembayaran</th>
                          <th>Keterangan</th>
                          <th>Tindakan</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($order_ol as $value) {
                      if($value->cod > 0){ $metpe="COD"; }else{ $metpe ="Online Payment"; }
                      if($value->transaction_status == "settlement"){ $value->transaction_status="Lunas"; }
                      ?>
                      <tr <?php if ($value->status_barang == "kirim ulang"): ?>
                        style="background:#ffc8c8;"
                      <?php endif; ?>>
                          <td>{{$value->no_kwitansi}}</td>
                          <td>{{date("d-m-Y", strtotime($value->tanggal_order))}}</td>
                          <td>{{$value->nama_pemilik}}</td>
                          <td><?php echo $value->alamat; ?></td>
                          <td>
                            <?php if (is_numeric($value->kota)) {
                              echo $data_kabupaten[$value->kota];
                            }else{
                              echo $value->kota;
                            }?>
                          </td>
                          <td>{{$value->nama_gudang}}</td>
                          <td>{{$metpe}}</td>
                          <td>{{$value->kurir}} ({{$value->service}})</td>
                          <td>{{$value->transaction_status}}</td>
                          <td>{{$value->nama_status." ".$value->ket}}</td>
                          <td>
                            <?php
                              if (Auth::user()->level == "1" || Auth::user()->level == "3" ||Auth::user()->id == $value->id_admin_p){
                                $ck = 1;
                              }else{
                                $ck = 0;
                              } ?>
                            <?php if (Auth::user()->level == "1" || Auth::user()->level == "3" || Auth::user()->id == $value->id_admin_p): ?>
                              <?php if ($value->transaction_status == "Lunas" || $metpe == "COD"){ ?>
                                  <button onclick="Proses('{{$value->no_kwitansi}}')" class="btn btn-primary">Proses</button>
                              <?php }else{ ?>
                                  <button onclick="Peringatan()" class="btn btn-secondary" >Proses</button>
                              <?php } ?>
                              <?php endif; ?>
                              <button onclick="Rincian('{{$value->no_kwitansi}}','{{$ck}}')" class="btn btn-primary">Lihat Rincian</button>
                              <button onclick="PrintDetail('{{$value->no_kwitansi}}')" class="btn btn-primary">Print</button>
                              <?php if (Auth::user()->level == "1" || Auth::user()->level == "3" || Auth::user()->id == $value->id_admin_p): ?>
                                <!-- <button onclick="Cancel('{{$value->no_kwitansi}}')" class="btn btn-danger">Cancel Order</button></td> -->
                              <?php endif; ?>
                      </tr>
                     <?php } ?>
                  </tbody>
              </table>
              <br>
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
          <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
              <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($sales as $value): ?>
                  <tr onclick="pilihsales('{{$value->id}}','{{$value->nama}}')">
                      <td>{{$value->nik}}</td>
                      <td>{{$value->nama}}</td>
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
                      <th>NIK</th>
                      <th>Nama</th>
                      <th>No HP</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($sales as $value): ?>
                    <tr onclick="pilihpengembang('{{$value->id}}','{{$value->nama}}')">
                        <td>{{$value->nik}}</td>
                        <td>{{$value->nama}}</td>
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
                    <th>No Kwitansi</th>
                    <th>No. SKU</th>
                    <th>Nama Barang</th>
                    <th>Warna Produk</th>
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
                <td>No Kwitansi</td>
                <td id="no_kwitansi">No Kwitansi</td>
              </tr>
              <tr>
                <td>Nama Konsumen</td>
                <td id="nama_pemilik">No Kwitansi</td>
              </tr>
              <tr>
                <td>Gudang Sebelumnya</td>
                <td id="before">No Kwitansi</td>
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
    //location.href ="{{url('/printdetailbarangkeluar/')}}"+"/"+value;
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

  function Proses(no_kwitansi){
    Swal.fire(
      'Proses '+no_kwitansi+'?',
      'Apakah Anda Yakin?',
      'question'
    ).then((result) => {
      if (result.value) {
        location.href="{{url('/prosesorderolshop/')}}"+"/"+no_kwitansi;
      }
    });
  }

  function Peringatan(){
    Swal.fire(
      'Pembayaran belum dilakukan, Orderan Belum bisa diproses!',
    );
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
    var myTable = document.getElementById("examples3");
    var rowCount = myTable.rows.length;
    for (var x=rowCount-1; x>0; x--) {
     myTable.deleteRow(x);
    }

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

             cell1.innerHTML = response[i]['no_kwitansi'];
             cell2.innerHTML = response[i]['no_sku'];
             cell3.innerHTML = response[i]['nama_barang'];
             cell4.innerHTML = response[i]['warna'];
             cell5.innerHTML = response[i]['jumlah'];
             var vl = "'"+response[i]['nama_barang']+"',"+response[i]['id_link'];
             if (cek == '1') {
                cell6.innerHTML = '<button onclick="Deleted('+vl+')" class="btn btn-danger">Hapus</button>';
             }
           }

           $('#detail').modal('show');
         }
       });
  }
  </script>
@endsection
