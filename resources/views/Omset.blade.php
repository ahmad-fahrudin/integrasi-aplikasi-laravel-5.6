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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > <a href="https://stokis.app/?s=data+omset+penjualan" target="_blank">Data Omset</a></li>
                          </ol>
                      </nav>
                    </h4>
									<div class="table-responsive">
                    <form action="{{url('dataomset')}}" method="post">
                      {{csrf_field()}}
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                        <p><strong>Filter Berdasarkan</strong></p>

                    <div class="form-group">
                      <div class="row">
                         <label class="col-lg-2">Range Tanggal</label>
                        <div class="col-md-2">

                        <div class="row">
                        <div class="col-md-12">
                          <input type="date" name="from" required
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
                          <input type="date" name="to" required
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
                  <table id="omset_table" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Tanggal</th>
                              <th>Keterangan Transaksi</th>
                              <th hidden>Omset Penjualan</th>
                              <th hidden>Jumlah Omset</th>
                              <th>Nilai Penjualan</th>
                              <th>Jumlah Penjualan</th>
                              <th>Admin</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; $jumlah=0; $jumlah_penj=0; foreach ($omset as $key => $value): ?>
                          <tr>
                            <td>{{tanggal($value->tgl_transaksi)}}</td>
                            <td>
                                {{$value->nama_jenis}} {{$value->keterangan}} - {{$value->no_trip}}
                            </td>
                            <td hidden align="right">
                              <?php if ($value->jenis == "in"): $jumlah += $value->jumlah;?>
                                {{ribuan($value->jumlah)}}
                              <?php endif; ?>
                            </td>
                            <td hidden align="right">{{ribuan($jumlah)}}</td>
                            <td align="right">{{ribuan($value->nilai_penjualan)}}</td>
                            <td align="right">
                              <?php if ($value->jenis == "in"): $jumlah_penj += $value->nilai_penjualan;?>
                                {{ribuan($jumlah_penj)}}
                              <?php endif; ?>
                            </td>
                            <td>
                              <?php if (isset($value->admin)): ?>
                                {{$admin[$value->admin]}}
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php $no++; endforeach;
                        ?>
                      </tbody>
              </table>
            </div>
            </div>
          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
      <script>
          $("#omset_table").DataTable(
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
