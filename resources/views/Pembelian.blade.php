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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pembelian</li>
                              <li class="breadcrumb-item text-muted" aria-current="page">Daftar Pembelian</li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                  <h4><b>Rekapan Orderan</b></h4>
                  <select id="gudang" onchange="Change()" class="col-lg-3 form-control">
                    <option value="all">Semua Gudang</option>
                    <?php foreach ($gudang as $value): ?>
                      <option value="{{$value->id}}"
                        <?php if (isset($v_gudang)): ?>
                          <?php if ($v_gudang == $value->id): ?>
                            selected
                          <?php endif; ?>
                        <?php endif; ?>
                      >{{$value->nama_gudang}}</option>
                    <?php endforeach; ?>
                  </select><br>
									<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>No SKU</th>
                              <th>Nama Barang</th>
                              <th>Stok</th>
                              <th>Orderan</th>
                              <th>Minimal Pembelian</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; foreach ($kulakan as $value) {
                          //dd($value['orderan']);
                          if (($value['orderan'] - $value['stok']) > 0) { ?>
                          <tr>
                            <td>{{$no}}</td>
                            <td>{{$value['no_sku']}}</td>
                            <td>{{$value['nama_barang']}}</td>
                            <td>{{$value['stok']}}</td>
                            <td>{{$value['orderan']}}</td>
                            <td>{{$value['orderan'] - $value['stok']}}</td>
                          </tr>
                        <?php  }
                        $no++; } ?>
                      </tbody>
                  </table>
		              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
    function Change(){
      var value = document.getElementById("gudang").value;
      location.href="{{url('/cariKulakan/')}}"+'/'+value;
      /*$.ajax({
         url: 'cariKulakan/'+value,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           var table = $('#example').DataTable();
           table.clear().draw();
           for (var i = 0; i < response.length; i++) {
             if ((response[i]['orderan'] - response[i]['stok']) > 0) {
               table.row.add( [
                 i,
                 response[i]['no_sku'],
                 response[i]['nama_barang'],
                 response[i]['stok'],
                 response[i]['orderan'],
                 response[i]['orderan'] - response[i]['stok']
               ] ).draw( false );
             }
           }
         }
       });*/
    }
    </script>
@endsection
