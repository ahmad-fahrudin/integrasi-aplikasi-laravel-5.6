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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Hutang > <a href="https://stokis.app/?s=daftar+hutang+pembelian" target="_blank">Daftar Hutang Pembelian</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
				  <div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Tanggal Transaksi</th>
                              <th>Tempo</th>
                              <th>Supplier</th>
                              <th>Alamat</th>
                              <th>Keterangan</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach($hutang as $key => $value){ 
                          $a = new DateTime(date("Y-m-d"));
                          $b = new DateTime($value->tgl_transaksi);
                          $interval = $a->diff($b);
                          $x= $interval->format("%a");
                          ?>
                          <tr>
                              <td>{{$value->tgl_transaksi}}</td>
                              <td>{{$x}} Hari</td>
                              <td><?php if(isset($value->suplayer) && isset($val_suplayer[$value->suplayer]->nama_pemilik)){ ?>{{$val_suplayer[$value->suplayer]->nama_pemilik}} <?php } ?></td>
                              <td><?php if(isset($value->suplayer) && isset($val_suplayer[$value->suplayer]->alamat)){ ?><?=$val_suplayer[$value->suplayer]->alamat?> <?php } ?></td>
                              <td>{{$value->keterangan}}</td>
                              <td>
                                  <button onclick="RincianProduk('{{$value->no_faktur}}','{{$value->jumlah}}')" class="btn btn-warning">Lihat Rincian Produk</button>
                                  <button onclick="Rincian('{{$value->no_faktur}}','{{$value->jumlah}}')" class="btn btn-primary">Lihat Rincian Pembayaran</button>
                                  </td>
                          </tr>
                          <?php } ?>
                      </tbody>
                  </table>
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
                          <th>No Faktur</th>
                          <th>Sub Total</th>
                          <th>Pembayaran</th>
                          <th>Sisa Hutang</th>
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
                          <th>No Faktur</th>
                          <th>No SKU</th>
                          <th>Nama Barang</th>
                          <th>Jumlah</th>
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
function RincianProduk(value,jumlah)
  {
    var myTable = document.getElementById("examples3");
    var rowCount = myTable.rows.length;
    for (var x=rowCount-1; x>0; x--) {
     myTable.deleteRow(x);
    }

      $.ajax({
         url: 'detailBarangMasuk2/'+value,
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
             
             cell1.innerHTML = response[i]['no_faktur'];
             cell2.innerHTML = response[i]['no_sku'];
             cell3.innerHTML = response[i]['nama_barang'];
             cell4.innerHTML = response[i]['jumlah'];
           }

           $('#detail2').modal('show');
         }
       });
  }

function Rincian(value,jumlah)
  {
    var myTable = document.getElementById("examples3");
    var rowCount = myTable.rows.length;
    for (var x=rowCount-1; x>0; x--) {
     myTable.deleteRow(x);
    }

      $.ajax({
         url: 'detailBarangMasuk/'+value,
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
             
             cell1.innerHTML = response[i]['no_faktur'];
             cell2.innerHTML = numberWithCommas(jumlah);
             cell3.innerHTML = numberWithCommas(response[i]['total_sudah_bayar']);
             var piutang = Number(jumlah) - Number(response[i]['total_sudah_bayar']);
             cell4.innerHTML = numberWithCommas(piutang);
           }

           $('#detail').modal('show');
         }
       });
  }
  </script>
@endsection
