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
                          <a href="{{url('/penjualterbaik')}}" class="nav-link active">
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
                          <a href="{{url('pembelianterbanyak')}}" class="nav-link">
                              <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                              <span class="d-lg-block">Konsumen Terbaik</span>
                          </a>
                      </li>
                    </ul>

                    <div class="row">
                      <div class="col-md-12">
                        <strong>Penjualan Terbaik</strong>&emsp;
                        <select onchange="change()" id="bulan">
                          <option value="{{Date('m')}}">Bulan ini</option>
                          <option value="semua">Semua</option>
                        </select>
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered no-wrap" id="penjualan" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Sales</th>
                                    <th>Order</th>
                                    <th>Proses</th>
                                    <th>Terkirim</th>
                                    <th>Total Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $no=1; foreach ($penjual as $value) { ?>
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{$sls[$value['nama']]['nama']}}</td>
                                    <td align="right">
                                      <?php if (isset($value['order'])): ?>
                                        {{ribuan($value['order'])}}
                                      <?php endif; ?>
                                    </td>
                                    <td align="right">
                                      <?php if (isset($value['proses'])): ?>
                                        {{ribuan($value['proses'])}}
                                      <?php endif; ?>
                                    </td>
                                    <td align="right">
                                      <?php if (isset($value['terkirim'])): ?>
                                        {{ribuan($value['terkirim'])}}
                                      <?php endif; ?>
                                    </td>
                                    <td align="right">
                                      <?php if (isset($value['total'])): ?>
                                        {{ribuan($value['total'])}}
                                      <?php endif; ?>
                                    </td>
                                </tr>
                               <?php if(++$no > 10) break; } ?>
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
      function change(){
        var value = document.getElementById("bulan").value;

        $.ajax({
           url: 'penjualanterbaik/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             var myTable = document.getElementById("penjualan");
             var rowCount = myTable.rows.length;
             for (var x=rowCount-1; x>0; x--) {
              myTable.deleteRow(x);
             }
             for (var i = 0; i < 10; i++) {

               var table = document.getElementById("penjualan").getElementsByTagName('tbody')[0];
               var lastRow = table.rows.length;
               var row = table.insertRow(lastRow);
               row.id = lastRow;

               var cell1 = row.insertCell(0);
               var cell2 = row.insertCell(1);
               var cell3 = row.insertCell(2);
               var cell4 = row.insertCell(3);
               var cell5 = row.insertCell(4);
               var cell6 = row.insertCell(5);

               cell3.style.textAlign = "right";
               cell4.style.textAlign = "right";
               cell5.style.textAlign = "right";
               cell6.style.textAlign = "right";

               if (!response[i].hasOwnProperty('order')) {
                 response[i]['order'] = 0;
               }
               if (!response[i].hasOwnProperty('proses')) {
                 response[i]['proses'] = 0;
               }
               if (!response[i].hasOwnProperty('terkirim')) {
                 response[i]['terkirim'] = 0;
               }


               cell1.innerHTML = i + 1;
               cell2.innerHTML = response[i]['nama'];
               cell3.innerHTML = " "+numberWithCommas(response[i]['order']);
               cell4.innerHTML = " "+numberWithCommas(response[i]['proses']);
               cell5.innerHTML = " "+numberWithCommas(response[i]['terkirim']);
               cell6.innerHTML = " "+numberWithCommas(response[i]['total']);
             }
           }
         });
      }

      function numberWithCommas(x) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
    </script>

@endsection
