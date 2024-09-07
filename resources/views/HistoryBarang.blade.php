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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Stok Gudang Barang > <a href="https://stokis.app/?s=history+data+stok+opname" target="_blank">History Data Stok (Stock Opname)</a></li>
                          </ol>
                      </nav>
                    </h4>

                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <div class="form-group">
                       <form name="form1" action="{{url('historybarang')}}" method="post" enctype="multipart/form-data">
                         {{csrf_field()}}
                      <div class="row">
                           <label class="col-lg-1">Gudang</label>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-12">
                                      <select name="gudang" class="form-control">
                                        <?php foreach ($gudang as $key => $value): ?>
                                          <option value="{{$value->id}}"
                                            <?php if (isset($gdg) && $gdg == $value->id): ?>
                                              selected
                                            <?php endif; ?>
                                          >{{$value->nama_gudang}}</option>
                                        <?php endforeach; ?>
                                      </select>
                                   </div>
                                </div>
                            </div>
                         <div class="row">
                           <label class="col-lg-1"></label>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-12">
                             <button id="filter" class="btn btn-success btn-lg">Filter</button></center>
                            </div>
                            </div>
                        </div>
                        </div>
                      </div>
                      </form>
                      </div>
                      </div>
                      <hr>

									<div class="table-responsive">
                  <table id="kulakan" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>History</th>
                              <th>Stok Awal</th>
                              <th>Barang Masuk</th>
                              <th>Barang Keluar</th>
                              <th>Stok Sekarang</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($stok as $key => $value): $bm = 0; $bk = 0;?>
                          <tr>
                            <td>{{$value->no_sku}}</td>
                            <td>{{$value->nama_barang}}</td>
                            <td>
                              <?php
                               if (isset($barangmasuk[$value->id])){
                                  $bm = $barangmasuk[$value->id];
                               }else{
                                  $bm = 0;
                               }
                               echo "barang masuk = ".$bm."<br>";
                               if (isset($barangkeluar[$value->id])){
                                  $bk = $barangkeluar[$value->id];
                               }else{
                                  $bk = 0;
                               }
                               echo "barang keluar = ".$bk."<br>";

                               if (isset($barangretur[$value->id])){
                                  $br = $barangretur[$value->id];
                               }else{
                                  $br = 0;
                               }
                               echo "barang retur = ".$br."<br>";

                               if (isset($reject[$value->id])){
                                  $bk += $reject[$value->id];
                                  echo "barang riject = ".$reject[$value->id]."<br>";
                               }else{
                                  $bk += 0;
                                  echo "barang riject = 0"."<br>";
                               }
                               if (isset($tfin[$value->id])){
                                  $bm += $tfin[$value->id];
                                  echo "transfer in = ".$tfin[$value->id]."<br>";
                               }else{
                                  $bm += 0;
                                  echo "transfer in = 0"."<br>";
                               }
                               if (isset($tfout[$value->id])){
                                  $bk += $tfout[$value->id];
                                  echo "transfer out = ".$tfout[$value->id]."<br>";
                               }else{
                                  $bk += 0;
                                  echo "transfer out = 0"."<br>";
                               }
                               ?>
                            </td>
                            <td>{{$value->stok + $bk - $bm - $br}}</td>
                            <td>{{$bm+$br}}</td>
                            <td>{{$bk}}</td>
                            <td>{{$value->stok}}</td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                  </table>
								</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
