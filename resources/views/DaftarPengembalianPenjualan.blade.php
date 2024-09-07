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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Validasi Stok Kembali > <a href="https://stokis.app/?s=validasi+stok+kembali+dari+penjualan+batal" target="_blank">Penjualan Batal</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
									<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Kwitansi</th>
                              <th>Nama Konsumen</th>
                              <th>Alamat</th>
                              <th>Tanggal Terkirim</th>
                              <th>Cabang</th>
                              <th>Nama Barang</th>
                              <th>Proses</th>
                              <th>Terkirim</th>
                              <th>Kembali</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($verifikasi as $value) {
                          if (isset($bk[$value->no_kwitansi])) {
                          ?>
                          <tr>
                              <td>{{$value->no_kwitansi}}</td>
                              <td>
                                  <?php
                                  if(isset($konsumen[$bk[$value->no_kwitansi]['id_konsumen']]['nama'])){
                                      echo $konsumen[$bk[$value->no_kwitansi]['id_konsumen']]['nama'];
                                  }else{
                                      echo $karyawan[$bk[$value->no_kwitansi]['id_konsumen']]['nama'];
                                  }
                                  ?></td>
                              <td>
                                  <?php
                                  if(isset($konsumen[$bk[$value->no_kwitansi]['id_konsumen']]['alamat'])){
                                      echo $konsumen[$bk[$value->no_kwitansi]['id_konsumen']]['alamat'];
                                  }else{
                                      echo $karyawan[$bk[$value->no_kwitansi]['id_konsumen']]['alamat'];
                                  }
                                  ?></td>
                              <td>{{tanggal($bk[$value->no_kwitansi]['tanggal_terkirim'])}}</td>
                              <td>{{$gudang[$bk[$value->no_kwitansi]['id_gudang']]}}</td>
                              <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                              <td>{{$value->proses}}</td>
                              <td>{{$value->terkirim}}</td>
                              <td>{{$value->return}}</td>
                              <td>
                                <button onclick="Verifikasi('{{$value->id_retur}}','{{$barang[$value->id_barang]['nama_barang']}}')" class="btn btn-success">Verifikasi</button>
                                <button onclick="Cancel('{{$value->id_retur}}','{{$barang[$value->id_barang]['nama_barang']}}')" class="btn btn-danger">Reject</button>
                              </td>
                          </tr>
                        <?php } }?>
                      </tbody>
                  </table>
								</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function Verifikasi(id,nama){
      Swal.fire(
        'Verifikasi '+nama+' ?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/verifikasireturpenjualan/')}}"+"/"+id;
        }
      });
    }
    function Cancel(id,nama){
      Swal.fire(
        'Reject '+nama+' ?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/cancelreturpenjualan/')}}"+"/"+id;
        }
      });
    }
    </script>

@endsection
