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
                              <li class="breadcrumb-item text-muted" aria-current="page">Dashboard</li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <ul class="nav nav-tabs mb-3">
                      <li class="nav-item">
                          <a href="{{url('/')}}" class="nav-link">
                              <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                              <span class="d-lg-block">Grafik Omset</span>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{url('/penjualterbaik')}}" class="nav-link">
                              <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                              <span class="d-lg-block">Sales Terbaik</span>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{url('/penjualterlaris')}}" class="nav-link">
                              <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                              <span class="d-lg-block">Produk Terlaris</span>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{url('pembelianterbanyak')}}" class="nav-link active">
                              <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                              <span class="d-lg-block">Konsumen Terbaik</span>
                          </a>
                      </li>
                    </ul>
                    <div class="row">
                      <div class="col-md-12">
                        <strong>Pembelian Terbanyak</strong>&emsp;
                        <select onchange="changebanyak()" id="bulanbanyak">
                          <option value="{{Date('m')}}">Bulan ini</option>
                          <option value="semua">Semua</option>
                        </select>
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered no-wrap" id="terbanyak" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Konsumen</th>
                                    <th>Kabupaten/Kota</th>
                                    <th>Total Pembelian</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $no=1; foreach ($pembeli as $value) { ?>
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{$kns[$value->id_konsumen]['nama_pemilik']}}</td>
                                    <td>{{$kns[$value->id_konsumen]['kota']}}</td>
                                    <td align="right">{{rupiah($value->pembelian)}}</td>
                                </tr>
                               <?php $no++; } ?>
                            </tbody>
                          </table>
        								</div>

                      </div>
                    </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script>
      function changebanyak(){
        var value = document.getElementById("bulanbanyak").value;

        $.ajax({
           url: 'penjualanterbanyak/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             var myTable = document.getElementById("terbanyak");
             var rowCount = myTable.rows.length;
             for (var x=rowCount-1; x>0; x--) {
              myTable.deleteRow(x);
             }
             for (var i = 0; i < 10; i++) {

               var table = document.getElementById("terbanyak").getElementsByTagName('tbody')[0];
               var lastRow = table.rows.length;
               var row = table.insertRow(lastRow);
               row.id = lastRow;

               var cell1 = row.insertCell(0);
               var cell2 = row.insertCell(1);
               var cell3 = row.insertCell(2);
               var cell4 = row.insertCell(3);

               cell4.style.textAlign = "right";

               cell1.innerHTML = i + 1;
               cell2.innerHTML = response[i]['nama_pemilik'];
               cell3.innerHTML = response[i]['kota'];
               cell4.innerHTML = numberWithCommas(response[i]['pembelian']);
             }
           }
         });
      }

      function numberWithCommas(x) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
    </script>

@endsection
