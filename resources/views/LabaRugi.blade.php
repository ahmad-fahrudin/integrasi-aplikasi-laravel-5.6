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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > <a href="https://stokis.app/?s=data+laporan+laba+rugi" target="_blank">Data Laba Rugi</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <div class="col-md-4">
                      <form action="{{url('proseslabarugi')}}" method="post" id="form_proseslabarugi" enctype="multipart/form-data">
                        <p><strong>Catatan Transaksi</strong></p>
                        {{csrf_field()}}
                        Saldo saat ini:
                        <div class="row">
                          <div class="col-lg-12">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="saldo" name="old_saldo" required type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        Jenis Transaksi:
                        <select required onchange="Catatan()" name="cek" id="jenis" class="form-control">
                          <option value="out">Keluar</option>
                          <option value="in">Masuk</option>
                        </select>
                        <br>
                        Nominal:
                        <input required type="text" name="jumlah" class="form-control" data-a-sign="" id="nominal" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                        <br>
                        Catatan:
                        <select name="nama_jenis" id="catatan" required class="form-control">
                          <option>Revisi</option>
                          <!--option>Operasional</option-->
                          <!--option>Beban</option-->
                        </select>
                        <br>
                        Catatan Tambahan:
                        <input type="text" name="keterangan" class="form-control" placeholder="opsional">
                        <br>
                        Tanggal Transaksi:
                        <input required type="date" name="tgl_transaksi" value="{{date('Y-m-d')}}" class="form-control">
                        <br>
                        <div class="form-group">
                         <div class="col-4">
                        <input type="submit" value="Simpan" class="btn btn-primary form-control">
                        </div>
                        </div>
                      </form>
                      <br><br>
                    </div>
                    <hr>
									<div class="table-responsive">
                    <form action="{{url('labarugi')}}" method="post">
                      {{csrf_field()}}
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                        <p><strong>Filter Berdasarkan</strong></p>

                    <div class="form-group">
                      <div class="row">
                         <label class="col-lg-2">Range Tanggal</label>
                        <div class="col-md-2">

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
                        <label class="col-lg-0.5">&emsp;s/d&emsp;</label>
                        <div class="col-md-2">

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
                    <div class="col-md-1">
                    <div class="row">
                    <div class="col-md-2">&emsp;&emsp;
                    </div></div></div>
                    <div class="form-group">
                    <div class="col-lg-12">
                    <center><input type="submit" class="form-control btn-success" value="Filter Data"></center>
                    </div>
                    </div>
                    </div>
                      </div>
                      </div>
                    </form>
                    <hr><br>
                  <table id="labarugi_table" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Tanggal</th>
                              <th>Keterangan Transaksi</th>
                              <th>Pendapatan</th>
                              <th>Pengeluaran</th>
                              <th>Saldo Laba Rugi</th>
                              <th>Admin</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; $jumlah=0; foreach ($labarugi as $key => $value): if($value->jumlah > 0){?>
                          <tr>
                            <td>{{tanggal($value->tgl_transaksi)}}</td>
                            <td>
                                {{$value->nama_jenis}}<?php if ($value->nama_jenis == "Laba Rugi" || $value->nama_jenis == "Tenaga Toko" || $value->nama_jenis == "Tenaga Gudang" || $value->nama_jenis == "Ongkir" || $value->nama_jenis == "Bonus Gudang"|| $value->nama_jenis == "Pendapatan"): ?> -{{$value->no_trip}}<?php endif; ?>
                                <?php if ($value->keterangan != "") { echo $value->keterangan; } ?>
                            </td>
                            <td align="right">
                              <?php if ($value->jenis == "in"): $jumlah += $value->jumlah;?>
                                {{ribuan($value->jumlah)}}
                              <?php endif; ?>
                            </td>
                            <td align="right">
                              <?php if ($value->jenis == "out"): $jumlah -= $value->jumlah;?>
                                {{ribuan($value->jumlah)}}
                              <?php endif; ?>
                            </td>
                            <td align="right">{{ribuan($jumlah)}}</td>
                            <td>
                              <?php if (isset($value->admin)): ?>
                                {{$admin[$value->admin]}}
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php $no++; } endforeach;
                        echo '<script type="text/javascript">',
                             '
                             document.getElementById("saldo").value = '.'"'.ribuan($jumlah).'"'.'
                             ',
                             '</script>'
                             ;
                        ?>
                      </tbody>
              </table>
            </div>

            </div>
          </div>
        </div>
      </div>

      <div id="image" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
              <img width="100%" id="img">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
      <script>
      new AutoNumeric('#nominal', "euroPos");
      //new AutoNumeric('#in_jumlah', "euroPos");
      function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
      function Catatan(){
        var cek = document.getElementById("jenis").value;
        if (cek == "out") {
          var select = document.getElementById("catatan");
          var length = select.options.length;
          for (i = length-1; i >= 0; i--) {
          select.options[i] = null;
          }

          var x = document.createElement("OPTION");
          var t = document.createTextNode("Revisi");
          x.appendChild(t);
          document.getElementById("catatan").appendChild(x);

          /*var x2 = document.createElement("OPTION");
          var t2 = document.createTextNode("Operasional");
          x2.appendChild(t2);
          document.getElementById("catatan").appendChild(x2);

          var x3 = document.createElement("OPTION");
          var t3 = document.createTextNode("Beban");
          x3.appendChild(t3);
          document.getElementById("catatan").appendChild(x3);*/
        }else{
          var select = document.getElementById("catatan");
          var length = select.options.length;
          for (i = length-1; i >= 0; i--) {
          select.options[i] = null;
          }
          var x = document.createElement("OPTION");
          var t = document.createTextNode("Revisi");
          x.appendChild(t);
          document.getElementById("catatan").appendChild(x);

          /*var x2 = document.createElement("OPTION");
          var t2 = document.createTextNode("Pendapatan lain lain");
          x2.appendChild(t2);
          document.getElementById("catatan").appendChild(x2);*/
        }
      }

      </script>

      <script>
          $("#labarugi_table").DataTable(
            {
                "ordering": false,
                dom: 'Bfrtip',
                buttons: [
                  {
                      extend: 'print',
                      columns: [ 0, 1, 2, 3 , 4 ,5],
                      customize: function ( win ) {
                          $(win.document.body)
                              .css( 'font-size', '10pt' );
                          $(win.document.body).find( 'table' )
                              .addClass( 'compact' )
                              .css( 'font-size', 'inherit' );
                      }
                  },
                  {

                      extend: 'excel',
                      title: namadon,
                      exportOptions: {
                             columns: [ 0, 1, 2, 3 , 4 ,5],
                             format: {
                                      body: function(data, row, column, node) {
                                        if(column===2){
                                          return data.split(".").join("");
                                        }
                                        if(column===1){
                                          var temp = data.split("                                  ").join("");
                                          temp = temp.split("<br>").join("-");
                                          temp = temp.split('<button class="btn btn-default" onclick="Load(').join("");
                                          temp = temp.split(')">').join("");
                                          temp = temp.split('</button>').join("");
                                          var res = temp.split("'");
                                          if (res.length > 1) {
                                            temp = res[0]+res[2];
                                          }
                                          return temp;
                                        }
                                        if(column===3){
                                          return data.split(".").join("");
                                        }
                                        if(column===4){
                                          return data.split(".").join("");
                                        }
                                        if(column===12){
                                          return data.split(".").join("");
                                        }
                                        if(column===13){
                                          return data.split(".").join("");
                                        }
                                        if(column===14){
                                          return data.split(".").join("");
                                        }
                                        if(column===15){
                                          return data.split(".").join("");
                                        }else{
                                          return data
                                        }
                                      }
                        }
                     }

                  },
                  {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    title: namadon,
                      customize: function ( win ) {
                        win.defaultStyle.fontSize = 10
                      },
                      exportOptions: {
                        columns: [ 0, 1, 2, 3 , 4 ,5]
                      }
                  }
                ]
            }
          ).page('last').draw('page');
      </script>
@endsection
