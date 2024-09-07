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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Validasi Stok Kembali > <a href="https://stokis.app/?s=validasi+stok+kembali+dari+proses+transfer+stok" target="_blank">Transfer Batal</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
									<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Transfer</th>
                              <th>Tanggal Order</th>
                              <th>Pengorder</th>
                              <th>Pemroses</th>
                              <th>Nama Barang</th>
                              <th>Proses</th>
                              <th>Terkirim</th>
                              <th>Kembali</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($transfer_stok as $value) { ?>
                          <tr>
                              <td>{{$value->no_transfer}}</td>
                              <td>{{tanggal($value->tanggal_order)}}</td>
                              <td>{{$value->dari}}</td>
                              <td>{{$value->kepada}}</td>
                              <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                              <td>{{$value->proses}}</td>
                              <td>{{$value->terkirim}}</td>
                              <td>{{$value->retur}}</td>
                              <td>
                                <button onclick="Verifikasi('{{$value->id_retur}}','{{$barang[$value->id_barang]['nama_barang']}}')" class="btn btn-success">Verifikasi</button>
                                <button onclick="Cancel('{{$value->id_retur}}','{{$barang[$value->id_barang]['nama_barang']}}')" class="btn btn-danger">Reject</button>
                              </td>
                          </tr>
                         <?php } ?>
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
          location.href="{{url('/verifikasiretur/')}}"+"/"+id;
        }
      });
    }
    function Cancel(id,nama){
      Swal.fire(
        'Cancel '+nama+' ?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/verifikasireturreject/')}}"+"/"+id;
        }
      });
    }
    </script>

@endsection
