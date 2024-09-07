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
                              <li class="breadcrumb-item text-muted" aria-current="page">Laporan Harian / Trip > <a href="https://stokis.app/?s=pending+trip+laporan+jasa" target="_blank">Daftar Nota Belum Laporan</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>

                <div class="table-responsive">
                  Penjualan Jasa
                          <table class="table table-striped table-bordered no-wrap" style="width:100%">
                              <thead>
                                  <tr>
                                      <th>No Kwitansi</th>
                                      <th>Member</th>
                                      <th>Alamat</th>
                                      <th>Kasir</th>
                                      <th>Gudang</th>
                                  </tr>
                              </thead>
                                <?php $no=1; foreach ($js as $key => $value): ?>
                                  <tr>
                                    <td>{{$value->no_kwitansi}}</td>
                                    <td>{{$konsumen[$value->id_konsumen]['nama']}}</td>
                                    <td><?php if (isset($konsumen[$value->id_konsumen]['alamat'])){
                                      echo $konsumen[$value->id_konsumen]['alamat']; } ?></td>
                                    <td><?php if (isset($usr[$value->kasir])){
                                      echo $usr[$value->kasir]; } ?></td>
                                    <td><?php if (isset($dt_gudang[$value->gudang])){
                                      echo $dt_gudang[$value->gudang]; } ?></td>
                                  </tr>
                                <?php $no++; endforeach; ?>
                              <tbody>

                              </tbody>
                          </table>
                          {{$js->links()}}
        								</div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


</script>
@endsection
