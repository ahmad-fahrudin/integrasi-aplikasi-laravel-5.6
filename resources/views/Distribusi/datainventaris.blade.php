@extends('template/nav')
@section('content')
<script src="{{asset('system/assets/ckeditor/ckeditor.js')}}"></script>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Inventaris > <a href="https://stokis.app/?s=input+inventaris" target="_blank">Data Barang Inventaris</a></li>
                          </ol>
                      </nav>
                    </h4>

                    <hr>
                      
				<div class="table-responsive">
                  <table
                  <?php if (Auth::user()->level == "1"){ ?>
                    id="example"
                  <?php }else{ ?>
                    id="examples"
                  <?php } ?>
                    class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                        <tr>
                            <th>No. SPB</th>
                            <th>Tanggal Order</th>
                            <th>Penanggung Jawab</th>
                            <th>Dari Gudang</th>
                            <th>Admin Proses</th>
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($inv as $key => $value): ?>
                          <tr>
                            <td>{{$value->no_kwitansi}}</td>
                            <td>{{$value->tanggal_order}}</td>
                            <td>{{$karyawan[$value->id_konsumen]->nama}}</td>
                            <td>{{$gudang[$value->id_gudang]->nama_gudang}}</td>
                            <td>{{$user[$value->admin_p]->name}}</td>
                            <td>{{$barang[$value->id_barang]->no_sku}}</td>
                            <td>{{$barang[$value->id_barang]->nama_barang}}</td>
                            <td>{{$value->jumlah}}</td>
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





    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
@endsection
