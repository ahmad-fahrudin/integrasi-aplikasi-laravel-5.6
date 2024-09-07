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
                          <a href="{{url('/')}}" class="nav-link active">
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
                          <a href="{{url('pembelianterbanyak')}}" class="nav-link">
                              <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                              <span class="d-lg-block">Konsumen Terbaik</span>
                          </a>
                      </li>
                    </ul>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <canvas id="myChart" width="100%" height="40%"></canvas>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="container">
    <br>
    <?php if (Auth::user()->level == "1"): ?>
    <div class="d-block d-md-none">
    <h4><b>Pintasan Navigasi:</b></h4>
    <div class="row">
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('inputbarangbaru')}}">
              <i data-feather="package" class="feather-icon"></i><br>
              Input Barang Baru
            </a></b>
          </div>
        </aside>
              
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('stokgudang')}}">
              <i data-feather="package" class="feather-icon"></i><br>
              Data Stok Gudang
            </a></b>
          </div>
        </aside>
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('pricelist')}}">
              <i data-feather="file-text" class="feather-icon"></i><br>
              Daftar Harga
            </a></b>
          </div>
        </aside>
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('priceupdate')}}">
              <i data-feather="file-text" class="feather-icon"></i><br>
              Update Harga
            </a></b>
          </div>
        </aside>
        <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('inputbarangmasuk')}}">
              <i data-feather="grid" class="feather-icon"></i><br>
             Input Barang Masuk
            </a></b>
          </div>
        </aside>
        <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('/kasir')}}">
              <i data-feather="shopping-bag" class="feather-icon"></i><br>
              Kasir Toko
            </a></b>
          </div>
        </aside>
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('prosespembayaran')}}">
              <i data-feather="credit-card" class="feather-icon"></i><br>
              Proses Pembayaran
            </a></b>
          </div>
        </aside>
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('inputtripinsentif')}}">
              <i data-feather="dollar-sign" class="feather-icon"></i><br>
              Input Insentif
            </a></b>
          </div>
        </aside>
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('kasditangan')}}">
              <i data-feather="dollar-sign" class="feather-icon"></i><br>
              Kas di Tangan
            </a></b>
          </div>
        </aside>
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('kasdibank')}}">
              <i data-feather="dollar-sign" class="feather-icon"></i><br>
              Kas di Bank
            </a></b>
          </div>
        </aside>
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('dataomset')}}">
              <i data-feather="activity" class="feather-icon"></i><br>
              Data Omset
            </a></b>
          </div>
        </aside>
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('labarugi')}}">
              <i data-feather="activity" class="feather-icon"></i><br>
              Data Laba Rugi
            </a></b>
          </div>
        </aside>
        <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('inputsuplayer')}}">
              <i data-feather="users" class="feather-icon"></i><br>
              Input Supplier
            </a></b>
          </div>
        </aside>
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('inputkonsumen')}}">
              <i data-feather="users" class="feather-icon"></i><br>
              Input Konsumen
            </a></b>
          </div>
        </aside>
              <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('inputkaryawan')}}">
              <i data-feather="users" class="feather-icon"></i><br>
              Input Karyawan
            </a></b>
          </div>
        </aside>
         <aside class="col-md-2 col-6">
          <div class="card text-center" style="height:auto; margin-bottom:20px;">
            <b>
              <br>
              <a style="color:grey;" href="{{url('user')}}">
              <i data-feather="users" class="feather-icon"></i><br>
              User Admin
            </a></b>
          </div>
        </aside>
            </div>
  </div>
  </div>
            <?php endif; ?>        
                    
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script>

    <?php
    $label = array();
	$data = array();
	  
	$xc=1;
    foreach ($grafik as $value) {
        if($xc < 13){
            $label[] = $value->months;
            $data[] = $value->sums;   
        }
      $xc++;
    }
    $label = array_reverse($label);
    $data = array_reverse($data);
    
    
    $str_label = json_encode((array)$label);
    $str_data = json_encode((array)$data);
    ?>


    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $str_label; ?>,
            datasets: [{
                label: 'Omset Penjualan',
                data: <?php echo $str_data; ?>,
                backgroundColor: [
                    'rgba(199, 39, 39, 1)',
                    'rgba(199, 39, 159, 1)',
                    'rgba(161, 47, 227, 1)',
                    'rgba(56, 64, 234, 1)',
                    'rgba(35, 133, 217, 1)',
                    'rgba(37, 165, 160, 1)',
                    'rgba(18, 196, 81, 1)',
                    'rgba(31, 131, 17, 1)',
                    'rgba(145, 231, 33, 1)',
                    'rgba(226, 198, 12, 1)',
                    'rgba(226, 138, 12, 1)',
                    'rgba(255, 34, 34, 1)'

                ]
            }]
        },
        options: {
          /*animation: {
              onComplete: function () {
                var chartInstance = this.chart;
                var ctx = chartInstance.ctx;
                console.log(chartInstance);
                var height = chartInstance.controller.boxes[0].bottom;
                ctx.textAlign = "center";
                ctx.fontColor = "white";
                Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  Chart.helpers.each(meta.data.forEach(function (bar, index) {
                    //ctx.fillText(dataset.data[index], bar._model.x, height - ((height - bar._model.y) / 3));
                    var data = dataset.data[index];
                    ctx.fillText(data, bar._model.x, bar._model.y + 25);
                  }),this)
                }),this);
              }
            },*/
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                          if(parseInt(value) >= 1000){
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                          } else {
                            return 'Rp ' + value;
                          }
                        }
                    }
                }]
            }
        }
    });
    </script>
    <script>
      function numberWithCommas(x) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
    </script>

@endsection
