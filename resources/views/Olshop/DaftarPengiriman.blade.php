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
                          <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Orderan Web Store > <a href="https://stokis.app/?s=daftar+order+proses+web+store" target="_blank">Order Proses</a></li>
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
                          <th>Metode Pembayaran</th>
                          <th>Kurir</th>
                          <th>Status Pembayaran</th>
                          <th>Keterangan</th>
                          <th>Tindakan</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($order as $value) {
                      if($value->cod > 0){ $metpe="COD"; }else{ $metpe ="Online Payment"; }
                      if($value->transaction_status == "settlement"){ $value->transaction_status="Lunas"; }
                      ?>
                      <tr>
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
                          <td>{{$value->keterangan}}</td>
                          <td>
                            <?php
                              if (Auth::user()->level == "1" || Auth::user()->level == "3" ||Auth::user()->id == $value->id_admin_p){
                                $ck = 1;
                              }else{
                                $ck = 0;
                              } ?>
                              <a class="btn btn-success" href="{{url('lacak_kurir')}}/{{$value->no_kwitansi}}">Lacak Pengiriman</a>
                              <button onclick="Rincian('{{$value->no_kwitansi}}','{{$ck}}')" class="btn btn-primary">Lihat Rincian</button>
                          </td>
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


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script>
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
